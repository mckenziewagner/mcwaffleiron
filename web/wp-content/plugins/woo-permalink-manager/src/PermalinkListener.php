<?php

namespace Premmerce\UrlManager;

use  Premmerce\UrlManager\Admin\Settings ;
/**
 * Class PermalinkListener
 *
 * The class is responsible for filtering of
 * product and category links invoked by 'post_type_link' and 'term_link'
 *
 * @package Premmerce\UrlManager
 */
class PermalinkListener
{
    const  WOO_CAT = 'product_cat' ;
    const  WOO_TAG = 'product_tag' ;
    const  WOO_PRODUCT = 'product' ;
    private  $options = array() ;
    private  $taxonomyOptions = array() ;
    private  $productBase ;
    public function __construct()
    {
        $options = get_option( Settings::OPTIONS );
        $this->options = array(
            'use_primary_category' => !empty($options['use_primary_category']),
            'product'              => ( isset( $options['product'] ) ? $options['product'] : '' ),
        );
        $this->taxonomyOptions['product_cat'] = ( isset( $options['category'] ) ? $options['category'] : '' );
        #/premmerce_clear
    }
    
    /**
     * Add post_type_link, term_link, rewrite_rules_array filters
     */
    public function registerFilters()
    {
        add_filter(
            'post_type_link',
            array( $this, 'replaceProductLink' ),
            1,
            2
        );
        add_filter(
            'term_link',
            array( $this, 'replaceTermLink' ),
            0,
            3
        );
        add_filter( 'rewrite_rules_array', array( $this, 'addRewriteRules' ), 99 );
    }
    
    /**
     * Replace category permalink according to settings
     *
     * @param string $link
     * @param object $term
     * @param string $taxonomy
     *
     * @return string
     */
    public function replaceTermLink( $link, $term, $taxonomy )
    {
        if ( empty($this->taxonomyOptions[$taxonomy]) ) {
            return $link;
        }
        $isHierarchical = $this->isHierarchical( $this->taxonomyOptions[$taxonomy] );
        return home_url( user_trailingslashit( $this->buildTermPath( $term, $isHierarchical ) ) );
    }
    
    /**
     * Replace product permalink according to settings
     *
     *
     * @param string $permalink
     * @param object $post
     *
     * @return string
     */
    public function replaceProductLink( $permalink, $post )
    {
        if ( $post->post_type !== self::WOO_PRODUCT ) {
            return $permalink;
        }
        if ( !get_option( 'permalink_structure' ) ) {
            return $permalink;
        }
        if ( empty($this->options['product']) ) {
            return $permalink;
        }
        $product_base = $this->getProductBase();
        if ( strpos( $product_base, '%product_cat%' ) !== false ) {
            $product_base = str_replace( '%product_cat%', '', $product_base );
        }
        $product_base = '/' . trim( $product_base, '/' ) . '/';
        $link = str_replace( $product_base, '/', $permalink );
        $link = $this->addPostParentLink( $link, $post, $this->isHierarchical( $this->options['product'] ) );
        return $link;
    }
    
    /**
     * Add rewrite rules for wp
     *
     * @param $rules
     *
     * @return array
     */
    public function addRewriteRules( $rules )
    {
        if ( empty($this->taxonomyOptions) ) {
            return $rules;
        }
        wp_cache_flush();
        global  $wp_rewrite ;
        $feed = '(' . trim( implode( '|', $wp_rewrite->feeds ) ) . ')';
        $customRules = array();
        /**
         * Remove WPML filters while getting terms, to get all languages
         */
        
        if ( isset( $GLOBALS['sitepress'] ) ) {
            $sitepress = $GLOBALS['sitepress'];
            $has_get_terms_args_filter = remove_filter( 'get_terms_args', array( $sitepress, 'get_terms_args_filter' ) );
            $has_get_term_filter = remove_filter( 'get_term', array( $sitepress, 'get_term_adjust_id' ), 1 );
            $has_terms_clauses_filter = remove_filter( 'terms_clauses', array( $sitepress, 'terms_clauses' ) );
        }
        
        foreach ( $this->taxonomyOptions as $taxonomy => $option ) {
            
            if ( !empty($option) ) {
                $terms = get_categories( array(
                    'taxonomy'   => $taxonomy,
                    'hide_empty' => false,
                ) );
                $hierarchical = $this->isHierarchical( $option );
                foreach ( $terms as $term ) {
                    $slug = $this->buildTermPath( $term, $hierarchical );
                    $customRules["{$slug}/?\$"] = 'index.php?' . $taxonomy . '=' . $term->slug;
                    $customRules["{$slug}/embed/?\$"] = 'index.php?' . $taxonomy . '=' . $term->slug . '&embed=true';
                    $customRules["{$slug}/{$wp_rewrite->feed_base}/{$feed}/?\$"] = 'index.php?' . $taxonomy . '=' . $term->slug . '&feed=$matches[1]';
                    $customRules["{$slug}/{$feed}/?\$"] = 'index.php?' . $taxonomy . '=' . $term->slug . '&feed=$matches[1]';
                    $customRules["{$slug}/{$wp_rewrite->pagination_base}/?([0-9]{1,})/?\$"] = 'index.php?' . $taxonomy . '=' . $term->slug . '&paged=$matches[1]';
                }
            }
        
        }
        /**
         * Register WPML filters back
         */
        
        if ( isset( $sitepress ) ) {
            if ( !empty($has_terms_clauses_filter) ) {
                add_filter(
                    'terms_clauses',
                    array( $sitepress, 'terms_clauses' ),
                    10,
                    3
                );
            }
            if ( !empty($has_get_term_filter) ) {
                add_filter(
                    'get_term',
                    array( $sitepress, 'get_term_adjust_id' ),
                    1,
                    1
                );
            }
            if ( !empty($has_get_terms_args_filter) ) {
                add_filter(
                    'get_terms_args',
                    array( $sitepress, 'get_terms_args_filter' ),
                    10,
                    2
                );
            }
        }
        
        return $customRules + $rules;
    }
    
    private function getProductBase()
    {
        
        if ( is_null( $this->productBase ) ) {
            $permalinkStructure = wc_get_permalink_structure();
            $this->productBase = $permalinkStructure['product_rewrite_slug'];
        }
        
        return $this->productBase;
    }
    
    private function addPostParentLink( $permalink, $post, $hierarchical )
    {
        if ( false === strpos( $permalink, '%product_cat%' ) ) {
            return $permalink;
        }
        $term = $this->getProductCategory( $post );
        
        if ( $term ) {
            $slug = $this->buildTermPath( $term, $hierarchical );
            $permalink = str_replace( '%product_cat%', $slug, $permalink );
        }
        
        return $permalink;
    }
    
    private function buildTermPath( $term, $hierarchical )
    {
        //urldecode used here to fix copied url via ctrl+c
        $slug = urldecode( $term->slug );
        
        if ( $hierarchical && $term->parent ) {
            $ancestors = get_ancestors( $term->term_id, 'product_cat' );
            foreach ( $ancestors as $ancestor ) {
                $ancestor_object = get_term( $ancestor, 'product_cat' );
                $slug = urldecode( $ancestor_object->slug ) . '/' . $slug;
            }
        }
        
        return $slug;
    }
    
    private function getProductCategory( $product )
    {
        $term = null;
        if ( !empty($this->options['use_primary_category']) ) {
            $term = $this->getSeoPrimaryTerm( $product );
        }
        if ( !$term instanceof \WP_Term ) {
            $term = $this->getWcPrimaryTerm( $product );
        }
        if ( $term instanceof \WP_Term ) {
            return $term;
        }
    }
    
    private function getSeoPrimaryTerm( $product )
    {
        
        if ( $this->checkSeoPlugin() ) {
            $primaryTerm = yoast_get_primary_term_id( self::WOO_CAT, $product->ID );
            $term = get_term( $primaryTerm );
            return $term;
        }
    
    }
    
    private function getWcPrimaryTerm( $product )
    {
        $terms = get_the_terms( $product->ID, 'product_cat' );
        if ( empty($terms) ) {
            return null;
        }
        
        if ( function_exists( 'wp_list_sort' ) ) {
            $terms = wp_list_sort( $terms, 'term_id', 'ASC' );
        } else {
            usort( $terms, '_usort_terms_by_ID' );
        }
        
        $category_object = apply_filters(
            'wc_product_post_type_link_product_cat',
            $terms[0],
            $terms,
            $product
        );
        $category_object = get_term( $category_object, 'product_cat' );
        return $category_object;
    }
    
    private function isHierarchical( $type )
    {
        return $type === 'hierarchical';
    }
    
    /**
     * Check that seo plugin is enabled and available to use
     *
     * @return bool
     */
    protected function checkSeoPlugin()
    {
        if ( !function_exists( 'is_plugin_active' ) ) {
            include_once ABSPATH . 'wp-admin/includes/plugin.php';
        }
        $active = function_exists( 'is_plugin_active' ) && defined( 'WPSEO_BASENAME' ) && is_plugin_active( WPSEO_BASENAME ) && function_exists( 'yoast_get_primary_term_id' );
        return $active;
    }

}
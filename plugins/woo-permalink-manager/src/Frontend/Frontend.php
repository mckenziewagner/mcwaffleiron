<?php

namespace Premmerce\UrlManager\Frontend;

use  Premmerce\UrlManager\Admin\Settings ;
use  WP_Post ;
use  WP_Term ;
/**
 * Class Frontend
 *
 * @package Premmerce\UrlManager
 */
class Frontend
{
    const  WOO_PRODUCT = 'product' ;
    /**
     * Frontend constructor.
     */
    public function __construct()
    {
        $options = get_option( Settings::OPTIONS );
        if ( !empty($options['product']) ) {
            add_action( 'request', array( $this, 'replaceRequest' ), 11 );
        }
        if ( !empty($options['canonical']) ) {
            add_action( 'wp_head', array( $this, 'addCanonical' ) );
        }
        #/premmerce_clear
    }
    
    /**
     * Replace request if product found
     *
     * @param array $request
     *
     * @return array
     */
    public function replaceRequest( $request )
    {
        global  $wp, $wpdb ;
        $url = $wp->request;
        
        if ( !empty($url) ) {
            $url = explode( '/', $url );
            $slug = array_pop( $url );
            $replace = array();
            
            if ( $slug === 'feed' ) {
                $replace['feed'] = $slug;
                $slug = array_pop( $url );
            }
            
            
            if ( $slug === 'amp' ) {
                $replace['amp'] = $slug;
                $slug = array_pop( $url );
            }
            
            $commentsPosition = strpos( $slug, 'comment-page-' );
            
            if ( $commentsPosition === 0 ) {
                $replace['cpage'] = substr( $slug, strlen( 'comment-page-' ) );
                $slug = array_pop( $url );
            }
            
            $sql = "SELECT COUNT(ID) as count_id FROM {$wpdb->posts} WHERE post_name = %s AND post_type = %s";
            $query = $wpdb->prepare( $sql, array( $slug, self::WOO_PRODUCT ) );
            $num = intval( $wpdb->get_var( $query ) );
            
            if ( $num > 0 ) {
                $replace['page'] = '';
                $replace['post_type'] = self::WOO_PRODUCT;
                $replace['product'] = $slug;
                $replace['name'] = $slug;
                return $replace;
            }
        
        }
        
        return $request;
    }
    
    public function addCanonical()
    {
        //avoid canonicals duplication
        
        if ( !defined( 'WPSEO_VERSION' ) && !get_queried_object() instanceof WP_Post ) {
            $canonical = apply_filters( 'premmerce_permalink_manager_canonical', $this->getCanonical() );
            if ( !empty($canonical) ) {
                echo  '<link rel="canonical" href="' . esc_url( $canonical ) . '" />' . "\n" ;
            }
        }
    
    }
    
    private function getCanonical( $useCommentsPagination = false )
    {
        global  $wp_rewrite ;
        $qo = get_queried_object();
        $canonical = null;
        
        if ( $qo instanceof WP_Term ) {
            $canonical = get_term_link( $qo );
            $paged = get_query_var( 'paged' );
            if ( $paged > 1 ) {
                $canonical = trailingslashit( $canonical ) . trailingslashit( $wp_rewrite->pagination_base ) . $paged;
            }
        } elseif ( $qo instanceof WP_Post ) {
            $canonical = get_permalink( $qo );
            
            if ( $useCommentsPagination ) {
                $page = get_query_var( 'cpage' );
                if ( $page > 1 ) {
                    $canonical = trailingslashit( $canonical ) . $wp_rewrite->comments_pagination_base . '-' . $page;
                }
            }
        
        }
        
        if ( $canonical ) {
            return user_trailingslashit( $canonical );
        }
    }

}
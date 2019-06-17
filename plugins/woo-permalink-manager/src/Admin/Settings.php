<?php namespace Premmerce\UrlManager\Admin;

use Premmerce\SDK\V2\FileManager\FileManager;

class Settings
{
    const OPTION_DISABLED = 'premmerce_url_manager_disabled';

    const OPTION_FLUSH = 'premmerce_url_manager_flush_rules';

    const OPTIONS = 'premmerce_permalink_manager';

    const SETTINGS_PAGE = 'premmerce_permalink_manager_page';

    const PERMALINK_STRUCTURE = '/%postname%/';

    const PERMALINK_WC_PRODUCT_CAT = '/shop/%product_cat%/';

    const PERMALINK_WC_PRODUCT = 'product';

    /**
     * @var FileManager
     */
    private $fileManager;

    public function __construct(FileManager $fileManager)
    {
        $this->fileManager = $fileManager;
    }

    public function register()
    {
        register_setting(self::OPTIONS, self::OPTIONS, array(
            'sanitize_callback' => array($this, 'updateSettings'),
        ));

        add_settings_section('category_link', __('Categories', 'premmerce-url-manager'), array(
            $this,
            'categorySection',
        ), self::SETTINGS_PAGE);
        add_settings_section('product_link', __('Products', 'premmerce-url-manager'), array(
            $this,
            'productSection',
        ), self::SETTINGS_PAGE);
        add_settings_section('additional', __('Additional', 'premmerce-url-manager'), array(
            $this,
            'canonicalSection',
        ), self::SETTINGS_PAGE);
    }

    public function show()
    {
        print('<form action="' . admin_url('options.php') . '" method="post">');

        settings_errors();

        settings_fields(self::OPTIONS);

        do_settings_sections(self::SETTINGS_PAGE);

        submit_button();
        print('</form>');
    }

    public function categorySection()
    {
        $this->fileManager->includeTemplate('admin/section/category.php', array(
            'category' => $this->getOption('category'),
        ));
    }

    public function productSection()
    {
        $this->fileManager->includeTemplate('admin/section/product.php', array(
            'product' => $this->getOption('product'),
        ));
    }

    public function canonicalSection()
    {
        $this->fileManager->includeTemplate('admin/section/additional.php', array(
            'tag'                  => $this->getOption('tag'),
            'canonical'            => $this->getOption('canonical'),
            'redirect'             => $this->getOption('redirect'),
            'use_primary_category' => $this->getOption('use_primary_category'),
        ));
    }

    public function updateSettings($settings)
    {
        $this->fixWPWCSettings($settings);
        return $settings;
    }

    private function fixWPWCSettings($options)
    {
        if ($options['product'] || $options['category']) {
            if (!get_option('permalink_structure')) {
                update_option('permalink_structure', self::PERMALINK_STRUCTURE);
            };
        }

        if ($options['product']) {
            if ($options['product'] == 'slug') {
                $wc['product_base'] = self::PERMALINK_WC_PRODUCT;
            }
            if (in_array($options['product'], array('category_slug', 'hierarchical'))) {
                $wc['product_base'] = self::PERMALINK_WC_PRODUCT_CAT;
            }

            update_option('woocommerce_permalinks', $wc);
        }
    }

    /**
     * @param string $key
     * @param mixed|null $default
     *
     * @return mixed|null
     */
    public function getOption($key, $default = null)
    {
        if (!isset($this->options)) {
            $this->options = get_option(self::OPTIONS);
        }

        return isset($this->options[ $key ])? $this->options[ $key ] : $default;
    }
}

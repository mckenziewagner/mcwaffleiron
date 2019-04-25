<?php

if ( ! defined('WPINC')) {
    die;
}

use Premmerce\UrlManager\Admin\Settings;

?>
<table class="form-table">
    <tbody>
    <tr>
        <th>
            <label class="flex-label">
                <input type="radio" name="<?=Settings::OPTIONS?>[product]"
                       value="" <?php checked('', $product); ?>>
                <span>
				<?php _e('Use WooCommerce settings', 'premmerce-url-manager') ?>
                </span>

            </label>
        </th>
    </tr>
    <tr>
        <th>
            <label class="flex-label">
                <input type="radio" name="<?=Settings::OPTIONS?>[product]"
                       value="slug" <?php checked('slug', $product); ?>>
				<?php _e('Product slug', 'premmerce-url-manager') ?>
            </label>
        </th>
        <td>
            <code><?=home_url('/sample-product')?></code>
        </td>
    </tr>
    <tr>
        <th>
            <label class="flex-label">
                <input type="radio" name="<?=Settings::OPTIONS?>[product]"
                       value="category_slug" <?php checked('category_slug', $product); ?>>
				<?php _e('Product slug with primary category', 'premmerce-url-manager') ?>
            </label>
        </th>
        <td>
            <code><?=home_url('/category/sample-product')?></code>
        </td>
    </tr>
    <tr>
        <th>
            <label class="flex-label">
                <input type="radio" name="<?=Settings::OPTIONS?>[product]"
                       value="hierarchical" <?php checked('hierarchical', $product); ?>>
				<?php _e('Full product path', 'premmerce-url-manager') ?>
            </label>
        </th>
        <td>
            <code><?=home_url('parent-category/category/sample-product')?></code>
        </td>
    </tr>
    </tbody>
</table>
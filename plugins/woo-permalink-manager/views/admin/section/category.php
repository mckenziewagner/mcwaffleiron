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
                <input type="radio" name="<?=Settings::OPTIONS?>[category]"
                       value="" <?php checked('', $category); ?>>
				<?php _e('Use WooCommerce settings','premmerce-url-manager') ?>
            </label>
        </th>
    </tr>
    <tr>
        <th>
            <label class="flex-label">
                <input type="radio" name="<?=Settings::OPTIONS?>[category]"
                       value="slug" <?php checked('slug', $category); ?>>
				<?php _e('Category slug','premmerce-url-manager') ?>
            </label>
        </th>
        <td>
            <code><?=home_url('/category')?></code>
        </td>
    </tr>
    <tr>
        <th>
            <label class="flex-label">
                <input type="radio" name="<?=Settings::OPTIONS?>[category]"
                       value="hierarchical" <?php checked('hierarchical', $category); ?>>
				<?php _e('Full category path','premmerce-url-manager') ?>
            </label>
        </th>
        <td>
            <code><?=home_url('parent-category/category')?></code>
        </td>
    </tr>
    </tbody>
</table>
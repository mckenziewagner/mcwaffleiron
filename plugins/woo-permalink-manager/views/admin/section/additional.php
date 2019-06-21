<?php

if ( !defined( 'WPINC' ) ) {
    die;
}
use  Premmerce\UrlManager\Admin\Settings ;
#premmerce_clear
$free = true;
#/premmerce_clear
?>

<table class="form-table">
    <tbody class="<?php 
echo  ( $free ? 'is-free' : '' ) ;
?>">
    <tr>
        <th>
            <label class="premium-only-label">
                <input <?php 
echo  ( $free ? 'disabled' : '' ) ;
?> type="checkbox" name="<?php 
echo  Settings::OPTIONS ;
?>[tag]"
                                                            value="slug" <?php 
checked( 'slug', $tag );
?>>
				<?php 
_e( 'Remove product tag base', 'premmerce-url-manager' );
?>
            </label>
            <p class="description">
                <span class="premium-only-feature"><?php 
_e( 'Available only in premium version', 'premmerce-url-manager' );
?></span>
            </p>
        </th>
    </tr>
    <tr>
        <th>
            <label>
                <input type="checkbox" name="<?php 
echo  Settings::OPTIONS ;
?>[use_primary_category]"
					<?php 
checked( 'on', $use_primary_category );
?>>
				<?php 
_e( 'Use primary category', 'premmerce-url-manager' );
?>
            </label>
            <p class="description"><?php 
_e( "Use 'Yoast SEO' primary category to build product path", 'premmerce-url-manager' );
?></p>
        </th>
    </tr>
    <tr>
        <th>
            <label>
                <input type="checkbox" name="<?php 
echo  Settings::OPTIONS ;
?>[canonical]"
					<?php 
checked( 'on', $canonical );
?>>
				<?php 
_e( 'Add canonicals', 'premmerce-url-manager' );
?>
            </label>
            <p class="description"><?php 
_e( 'Add canonical meta tag to duplicated pages', 'premmerce-url-manager' );
?></p>
        </th>
    </tr>
    <tr>
        <th>
            <label class="premium-only-label">
                <input <?php 
echo  ( $free ? 'disabled' : '' ) ;
?> type="checkbox" name="<?php 
echo  Settings::OPTIONS ;
?>[redirect]"
					<?php 
checked( 'on', $redirect );
?>>
				<?php 
_e( 'Create redirects', 'premmerce-url-manager' );
?>
            </label>
            <p class="description">
                <span class="premium-only-feature"><?php 
_e( 'Available only in premium version', 'premmerce-url-manager' );
?></span>
				<?php 
_e( 'Create 301 redirect from duplicated pages', 'premmerce-url-manager' );
?>
            </p>
        </th>
    </tr>
    </tbody>
</table>
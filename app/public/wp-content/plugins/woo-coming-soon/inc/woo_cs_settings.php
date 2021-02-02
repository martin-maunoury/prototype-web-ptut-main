<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<?php 
	
	
	global $woo_cs_data, $woo_cs_url, $woo_cs_android_settings, $woo_cs_pro, $woo_cs_premium_link;
	
	$woo_cs_options = woo_cs_settings_update();
	
?>	

<div class="wrap woo_cs_settings">

<div id="icon-options-general"><br></div><h2><span class="dashicons-before dashicons-backup"></span>&nbsp;<?php echo $woo_cs_data['Name']; ?> (<?php echo $woo_cs_data['Version']; ?>)<?php echo ($woo_cs_pro?' '.'Pro':''); ?> - <?php _e('Settings', 'woo-coming-soon'); ?>

<?php $woo_cs_android_settings->ab_io_display($woo_cs_url);?>
</h2>

<hr />


<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
	<?php wp_nonce_field( 'woo_cs_nonce_action', 'woo_cs_nonce_field' ); ?>
    
    <fieldset>

        <label for="product_page_text"><?php _e('Product Page Message', 'woo-coming-soon'); ?>:</label>
        <textarea id="product_page_text" type="text" name="woo_cs_options[product_page_text]"><?php echo array_key_exists('product_page_text', $woo_cs_options)?$woo_cs_options['product_page_text']:''; ?></textarea>


        <label for="product_page_edit"><?php _e('Product Page Button', 'woo-coming-soon'); ?> (<?php _e('Admin Panel', 'woo-coming-soon'); ?>):</label>
        <textarea placeholder="<?php echo woo_cs_btn_text(); ?>" id="product_page_edit" type="text" name="woo_cs_options[product_page_edit]"><?php echo array_key_exists('product_page_edit', $woo_cs_options)?$woo_cs_options['product_page_edit']:''; ?></textarea>
        

    </fieldset>

    <fieldset>

        <label for="product_arrival_date">
            <input type="checkbox" id="product_arrival_date" value="1" name="woo_cs_options[arrival_date]" <?php echo $arrival_date = checked(array_key_exists('arrival_date', $woo_cs_options), false) ?>/>
            <?php _e('Make Coming Soon message disappear on a specified date?', 'woo-coming-soon'); ?>
        </label>
		<div class="wc_arrival_toggle" <?php echo $arrival_date?'style="display:block;"':''; ?>>
            <div class="wc_arrival_toggle_left">
            	<img src="<?php echo $woo_cs_url; ?>img/arrival-demo.png" />
            </div>
            <div class="wc_arrival_toggle_right">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/vm2JMMXYsCc" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
           
        </div>

    </fieldset>
	<p class="submit">
    <input type="submit" value="<?php _e('Save Changes', 'woo-coming-soon'); ?>" class="button button-primary" id="submit" name="submit" />
    </p>
</form>


<div class="wp-plugins-list">
<strong><?php _e('Install Plugins', 'woo-coming-soon'); ?> - (<?php _e('Optional', 'woo-coming-soon'); ?>):</strong>
<ul>
<li>
<a href="<?php echo admin_url('plugin-install.php?s=gulri+slider&tab=search&type=term'); ?>" target="_blank"><?php _e('Click here to install the recommended Image Slider plugin', 'woo-coming-soon'); ?></a>
</li>
<li>
<a href="<?php echo admin_url('plugin-install.php?s=wp+header+images+fahad&tab=search&type=term'); ?>" target="_blank"><?php _e('Click here to install the recommended Header Images plugin', 'woo-coming-soon'); ?></a>
</li>

<?php if(!$woo_cs_pro): ?>
<li>
<a href="<?php echo $woo_cs_premium_link; ?>" target="_blank"><?php _e('Go Premium', 'woo-coming-soon'); ?></a>
</li>
<?php endif; ?>
</ul>
<?php if(!$woo_cs_pro): ?>
<div style="text-align:center"><a href="<?php echo $woo_cs_premium_link; ?>" target="_blank"><img src="<?php echo $woo_cs_url; ?>/img/pro-features.png" /></a></div>
<?php endif; ?>
</div>


</div>


<script type="text/javascript" language="javascript">

jQuery(document).ready(function($) {
	

});

</script>
<style type="text/css">
.update-nag,
#message {
    display: none;
}
[class^="icon-"], [class*=" icon-"] {
    margin-right: 6px;
}
#wpcontent, #wpfooter {
    background-color: #fff;
}
</style>
<?php
	function woo_cs_plugin_links($links) { 
		global $woo_cs_premium_link, $woo_cs_pro;

		$settings_link = '<a href="admin.php?page=woo_cs_settings">'.__('Settings', 'woo-coming-soon').'</a>';
		$app_link = '<a href="https://play.google.com/store/apps/details?id=woo.coming.soon" title="'.__('Get it on GooglePlay', 'woo-coming-soon').'">'.__('GooglePlay', 'woo-coming-soon').'</a>';
		
		if($woo_cs_pro){
			array_unshift($links, $settings_link, $app_link); 
		}else{
			if($woo_cs_premium_link){
				$woo_cs_premium_link = '<a href="'.$woo_cs_premium_link.'" title="'.__('Go Premium', 'woo-coming-soon').'" target="_blank">'.__('Go Premium', 'woo-coming-soon').'</a>'; 
				array_unshift($links, $settings_link, $app_link, $woo_cs_premium_link); 
			}else{
				array_unshift($links, $settings_link, $app_link); 
			}
		
		}
		
		
		return $links; 
	}	
	
	
	add_filter('woocommerce_loop_add_to_cart_link', 'woo_csn_woocommerce_loop_add_to_cart_link', 10, 2);
	
	function woo_csn_woocommerce_loop_add_to_cart_link($html, $product){
		
		$_coming_soon = get_post_meta($product->get_id(), '_coming_soon', true);
		$_coming_soon = ($_coming_soon?$_coming_soon:'false').'';
			
		$is_cs = ($product->get_status()=='coming_soon' || $_coming_soon=='true');
		
		$woo_cs_text = woo_cs_btn_text();
		
			
		if($is_cs)
		return '<div class="add-to-cart-button-outer"><div class="add-to-cart-button-inner"><div class="add-to-cart-button-inner2"><a rel="nofollow" class="qbutton add-to-cart-button button add_to_cart_button ajax_add_to_cart">'.$woo_cs_text.'</a></div></div></div>';
		else
		return $html;
	}
	
	add_action( 'post_submitbox_misc_actions', 'woo_csn_custom_button' );
	
	function woo_csn_custom_button(){
			global $post, $woo_cs_android_settings, $woo_cs_url, $woo_cs_options;
			$_coming_soon = get_post_meta($post->ID, '_coming_soon', true);
			$_coming_soon_date = get_post_meta($post->ID, '_coming_soon_date', true);
			$_coming_soon = ($_coming_soon?$_coming_soon:'false').'';
			$woo_cs_android_settings->ab_io_display($woo_cs_url);
			$woo_cs_title_date = __('Add date when to remove coming soon property from this product', 'woo-coming-soon');
			$woo_cs_label_date = __('Arrival date', 'woo-coming-soon');
			$woo_cs_remove_date = __('Remove date', 'woo-coming-soon');

			$html  = '<div class="coming-soon-section">';
			$html .= '<input type="button" value="'.woo_cs_btn_text().'" class="button button-secondary '.($_coming_soon=='true'?'active':'').'"><input type="hidden" class="" name="_coming_soon" value="'.$_coming_soon.'" />';
            if(array_key_exists('arrival_date', $woo_cs_options)) {

                $html .= "<div class='woo_cs_date_section'>";
                $html .= '<input type="text" placeholder="' . $woo_cs_label_date . '" name="_coming_soon_date" value="' . $_coming_soon_date . '" id="woo_cs_coming_soon_date" style="margin-top:5px;" /> <span class="dashicons dashicons-calendar-alt" style="position: relative; top: 9px; left: -29px;" title="' . $woo_cs_remove_date . '"></span>';
                $html .= '</div>';
            }
			$html .= '</div>';
			echo $html;
	}
	
	function woo_csn_disable_coming_soon_purchase( $purchasable, $product ) {
	
		$_coming_soon = get_post_meta($product->get_id(), '_coming_soon', true);
		$_coming_soon = ($_coming_soon?$_coming_soon:'false').'';
			
		$is_cs = ($product->get_status()=='coming_soon' || $_coming_soon=='true');
		 
		//$product_id = $product->is_type( 'variation' ) ? $product->get_variation_id() : $product->get_id();
	   
		return (!$is_cs);
	}
	add_filter( 'woocommerce_variation_is_purchasable', 'woo_csn_disable_coming_soon_purchase', 10, 2 );
	add_filter( 'woocommerce_is_purchasable', 'woo_csn_disable_coming_soon_purchase', 10, 2 );
	
	function woo_csn_custom_post_status(){
		register_post_status( 'coming_soon', array(
			'label'                     => _x( woo_cs_btn_text(), 'post' ),
			'public'                    => true,
			'exclude_from_search'       => true,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'label_count'               => _n_noop( woo_cs_btn_text().' <span class="count">(%s)</span>', woo_cs_btn_text().' <span class="count">(%s)</span>' ),
		) );
	}
	add_action( 'init', 'woo_csn_custom_post_status' );
	
	add_action('admin_footer', 'woo_csn_append_post_status_list');
	function woo_csn_append_post_status_list(){
		 global $post;
		 $complete = '';
		 $label = '';
		 //pre($post);
		 if(is_object($post) && $post->post_type == 'product'){
			  if($post->post_status == 'coming_soon'){
				   $complete = ' selected="selected"';
				   $label = '<span id="post-status-display"> '.woo_cs_btn_text().'</span>';
			  }
	?>
			  <script>
			  jQuery(document).ready(function($){
				   $('select#post_status').append('<option value="coming_soon" <?php echo $complete; ?>><?php echo woo_cs_btn_text(); ?></option>');
				   $('.misc-pub-section label').append('<?php echo $label; ?>');

                  var obj = $('.coming-soon-section input[name="_coming_soon"]');
                  var obj_date = $('.coming-soon-section .woo_cs_date_section');
                  var remove_date = $('.coming-soon-section .woo_cs_date_section .dashicons');

                  if(obj.val()=='true'){

                      obj_date.show();

                  }else{

                      obj_date.hide();

                  }

                  $('.coming-soon-section input[type="button"]').click(function(){
					   $(this).toggleClass('active');
					   if(obj.val()=='true'){

					    obj.val('false');
                       obj_date.hide();

					   }else{

					    obj.val('true');
                        obj_date.show();

					   }

				   });


                  obj_date.find('input[type="text"]').datepicker(woo_coming_soon_obj.datepicker);

                  remove_date.on('click', function(){

                      // obj_date.find('input[type="text"]').val('');

                  });



			  });
			  </script>
			  
              
	<?php  
		 }
	}
	function woo_csn_display_archive_state( $states ) {
		 global $post;
		 $arg = get_query_var( 'post_status' );
		 if($arg != 'coming_soon'){
			  if(is_object($post) && !empty($post) && $post->post_status == 'coming_soon'){
				   return array(woo_cs_btn_text());
			  }
		 }
		return $states;
	}
	add_filter( 'display_post_states', 'woo_csn_display_archive_state' );
	
	add_action( 'woocommerce_before_single_product', 'woo_csn_wc_print_notices', 10 );

	function woo_cs_sanitize_input( $input ) {
		if(is_array($input)){		
			$new_input = array();	
			foreach ( $input as $key => $val ) {
				$new_input[ $key ] = (is_array($val)?woo_cs_sanitize_input($val):sanitize_text_field( $val ));
			}			
		}else{
			$new_input = sanitize_text_field($input);			
			if(stripos($new_input, '@') && is_email($new_input)){
				$new_input = sanitize_email($new_input);
			}
			if(stripos($new_input, 'http') || wp_http_validate_url($new_input)){
				$new_input = esc_url($new_input);
			}			
		}	
		return $new_input;
	}	
	

	
	
	function woo_csn_wc_print_notices(){
		global $post, $woo_cs_options;
		
		
		$_coming_soon = get_post_meta($post->ID, '_coming_soon', true);
		$_coming_soon = ($_coming_soon?$_coming_soon:'false').'';
			
		$is_cs = ($post->post_status=='coming_soon' || $_coming_soon=='true');
			
		if($is_cs){
			
			
	?>
	<style type="text/css">
	.single-product .woo_csn_notices{
		text-align:right;
		font-size:18px;	
	}
	.single-product form.cart,
	.single-product #tab-reviews{
		display:none !important;
	}
	</style>
	<script type="text/javascript" language="javascript">
		jQuery(document).ready(function($){
			setTimeout(function(){
				$('.single-product form.cart').remove();
			}, 3000);
		});
	</script>
	<div class="woo_csn_notices"><strong><?php echo $woo_cs_options['product_page_text']; ?></strong></div>
	<?php			
		}
		
	}
	
	function woo_csn_update_post( $post_id ) {
		if(is_admin()){
		    if(isset($_POST['_coming_soon'])){

			    update_post_meta($post_id, '_coming_soon', woo_cs_sanitize_input($_POST['_coming_soon']));
            }

            if(isset($_POST['_coming_soon_date'])){

                update_post_meta($post_id, '_coming_soon_date', woo_cs_sanitize_input($_POST['_coming_soon_date']));
            }
		}
	}
	add_action( 'save_post', 'woo_csn_update_post' );
	
	if(!function_exists('pre')){
	function pre($data){
			if(isset($_GET['debug'])){
				pree($data);
			}
		}	 
	} 	
	if(!function_exists('pree')){
	function pree($data){
				echo '<pre>';
				print_r($data);
				echo '</pre>';	
		
		}	 
	} 

	function woo_cs_settings(){ 		
		global $wpdb, $woo_cs_dir; 
		//echo $woo_cs_dir;exit;
		include($woo_cs_dir.'inc/woo_cs_settings.php');	
	}
	
	function woo_cs_admin_menu(){
		
		global $woo_cs_data;
		//pree($woo_cs_data);
		add_submenu_page('woocommerce', $woo_cs_data['Name'], $woo_cs_data['Name'], 'manage_woocommerce', 'woo_cs_settings', 'woo_cs_settings');

	}
	function woo_cs_settings_update(){
		
		global $woo_cs_options;
	
		if(!empty($_POST) && array_key_exists('woo_cs_options', $_POST)){
				
			if ( ! isset( $_POST['woo_cs_nonce_field'] ) 
				|| ! wp_verify_nonce( $_POST['woo_cs_nonce_field'], 'woo_cs_nonce_action' ) 
			) {
			   _e('Sorry, your nonce did not verify.', 'woo-coming-soon');
			   exit;
			} else {
			   // process form data
			   $woo_cs_options = woo_cs_sanitize_input($_POST['woo_cs_options']);
			   update_option('woo_cs_options', $woo_cs_options);
			}
		}
		
		return $woo_cs_options;
	}
	
	function woo_cs_admin_scripts(){
		global $woo_cs_url, $post_type;

		wp_enqueue_style( 'woo-coming-soon', $woo_cs_url.'css/admin-styles.css?t='.time(), array(), true );

		if($post_type == 'product'){

            wp_enqueue_style( 'woo-coming-soon-ui', $woo_cs_url.'css/jquery-ui.css?t='.time(), array(), true );
            wp_enqueue_script('jquery-ui-datepicker' );
            wp_localize_script('jquery-ui-datepicker', "woo_coming_soon_obj", array(

            'datepicker' => array(
                'dateFormat' => "dd-mm-yy",
                'changeMonth' => true,
                'changeYear' => true,
                'minDate' => date('d-m-Y', strtotime('+ 1day')),
                ),

            ));

        }

    }		
		
		
	
	
	
		
	function woo_cs_custom_columns_values( $column, $post_id ) {
		
		if($column == 'woo_coming_soon'){
			$_coming_soon = get_post_meta($post_id, '_coming_soon', true);
			$_coming_soon = ($_coming_soon?$_coming_soon:'false').'';
				
			$is_cs = (get_post_type( $post_id )=='coming_soon' || $_coming_soon=='true');
					
			if ($is_cs){
				global $woo_cs_data;
				echo '<span style="font-size:10px; color:#0073aa;" title="'.$woo_cs_data['Name'].'">'.woo_cs_btn_text().'</span>';
			}
		}
	}
	add_action( 'manage_posts_custom_column' , 'woo_cs_custom_columns_values', 10, 2 );
	
	/* Add custom column to post list */
	function woo_cs_custom_columns_title( $column_array ) {		
	
		$column_array['woo_coming_soon'] = woo_cs_btn_text();		
		return $column_array;	
	}
		
	function woo_cs_btn_text() {		
		global $woo_cs_options;
		$btn_text = array_key_exists('product_page_edit', $woo_cs_options)?$woo_cs_options['product_page_edit']:'';
		$btn_text = trim($btn_text)?$btn_text:__('Coming Soon', 'woo-coming-soon');
		return $btn_text;		
    }

    add_action('init', 'woo_cs_remove_coming_soon_by_date');

    function woo_cs_remove_coming_soon_by_date(){

        global $wpdb;
        $coming_soon_args = array(
            'numberposts' => -1,
            'post_type' => 'product',
            'post_status' => 'any',
            'fields' => 'ids',
            'meta_query' => array(
                array(
                    'key' => '_coming_soon',
                    'value' => 'true',
                    'compare' => '=',
                ),
                array(
                    'key' => '_coming_soon_date',
                    'compare' => 'EXIST',
                ),
                array(
                    'key' => '_coming_soon_date',
                    'value' => '',
                    'compare' => '!=',
                ),

            ),
        );



        $coming_soon_products = get_posts($coming_soon_args);

        if(empty($coming_soon_products)){return;}

        $coming_soon_products_str = '('.implode(', ', $coming_soon_products).')';
        $coming_soon_dates_query = "SELECT * FROM $wpdb->postmeta WHERE `post_id` IN $coming_soon_products_str AND `meta_key` = '_coming_soon_date'";
        $coming_soon_dates = $wpdb->get_results($coming_soon_dates_query);

        $finished_date_products = array();

        $current_time = time();

        if(!empty($coming_soon_dates)){
            foreach($coming_soon_dates as $index => $coming_soon_date_obj){

                $coming_soon_date = $coming_soon_date_obj->meta_value;
                $coming_soon_date = strtotime($coming_soon_date);

                if($coming_soon_date <= $current_time){

                    $finished_date_products[] = $coming_soon_date_obj->post_id;
                }


            }
        }

        if(!empty($finished_date_products)){

            $finished_date_products_str = '('.implode(', ', $finished_date_products).')';
            $coming_soon_update_query = "UPDATE $wpdb->postmeta set `meta_value` = 'false' WHERE `post_id` IN $finished_date_products_str AND `meta_key` = '_coming_soon'";
            $coming_soon_date_update_query = "UPDATE $wpdb->postmeta set `meta_value` = '' WHERE `post_id` IN $finished_date_products_str AND `meta_key` = '_coming_soon_date'";


            $wpdb->query($coming_soon_update_query);
            $wpdb->query($coming_soon_date_update_query);


        }

    }
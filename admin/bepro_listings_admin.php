<?php
/*
	This file is part of BePro Listings.

    BePro Listings is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    BePro Listings is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with BePro Listings.  If not, see <http://www.gnu.org/licenses/>.
*/	

	function bepro_admin_init(){
		$data = get_option("bepro_listings");
		add_meta_box("contact_general_meta", " ", "BL_Meta_Box_Listing_Images::contact_general_meta", "bepro_listings", "normal", "low");
		if($data["show_cost"] == (1 || "on"))add_meta_box("cost_meta", "Cost $", "BL_Meta_Box_Listing_Images::cost_meta", "bepro_listings", "side", "low");
		if($data["show_con"] == (1 || "on"))add_meta_box("contact_details_meta", "Lisiting Details", "BL_Meta_Box_Listing_Images::contact_details_meta", "bepro_listings", "normal", "low");
		if($data["show_geo"] == (1 || "on"))add_meta_box("geographic_details_meta", "Geographic Details", "BL_Meta_Box_Listing_Images::geographic_details_meta", "bepro_listings", "normal", "low");
		
		add_meta_box( 'bepro-listings-images', __( 'Listing Gallery', 'bepro-listings' ), 'BL_Meta_Box_Listing_Images::gallery_images_meta', 'bepro_listings', 'side' );
		
		permalink_save_options();
		permalink_admin_init();
	}
	
	function bepro_admin_head(){
		echo '<link type="text/css" rel="stylesheet" href="'.plugins_url('../css/jquery-ui-1.8.18.custom.css', __FILE__ ).'" >';
		echo '<script type="text/javascript" src="'.plugins_url('../js/bepro_listings_admin.js', __FILE__ ).'" ></script>';
		echo "<style type='text/css'>.bepro_listings input[type=checkbox]{margin:11px 0;}</style>";
		echo "<style>
		  .ui-tabs-vertical { width: 55em; }
		  .ui-tabs-vertical .ui-tabs-nav { padding: .2em .1em .2em .2em; float: left; width: 12em; }
		  .ui-tabs-vertical .ui-tabs-nav li { clear: left; width: 100%; border-bottom-width: 1px !important; border-right-width: 0 !important; margin: 0 -1px .2em 0; }
		  .ui-tabs-vertical .ui-tabs-nav li a { display:block; }
		  .ui-tabs-vertical .ui-tabs-nav li.ui-tabs-active { padding-bottom: 0; padding-right: .1em; border-right-width: 1px; border-right-width: 1px; }
		  .ui-tabs-vertical .ui-tabs-panel { padding: 1em; float: right; width: 40em;}
		  .bepro_listings_admin_form{display:none;}
		  #bepro-listings-images .inside #listing_images_container ul li.image {
			width: 80px;
			float: left;
			border: 1px solid #d5d5d5;
			margin: 9px 9px 0 0;
			background: #f7f7f7;
			-webkit-border-radius: 2px;
			-moz-border-radius: 2px;
			border-radius: 2px;
			position: relative;
			-webkit-box-sizing: border-box;
			-moz-box-sizing: border-box;
			box-sizing: border-box;
			}
			#bepro-listings-images .inside #listing_images_container ul ul.actions li {
			float: right;
			margin: 0 0 0 2px;
			}
			#bepro-listings-images .inside #listing_images_container ul ul.actions li a.delete:before {
				font-family: 'dashicons' !important;
				speak: none;
				font-weight: 400;
				font-variant: normal;
				text-transform: none;
				line-height: 1;
				-webkit-font-smoothing: antialiased;
				margin: 0;
				text-indent: 0;
				position: absolute;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
				text-align: center;
				content: '\f156';
				color: #fff;
				background-color: #000;
				-webkit-border-radius: 100%;
				border-radius: 100%;
				box-shadow: 0 1px 2px rgba(0,0,0,.2);
			}
			#bepro-listings-images .inside #listing_images_container ul li img{
				width:100%;
				display: block;
				height: auto;
			}
			#bepro-listings-images .add_listing_images {
				display:block;
				clear:both;
			}
			#bepro-listings-images .inside #listing_images_container ul ul.actions {
				position: absolute;
				top: -8px;
				right: -8px;
				padding: 2px;
				display: none;
			}
			#listing_images_container ul ul.actions li a.delete{display:block;text-indent:-9999px;position:relative;height:1em;width:1em;font-size:1.4em}
			#listing_images_container ul ul.actions li a.delete:hover:before{background-color:#a00}
			#bepro-listings-images .inside #listing_images_container ul li:hover ul.actions{display:block}
		  </style>
		  ";
		echo '
			<script type="text/javascript">
				jQuery(document).ready(function(){
					if(jQuery("#bepro_listings_tabs")){
						jQuery( "#bepro_listings_tabs" ).tabs();
					}
					if(jQuery("#bepro_listings_addon_tabs")){
						jQuery( "#bepro_listings_addon_tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
						jQuery( "#bepro_listings_addon_tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
						jQuery( ".admin_addon_form" ).submit(function(e){
							e.preventDefault();
							id = jQuery(this)[0].id;
							jQuery.post(ajaxurl, jQuery("#" + id).serialize(), function(rtn){
								if(rtn == 1){
									alert("Form saved!");
								}else{
									alert("!Form save error!");
								}								
							})
						});
					}
					jQuery(".bepro_listings_admin_form").css("display","block");
					jQuery(".bepro_listings_loading_msg").css("display","none");
					jQuery("#require_payment").change(function(rp){
						if(jQuery(this).val() == 2){
							jQuery("#flat_fee_details").css("display", "block");
							jQuery("#payment_options").css("display", "block");
						}else if(jQuery(this).val() == 1){
							jQuery("#payment_options").css("display", "block");
						}else{
							jQuery("#flat_fee_details").css("display", "none");
							jQuery("#payment_options").css("display", "none");
						}
					});
					if(jQuery("#require_payment").val() != 2)
						jQuery("#flat_fee_details").css("display", "none");
						
					if(jQuery("#require_payment").val() == "")
						jQuery("#payment_options").css("display", "none");
						
				});
			</script>
		';
	}
	
	function permalink_admin_init(){
		add_settings_field(
			'bl_permalink_url',
			'Listing Permalink',
			'permalink_setting_input',
			'permalink',
			'optional'
		);
		add_settings_field(
			'bl_cat_permalink_url',
			'Listing Category Permalink',
			'cat_permalink_setting_input',
			'permalink',
			'optional'
		);
	}
	
	function permalink_setting_input() {
		$options = get_option( 'bepro_listings' );
		$permalink = $options['permalink'];
		
		// echo the field
		?>
	<code><?php bloginfo("url"); ?></code><input id='bl_permalink_option' name='bl_permalink_option'
	 type='text' value='<?php echo esc_attr( $permalink ); ?>' /> e.g. /listings<br />
		<?php
	}

	function cat_permalink_setting_input() {
		// get option 'boss_email' value from the database
		$options = get_option( 'bepro_listings' );
		$cat_permalink = $options['cat_permalink'];
		
		// echo the field
		?>
	<code><?php bloginfo("url"); ?></code><input id='bl_cat_permalink_option' name='bl_cat_permalink_option'
	 type='text' value='<?php echo esc_attr( $cat_permalink ); ?>' /> e.g. /<?php echo BEPRO_LISTINGS_CATEGORY_SLUG;?><br />
		<?php
	}
	
	// Validate user input and return validated data
	function permalink_save_options( ) {
		if(isset($_POST["bl_permalink_option"])){
			$options = get_option( 'bepro_listings' );
			$options["permalink"] = $_POST["bl_permalink_option"];
			$options["cat_permalink"] = $_POST["bl_cat_permalink_option"];
			update_option("bepro_listings", $options);
		}
	}
	
	//Save Bepro Listing
	function bepro_admin_save_details($post_id, $post_after, $post_before){
		global $wpdb;
		if (!isset($_POST['save_bepro_listing'])) return; 
		if ($parent_id = wp_is_post_revision($post_id)) 
			$post_id = $parent_id;
	  
		$post_type = get_post_type( $post_id);
		if($post_type != "bepro_listings")return;
		//get lat/lon
		bepro_listings_save($post_id);
	}

	//Admin Bepro Listings table columns
	function bepro_listings_edit_columns($columns){
		$data = get_option("bepro_listings");
		$columns = array(
			"cb" => "<input type='checkbox' />",
			"title" => "Item Name",
			"description" => "Description");
		if($data["show_geo"]) $columns["lat_lon"] =  "Lat/Lon?";	
		if($data["show_cost"]) $columns["cost"] =   "Cost";	
		$columns["notices"] = "Notices";
		$columns["listing_types"] = "Listing Types";
		$columns["date"] =  "Date";
	 
	  return $columns;
	}
	
	//Admin Bepro Listing table data
	function bepro_listings_custom_columns($column){
	  global $post;
		
	  switch ($column) {
		case "description":
		  the_excerpt();
		  break;
		case "lat_lon":
		  global $wpdb;
		  $custom = $wpdb->get_row("SELECT lat, lon FROM ".$wpdb->prefix.BEPRO_LISTINGS_TABLE_NAME." WHERE post_id =".$post->ID);
		  echo (!empty($custom->lat) && !empty($custom->lon))? "Yes": "No";
		  break;
		case "cost":
		  global $wpdb;
		  $custom = $wpdb->get_row("SELECT cost FROM ".$wpdb->prefix.BEPRO_LISTINGS_TABLE_NAME." WHERE post_id =".$post->ID);
		  echo $custom->cost;
		  break;
		case "notices":
			global $wpdb;
			$data = get_option("bepro_listings");
			$notice = "None";
			$item = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix.BEPRO_LISTINGS_TABLE_NAME." WHERE post_id =".$post->ID);
			$status = (($post->post_status == "publish")? "Published":"Pending");
			if(isset($data["days_until_expire"]) && ($data["days_until_expire"] > 0) && ($status == "Published")){
				$notice = "Expires: ".(empty($item->expires)? "Never":date("M, d Y", strtotime($item->expires)));
			}else if(!empty($data["require_payment"])  && ($status == "Pending")){
				if(is_numeric($item->bepro_cart_id)){
					$notice = "Paid";
				}else if($data["require_payment"] == 1){
					//category option
					$cost = bepro_get_total_cat_cost($item->post_id);
				}else if($data["require_payment"] == 2){
					$cost = $data["flat_fee"];
				}
				
				if($cost > 0){
					$notice = "Requires: $".$cost;
				}
			}
			echo $notice;
		  break;
		case "listing_types":
		  echo get_the_term_list($post->ID, 'bepro_listing_types', '', ', ','');
		  break;
	  }
	}
	
		
	/**
	 * Category thumbnail fields.
	 *
	 * @access public
	 * @return void
	 */
	function bepro_listings_add_category_thumbnail_field() {
		?>
		<div class="form-field">
			<label><?php _e('Thumbnail', 'bepro_listings'); ?></label>
			<div id="bepro_listing_types_thumbnail" style="float:left;margin-right:10px;"><img src="<?php echo bepro_listings_placeholder_img_src(); ?>" width="60px" height="60px" /></div>
			<div style="line-height:60px;">
				<input type="hidden" id="bepro_listing_types_thumbnail_id" name="bepro_listing_types_thumbnail_id" />
				<button type="submit" class="upload_image_button button"><?php _e('Upload/Add image', 'bepro_listings'); ?></button>
				<button type="submit" class="remove_image_button button"><?php _e('Remove image', 'bepro_listings'); ?></button>
			</div>
			<script type="text/javascript">
				
				 // Only show the "remove image" button when needed
				 if ( ! jQuery('#bepro_listing_types_thumbnail_id').val() )
					 jQuery('.remove_image_button').hide();

				window.send_to_editor_default = window.send_to_editor;

				window.send_to_termmeta = function(html) {

					jQuery('body').append('<div id="temp_image">' + html + '</div>');

					var img = jQuery('#temp_image').find('img');

					imgurl 		= img.attr('src');
					imgclass 	= img.attr('class');
					imgid		= parseInt(imgclass.replace(/\D/g, ''), 10);

					jQuery('#bepro_listing_types_thumbnail_id').val(imgid);
					jQuery('#bepro_listing_types_thumbnail img').attr('src', imgurl);
					jQuery('.remove_image_button').show();
					jQuery('#temp_image').remove();

					tb_remove();

					window.send_to_editor = window.send_to_editor_default;
				}

				jQuery('.upload_image_button').live('click', function(){
					var post_id = 0;

					window.send_to_editor = window.send_to_termmeta;

					tb_show('', 'media-upload.php?post_id=' + post_id + '&amp;type=image&amp;TB_iframe=true');
					return false;
				});

				jQuery('.remove_image_button').live('click', function(){
					jQuery('#bepro_listing_types_thumbnail img').attr('src', '<?php echo bepro_listings_placeholder_img_src(); ?>');
					jQuery('#bepro_listing_types_thumbnail_id').val('');
					jQuery('.remove_image_button').hide();
					return false;
				});

			</script>
			<div class="clear"></div>
		</div>
		<?php
	}


	/**
	 * Edit category thumbnail field.
	 *
	 * @access public
	 * @param mixed $term Term (category) being edited
	 * @param mixed $taxonomy Taxonomy of the term being edited
	 * @return void
	 */
	function bepro_listings_edit_category_thumbnail_field( $term, $taxonomy ) {

		$image 			= '';
		$thumbnail_id 	= get_bepro_listings_term_meta( $term->term_id, 'thumbnail_id', true );
		if ($thumbnail_id) :
			$image = wp_get_attachment_url( $thumbnail_id );
		else :
			$image = bepro_listings_placeholder_img_src();
		endif;
		?>
		<tr class="form-field">
			<th scope="row" valign="top"><label><?php _e('Thumbnail', 'bepro_listings'); ?></label></th>
			<td>
				<div id="bepro_listing_types_thumbnail" style="float:left;margin-right:10px;"><img src="<?php echo $image; ?>" width="60px" height="60px" /></div>
				<div style="line-height:60px;">
					<input type="hidden" id="bepro_listing_types_thumbnail_id" name="bepro_listing_types_thumbnail_id" value="<?php echo $thumbnail_id; ?>" />
					<button type="submit" class="upload_image_button button"><?php _e('Upload/Add image', 'bepro_listings'); ?></button>
					<button type="submit" class="remove_image_button button"><?php _e('Remove image', 'bepro_listings'); ?></button>
				</div>
				<script type="text/javascript">

					window.send_to_termmeta = function(html) {

						jQuery('body').append('<div id="temp_image">' + html + '</div>');

						var img = jQuery('#temp_image').find('img');

						imgurl 		= img.attr('src');
						imgclass 	= img.attr('class');
						imgid		= parseInt(imgclass.replace(/\D/g, ''), 10);

						jQuery('#bepro_listing_types_thumbnail_id').val(imgid);
						jQuery('#bepro_listing_types_thumbnail img').attr('src', imgurl);
						jQuery('#temp_image').remove();

						tb_remove();
					}

					jQuery('.upload_image_button').live('click', function(){
						var post_id = 0;

						window.send_to_editor = window.send_to_termmeta;

						tb_show('', 'media-upload.php?post_id=' + post_id + '&amp;type=image&amp;TB_iframe=true');
						return false;
					});

					jQuery('.remove_image_button').live('click', function(){
						jQuery('#bepro_listing_types_thumbnail img').attr('src', '<?php echo bepro_listings_placeholder_img_src(); ?>');
						jQuery('#bepro_listing_types_thumbnail_id').val('');
						return false;
					});

				</script>
				<div class="clear"></div>
			</td>
		</tr>
		<?php
	}



	/**
	 * bepro_listings_category_thumbnail_field_save function.
	 *
	 * @access public
	 * @param mixed $term_id Term ID being saved
	 * @param mixed $tt_id
	 * @param mixed $taxonomy Taxonomy of the term being saved
	 * @return void
	 */
	function bepro_listings_category_thumbnail_field_save( $term_id, $tt_id, $taxonomy ) {
		if ( isset( $_POST['bepro_listing_types_thumbnail_id'] ) )
			update_bepro_listings_term_meta( $term_id, 'thumbnail_id', $_POST['bepro_listing_types_thumbnail_id'] );
	}

	
	function bepro_edit_listing_types_column($theme_columns){
	$new_columns = array(
        'cb' => '<input type="checkbox" />',
        'name' => __('Name'),
        'thumb' => '',
		'description' => __('Description'),
        'slug' => __('Slug'),
        'posts' => __('Posts')
        );
		return $new_columns;
	}

	function bepro_listing_types_column( $columns, $column, $id ) {

		if ( $column == 'thumb' ) {

			$image 			= '';
			$thumbnail_id 	= get_bepro_listings_term_meta( $id, 'thumbnail_id', true );

			if ($thumbnail_id)
				$image = wp_get_attachment_url( $thumbnail_id );
			else
				$image = bepro_listings_placeholder_img_src();

			$columns .= '<img src="' . $image . '" alt="Thumbnail" class="wp-post-image" height="48" width="48" />';

		}

		return $columns;
	}

	
	//Admin css and javascript
	function bepro_listings_adminhead() {
		wp_admin_css('thickbox');
		wp_enqueue_script('editor');
		wp_enqueue_script('media-upload');
		wp_enqueue_script('jquery-ui-tabs');
		wp_enqueue_script('tiny_mce');
		wp_enqueue_script('editor');
		
		do_action('admin_print_styles');
		?><style type="text/css">
		.form_label {
			clear: left;
			display: block;
			float: left;
			margin: 5px 0;
			width: 155px;
		}
		</style>
	<script type="text/javascript">
		// Deals with calling the WordPress Media popup box
		function myMediaPopupHandler(version)
		{
			window.send_to_editor = function(html) {
				imgurl = jQuery('img',html).attr('src');
				jQuery('#upload_image' + version).val(imgurl);
				tb_remove();
			}

			formfield = jQuery('#upload_image' + version).attr('name');
			tb_show('', '<?php echo admin_url(); ?>media-upload.php?type=image&tab=library&TB_iframe=true');
			return false;
		}
	</script>
		<?php
	}

	//Options Page
	function bepro_listings_options() {
		$data = get_option("bepro_listings");
		if(!empty($_POST["update_options"])){
			//general
			$data["show_cost"] = $_POST["show_cost"];
			$data["show_con"] = $_POST["show_con"];
			$data["show_geo"] = $_POST["show_geo"];
			$data["num_images"] = $_POST["num_images"];
			$data["cat_heading"] = $_POST["cat_heading"];
			$data["cat_empty"] = $_POST["cat_empty"];
			$data["cat_singular"] = $_POST["cat_singular"];
			$data["days_until_expire"] = (is_numeric($_POST["days_until_expire"]) && ($_POST["days_until_expire"] > 0))? $_POST["days_until_expire"]:0;
	
			//forms
			$data["validate_form"] = $_POST["validate_form"];
			$data["default_user_id"] = $_POST["default_user_id"];
			$data["default_status"] = $_POST["default_status"];
			$data["success_message"] = $_POST["success_message"];			
			$data["fail_message"] = $_POST["fail_message"];		
			
			//check cat exclude
			$data["bepro_listings_cat_exclude"] = (bl_check_is_valid_cat($_POST["bepro_listings_cat_exclude"]))? $_POST["bepro_listings_cat_exclude"]:"";
			
			//check cat required
			$data["bepro_listings_cat_required"] = (bl_check_is_valid_cat($_POST["bepro_listings_cat_required"]))?$_POST["bepro_listings_cat_required"]:"";
			
			//search listings
			$data["default_image"] = $_POST["default_image"];
			$data["link_new_page"] = $_POST["link_new_page"];
			$data["ajax_on"] = $_POST["ajax_on"];
			$data["num_listings"] = $_POST["num_listings"];
			$data["distance"] = $_POST["distance"];
			$data["search_names"] = $_POST["search_names"];
			$data["title_length"] = is_numeric($_POST["title_length"])?$_POST["title_length"]:$data["title_length"];
			$data["details_link"] = $_POST["details_link"];
			$data["show_web_link"] = $_POST["show_web_link"];
			$data["show_date"] = $_POST["show_date"];
			$data["currency_sign"] = $_POST["currency_sign"];
			
			//Page/post
			$data["gallery_size"] = $_POST["gallery_size"];
			$data["gallery_cols"] = $_POST["gallery_cols"];
			$data["show_details"] = $_POST["show_details"];
			$data["add_detail_links"] = $_POST["add_detail_links"];
			$data["protect_contact"] = $_POST["protect_contact"];
			$data["show_content"] = $_POST["show_content"];
			$data["tabs_type"] = $_POST["tabs_type"];
			
			//map
			$data["map_query_type"] = $_POST["map_query_type"];
			
			//3rd party
			$data["buddypress"] = $_POST["buddypress"];
			
			//payment
			$data["require_payment"] = $_POST["require_payment"];
			$data["flat_fee"] = is_numeric($_POST["flat_fee"])?$_POST["flat_fee"]:0;
			$data["add_to_cart"] = $_POST["add_to_cart"];
			$data["publish_after_payment"] = $_POST["publish_after_payment"];
			
			//repair
			if(!empty($_POST["recreate_templates"]) && ($_POST["recreate_templates"] == 2)){
				$data = create_result_listing_templates($data);
			}
			if(!empty($_POST["bepro_email_notifications"]) && ($_POST["bepro_email_notifications"] == 2)){
				create_bepro_emails_for_bepro_listings();
			}
			
			//Support
			$data["footer_link"] = $_POST["footer_link"];
			
			update_option("bepro_listings", $data);
			
			if(isset($_FILES["csv_upload"]) && !empty($_FILES["csv_upload"]["size"])){
				$delimiter = $_POST["csv_upload_delimiter"];
				$file_path = $_FILES["csv_upload"]["tmp_name"];
				$file = fopen($file_path, 'r');
				$csv_titles = array();
				$counter = 0;
				while (($results = fgetcsv($file, 1500, $delimiter)) !== false){
					if($counter > 0){
						$_POST = "";
						foreach($results as $key => $result){
							$_POST[$csv_titles[$key]] = $result;
						}
						
						if(!empty($csv_titles[0])){
							//check for multiple categories
							$_POST["categories"] = (!empty($_POST["categories"]) && !is_numeric($_POST["categories"]) && (strpos($_POST["categories"],'|') !== false))? str_replace("|",",",$_POST["categories"]):$_POST["categories"]; 
							$_POST["save_bepro_listing"] = 1;
							$post_id = bepro_listings_save(false, true);
							
							if(!empty($_POST["photo"])){
								$remote_url = addslashes(strip_tags($_POST["photo"]));
								bl_attach_remote_file($post_id, $remote_url);
							}
						}
					}else{
						$csv_titles = array_values($results);
					}
					$counter++;
				}
				fclose($file);
			}
			
		}
		
		
		?>
		<h1><?php _e("BePro Listings Options", "bepro-listings"); ?></h1>
		<div class="wrap bepro_listings_admin_form">
			<form class="bepro_listings" method="post" enctype="multipart/form-data">
				<input type="hidden" name="update_options" value="1" />
				<div id="bepro_listings_tabs">
					<ul>
						<li><a href="#tabs-1"><?php _e("General", "bepro-listings"); ?></a></li>
						<li><a href="#tabs-2"><?php _e("Forms", "bepro-listings"); ?></a></li>
						<li><a href="#tabs-3"><?php _e("Search/Listings", "bepro-listings"); ?></a></li>
						<li><a href="#tabs-4"><?php _e("Page/Post", "bepro-listings"); ?></a></li>
						<li><a href="#tabs-5"><?php _e("Map", "bepro-listings"); ?></a></li>
						<li><a href="#tabs-6"><?php _e("3rd Party", "bepro-listings"); ?></a></li>
						<li><a href="#tabs-7"><?php _e("CSV Upload", "bepro-listings"); ?></a></li>
						<li><a href="#tabs-8"><?php _e("Payments", "bepro-listings"); ?></a></li>
						<li><a href="#tabs-9"><?php _e("Repair", "bepro-listings"); ?></a></li>
						<li><a href="#tabs-10"><?php _e("Support", "bepro-listings"); ?></a></li>
					</ul>
				
					<div id="tabs-1">
						<span class="form_label"><?php _e("Show Cost", "bepro-listings"); ?></span><input type="checkbox" name="show_cost" <?php echo ($data["show_cost"]== (1 || "on"))? 'checked="checked"':"" ?>><br />
						<span class="form_label"><?php _e("Show Contact", "bepro-listings"); ?></span><input type="checkbox" name="show_con" <?php echo ($data["show_con"]== (1 || "on"))? 'checked="checked"':"" ?>><br />
						<span class="form_label"><?php _e("Show Geography", "bepro-listings"); ?></span><input type="checkbox" name="show_geo" <?php echo ($data["show_geo"]== (1 || "on"))? 'checked="checked"':"" ?>><br />
						<span class="form_label"><?php _e("# Of Uploads", "bepro-listings"); ?></span><select name="num_images"><br />
							<option value="1" <?php echo ($data["num_images"]== 1)? 'selected="selected"':"" ?>>1</option>
							<option value="2" <?php echo ($data["num_images"]== 2)? 'selected="selected"':"" ?>>2</option>
							<option value="3" <?php echo ($data["num_images"]== 3)? 'selected="selected"':"" ?>>3</option>
							<option value="4" <?php echo ($data["num_images"]== 4)? 'selected="selected"':"" ?>>4</option>
							<option value="5" <?php echo ($data["num_images"]== 5)? 'selected="selected"':"" ?>>5</option>
							<option value="6" <?php echo ($data["num_images"]== 6)? 'selected="selected"':"" ?>>6</option>
							<option value="7" <?php echo ($data["num_images"]== 7)? 'selected="selected"':"" ?>>7</option>
							<option value="8" <?php echo ($data["num_images"]== 8)? 'selected="selected"':"" ?>>8</option>
							<option value="9" <?php echo ($data["num_images"]== 9)? 'selected="selected"':"" ?>>9</option>
							<option value="0" <?php echo ($data["num_images"]== 0)? 'selected="selected"':"" ?>>None</option>
						</select><br />
						<span class="form_label"><?php _e("Category Heading", "bepro-listings"); ?></span><input type="input" name="cat_heading" value="<?php echo $data["cat_heading"]; ?>"><br />
						<span class="form_label"><?php _e("Category Empty", "bepro-listings"); ?></span><input type="input" name="cat_empty" value="<?php echo $data["cat_empty"]; ?>"><br />
						<span class="form_label"><?php _e("Category Singular", "bepro-listings"); ?></span><input type="input" name="cat_singular" value="<?php echo $data["cat_singular"]; ?>"><br />
						<span class="form_label"><?php _e("Days until Listings Expire?", "bepro-listings"); ?></span><input type="text" name="days_until_expire" value="<?php echo $data["days_until_expire"];?>" <?php echo $disabled; ?>><br />
					</div>
					<div id="tabs-2">
						<span class="form_label"><?php _e("Validate Form", "bepro-listings"); ?></span><input type="checkbox" name="validate_form" <?php echo ($data["validate_form"]== (1 || "on"))? 'checked="checked"':"" ?>><br />
						<span class="form_label"><?php _e("Default User Id", "bepro-listings"); ?></span><input type="text" name="default_user_id" value="<?php echo $data["default_user_id"]; ?>"><br />
						<span class="form_label"><?php _e("Default Status", "bepro-listings"); ?></span><select name="default_status">
							<option value="pending" <?php echo ($data["default_status"]== "pending")? 'selected="selected"':"" ?>>Pending</option>
							<option value="publish" <?php echo ($data["default_status"]== "publish")? 'selected="selected"':"" ?>>Published</option>
						</select></br>
						<span class="form_label"><?php _e("Success Message", "bepro-listings"); ?></span><textarea name="success_message"><?php echo $data["success_message"]; ?></textarea><br />
						<span class="form_label"><?php _e("Fail Message", "bepro-listings"); ?></span><textarea name="fail_message"><?php echo $data["fail_message"]; ?></textarea><br />
						<span class="form_label"><?php _e("Required Categories", "bepro-listings"); ?></span><input type="text" name="bepro_listings_cat_required" value="<?php echo $data["bepro_listings_cat_required"]; ?>" /></br>
						<span class="form_label"><?php _e("Exclude Categories", "bepro-listings"); ?></span><input type="text" name="bepro_listings_cat_exclude" value="<?php echo $data["bepro_listings_cat_exclude"]; ?>" /></br>
					</div>
					<div id="tabs-3">
						<span class="form_label"><?php _e("Default Listing Image", "bepro-listings"); ?></span><input type="text" name="default_image" value="<?php echo $data["default_image"]; ?>" /></br>
						<span class="form_label"><?php _e("How Links Open", "bepro-listings"); ?></span><select name="link_new_page">
							<option value="1" <?php echo ($data["link_new_page"] == 1)? 'selected="selected"':"" ?>><?php _e("Go To Page", "bepro-listings"); ?></option>
							<option value="2" <?php echo ($data["link_new_page"] == 2)? 'selected="selected"':"" ?>><?php _e("New Tab", "bepro-listings"); ?></option>
							<option value="3" <?php echo ($data["link_new_page"] == 3)? 'selected="selected"':"" ?>><?php _e("Ajax Page", "bepro-listings"); ?></option>
							<option value="4" <?php echo ($data["link_new_page"] == 4)? 'selected="selected"':"" ?>><?php _e("Hide Internal", "bepro-listings"); ?></option>
						</select><br />
						<span class="form_label"><?php _e("Ajax On?", "bepro-listings"); ?></span><input type="checkbox" name="ajax_on" <?php echo ($data["ajax_on"]== (1 || "on"))? 'checked="checked"':"" ?>><br />
						<span class="form_label"><?php _e("Default # Listings", "bepro-listings"); ?></span><select name="num_listings">
							<option value="1" <?php echo ($data["num_listings"]== 1)? 'selected="selected"':"" ?>>1</option>
							<option value="3" <?php echo ($data["num_listings"]== 3)? 'selected="selected"':"" ?>>3</option>
							<option value="5" <?php echo ($data["num_listings"]== 5)? 'selected="selected"':"" ?>>5</option>
							<option value="8" <?php echo ($data["num_listings"]== 8)? 'selected="selected"':"" ?>>8</option>
							<option value="10" <?php echo ($data["num_listings"]== 10)? 'selected="selected"':"" ?>>10</option>
							<option value="12" <?php echo ($data["num_listings"]== 12)? 'selected="selected"':"" ?>>12</option>
							<option value="16" <?php echo ($data["num_listings"]== 16)? 'selected="selected"':"" ?>>16</option>
							<option value="20" <?php echo ($data["num_listings"]== 20)? 'selected="selected"':"" ?>>20</option>
							<option value="50" <?php echo ($data["num_listings"]== 50)? 'selected="selected"':"" ?>>50</option>
						</select></br>
						<span class="form_label"><?php _e("Default Search Distance (Mi)", "bepro-listings"); ?></span><select name="distance">
							<option value="10" <?php echo ($data["distance"]== 10)? 'selected="selected"':"" ?>>10</option>
							<option value="50" <?php echo ($data["distance"]== 50)? 'selected="selected"':"" ?>>50</option>
							<option value="150" <?php echo ($data["distance"]== 150)? 'selected="selected"':"" ?>>150</option>
							<option value="250" <?php echo ($data["distance"]== 250)? 'selected="selected"':"" ?>>250</option>
							<option value="500" <?php echo ($data["distance"]== 500)? 'selected="selected"':"" ?>>500</option>
							<option value="1000" <?php echo ($data["distance"]== 1000)? 'selected="selected"':"" ?>>1000</option>
						</select>
						<span style="clear:both;display: block;"><br /></span>
						<span class="form_label"><?php _e("Name Search", "bepro-listings"); ?></span><select name="search_names">
							<option value="1" <?php echo ($data["search_names"]== 1)? 'selected="selected"':"" ?>>Title Only</option>
							<option value="2" <?php echo ($data["search_names"]== 2)? 'selected="selected"':"" ?>>Contact Name Only</option>
							<option value="3" <?php echo ($data["search_names"]== 3)? 'selected="selected"':"" ?>>Both</option>
							<option value="4" <?php echo ($data["search_names"]== 4)? 'selected="selected"':"" ?>>None</option>
						</select><br />
						<span class="form_label"><?php _e("Title Length", "bepro-listings"); ?></span><input type="text" name="title_length" value="<?php echo $data["title_length"]; ?>" /></br>
						<span class="form_label"><?php _e("Details Link Text", "bepro-listings"); ?></span><input type="text" name="details_link" value="<?php echo $data["details_link"]; ?>" /></br>
						<span class="form_label"><?php _e("Show Website Link?", "bepro-listings"); ?></span><input type="checkbox" name="show_web_link" <?php echo (($data["show_web_link"]==1) || ($data["show_web_link"]== "on"))? 'checked="checked"':"" ?> value="1"><br />
						<span class="form_label"><?php _e("Currency Sign?", "bepro-listings"); ?></span><input type="text" name="currency_sign" value="<?php echo $data["currency_sign"]; ?>" /></br>
						<span class="form_label"><?php _e("Show Date filter?", "bepro-listings"); ?></span><input type="checkbox" name="show_date" <?php echo ($data["show_date"]== (1))? 'checked="checked"':"" ?> value="1"><br />
						<span style="clear:both;display: block;"><br /></span>
					</div>
					<div id="tabs-4">
						<span class="form_label"><?php _e("Gallery Size", "bepro-listings"); ?></span><select name="gallery_size">
							<option value="thumbnail" <?php echo ($data["gallery_size"]== "thumbnail")? 'selected="selected"':"" ?>>thumbnail</option>
							<option value="medium" <?php echo ($data["gallery_size"]== "medium")? 'selected="selected"':"" ?>>medium</option>
							<option value="large" <?php echo ($data["gallery_size"]== "large")? 'selected="selected"':"" ?>>large</option>
							<option value="full" <?php echo ($data["gallery_size"]== "full")? 'selected="selected"':"" ?>>full</option>
						</select><br />
						<span class="form_label"><?php _e("# Gallery Columns", "bepro-listings"); ?></span><select name="gallery_cols">
							<option value="3" <?php echo ($data["gallery_cols"]== 3)? 'selected="selected"':"" ?>>3</option>
							<option value="5" <?php echo ($data["gallery_cols"]== 5)? 'selected="selected"':"" ?>>5</option>
							<option value="8" <?php echo ($data["gallery_cols"]== 8)? 'selected="selected"':"" ?>>8</option>
						</select><br />
						<span class="form_label"><?php _e("Show Details", "bepro-listings"); ?></span><input type="checkbox" name="show_details" <?php echo (($data["show_details"]==1) || ($data["show_details"] == "on"))? 'checked="checked"':"" ?>><br />
						<span class="form_label"><?php _e("Links on Details", "bepro-listings"); ?></span><input type="checkbox" name="add_detail_links" <?php echo (($data["add_detail_links"]==1) || ($data["add_detail_links"] == "on"))? 'checked="checked"':"" ?>><br />
						<span class="form_label"><?php _e("Protect Contact", "bepro-listings"); ?></span><input type="checkbox" name="protect_contact" <?php echo (($data["protect_contact"]== 1) || ($data["protect_contact"] == "on"))? 'checked="checked"':"" ?>><br />
						<span class="form_label"><?php _e("Show Content", "bepro-listings"); ?></span><input type="checkbox" name="show_content" <?php echo (($data["show_content"]==1) || ($data["show_content"] == "on"))? 'checked="checked"':"" ?>><br />
						<span class="form_label"><?php _e("Tab Direction", "bepro-listings"); ?></span><select name="tabs_type">
							<option value="1" <?php echo ($data["tabs_type"] == 1)? 'selected="selected"':""; ?>>Vertical</option>
							<option value="2" <?php echo ($data["tabs_type"] == 2)? 'selected="selected"':""; ?>>Horizontal</option>
						</select>	
					</div>
					<div id="tabs-5">
						<span class="form_label"><?php _e("Query Type", "bepro-listings"); ?></span><select name="map_query_type">
							<option value="curl" <?php echo ($data["map_query_type"] == "curl")? 'selected="selected"':""; ?>>Curl</option>
							<option value="file_get_contents" <?php echo ($data["map_query_type"] == "file_get_contents")? 'selected="selected"':""; ?>>file_get_contents</option>
						</select>	
					</div>
					<div id="tabs-6">
						<span class="form_label"><?php _e("Buddypress", "bepro-listings"); ?></span><input type="checkbox" name="buddypress" <?php echo ($data["buddypress"]== (1 || "on"))? 'checked="checked"':"" ?>>
					</div>
					<div id="tabs-7">
						<p>CSV upload documenation avaialble <a href="https://www.beprosoftware.com/documentation/listing-csv-upload/" target="_blank">here</a></p>
						<span class="form_label"><?php _e("CSV File", "bepro-listings"); ?></span><input type="file" name="csv_upload" value=""><br />
						<span class="form_label"><?php _e("Delimiter", "bepro-listings"); ?></span><select name="csv_upload_delimiter">
							<option value=";">;</option>
							<option value=",">,</option>
							<option value="#*">#*</option>
						</select>
					</div>
					<div id="tabs-8">
						<?php 
							if(!class_exists("Bepro_cart")){
								$disabled = "disabled='disabled'";
								echo "<p>You need to download and install <a href='https://www.beprosoftware.com/shop/bepro-cart' target='_blank'>BePro Cart</a> to activate payment features.</p>";
							}else{
								$disabled = "";
							}
						?>
						<span class="form_label"><?php _e("Accept Payments?", "bepro-listings"); ?></span><select name="require_payment" id="require_payment" <?php echo $disabled; ?>>
							<option value="">Do Not Charge</option>
							<option value="1" <?php echo ($data["require_payment"] == 1)? "selected='selected'":""; ?>>Charge Per Category</option>
							<option value="2" <?php echo ($data["require_payment"] == 2)? "selected='selected'":""; ?>>Charge Flat Fee</option>
						</select><br />
						<div id="flat_fee_details">
							<span class="form_label"><?php _e("Flat Fee", "bepro-listings"); ?></span><input type="text" name="flat_fee" value="<?php echo $data["flat_fee"];?>" <?php echo $disabled; ?>><br />
						</div>
						<div id="payment_options">
							<span class="form_label"><?php _e("Add price to cart?", "bepro-listings"); ?></span><input type="checkbox" name="add_to_cart" value="1" <?php echo ($data["add_to_cart"] == 1)? "checked='checked'":""; ?> <?php echo $disabled; ?>><br />
							<span class="form_label"><?php _e("Publish after confirm Paid?", "bepro-listings"); ?></span><input type="checkbox" name="publish_after_payment" value="1" <?php echo ($data["publish_after_payment"] == 1)? "checked='checked'":""; ?> <?php echo $disabled; ?>><br /><br />
						</div>
					</div>
					<div id="tabs-9">
						<?php 
							if(!class_exists("Bepro_email")){
								$disabled = "disabled='disabled'";
								echo "<p>You need to download and install <a href='https://www.beprosoftware.com/shop/bepro-email' target='_blank'>BePro Email</a> to activate notification features.</p>";
							}else{
								$disabled = "";
							}
						?>
						<span class="form_label"><?php _e("Recreate Search Result Templates", "bepro-listings"); ?></span><input type="checkbox" name="recreate_templates" value="2"><br /><br />
						<span class="form_label"><?php _e("Recreate BePro Email Notifications", "bepro-listings"); ?></span><input type="checkbox" name="bepro_email_notifications" <?php echo $disabled; ?> value="2"><br />
					</div>
					<div id="tabs-10">
						<a href="http://beprosoftware.com"><img src="<?php echo BEPRO_LISTINGS_PLUGIN_PATH."/images/bepro_software_logo.png"; ?>"></a><br />
						<iframe width="560" height="315" src="//www.youtube.com/embed/D5YpZX0go88" frameborder="0" allowfullscreen></iframe>
						<p><b>THANK YOU</b> for your interest and support of this plugin. Our BePro Software Team is dedicated to providing you with the tools needed for great websites. You can get involved in any of the following ways:</p>
						<h2>Support For You</h2>
						<ul style="border:1px solid; padding:10px">
							<li>Subscriptions - We offer various <a href="http://beprosoftware.com/subscriptions" target="_blank">subscription</a> options for discounts, freebies, videos, newsletters and access to other unique wordpress / BePro Listings related content</li>
							<li>Support Forum - Join our <a href="http://beprosoftware.com/forums" target="_blank">forums</a> for any support questions</li>
							<li>Documentation - Instructions, videos, shortcodes, and more on <a href="http://beprosoftware.com/products/bepro-listings/">this dedicated page</a></li>
							<li>Contact Us - Send us an email via our <a href="http://www.beprosoftware.com/contact-us/">Contact Us</a> Page</li>
							<li>Upgrades - View our list of <a href="http://www.beprosoftware.com/products/" target="_blank">wordpress plugins and themes</a></li>
							<li>Services - We offer <a href="http://www.beprosoftware.com/services/" target="_blank">Various services</a> including support starting at $15/hr</li>
							<li>Social - Our <a href="https://twitter.com/BeProSoftware" target="_blank">Twitter Page</a></li>
							<li>Youtube - Our <a href="http://www.youtube.com/playlist?list=PLMzIqO2N1YpjMx4QfiCjwFsxxfHVy1goG" target="_blank">Youtube Playlist</a> managed by <a href="http://www.adcoordinates.com" target="_blank">Ad Coordinates</a></li>
						</ul>
						<h2>Support For The Plugin</h2>
						<ul style="border:1px solid; padding:10px">		
							<li><a href="http://wordpress.org/support/view/plugin-reviews/bepro-listings" target="_blank"><span style="color:green;font-weight:bold;font-size:18px;text-decoration:underline">Rate Us</span></a> - Give this plugin a <a href="http://wordpress.org/support/view/plugin-reviews/bepro-listings" target="_blank"><span style="color:green;font-weight:bold;font-size:18px;text-decoration:underline">rating</span></a> on <a href="http://wordpress.org/support/view/plugin-reviews/bepro-listings" target="_blank">Wordpress.org</a>. This is the best way to support the plugin and encourage its growth</li>
							<li>Donations - We accept donations of any amount <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=support@beprosoftware.com&item_name=Donation+for+BePro+Listings">via paypal</a></li>
							<li><?php _e("Our Link in your footer?", "bepro-listings"); ?> - <input style="vertical-align:middle" type="checkbox" name="footer_link" value="1" <?php echo ($data["footer_link"]== ("on" || 1))? 'checked="checked"':"" ?>></li>
						</ul>
						<p>NOTE: We can help with customizing this plugin to fit any of your needs. Simply <a href="http://www.beprosoftware.com/contact-us/" target="_blank">reach out</a>. You will receive a personalized responce from a senior member of our <b>BePro Software Team</b></p>
						<hr />
						<p><b>BePro Software&trade;</b> is a service owned and operated by <a href="http://beyondprograms.ca" target="_blank">Beyond Programs Ltd.</a> a Canadian company.</p>
					</div>
				</div>
				<span style="clear:both;display: block;"><br /></span>
				<input type="submit" name="submit" value="<?php _e("Update BePro Listings Options", "bepro-listings"); ?> &raquo" />
			</form>
		</div>
		<div class="bepro_listings_loading_msg">
		<p>Jquery is loading... Please wait</p>
		</div>	
			<?php	
	}
	
	function bepro_listings_addons(){
			ob_start();
			do_action('bepro_listings_admin_tabs');
			$tabs = trim( ob_get_clean() );
			?>
		<h1>Add-On Options</h1>
		<div class="wrap bepro_listings_admin_form">
			<div id="bepro_listings_addon_tabs">
				<ul class="tabs">
					<?php echo $tabs; ?>
				</ul>
				<?php do_action('bepro_listings_admin_tab_panels'); ?>
			</div>	
		</div>
		<div class="bepro_listings_loading_msg">
		<p>Jquery is loading... Please wait</p>
		</div>
		<?php
	}
	
	function bl_tinymce_add_buttons($plugin_array){
		if(get_post_type(get_the_ID()) == "bepro_listings") return $plugin_array;
		$plugin_array['bepro_listings'] = plugins_url('../js/bl_tinymce_buttons.js', __FILE__ );
		return $plugin_array;
	}
	
	function bl_tinymce_register_buttons($buttons){
		if(get_post_type(get_the_ID()) == "bepro_listings") return $buttons;
		array_push( $buttons, 'beprolistings'); 
		return $buttons;
	}
	
	function bepro_listings_shortcode_dialog(){
		wp_print_scripts("jquery");
		echo '
		<style type="text/css">
			.shorcode_options{
				padding: 2px 5px;
				margin: 5px 0;
				border: 1px solid;
			}
			.shorcode_options p{
				background-color:#dfdfdf;
				padding: 0px 3px;
			}
			.hide_options{
				display:none;
			}
			.shortcode_label{
				width: 140px !important;
				display: inline-block;
			}
		</style>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery("#send_bl_shortcode").click(function(){
					val = jQuery("#bl_shortcode_type").val();
					shortcode = "[" + val;
					
					form = "form_" + val;
					form_vals = jQuery("#" + form).serialize();
					if(form_vals.length > 0){
						form_vals = form_vals.split("&");
						for(i=0; i< form_vals.length; i++){
							input_vals = form_vals[i].split("=");
							if((input_vals[0].length > 0) && (input_vals[1].length > 0)){
								shortcode = shortcode + " " + input_vals[0] + "= \'" + decodeURIComponent(input_vals[1]) + "\'"
							}
						}
					}
					
					shortcode = shortcode + "]";
					parent.tinyMCE.activeEditor.execCommand( "mceInsertContent", false, shortcode );
					parent.tinyMCE.activeEditor.windowManager.close(window);
				});
			
				jQuery("#bl_shortcode_type").change(function(e){
					val = jQuery(this).val();
					id = "tab_" + val;
					
					jQuery(".shorcode_options").addClass("hide_options");
					jQuery("#" + id).removeClass("hide_options");
				});
			});
		</script>
		';
		
		
		echo "
			<p><a href='https://www.beprosoftware.com/documentation/bepro-listings-shortcodes/' target='_blank'>Click here</a> to view complete shortcode documentation</p>
			<span class='shortcode_label'>Select Shortcode</span> <select id='bl_shortcode_type'>
				<option value='bl_all_in_one'>All In One</option>
				<option value='display_listings'>Show Listings</option>
				<option value='filter_form'>Search Filter Table</option>
				<option value='bl_search_filter'>Search Filter Css</option>
				<option value='search_form'>Search Form</option>
				<option value='generate_map'>Show Map</option>
				<option value='display_listing_categories'>Show Categories</option>
				<option value='create_listing_form'>Front End Form</option>
				<option value='bl_my_listings'>My Listings</option>
			</select><br />
			
			<div id='tab_bl_all_in_one' class='shorcode_options'>
				<p class='shortcode_desc'>All In one shortcode is an easy way to get started. It calls other shortcodes for you, delivering several features at once. Its easy to switch between the available options or simply use the shortcodes you need. </p>
				<form id='form_bl_all_in_one' method='post'>
					<span class='shortcode_label'>Template</span><select name='l_type'>
						<option value=''>Full Width Map</option>
						<option value='a1'>Small Map</option>
						<option value='a2'>Med Map</option>
						<option value='a3'>Large Map</option>
						<option value='a4'>No Map</option>
					</select>
				</form>
			</div>
			<div id='tab_display_listings' class='shorcode_options hide_options'>
				<p class='shortcode_desc'>Show Listings and search results. By default, the latest x Listings are shown. X (# of listings) is a setting in the admin</p>
				<form id='form_display_listings' method='post'>
					<span class='shortcode_label'>Show Paging?</span><input type='checkbox' value=1 name='show_paging' /></br />
					<span class='shortcode_label'>Template</span><select name='type'>
						<option value='1'>Small</option>
						<option value='2'>Large</option>
					</select><br />
					<span class='shortcode_label'>Order By</span><select name='order_by'>
						<option value='1'>Post Title</option>
						<option value='2'>Randomize</option>
						<option value='2'>Last Name</option>
					</select><br />
					<span class='shortcode_label'>Order Dir</span><select name='order_dir'>
						<option value='1'>Asc</option>
						<option value='2'>Desc</option>
					</select><br />
					<span class='shortcode_label'>Featured?</span><input type='checkbox' value=1 name='l_featured' /></br />
					<span class='shortcode_label'>Listing ID's</span><input type='text' name='l_ids' placeholder='e.g. 13,34,55,22'/><br />
					<span class='shortcode_label'>Exclude Categories</span><input type='text' name='ex_type' placeholder='e.g. 13,34,55,22'/>
				</form>
			</div>
			<div id='tab_filter_form' class='shorcode_options hide_options'>
				<p class='shortcode_desc'>Show the Search Filter with a table layout. This is the exact same component as the search filter widget.</p>
				<form id='form_filter_form' method='post'>
					<span class='shortcode_label'>Listing page</span><input type='text' name='listing_page' />
				</form>
			</div>
			<div id='tab_bl_search_filter' class='shorcode_options hide_options'>
				<p class='shortcode_desc'>Show the Search filter with a CSS layout. This responsive element will adapt to the space you put it in.</p>
				<form id='form_bl_search_filter' method='post'>
					<span class='shortcode_label'>Listing page</span><input type='text' name='listing_page' /></br />
					<span class='shortcode_label'>Category ID</span><input type='text' name='l_type'  size=1 placeholder='e.g. 5'/></br />
				</form>
			</div>
			<div id='tab_search_form' class='shorcode_options hide_options'>
				<p class='shortcode_desc'>Search form with name and location. If you have geo features turned off, the location option will not be available. Name refers to the contact name, title or both depending on your admin configuration</p>
				<form id='form_search_form' method='post'>
					<span class='shortcode_label'>Listing page</span><input type='text' name='listing_page' />
				</form>
			</div>
			<div id='tab_generate_map' class='shorcode_options hide_options'>
				<p class='shortcode_desc'>Show the google map with markers for each listing</p>
				<form id='form_generate_map' method='post'>
					<span class='shortcode_label'>Category ID's</span><input type='text' name='l_type' placeholder='e.g. 11,21,43' /><br />
					<span class='shortcode_label'>Size</span><select name='size'>
						<option value='1'>Small</option>
						<option value='2'>Medium</option>
						<option value='3'>Large</option>
						<option value='4'>Full Width</option>
					</select><br />
					<span class='shortcode_label'>Pop Up?</span><input type='checkbox' value=1 name='pop_up' />
				</form>
			</div>
			<div id='tab_display_listing_categories' class='shorcode_options hide_options'>
				<p class='shortcode_desc'>Show the Listing categories with listings assigned to them.</p>
				<form id='form_display_listing_categories' method='post'>
					<span class='shortcode_label'>URL</span><input type='text' name='url_input' /><br />
					<span class='shortcode_label'>Template</span><select name='ctype'>
						<option value=''>Title Only</option>
						<option value='1'>image & title</option>
						<option value='2'>Image, title, desc</option>
						<option value='3'>title, desc</option>
					</select><br />			
					<span class='shortcode_label'>Category ID</span><input type='text' name='cat' size=1 placeholder='e.g. 6'/>
				</form>
			</div>
			<div id='tab_create_listing_form' class='shorcode_options hide_options'>
				<p class='shortcode_desc'>Show the front end form to capture user information</p>
				<form id='form_create_listing_form' method='post'>
					<span class='shortcode_label'>Register?</span><input type='checkbox' value=1 name='register' /></br />
					<span class='shortcode_label'>Redirect URL</span><input type='text' name='redirect' /><br />
				</form>
			</div>
			<div id='tab_bl_my_listings' class='shorcode_options hide_options'>
				<p class='shortcode_desc'>Show the user profile page, allowing them to edit their listings</p>
				<form id='form_bl_my_listings' method='post'>
				
				</form>
			</div>
			<button id='send_bl_shortcode'>Use ShortCode</button>";
		exit;
	}
	
	function bepro_listings_add_settings_link($links) {
		$links[] = '<a href="edit.php?post_type=bepro_listings&page=bepro_listings_options">' . (__("Settings", "bepro-listings")) . '</a>';
		$links[] = '<a href="https://www.beprosoftware.com/forums">' . (__("Support", "bepro-listings")) . '</a>';
		return $links;
	}
?>

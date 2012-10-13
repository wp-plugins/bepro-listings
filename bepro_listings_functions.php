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
 
	function bepro_listings_wphead() {
		echo '<link type="text/css" rel="stylesheet" href="'.plugins_url('bepro_listings/css/bepro_listings.css').'" ><link type="text/css" rel="stylesheet" href="'.plugins_url('bepro_listings/css/jquery-ui-1.8.18.custom.css').'" ><meta name=\"plugin\" content=\"Bepro Listings plugin\">';
		
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-datepicker');
		wp_enqueue_script('google-maps' , 'http://maps.google.com/maps/api/js' , false , '3.5&sensor=false');
	} 

	function bepro_listings_javascript() {
		$plugindir = plugins_url("bepro_listings");
		
		$scripts .= "\n".'<script type="text/javascript" src="'.$plugindir.'/js/bepro_listings.js"></script><script type="text/javascript" src="'.plugins_url("bepro_listings/js/markerclusterer.js").'"></script><script type="text/javascript" src="'.plugins_url("bepro_listings/js/jquery.validate.min.js").'"></script><script type="text/javascript" src="'.plugins_url("bepro_listings/js/jquery.maskedinput-1.3.min.js").'"></script>';
		
		$scripts .= '
		<script type="text/javascript">
            jQuery(document).ready(function(){
				jQuery("#min_date").datepicker();
				jQuery("#max_date").datepicker();
			});
		</script>';
		
		echo $scripts;
		return;
	}

	
	function bepro_listings_menus() {
		add_submenu_page('edit.php?post_type=bepro_listings', 'Option', 'Options', 4, 'bepro_listings_options', 'bepro_listings_options');
	}
	
	//Setup database and other needed
	function bepro_listings_install() {
		global $wpdb;
		$bepro_listings_version = '1.1.0';
		$table_name = $wpdb->prefix.BEPRO_LISTINGS_TABLE_NAME;
 		if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'")!=$table_name
				|| version_compare(get_option("bepro_listings_version"), '1.0.0', '<') ) {
			$table_name = $wpdb->prefix.BEPRO_LISTINGS_TABLE_NAME;
			$sql = "CREATE TABLE " . $table_name . " (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				email tinytext DEFAULT NULL,
				phone tinytext DEFAULT NULL,
				cost float DEFAULT NULL,
				post_id int(9) NOT NULL,
				first_name tinytext DEFAULT NULL,
				last_name tinytext DEFAULT NULL,
				address_line1 tinytext DEFAULT NULL,
				city tinytext DEFAULT NULL,
				state tinytext DEFAULT NULL,
				country tinytext DEFAULT NULL,
				postcode tinytext DEFAULT NULL,
				website varchar(55) DEFAULT NULL,
				lat varchar(15) DEFAULT NULL,
				lon varchar(15) DEFAULT NULL,
				created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY  (id),
				UNIQUE KEY `post_id` (`post_id`)
			);";

			require_once(ABSPATH . 'wp-admin/upgrade-functions.php');
			dbDelta($sql);
			
			//initial bepro listing
			$user_id = get_current_user_id();
			$post = array(
				  'post_author' => $user_id,
				  'post_content' => "This is your first listing. Delete this one in your admin and create one of your own.",
				  'post_status' => "publish", 
				  'post_title' => "Your First Listing",
				  'post_type' => "bepro_listings"
				);  
				
			//Create post
			$post_id = wp_insert_post( $post, $wp_error ); 
			
			//add first image
			
			$upload_dir = wp_upload_dir();
			$to_filename = $upload_dir['path']."no_img.jpg";
			$full_filename = plugins_url("bepro_listings/images/no_img.jpg");
			$attachment = array(
				 'post_mime_type' => "image/jpeg",
				 'post_title' => "No Image",
				 'post_content' => '',
				 'post_status' => 'inherit'
			);
			copy($full_filename, $to_filename);
			
			$attach_id = wp_insert_attachment( $attachment, $to_filename, $post_id);
			$attach_data = wp_generate_attachment_metadata( $attach_id, $to_filename);
			wp_update_attachment_metadata( $attach_id, $attach_data );
			
		}
		//set version
		update_option('bepro_listings_version', $bepro_listings_version);
		
		if(!empty($post_id))$wpdb->query("UPDATE ".$wpdb->prefix.BEPRO_LISTINGS_TABLE_NAME." SET email='support@beprosoftware.com', phone='555-445-5544', cost=0, address_line1='', city='halifax', postcode='', state='NS', country='Canada', website='beprosoftware.com', lat='44.6470678', lon='-63.5747943', first_name='John', last_name='Tester' WHERE post_id=".$post_id);
		
		//load options if not already existant		
		$data = get_option("bepro_listings");
		if(empty($data)){
			//general
			$data["show_cost"] = 1;
			$data["show_con"] = 1;
			$data["show_geo"] = 1;
			$data["num_images"] = 3;
			//forms
			$data["validate_form"] = 1;
			$data["success_message"] = 'Listing Created and pending admin approval.';			
			$data["default_user_id"] = get_current_user_id();			
			//search listings
			$data["default_image"] = plugins_url("bepro_listings/images/no_img.jpg");
			$data["num_listings"] = 3;
			$data["distance"] = 150;
			//Page/post
			$data["gallery_size"] = "thumbnail";
			$data["show_details"] = 1;
			$data["show_content"] = 1;
			//Support
			$data["footer_link"] = 0;
			//save
			update_option("bepro_listings", $data);
		}else{
			if($data["footer_link"] == ("on" || 1)){
				add_action("wp_footer", "footer_message");
			}
		}
	}
	
	//if selected, show link in footer
	function footer_message(){
		echo '<div id="bepro_lisings_footer">
								<a href="http://www.beprosoftware.com/products/bepro-listings" title="Wordpress Plugin" rel="generator">Proudly powered by BePro Lisitngs</a>
			</div>';
	}
	
	
	function load_constants(){
		// The Main table name
		if ( !defined( 'BEPRO_LISTINGS_TABLE_NAME' ) )
			define( 'BEPRO_LISTINGS_TABLE_NAME', 'bepro_listings' );
		
		//Load Languages
		load_plugin_textdomain( 'bepro-listings', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}
	
	
	//Search wordpress table hierarchy for custom post type 'bepro_listing_types'
	function listing_types(){
		global $wpdb;
		return $wpdb->get_results("SELECT *
			FROM ".$wpdb->prefix."terms AS terms
			LEFT JOIN ".$wpdb->prefix."term_taxonomy AS tx ON tx.term_id = terms.term_id
			WHERE tx.taxonomy = 'bepro_listing_types'");
	}
	
	//Return Listings that meet requested critera.
	function bepro_get_listings($returncaluse = false, $catfinder = false, $limit_clause = false){
		global $wpdb;
		if($catfinder)$cat_finder = "LEFT JOIN ".$wpdb->prefix."term_relationships rel ON rel.object_id = posts.ID
				LEFT JOIN ".$wpdb->prefix."term_taxonomy tax ON tax.term_taxonomy_id = rel.term_taxonomy_id
				LEFT JOIN ".$wpdb->prefix."terms t ON t.term_id = tax.term_id";
		if(!empty($returncaluse)){//if we have a search query
			$raw_results = $wpdb->get_results("SELECT geo.*, posts.post_title, posts.post_content, posts.post_status FROM ".$wpdb->prefix.BEPRO_LISTINGS_TABLE_NAME." as geo 
		LEFT JOIN ".$wpdb->prefix."posts as posts on posts.ID = geo.post_id $cat_finder WHERE (posts.post_status = 'publish' OR posts.post_status = 'private') $returncaluse $limit_clause");
		}else{//general blank search
			$raw_results = $wpdb->get_results("SELECT geo.*, posts.post_title, posts.post_content, posts.post_status FROM ".$wpdb->prefix.BEPRO_LISTINGS_TABLE_NAME." as geo 
		LEFT JOIN ".$wpdb->prefix."posts as posts on posts.ID = geo.post_id $cat_finder WHERE (posts.post_status = 'publish' OR posts.post_status = 'private') $limit_clause");	
		}
		return $raw_results;
	}
	
	//Get the categores of a Bepro Listing
	function listing_types_by_post($post_id){
		global $wpdb;
		return $wpdb->get_results("SELECT p.ID, t.term_id
				FROM ".$wpdb->prefix."posts p
				LEFT JOIN ".$wpdb->prefix."term_relationships rel ON rel.object_id = p.ID
				LEFT JOIN ".$wpdb->prefix."term_taxonomy tax ON tax.term_taxonomy_id = rel.term_taxonomy_id
				LEFT JOIN ".$wpdb->prefix."terms t ON t.term_id = tax.term_id
				WHERE p.ID =".$post_id);
	}
	
	//On delete post, also delete the listing from the database and all attachments
	function bepro_delete_post($post_id){
		global $wpdb;
		$wpdb->query("DELETE FROM ".$wpdb->prefix.BEPRO_LISTINGS_TABLE_NAME." WHERE post_id =".$post_id);
		return;
	}
	
	//Create BePro Listings custom post type.
	function create_post_type() {
		$labels = array(
			'name' => _x('BePro Listings', 'post type general name'),
			'singular_name' => _x('Listing', 'post type singular name'),
			'add_new' => _x('Add New', 'Listing'),
			'add_new_item' => __('Add New Listing'),
			'edit_item' => __('Edit Listing'),
			'new_item' => __('New Listing'),
			'view_item' => __('View Listing'),
			'search_items' => __('Search Listing'),
			'not_found' =>  __('Nothing found'),
			'not_found_in_trash' => __('Nothing found in Trash'),
			'parent_item_colon' => ''
		);
	 
		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'menu_icon' => plugins_url("bepro_listings/images/blogs.png") ,
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => null,
			'supports' => array('title','editor','thumbnail', 'comments', 'revisions', 'page-attributes')
		  ); 
	 
		register_post_type( 'bepro_listings' , $args );
		register_taxonomy("bepro_listing_types", array("bepro_listings"), array("hierarchical" => true, "label" => "Listing Types", "singular_label" => "Listing Type", "rewrite" => true));
	}
?>

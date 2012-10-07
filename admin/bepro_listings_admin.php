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
		add_meta_box("cost_meta", "Cost $", "cost_meta", "bepro_listings", "side", "low");
		add_meta_box("contact_details_meta", "Lisiting Details", "contact_details_meta", "bepro_listings", "normal", "low");
		add_meta_box("geographic_details_meta", "Geographic Details", "geographic_details_meta", "bepro_listings", "normal", "low");
	}
	
	function bepro_admin_head(){
		echo "<style type='text/css'>.bepro_listings input[type=checkbox]{margin:11px 0;}</style>";
	}
	function cost_meta(){
	  global $wpdb, $post;
	  $listing = $wpdb->get_row("SELECT cost FROM ".$wpdb->prefix.BEPRO_LISTINGS_TABLE_NAME." WHERE post_id =".$post->ID);
	  ?>
	  <span class="form_label">Cost:</span>
	  <input name="cost" value="<?php echo $listing->cost; ?>" />
	  <?php
	}
	 
	function contact_details_meta($post) {
	  global $wpdb;
	  $listing = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix.BEPRO_LISTINGS_TABLE_NAME." WHERE post_id =".$post->ID);
	  echo '
		<input type="hidden" name="save_bepro_listings" value="1">
		<span class="form_label">First Name</span><input type="text" name="first_name" value="'.$listing->first_name.'"><br />
		<span class="form_label">Last Name</span><input type="text" name="last_name" value="'.$listing->last_name.'"><br />
		<span class="form_label">Phone</span><input type="text" name="phone" value="'.$listing->phone.'"><br />
		<span class="form_label">Email</span><input type="text" name="email" value="'.$listing->email.'"><br />
		<span class="form_label">Website</span><input type="text" name="website" value="'.$listing->website.'"><br />
	  ';
	}
	
	function geographic_details_meta($post) {
	  global $wpdb;
	  $listing = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix.BEPRO_LISTINGS_TABLE_NAME." WHERE post_id =".$post->ID);
	  
	  echo '
		<span class="form_label">Lat</span><input type="test" name="lat" value="'.$listing->lat.'"><br />
		<span class="form_label">Lon</span><input type="test" name="lon" value="'.$listing->lon.'"><br />
		<span class="form_label">Get New Coords?</span><input type="checkbox" name="getlatlon" value="1"><br /><br />
		<span class="form_label">Address</span><input type="text" name="address_line1" value="'.$listing->address_line1.'"><br />
		<span class="form_label">City</span><input type="text" name="city" value="'.$listing->city.'"><br />
		<span class="form_label">State</span><input type="text" name="state" value="'.$listing->state.'"><br />
		<span class="form_label">Country</span><input type="text" name="country" value="'.$listing->country.'"><br />
		<span class="form_label">postcode</span><input type="text" name="postcode" value="'.$listing->postcode.'"><br />
	  ';
	}
	
	//Save Bepro Listing
	function bepro_admin_save_details($post_id){
	  global $wpdb;
	  if (!isset($_POST['save_bepro_listings'])) return; 
	  if ($parent_id = wp_is_post_revision($post_id)) 
		$post_id = $parent_id;
	  
	  $post_type = get_post_type( $post_id);
	  if($post_type != "bepro_listings")return;
		//get lat/lon
		if($_POST['getlatlon'] == 1){  
			if(!empty($_POST['address_line1']) || !empty($_POST['country'])){  
				$to_addr .= !empty($_POST['address_line1'])? $_POST['address_line1']:"";
				$to_addr .= !empty($_POST['city'])? ", ".$_POST['city']:"";
				$to_addr .= !empty($_POST['state'])? ", ".$_POST['state']:"";
				$to_addr .= !empty($_POST['country'])? ", ".$_POST['country']:"";
				$to_addr .= !empty($_POST['postcode'])? ", ".$_POST['postcode']:"";
				$addresstofind_1 = "http://maps.google.com/maps/geo?q=".urlencode($to_addr);
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $addresstofind_1);
				curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.001 (windows; U; NT4.0; en-US; rv:1.0) Gecko/25250101');
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,1);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
				$addr_search_1  =  curl_exec($ch);
				curl_close($ch);
				
				if($addr_search_1)$addr_search_1 = json_decode($addr_search_1);
				if($addr_search_1->Placemark[0]->address){
					$lon = $addr_search_1->Placemark[0]->Point->coordinates[0];
					$lat = $addr_search_1->Placemark[0]->Point->coordinates[1];
				}
			}
		}else{
			$lon = $_POST['lon'];
			$lat = $_POST['lat'];
		}		
	
	
		$listing = $wpdb->get_row("SELECT id FROM ".$wpdb->prefix.BEPRO_LISTINGS_TABLE_NAME." WHERE post_id =".$post_id);	
		if($listing){
			$wpdb->query("UPDATE ".$wpdb->prefix.BEPRO_LISTINGS_TABLE_NAME." SET
						cost    = '".addslashes(strip_tags($_POST['cost']))."',
						first_name    = '".addslashes(strip_tags($_POST['first_name']))."',
						last_name     = '".addslashes(strip_tags($_POST['last_name']))."',
						email         = '".addslashes(strip_tags($_POST['email']))."',
						phone         = '".addslashes(strip_tags($_POST['phone']))."',
						address_line1 = '".addslashes(strip_tags($_POST['address_line1']))."',
						city          = '".addslashes(strip_tags($_POST['city']))."',
						postcode      = '".addslashes(strip_tags($_POST['postcode']))."',
						state         = '".addslashes(strip_tags($_POST['state']))."',
						country       = '".addslashes(strip_tags($_POST['country']))."',
						lat           = '".$lat."',
						lon           = '".$lon."',
						website       = '".addslashes(strip_tags($_POST['website']))."'
						WHERE post_id ='".$post_id."'");
		}else{
			$sql = "INSERT INTO ".$wpdb->prefix.BEPRO_LISTINGS_TABLE_NAME." (cost, first_name, last_name, email, website, address_line1, city, postcode, state, country, phone, post_id, lat, lon) VALUES('".addslashes(strip_tags($_POST['cost']))."','".addslashes(strip_tags($_POST['first_name']))."','".addslashes(strip_tags($_POST['last_name']))."','".addslashes(strip_tags($_POST['email']))."','".addslashes(strip_tags($_POST['website']))."','".addslashes(strip_tags($_POST['address_line1']))."','".addslashes(strip_tags($_POST['city']))."','".addslashes(strip_tags($_POST['postcode']))."','".addslashes(strip_tags($_POST['state']))."','".addslashes(strip_tags($_POST['country']))."','".addslashes(strip_tags($_POST['phone']))."','".$post_id."','".$lat."','".$lon."')";
				$wpdb->query($sql);
		 }
	}

	//Admin Bepro Listings table columns
	function bepro_listings_edit_columns($columns){
	  $columns = array(
		"cb" => "<input type='checkbox' />",
		"title" => "Item Name",
		"description" => "Description",
		"lat_lon" => "Lat/Lon?",
		"cost" => "Cost",
		"listing_types" => "Listing Types",
		"date" => "Date"
	  );
	 
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
		case "listing_types":
		  echo get_the_term_list($post->ID, 'bepro_listing_types', '', ', ','');
		  break;
	  }
	}
	
	//Admin css and javascript
	function bepro_listings_adminhead() {
			wp_admin_css('thickbox');
			wp_print_scripts('editor');
			wp_print_scripts('media-upload');
			wp_print_scripts('jquery-ui-tabs');
			if(function_exists('wp_tiny_mce')) wp_tiny_mce();
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
		if(!empty($_POST["update_options"])){
			$data["default_image"] = $_POST["default_image"];
			$data["num_listings"] = $_POST["num_listings"];
			$data["distance"] = $_POST["distance"];
			update_option("bepro_listings", $data);
		}
		$data = get_option("bepro_listings");
		?>
		<h1>BePro Listings Options</h1>
		<div class="wrap">
			<form class="bepro_listings" method="post">
				<input type="hidden" name="update_options" value="1" />
				<span class="form_label">Default Listing Image</span><input type="text" name="default_image" value="<?php echo $data["default_image"]; ?>" /></br>
				<span class="form_label">Default # Listings</span><input type="text" name="num_listings" value="<?php echo $data["num_listings"]; ?>" /></br>
				<span class="form_label">Default Search Distance</span><input type="text" name="distance" value="<?php echo $data["distance"]; ?>" />
				<input type="submit" name="submit" value="Update Options &raquo" />
			</form>
		</div>
		<?php
	}
?>

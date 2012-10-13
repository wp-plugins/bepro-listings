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

	//Create map, used by shortcode and widget
	function generate_map($atts = array(), $raw_results = array()){
		global $wpdb;
		
		$echo_this = (!empty($atts))? true:false;
		extract(shortcode_atts(array(
			  'pop_up' => $wpdb->escape($_POST["num_results"]),
			  'size' => $wpdb->escape($_POST["size"]),
			  'show_paging' => $wpdb->escape($_POST["show_paging"])
		 ), $atts));
		 
		//Setup data
		$data = get_option("bepro_listings");
		$num_results = $data["num_listings"]; 
		$size = empty($size)? 1:$size;
		
		//Get Listing Results
		$findings = process_listings_results($show_paging, $num_results);				
		$raw_results = $findings[0];
		
		//Setup Listing Markers
		$counter = 0;
		foreach($raw_results as $result){
			$permalink = get_permalink( $result->post_id );
			if (!empty($result->lat) && !empty($result->lon)){
				$map_cities .= '
					position = new google.maps.LatLng('.$result->lat.','.$result->lon.');
					var marker_'.$counter.' = new google.maps.Marker({
						position: position,
						map: map,
						clickable: true,
						title: "'.$result->item_name.'",
					});
					
					markers.push(marker_'.$counter.');
					positions.push(position);	
				';
				$currlat = $result->lat;
				$currlon = $result->lon;
				$thumbnail = get_the_post_thumbnail($result->post_id, 'thumbnail'); 
				$default_img = (!empty($thumbnail))? $thumbnail:'<img src="'.$data["default_image"].'"/>';
				if($pop_up){//marker pop up 
					$map_cities .= "
					var infowindow_".$counter." = new google.maps.InfoWindow( { content: '<div class=\"marker_content\"><span class=\"marker_img\">".$default_img."</span><span class=\"marker_detais\">".$result->post_title."<br /><a href=\"http://".urlencode($result->website)."\">Visit Website</a><br /><a href=\"".get_permalink($result->post_id)."\">View Listing</a></span></div>, size: new google.maps.Size(50,50) '});
						  google.maps.event.addListener(marker_".$counter.", \"click\", function() {
							infowindow_".$counter.".open(map,marker_".$counter.");
						  });
					";
				}else{
					$map_cities .= '
					var infowindow_'.$counter.' = new google.maps.InfoWindow( { content: "<div class=\"marker_content\"><span class=\"marker_detais\">'.$result->post_title.'</span></div>", size: new google.maps.Size(50,50)});
						  google.maps.event.addListener(marker_'.$counter.', "mouseover", function() {
							infowindow_'.$counter.'.open(map,marker_'.$counter.');
						  });
						  google.maps.event.addListener(marker_'.$counter.', "click", function() {
							window.location.href = "'.$permalink.'";
						  });
					';
				}
			}
			$counter++;
		}
		
		//javascript initialization of the map
		$map = "<script type='text/javascript'>
			jQuery(document).ready(function(){
				var currentlat;
				var currentlon;
				markers = new Array();
				positions = new Array();
				var currentlat = $currlat;
				var currentlon = $currlon;
				
				var latlng = new google.maps.LatLng(currentlat, currentlon);
				var myOptions = {
					zoom:10,
					center: latlng,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				}
				map = new google.maps.Map(document.getElementById('map'), myOptions);
				
				$map_cities
				//cluster markers
				if(markers.length > 1){
					var markerCluster = new MarkerClusterer(map, markers);
					//makes sure map view fits all markers
					 latlngbounds = new google.maps.LatLngBounds();
					for ( var i = 0; i < positions.length; i++ ) {
						latlngbounds.extend( positions[ i ] );
					}
					map.fitBounds( latlngbounds );
				}
			});
		</script>
		<div id='map' class='result_map_$size'></div>";
		if($echo_this){
			echo $map;
		}else{	
			return $map;
		}
	}
	
	//Show listings Called from shortcode
	function display_listings($atts = array(), $raw_results = array(), $enlarge_map = 0){
		global $wpdb;
		extract(shortcode_atts(array(
			  'shorten' => $wpdb->escape($_POST["shorten"]),
			  'show_paging' => $wpdb->escape($_POST["show_paging"])
		 ), $atts));
		 
		$data = get_option("bepro_listings");
		$num_results = $data["num_listings"]; 
		$echo_this = (!empty($raw_results))? false:true;
		
		$findings = process_listings_results($show_paging, $num_results);				
		$raw_results = $findings[0];				
			
		//Create the GUI layout for the listings
		if(empty($raw_results) || is_null($raw_results)){
			$results = "<p>your criteria returned no results.</p>";
		}else{
			foreach($raw_results as $result){
				if(empty($layout)){
					$results .= basic_listing_layout($result, $shorten, $echo_this);
				}
			}
		}
		
		if($show_paging == 1){
			$pages = 0;
			$pages = $findings[1];
			$counter = 1;
			$paging = "<div style='clear:both'><br /></div><div class='paging'>Pages: ";
			while($pages != 0){
				$paging .= "<a href='?page=".$counter."'>".$counter."</a>";
				$pages--;
				$counter++;
			}
			$paging .= "</div>";
			if($counter > 1) $results.= $paging; // if no pages then dont show this
		}
		if($echo_this){
			echo $results;
		}else{	
			return $results;
		}
	}
	
	//process paging and listings
	function process_listings_results($show_paging = false, $num_results = false){
		if(!empty($_POST["filter_search"]))$returncaluse = Bepro_listings::listitems(array());
		$filter_cat = (!empty($_POST["type"]))? true:false;
		
		//Handle Paging selection calculations and process listings
		if($show_paging == 1){
			$page = (empty($_GET["page"]))? 1 : $_GET["page"];
			$page = ($page - 1) * $num_results;
			$limit_clause = " ORDER BY posts.post_title ASC LIMIT $page , $num_results";
			$resvs = bepro_get_listings($returncaluse);
			$pages = ceil(count($resvs)/$num_results);
			$findings[1] = $pages;
			$raw_results = bepro_get_listings($returncaluse, $filter_cat, $limit_clause);
		}else{
			$raw_results = bepro_get_listings($returncaluse, $filter_cat);
		}
		$findings[0] = $raw_results;
		return $findings;
	}
	
	function basic_listing_layout($result, $shorten = false, $echo_this = false){
		$data = get_option("bepro_listings");
		$listing_types = listing_types_by_post($result->post_id);
		$thumbnail = get_the_post_thumbnail($result->post_id, 'thumbnail'); 
		$default_img = (!empty($thumbnail))? $thumbnail:'<img src="'.$data["default_image"].'"/>';
		
		$results .= 
		'<div class="'.(($shorten)? "shortcode_results":"results").'">
			<div class="result_top">
				<table><tr>
				<td><span class="result_name">'.$result->post_title.'</span></td>
				<td class="result_bar"><span class="result_type">'.get_the_term_list($result->post_id, 'bepro_listing_types', '', ', ','').'</span></td>
				</tr></table>
			</div>
			<div class="result_buttom">
				<span class="result_img">'.$default_img.'</span>';
		
			//if requested, hide some of the post content
			if(empty($shorten)){
				$results .='		
				<span class="result_content">';
				if($data["show_geo"])$results .= '<span class="result_title">'.$result->city.','.$result->state.','.$result->country.'</span>';
				$results .= '	
					<span class="result_desc">'.htmlspecialchars(stripslashes(strip_tags($result->post_content))).'</span>
				</span>
				';		
			}
			$permalink = get_permalink( $result->post_id );
			if($data["show_cost"]){
				if(is_numeric($result->cost)){ 
					//formats the price to have comas and dollar sign like currency.
					setlocale(LC_MONETARY, "en_US");
					$cost = ($result->cost == 0)? "Free" : money_format("%.2n", $result->cost);
				}else{
					$cost = "Please Contact";
				} 
			}
		
		$results .=  '<span class="result_do">
						<span class="result_cost">'.$cost.'</span>
						';
		$results .=((!empty($result->website))? '<span class="result_button"><a href="http://'.$result->website.'" target="_blank">Website</a></span>':"");
		
		//If not private then don't show link to listing
		if($result->post_status == "publish")
		$results .='<span class="result_button"><a href="'.$permalink.'" target="_blank">Item</a>
						</span>
					</span>';
					
		$results .=	'<div style="clear:both"><br /></div>
					</div></div>';
					
		return $results;			
	}
	
	//User form for creating Bepro Listings
	function user_create_listing($atts = array()){
		global $wpdb;
		
		extract(shortcode_atts(array(
			  'register' => $wpdb->escape($_POST["register"])
		 ), $atts));
		
		//get settings
		$data = get_option("bepro_listings");
		$default_user_id = $data["default_user_id"];
		$num_images = $data["num_images"];
		$validate = $data["validate_form"];
		$show_cost = $data["show_cost"];
		$show_con = $data["show_con"];
		$show_geo = $data["show_geo"];
		$success_message = $data["success_message"];
		
		if(empty($default_user_id) && empty($register)){
			echo "You must provide a 'default user id' in the admin settings or use the registration=1 option.";	
			return;
		}
		
		$wp_upload_dir = wp_upload_dir();
		if(!empty($_POST["save_bepro_listing"]) && !empty($_POST["item_name"]) && !empty($_POST["content"])){
			$item_name = $wpdb->escape($_POST["item_name"]);
			$content = $wpdb->escape($_POST["content"]);
			$categories = $wpdb->escape($_POST["categories"]);
			$username = $wpdb->escape($_POST["username"]);
			$password = $wpdb->escape($_POST["password"]);
		
			//Figure out user_id
			if(is_user_logged_in()){
				$user_data = wp_get_current_user();
				$user_id = $user_data->ID;
				$username = $user_data->user_login;
			}elseif(isset($last_name) && isset($email) && !empty($password)){
				$username = $last_name."_".$first_name;
				$user_id = wp_create_user( $username, $password, $email );
				if($user_id){
					echo "<p>Account Successfully Created.</p>";
				}else{
					echo "<p>Account was Not created.</p>";
				}				
			}
			if(empty($user_id))$user_id = $default_user_id;
			if(!empty($user_id)){
				$post = array(
				  'post_author' => $user_id,
				  'post_content' => $content,
				  'post_status' => "pending", 
				  'post_title' => $item_name,
				  'post_type' => "bepro_listings"
				);  
				
				//Create post
				$post_id = wp_insert_post( $post, $wp_error ); 
			
				if(empty($wp_error)){
					//setup custom bepro listing post categories
					wp_set_post_terms($post_id,$categories,'bepro_listing_types');
					
					//setup post images
					if($num_images){
						$counter = 1;
						while($counter <= $num_images){
							if(!empty($_FILES["bepro_form_image_".$counter]) && (!$_FILES["bepro_form_image_".$counter]["error"]) && getimagesize($_FILES["bepro_form_image_".$counter]["tmp_name"])){
								$full_filename = $wp_upload_dir['path'].$_FILES["bepro_form_image_".$counter]["name"];
								$check_move = @move_uploaded_file($_FILES["bepro_form_image_".$counter]["tmp_name"], $full_filename);
								if($check_move){
									$filename = basename($_FILES["bepro_form_image_".$counter]["name"]);
									$filename = preg_replace('/\.[^.]+$/', '', $filename);
									$attachment = array(
										 'post_mime_type' => $_FILES["bepro_form_image_".$counter]['type'],
										 'post_title' => $filename,
										 'post_content' => '',
										 'post_status' => 'inherit'
									);
									$attach_id = wp_insert_attachment( $attachment, $full_filename, $post_id);
									$attach_data = wp_generate_attachment_metadata( $attach_id, $full_filename);
									wp_update_attachment_metadata( $attach_id, $attach_data );
								}
							}
							$counter++;
						}
					}
					
					if(!empty($_POST['postcode']) || !empty($_POST['country'])){  
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
					$sql = "INSERT INTO ".$wpdb->prefix.BEPRO_LISTINGS_TABLE_NAME." SET
						first_name    = '".$wpdb->escape($_POST['first_name'])."',
						last_name     = '".$wpdb->escape($_POST['last_name'])."',
						cost         = '".$wpdb->escape($_POST['cost'])."',
						email         = '".$wpdb->escape($_POST['email'])."',
						website       = '".$wpdb->escape($_POST['website'])."',
						address_line1 = '".$wpdb->escape($_POST['address_line1'])."',
						city          = '".$wpdb->escape($_POST['city'])."',
						postcode      = '".$wpdb->escape($_POST['postcode'])."',
						state         = '".$wpdb->escape($_POST['state'])."',
						country       = '".$wpdb->escape($_POST['country'])."',
						post_id         = '".$post_id."',
						phone         = '".$wpdb->escape($_POST['phone'])."',
						lat           = '".$lat."',
						lon           = '".$lon."'";
					$wpdb->query($sql);
					echo $success_message;
				}
			}else{
				echo "<p>There was an error creating this Listing.</p>";
			}
		}
		
		if(!empty($validate) && ($validate == "on")){
			echo '
				<script type="text/javascript">
					jQuery(document).ready(function(){
						jQuery("#phone").mask("(999) 999-9999");
						jQuery("#bepro_create_listings_form").validate({
							rules: {
								item_name: "required",
								content: {
									required: true,
									minlength: 15
								},
								categories: "required",
								first_name: "required",
								last_name: "required",
								country: "required",
								email: {
									required: true,
									email: true
								},
								password: {
									required: true,
									minlength: 5
								},
								agree: "required"
							},
							messages: {
								item_name: "Please give this a name",
								content: "Please tell us about this",
								first_name: "Please enter your firstname",
								last_name: "Please enter your lastname",
								password: {
									required: "Please provide a password",
									minlength: "Your password must be at least 5 characters long"
								},
								email: "Please enter a valid email address",
								country: "Where in the world is this?",
								agree: "Please accept our policy"
							},
							submitHandler: function(form) {
								form.submit();
							}
						});
					});
				</script>
			';
		}
	
		echo '
			<form method="post" enctype="multipart/form-data" id="bepro_create_listings_form">
				<input type="hidden" name="save_bepro_listing" value="1">';
				
		echo '
			<div class="add_listing_form_info bepro_form_section">
				<h3>'.__("Item Information", "bepro-listings").'</h3>
				<span class="form_label">'.__("Item Name", "bepro-listings").'</span><input type="" id="item_name" name="item_name"><br />
				<span class="form_label">'.__("Description", "bepro-listings").'</span><textarea name="content" id="content"></textarea>
				<span class="form_label">'.__("Categories", "bepro-listings").'</span>';
				$options = listing_types();
				foreach($options as $opt){
					echo '<span class="bepro_form_cat"><span class="form_label">'.$opt->name.'</span><input type="checkbox" id="categories" name="categories[]" value="'.$opt->term_id.'"/></span>';
				}
				echo "<div style='clear:both'></div>";
				if(!empty($num_images)){
					$counter = 1;
					echo "<span class='bepro_form_images'>";
					while($counter <= $num_images){
						echo '<span class="form_label">'.__("Image", "bepro-listings").$counter.'</span><input type="file" name="bepro_form_image_'.$counter.'"><br />';
						$counter++;
					}
					echo "</span>";
				}
		echo '		
			</div>
			';		
		
		if(!empty($show_cost) && ($show_cost == "on")){		
			echo '
			<div class="add_listing_form_cost bepro_form_section">
				<span class="form_label">'.__("Cost", "bepro-listings").'</span><input type="text" name="cost" value="0"><br />
			</div>';
		}
		
		if(!empty($show_con) && ($show_con == "on")){		
			echo '		
				<div class="add_listing_form_contact bepro_form_section">
					<h3>'.__("Contact Information", "bepro-listings").'</h3>
					<span class="form_label">'.__("First Name", "bepro-listings").'</span><input type="text" id="first_name" name="first_name">
					<span class="form_label">'.__("Last Name", "bepro-listings").'</span><input type="text" id="last_name" name="last_name">
					<span class="form_label">'.__("Email", "bepro-listings").'</span><input type="text" id="email" name="email">
					<span class="form_label">'.__("Phone", "bepro-listings").'</span><input type="text" name="phone" id="phone">
					<span class="form_label">'.__("Website", "bepro-listings").'</span><input type="text" name="website">
				</div>';
		}
		
		if(!empty($show_geo) && ($show_geo == "on")){
			echo '
				<div class="add_listing_form_geo bepro_form_section">
					<h3>'.__("Location Information", "bepro-listings").'</h3>
					<span class="form_label">'.__("Address", "bepro-listings").'</span><input type="text" name="address_line1">
					<span class="form_label">'.__("City", "bepro-listings").'</span><input type="text" name="city">
					<span class="form_label">'.__("State", "bepro-listings").'</span><input type="text" name="state">
					<span class="form_label">'.__("Country", "bepro-listings").'</span><input type="text" id="country" name="country">
					<span class="form_label">'.__("Zip / Postal", "bepro-listings").'</span><input type="text" name="postal">
				</div>
			';
		}		
		
		if(!empty($register) && !is_user_logged_in()){
			echo '
				<div class="add_listing_form_register bepro_form_section">
					<h3>'.__("Login / Register", "bepro-listings").'</h3>
					<span class="form_label">'.__("Username", "bepro-listings").'</span><input type="text" id="user_name" name="user_name">
					<span class="form_label">'.__("Password", "bepro-listings").'</span><input type="text" id="password" name="password">
				</div>
			';
		}
		echo '<input type="submit" value="'.__("Create Listing", "bepro-listings").'">
				</form>';
	}
	
	
?>

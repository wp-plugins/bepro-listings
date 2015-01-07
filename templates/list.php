<?php
		global $wpdb, $bp;
		$data = get_option("bepro_listings");
		
		if(isset($_GET["message"]))echo "<span class='classified_message'>".$_GET["message"]."</span>";
		echo "<h2>".__("My Item Listings", "bepro-listings")."</h2>";
		if(sizeof($items) > 0){
			echo "<table id='classified_listings_table'><tr>
					<td>".__("Name", "bepro-listings")."</td>
					<td>".__("Type", "bepro-listings")."</td>
					<td>".__("Image", "bepro-listings")."</td>
					<td>".__("Address", "bepro-listings")."</td>
					<td>".__("Notices", "bepro-listings")."</td>
					<td>".__("Status", "bepro-listings")."</td>
					<td>".__("Actions", "bepro-listings")."</td>
				</tr>
			";
			foreach($items as $item){
				$notice = "None";
				$status = (($item->post_status == "publish")? "Published":"Pending");
				if(isset($data["days_until_expire"]) && ($status == "Published")){
					$notice = __("Expires", "bepro-listings").": ".(empty($item->expires)? "Never":date("M, d Y", strtotime($item->expires)));
				}else if(!empty($data["require_payment"])  && ($status == "Pending")){
					if($data["require_payment"] == 1){
						//category option
						$cost = bepro_get_total_cat_cost($item->post_id);
					}else if($data["require_payment"] == 2){
						$cost = $data["flat_fee"];
					}
					
					if($cost > 0){
						$notice = __("Pay", "bepro-listings").": ".$data["currency_sign"].$cost;
					}
				}
				echo "
					<tr>
						<td>".$item->post_title."</td>
						<td>".get_the_term_list($item->post_id, 'bepro_listing_types', '', ', ','')."</td>
						<td>".((has_post_thumbnail( $item->post_id ))?"Yes":"No")."</td>
						<td>".((isset($item->lat) && isset($item->lon))?"Valid":"Not Valid")."</td>
						<td>".$notice."</td>
						<td>".$status."</td>
						<td>";
						
						if($item->post_status == "publish"){ 
							echo "<a href='".get_permalink($item->post_id)."' target='_blank'>".__("View", "bepro-listings")."</a>";
						}else if($cost > 0){
							echo "<div style='float:left'>".do_shortcode("[bepro_cart_button item_number='".$item->post_id."' name='".$item->post_title."' price='".$cost."']")."</div>";
						}else{
							echo __("Wait", "bepro-listings");
						}
						if($bp->displayed_user->id == $bp->loggedin_user->id)echo " | <a href='$listing_url".$item->id."'>".__("Edit", "bepro-listings")."</a> | <a id='file::".$item->post_id."::".$item->post_title."' href='#' class='delete_link'>".__("Delete", "bepro-listings")."</a>";
				echo "	</td>
					</tr>
				";
			}
		}else{
			echo "<table id=''>";
			if(@bp_is_my_profile()){
				echo "<tr><td colspan=7>".__("No Live listings created", "bepro-listings")."</a></td></tr>";
			}else{
				echo "<tr><td colspan=7>".__("No live listings for this user", "bepro-listings")."</td></tr>";
			}
		}		
		echo "</table>";
?>
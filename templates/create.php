<?php
	
	global $wpdb, $bp;
	
	
	
	
	echo '
		<script type="text/javascript" src="'.get_bloginfo("template_url").'/js/jquery.validate.js"></script>
		<script type="text/javascript" src="'.get_bloginfo("template_url").'/js/script.js"></script>
	';
	if(isset($_GET["message"]))echo "<span class='classified_message'>".$_GET["message"]."</span>";
	echo '
		<h2>Enter New Classifieds</h2><a href="'.$listing_url.'">Return to Listing</a><br />
		<form id="classifieds_form" method="post" enctype="multipart/form-data" >
			<input type="hidden" name="save_report" value="1">
			<span class="label">Item name</span><input type="text" id="item_name" name="item_name" size="60"><br />
			<span class="label">Cost $</span><input type="text" id="cost" name="cost"><br />
			<span class="label">Website</span><input type="text" id="website" name="website"><br />
			<span class="label">Address</span><input type="text" id="address_line1" name="address_line1"><br />
			<span class="label">City</span><input type="text" id="city" name="city"><br />
			<span class="label">Province</span><input type="text" id="state" name="state"><br />
			<span class="label">Postal</span><input type="text" id="postcode" name="postcode"><br />
			<span class="label">Phone</span><input type="text" id="phone" name="phone"><br />
			<span class="label">Search Target</span>'.$targets.'<br />
			<span class="label">Categories</span>'.$categories.'<br />';
			function fb_change_mce_buttons( $initArray ) {
				$initArray['width'] = '450px';
				return $initArray;
			}
			add_filter('tiny_mce_before_init', 'fb_change_mce_buttons');

			the_editor ( $item->notes, $id = 'notes', $prev_id = 'notes', $media_buttons = false, $tab_index = 2, $extended = true );
		echo '	
			<span class="label">Image</span><input type="file" id="image" name="image"><br />
			<input type="submit" value="Submit Listing">
		</form>
	';
?>
<?php
	
	global $wpdb, $bp;
	wp_enqueue_script('editor');
	add_thickbox();
	
	echo '
		<script type="text/javascript" src="'.get_bloginfo("template_url").'/js/jquery.validate.js"></script>
		<script type="text/javascript" src="'.get_bloginfo("template_url").'/js/script.js"></script>
	';
	if(isset($_GET["message"]))echo "<span class='classified_message'>".$_GET["message"]."</span>";	
	
	echo '
		<h2>Update Item - '.$item->item_name.'</h2><a href="'.$listing_url.'">Return to Listing</a><br /><br />
		<form id="classifieds_form" method="post" enctype="multipart/form-data">
			<input type="hidden" name="update_report" value="1">
			<input type="hidden" name="item_id" value="'.$item->id.'">
			<span class="label">Cost</span><input type="text" id="cost" name="cost" value="'.$item->cost.'"><br />
			<span class="label">Website</span><input type="text" id="website" name="website" value="'.$item->website.'"><br />
			<span class="label">Address</span><input type="text" id="address_line1" name="address_line1" value="'.$item->address_line1.'"><br />
			<span class="label">City</span><input type="text" id="city" name="city" value="'.$item->city.'"><br />
			<span class="label">Province</span><input type="text" id="state" name="state" value="'.$item->state.'"><br />
			<span class="label">Postal</span><input type="text" id="postcode" name="postcode" value="'.$item->postcode.'"><br />
			<span class="label">Phone</span><input type="text" id="phone" name="phone" value="'.$item->phone.'"><br />
			<span class="label">Search Target</span>'.$targets.'<br />
			<span class="label">Categories</span>'.$categories.'<br />';
			
			 function fb_change_mce_buttons( $initArray ) {
    $initArray['width'] = '450px';
    return $initArray;
    }
    add_filter('tiny_mce_before_init', 'fb_change_mce_buttons');

			the_editor ( stripslashes($item->notes), $id = 'notes', $prev_id = 'notes', $media_buttons = false, $tab_index = 2, $extended = true );
		
			echo (isset($item->image) && ($item->image != 0))? "<img style='height:150px;width:150px;' src='".$image."'><span class='label'>Replace/Delete Image</span><input type='checkbox' id='new_image_check' name='new_image_check' value='1'><br />": "";
	echo '	
			
			<span class="label">Image</span><input type="file" id="new_image" name="new_image"><br />
			<input type="submit" value="Submit Listing">
		</form>
	';
?>
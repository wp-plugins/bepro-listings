<?php
/**
 * Listing Images
 *
 * Display the listing images meta box.
 *
 * @author      BePro Software
 * @category    Admin
 * @package     bepro-listings/admin/meta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * BL_Meta_Box_Listing_Images Class
 */
class BL_Meta_Box_Listing_Images {
	public static function gallery_images_meta( $post ) {
		
		$attachments = bl_get_listing_images($post->ID); 
		$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
		if(($keys = array_keys($attachments, $post_thumbnail_id)) !== false) 
			foreach($keys as $key)
				unset($attachments[$key]);
		
		?>
		<div id="listing_images_container">
			<ul class="listing_images">
				<?php

					if ( $attachments ) {
						foreach ( $attachments as $attachment_id ) {
							echo '<li class="image" data-attachment_id="' . esc_attr( $attachment_id ) . '">
								' . wp_get_attachment_image( $attachment_id, 'thumbnail' ) . '
								<ul class="actions">
									<li><a href="#" class="delete dashicons dashicons-no" title="' . __( 'Delete image', 'bepro-listings' ) . '">' . __( 'Delete', 'bepro-listings' ) . '</a></li>
								</ul>
							</li>';
						}
					}
				?>
			</ul>

			<input type="hidden" id="listing_image_gallery" name="listing_image_gallery" value="<?php echo esc_attr( implode(",", $attachments) ); ?>" />

		</div>
		<p class="add_listing_images hide-if-no-js">
			<a href="#" data-choose="<?php _e( 'Add Images to Listing Gallery', 'bepro-listings' ); ?>" data-update="<?php _e( 'Add to gallery', 'bepro-listings' ); ?>" data-delete="<?php _e( 'Delete image', 'bepro-listings' ); ?>" data-text="<?php _e( 'Delete', 'bepro-listings' ); ?>"><?php _e( 'Add Listing gallery images', 'bepro-listings' ); ?></a>
		</p>
		<?php
	}
	
	
	function cost_meta(){
	  global $wpdb, $post;
	  $listing = $wpdb->get_row("SELECT cost FROM ".$wpdb->prefix.BEPRO_LISTINGS_TABLE_NAME." WHERE post_id =".$post->ID);
	  ?>
	  <span class="form_label">Cost:</span>
	  <input name="cost" value="<?php echo $listing->cost; ?>" />
	  <?php
	}
	 
	function contact_general_meta($post) {
		echo '<input type="hidden" name="save_bepro_listing" value="1">';
	}
	function contact_details_meta($post) {
	  global $wpdb;
	  $listing = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix.BEPRO_LISTINGS_TABLE_NAME." WHERE post_id =".$post->ID);
	  echo '
		<span class="form_label">'.__("First Name").'</span><input type="text" name="first_name" value="'.$listing->first_name.'"><br />
		<span class="form_label">'.__("Last Name").'</span><input type="text" name="last_name" value="'.$listing->last_name.'"><br />
		<span class="form_label">'.__("Phone").'</span><input type="text" name="phone" value="'.$listing->phone.'"><br />
		<span class="form_label">'.__("Email").'</span><input type="text" name="email" value="'.$listing->email.'"><br />
		<span class="form_label">'.__("Website").'</span><input type="text" name="website" value="'.$listing->website.'"><br />
	  ';
		$data = get_option("bepro_listings");
		if(isset($data["days_until_expire"]) && ($data["days_until_expire"] > 0)){
			echo '<span class="form_label">Expire Date</span><input class="bl_date_input" type="text" name="expires" value="'.$listing->expires.'" placeholder="yyyy-mm-dd HH:mm:ss">';
		}
	}
	
	function geographic_details_meta($post) {
	  global $wpdb;
	  $listing = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix.BEPRO_LISTINGS_TABLE_NAME." WHERE post_id =".$post->ID);
	  
	  echo '
		<span class="form_label">Lat</span><input type="test" name="lat" value="'.$listing->lat.'"><br />
		<span class="form_label">Lon</span><input type="test" name="lon" value="'.$listing->lon.'"><br />
		<span class="form_label">Address</span><input type="text" name="address_line1" value="'.$listing->address_line1.'"><br />
		<span class="form_label">City</span><input type="text" name="city" value="'.$listing->city.'"><br />
		<span class="form_label">State</span><input type="text" name="state" value="'.$listing->state.'"><br />
		<span class="form_label">Country</span><input type="text" name="country" value="'.$listing->country.'"><br />
		<span class="form_label">postcode</span><input type="text" name="postcode" value="'.$listing->postcode.'"><br />
	  ';
	}

	/**
	 * Save meta box data
	 */
	public static function save( $post_id, $post ) {
		$post_thumbnail_id = get_post_thumbnail_id( $post_id );
		$raw_old_images = get_children(array('post_parent'=>$post_id), ARRAY_A);
		unset($raw_old_images[$post_thumbnail_id]);
		$old_images = array_keys($raw_old_images);
		$new_images = empty($_POST['listing_image_gallery'])? array():explode( ',', addslashes( $_POST['listing_image_gallery'] ) );
		
		global $wpdb;
		if(!empty($new_images)){
			$diff = array_diff($old_images, $new_images);
			
			//unattach
			foreach($diff as $del_this)
				$wpdb->update($wpdb->posts, array('post_parent'=>0), array('id'=>$del_this, 'post_type'=>'attachment'));
		}else{
			//unattach
			foreach($old_images as $del_this)
				$wpdb->update($wpdb->posts, array('post_parent'=>0), array('id'=>$del_this, 'post_type'=>'attachment'));
		}
		
		//save new
		foreach($new_images as $add_this)
			$wpdb->update($wpdb->posts, array('post_parent'=>$post_id), array('id'=>$add_this, 'post_type'=>'attachment'));
			
		
		//save order of images
		$attachment_ids = array_filter( $new_images );
		update_post_meta( $post_id, '_listing_image_gallery', implode( ',', $attachment_ids ) );
	}
}
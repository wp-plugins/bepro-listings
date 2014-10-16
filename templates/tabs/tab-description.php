<?php
/**
 * Single listing tabs
 *
 * @author 		BePro Listings
 * @package 	bepro_listings/Templates
 */

global $post;

if ( $post->post_content ) : ?>
	<li class="description_tab"><?php _e('Description', 'bepro-listings'); ?></li>
<?php endif; ?>
<?php
/**
 * Single listing tabs
 *
 * @author 		BePro Listings
 * @package 	bepro_listings/Templates
 */

global $post;

if ( $post->post_content ) : ?>
	<li class="map_tab"><a href="#tab-map"><?php _e('View Map', 'bepro_listings'); ?></a></li>
<?php endif; ?>
<?php
/**
 * Reviews tab
 *
 * @author 		BePro Listings
 * @package 	bepro_listings/Templates
 */

global $post;

if ( comments_open() ) : ?>
	<div class="panel entry-content" id="tab-comments">

		<?php 
			
			$comments = get_template_part( "comments" ); 
			
			if(empty($comments))
				comments_template();
		?>

	</div>
<?php endif; ?>
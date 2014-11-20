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
			ob_start();
			get_template_part( "comments" );
			$comments = ob_get_contents();
			ob_end_clean();
			if(empty($comments)){
				comments_template();
			}else{
				echo $comments;
			}
		?>

	</div>
<?php endif; ?>
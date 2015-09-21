<?php
/**
 * BePro Listings dashboard page
 */
 
?>
<div class="wrap about-wrap">

	<h1><?php _e( 'Welcome to BePro Listings!', "bepro-listings"); ?></h1>
	
	<div class="about-text">
		<?php _e('Congratulations, you are now using the latest version of BePro Listings. With lots of ways to customize, this software is ideal for creating your custom listing needs. This page shows the new features packaged with the plugin.', "bepro-listings" ); ?>
	</div>
	
	<h2 class="nav-tab-wrapper">
		<a href="#" class="nav-tab nav-tab-active">
			<?php _e( "What's New", "bepro-listings" ); ?>
		</a>
	</h2>
	
	<div class="changelog">
		<h3><?php _e( 'You are using', "bepro-listings" ); _e( 'BePro Listings Version:', "bepro-listings" ); echo " ".BEPRO_LISTINGS_VERSION; ?>   </h3>
	
		<div class="feature-section images-stagger-right">
			<h4><?php _e( 'Various Search Result Refinements', "bepro-listings" ); ?></h4>
			<p><?php _e( 'We just rewrote a lot of the code which generates search results. The new enhancements should make searches faster and be more informative to end users. Also, developers can now tie into our ajax via wordpress hooks, perfect for creating custom addons', "bepro-listings" ); ?></p>
			
			<h4><?php _e( 'Form & Package Improvements', "bepro-listings" ); ?></h4>
			<p><?php _e( 'We have tweaked a few form labels and improved the category selectbox capabilities. Also, Packages now show the remaining number of listings while creating or editing a listing from the frontend.', "bepro-listings" ); ?></p>
			
			<h4><?php _e( 'Order Management', "bepro-listings" ); ?></h4>
			<p><?php _e( 'We fixed the admin process for creating and managing orders. Now you can create an order in the admin for a user and have it show up on their frontend profile page (My Listings). If the status is active, they can start posting articles related to the package', "bepro-listings" ); ?></p>
			
			<h4><?php _e( 'Translations', "bepro-listings" ); ?></h4>
			<p><?php _e( 'We have introduced a .POT file for those interested in creating their own translations. We will eventually move all tranlation files, except for the POT file from the plugin. This will reduce the plugin size while still allowing users to create the needed translations. The current po and mo files that we have created, will be moved to the copy of the plugin on github.', "bepro-listings" ); ?></p>
			
			<h4><?php _e( 'Import / Export', "bepro-listings" ); ?></h4>
			<p><?php _e( 'We have improved our CSV import process. Now you can list the category names instead of their IDs and upload multiple images. There is also a new delimiter option for csv imports. These changes make it easier to use our FREE csv import features for quickly uploading lots of data.', "bepro-listings" ); ?></p>
			
			<h4><?php _e( 'Support Us', "bepro-listings" ); ?></h4>
			<p><?php _e( 'Hopefully you like BePro Listings. Consider sharing your experience with other users by leaving a <a href="http://wordpress.org/support/view/plugin-reviews/bepro-listings" target="_blank">review on wordpress.org</a>. Your feedback helps to support development of this free solution and informs fellow wordpress users of its usefulness.', "bepro-listings" ); ?></p>
		</div>
	</div>

</div>
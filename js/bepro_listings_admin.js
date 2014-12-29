jQuery( function( $ ){
	// Product gallery file uploads
	var product_gallery_frame;
	var $image_gallery_ids = $('#listing_image_gallery');
	var $listing_images = $('#listing_images_container ul.listing_images');

	jQuery('.add_listing_images').on( 'click', 'a', function( event ) {
		var $el = $(this);
		var attachment_ids = $image_gallery_ids.val();

		event.preventDefault();

		// If the media frame already exists, reopen it.
		if ( product_gallery_frame ) {
			product_gallery_frame.open();
			return;
		}

		// Create the media frame.
		product_gallery_frame = wp.media.frames.product_gallery = wp.media({
			// Set the title of the modal.
			title: "Listing images",
			button: {
				text: "Update",
			},
			states : [
				new wp.media.controller.Library({
					title: "Choose",
					filterable : 'all',
					multiple: true
				})
			]
		});

		// When an image is selected, run a callback.
		product_gallery_frame.on( 'select', function() {

			var selection = product_gallery_frame.state().get('selection');

			selection.map( function( attachment ) {
				attachment = attachment.toJSON();

				if ( attachment.id ) {
				attachment_ids = attachment_ids ? attachment_ids + "," + attachment.id : attachment.id;

				$listing_images.append('\
					<li class="image" data-attachment_id="' + attachment.id + '">\
						<img src="' + attachment.url + '" />\
						<ul class="actions">\
							<li><a href="#" class="delete dashicons dashicons-no" title="' + $el.data('delete') + '">' + $el.data('text') + '</a></li>\
						</ul>\
					</li>');
				}

			});

			$image_gallery_ids.val( attachment_ids );
		});

		// Finally, open the modal.
		product_gallery_frame.open();
	});

	// Remove images
	$('#listing_images_container').on( 'click', 'a.delete', function(e) {
		e.preventDefault();
		$(this).closest('li.image').remove();

		var attachment_ids = '';

		$('#listing_images_container ul li.image').css('cursor','default').each(function() {
			var attachment_id = jQuery(this).attr( 'data-attachment_id' );
			attachment_ids = attachment_ids + attachment_id + ',';
		});

		$image_gallery_ids.val( attachment_ids );

		return false;
	});
});
	
// bepro_listings.js

// do not distribute without bepro_listings.php



/*

This file is part of BePro Listings.



    BePro Listings is free software: you can redistribute it and/or modify

    it under the terms of the GNU General Public License as published by

    the Free Software Foundation, either version 3 of the License, or

    (at your option) any later version.



    BePro Listings is distributed in the hope that it will be useful,

    but WITHOUT ANY WARRANTY; without even the implied warranty of

    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the

    GNU General Public License for more details.



    You should have received a copy of the GNU General Public License

    along with BePro Listings.  If not, see <http://www.gnu.org/licenses/>.

*/



jQuery(document).ready(function($) {

	launch_bepro_listing_tabs();
});	

function launch_bepro_listing_tabs(){
	jQuery('.bepro_listings_tabs .panel').hide();
	
	jQuery('.bepro_listings_tabs ul.tabs li a').click(function(){
		
		var jQuerytab = jQuery(this);
		var jQuerytabs_wrapper = jQuerytab.closest('.bepro_listings_tabs');
		
		jQuery('ul.tabs li', jQuerytabs_wrapper).removeClass('active');
		jQuery('div.panel', jQuerytabs_wrapper).hide();
		jQuery('div' + jQuerytab.attr('href')).show();
		jQuerytab.parent().addClass('active');
		
		return false;	
	});
	
	jQuery('.bepro_listings_tabs').each(function() {
		var hash = window.location.hash;
		if (hash.toLowerCase().indexOf("comment-") >= 0) {
			jQuery('ul.tabs li.reviews_tab a', jQuery(this)).click();
		} else {
			jQuery('ul.tabs li:first a', jQuery(this)).click();
		}
	});
	
	if(jQuery("#bepro_listings_tabs")){
		jQuery( "#bepro_listings_tabs" ).tabs();
	}
	
	map_count = 0;
	jQuery(".frontend_bepro_listings_vert_tabs").easyResponsiveTabs({           
	type: 'vertical',           
	width: 'auto',
	fit: true,
	activate: function(event) { 
		if((event.target.className == "map_tab resp-tab-item resp-tab-active") && (map_count == 0)){
			launch_frontend_map();
			map_count++;
		} 
	}
	});
}
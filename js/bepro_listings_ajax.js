jQuery(document).ready(function(){
	jQuery("body").on("click",".cat_list_item a",function(element){
		element.preventDefault();
		href = jQuery(this).attr("href");
		raw_val = href.split("l_type=");
		l_type = raw_val[1];
		shortcode_vals = get_bl_shortcode_vals();
		bl_ajax_init();
		fairy_dust = "";
		if(jQuery("#filter_search_form")){
			jQuery("#filter_search_form input[type=checkbox]").prop('checked', false);
			fairy_dust = jQuery("#filter_search_form").serialize();
		}else if(jQuery("#listingsearchform")){
			if(jQuery("input[name=filter_search]").val(l_type))
				fairy_dust = jQuery("#listingsearchform").serialize();
		}

		fairy_dust = fairy_dust + "&l_type[]=" + l_type;		
			
		jQuery.ajax({
			type : "POST",
			url : ajaxurl, 
			data: fairy_dust + "&action=bl_ajax_frontend_update" + shortcode_vals, 
			success : function(r_c){
			options = jQuery.parseJSON(r_c);
			bl_ajax_complete();
			if(((options.map).length > 0) && (jQuery("#shortcode_map")))
				jQuery("#shortcode_map").replaceWith(options.map);
			if(((options.cat).length > 0) && (jQuery("#shortcode_cat")))
				jQuery("#shortcode_cat").replaceWith(options.cat);
			if(((options.listings).length > 0) && (jQuery("#shortcode_list")))
				jQuery("#shortcode_list").replaceWith(options.listings);
			if(((options.filter).length > 0) && (jQuery("#filter_search_form")))
				jQuery("#filter_search_form").replaceWith(options.filter);
			if(((options.search).length > 0) && (jQuery("#listingsearchform")))
				jQuery("#listingsearchform").replaceWith(options.search);
		
		}});	
	});
	
	jQuery(".clear_search button").click(function(element){
		element.preventDefault();
	});
	
	jQuery("body").on("click",".clear_search",function(element){
		element.preventDefault();
		shortcode_vals = get_bl_shortcode_vals();
		bl_ajax_init();
		jQuery.ajax({
			type : "POST",
			url : ajaxurl, 
			data: "&action=bl_ajax_frontend_update" + shortcode_vals, 
			success : function(r_c){
			options = jQuery.parseJSON(r_c);
			bl_ajax_complete();
			if(((options.map).length > 0) && (jQuery("#shortcode_map")))
				jQuery("#shortcode_map").replaceWith(options.map);
			if(((options.cat).length > 0) && (jQuery("#shortcode_cat")))
				jQuery("#shortcode_cat").replaceWith(options.cat);
			if(((options.listings).length > 0) && (jQuery("#shortcode_list")))
				jQuery("#shortcode_list").replaceWith(options.listings);
			if(((options.filter).length > 0) && (jQuery("#filter_search_form")))
				jQuery("#filter_search_form").replaceWith(options.filter);
			if(((options.search).length > 0) && (jQuery("#listingsearchform")))
				jQuery("#listingsearchform").replaceWith(options.search);
		}});
	});
	
	jQuery("body").on("submit","#listingsearchform", function(element){
		element.preventDefault();
		fairy_dust = jQuery("#listingsearchform").serialize();
		shortcode_vals = get_bl_shortcode_vals();
		bl_ajax_init();
		jQuery.ajax({
			type : "POST",
			url : ajaxurl, 
			data: fairy_dust + "&action=bl_ajax_frontend_update" + shortcode_vals, 
			success : function(r_c){
			options = jQuery.parseJSON(r_c);
			bl_ajax_complete();
			if(((options.map).length > 0) && (jQuery("#shortcode_map")))
				jQuery("#shortcode_map").replaceWith(options.map);
			if(((options.cat).length > 0) && (jQuery("#shortcode_cat")))
				jQuery("#shortcode_cat").replaceWith(options.cat);
			if(((options.listings).length > 0) && (jQuery("#shortcode_list")))
				jQuery("#shortcode_list").replaceWith(options.listings);
			if(((options.filter).length > 0) && (jQuery("#filter_search_form")))
				jQuery("#filter_search_form").replaceWith(options.filter);
			if(((options.search).length > 0) && (jQuery("#listingsearchform")))
				jQuery("#listingsearchform").replaceWith(options.search);
		
		}});
	});
	jQuery("body").on("submit","#filter_search_form", function(element){
		element.preventDefault();
		fairy_dust = jQuery("#filter_search_form").serialize();
		shortcode_vals = get_bl_shortcode_vals();
		bl_ajax_init();
		jQuery.ajax({
			type : "POST",
			url : ajaxurl, 
			data: fairy_dust + "&action=bl_ajax_frontend_update" + shortcode_vals, 
			success : function(r_c){
			options = jQuery.parseJSON(r_c);
			bl_ajax_complete();
			if(((options.map).length > 0) && (jQuery("#shortcode_map")))
				jQuery("#shortcode_map").replaceWith(options.map);
			if(((options.cat).length > 0) && (jQuery("#shortcode_cat")))
				jQuery("#shortcode_cat").replaceWith(options.cat);
			if(((options.listings).length > 0) && (jQuery("#shortcode_list")))
				jQuery("#shortcode_list").replaceWith(options.listings);
			if(((options.filter).length > 0) && (jQuery("#filter_search_form")))
				jQuery("#filter_search_form").replaceWith(options.filter);
			if(((options.search).length > 0) && (jQuery("#listingsearchform")))
				jQuery("#listingsearchform").replaceWith(options.search);
		}});
	});
})

function get_bl_shortcode_vals(){
	returnstr = '';
	if(jQuery("#bl_size"))
		returnstr = returnstr + "&size=" + jQuery("#bl_size").html();
	if(jQuery("#bl_pop_up"))
		returnstr = returnstr + "&pop_up=" + jQuery("#bl_pop_up").html();
	if(jQuery("#bl_ctype"))
		returnstr = returnstr + "&ctype=" + jQuery("#bl_ctype").html();
	if(jQuery("#bl_limit"))
		returnstr = returnstr + "&limit=" + jQuery("#bl_limit").html();
	if(jQuery("#bl_type"))
		returnstr = returnstr + "&type=" + jQuery("#bl_type").html();
	if(jQuery("#bl_show_paging"))
		returnstr = returnstr + "&show_paging=" + jQuery("#bl_show_paging").html();
		
	return returnstr;	
}

function bl_ajax_init(){
	jQuery('body').css('cursor', 'wait'); 
}

function bl_ajax_complete(){
	jQuery('body').css('cursor', 'default'); 
}
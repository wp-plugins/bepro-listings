jQuery(document).ready(function(){
	jQuery("body").on("click",".cat_list_item a",function(element){
		element.preventDefault();
		href = jQuery(this).attr("href");
		raw_val = href.split("l_type=");
		l_type = raw_val[1];
		shortcode_vals = get_bl_shortcode_vals();
		bl_ajax_init();
		fairy_dust = "";
		if(jQuery("#filter_search_form").length > 0){
			jQuery("#filter_search_form input[type=checkbox]").prop('checked', false);
			fairy_dust = jQuery("#filter_search_form").serialize();
		}else if(jQuery("#listingsearchform").length > 0){
			if(jQuery("input[name=filter_search]").val() == 1)
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
			if(((options.cat).length > 0) && (jQuery("#shortcode_cat")))
				jQuery("#shortcode_cat").replaceWith(options.cat);
			if(((options.listings).length > 0) && (jQuery("#shortcode_list")))
				jQuery("#shortcode_list").replaceWith(options.listings);
			if(((options.filter).length > 0) && (jQuery("#filter_search_form")))
				jQuery("#filter_search_form").replaceWith(options.filter);
			if((options.short_filter) && ((options.short_filter).length > 0) && (jQuery(".filter_search_form_shortcode")))
				jQuery(".filter_search_form_shortcode").replaceWith(options.short_filter);
			if(((options.search).length > 0) && (jQuery("#listingsearchform")))
				jQuery(".search_listings").replaceWith(options.search);
			if(((options.map).length > 0) && (jQuery("#shortcode_map")))
				jQuery("#shortcode_map").replaceWith(options.map);	
			bl_ajax_end();
		
		}});	
	});
	
	jQuery("body").on("click",".bl_ajax_result_page",function(element){
		element.preventDefault();
		post_id = jQuery(this).attr("post_id");
		bl_ajax_get_page(post_id)
	});	
	
	jQuery("body").on("click",".paging a",function(element){
		element.preventDefault();
		href = jQuery(this).attr("href");
		raw_val = href.split("lpage=");
		lpage = raw_val[1];
		shortcode_vals = get_bl_shortcode_vals();
		bl_ajax_init();
		fairy_dust = "";
		if(jQuery("#filter_search_form").length > 0){
			fairy_dust = jQuery("#filter_search_form").serialize();
		}else if(jQuery("#listingsearchform").length > 0){
			if(jQuery("input[name=filter_search]").val() == 1)
				fairy_dust = jQuery("#listingsearchform").serialize();
		}

		fairy_dust = fairy_dust + "&lpage=" + lpage;		
			
		jQuery.ajax({
			type : "POST",
			url : ajaxurl, 
			data: fairy_dust + "&action=bl_ajax_frontend_update" + shortcode_vals, 
			success : function(r_c){
				options = jQuery.parseJSON(r_c);
				bl_ajax_complete();
				if(((options.cat).length > 0) && (jQuery("#shortcode_cat")))
					jQuery("#shortcode_cat").replaceWith(options.cat);
				if(((options.listings).length > 0) && (jQuery("#shortcode_list")))
					jQuery("#shortcode_list").replaceWith(options.listings);
				if(((options.filter).length > 0) && (jQuery("#filter_search_form")))
					jQuery("#filter_search_form").replaceWith(options.filter);
				if((options.short_filter) && ((options.short_filter).length > 0) && (jQuery(".filter_search_form_shortcode")))
					jQuery(".filter_search_form_shortcode").replaceWith(options.short_filter);
				if(((options.search).length > 0) && (jQuery("#listingsearchform")))
					jQuery(".search_listings").replaceWith(options.search);
				if(((options.map).length > 0) && (jQuery("#shortcode_map")))
					jQuery("#shortcode_map").replaceWith(options.map);	
				bl_ajax_end();
			}
		});	
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
			if(((options.cat).length > 0) && (jQuery("#shortcode_cat")))
				jQuery("#shortcode_cat").replaceWith(options.cat);
			if(((options.listings).length > 0) && (jQuery("#shortcode_list")))
				jQuery("#shortcode_list").replaceWith(options.listings);
			if(((options.filter).length > 0) && (jQuery("#filter_search_form")))
				jQuery("#filter_search_form").replaceWith(options.filter);
			if((options.short_filter) && ((options.short_filter).length > 0) && (jQuery(".filter_search_form_shortcode")))
				jQuery(".filter_search_form_shortcode").replaceWith(options.short_filter);
			if(((options.search).length > 0) && (jQuery("#listingsearchform")))
				jQuery(".search_listings").replaceWith(options.search);
			if(((options.map).length > 0) && (jQuery("#shortcode_map")))
				jQuery("#shortcode_map").replaceWith(options.map);	
			bl_ajax_end();
		}});
	});
	
	jQuery("body").on("submit","#result_page_back_button", function(element){
		element.preventDefault();
		fairy_dust = jQuery("#result_page_back_button").serialize();
		shortcode_vals = get_bl_shortcode_vals();
		bl_ajax_init();
		jQuery.ajax({
			type : "POST",
			url : ajaxurl, 
			data: fairy_dust + "&action=bl_ajax_frontend_update" + shortcode_vals, 
			success : function(r_c){
			options = jQuery.parseJSON(r_c);
			bl_ajax_complete();
			if(((options.cat).length > 0) && (jQuery("#shortcode_cat")))
				jQuery("#shortcode_cat").replaceWith(options.cat);
			if(((options.listings).length > 0) && (jQuery("#shortcode_list")))
				jQuery("#shortcode_list").replaceWith(options.listings);
			if(((options.filter).length > 0) && (jQuery("#filter_search_form")))
				jQuery("#filter_search_form").replaceWith(options.filter);
			if((options.short_filter) && ((options.short_filter).length > 0) && (jQuery(".filter_search_form_shortcode")))
				jQuery(".filter_search_form_shortcode").replaceWith(options.short_filter);
			if(((options.search).length > 0) && (jQuery("#listingsearchform")))
				jQuery(".search_listings").replaceWith(options.search);
			if(((options.map).length > 0) && (jQuery("#shortcode_map")))
				jQuery("#shortcode_map").replaceWith(options.map);	
			bl_ajax_end();
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
			if(((options.cat).length > 0) && (jQuery("#shortcode_cat")))
				jQuery("#shortcode_cat").replaceWith(options.cat);
			if(((options.listings).length > 0) && (jQuery("#shortcode_list")))
				jQuery("#shortcode_list").replaceWith(options.listings);
			if(((options.filter).length > 0) && (jQuery("#filter_search_form")))
				jQuery("#filter_search_form").replaceWith(options.filter);
			if((options.short_filter) && ((options.short_filter).length > 0) && (jQuery(".filter_search_form_shortcode")))
				jQuery(".filter_search_form_shortcode").replaceWith(options.short_filter);
			if(((options.search).length > 0) && (jQuery("#listingsearchform")))
				jQuery(".search_listings").replaceWith(options.search);
			if(((options.map).length > 0) && (jQuery("#shortcode_map")))
				jQuery("#shortcode_map").replaceWith(options.map);	
			bl_ajax_end();
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
			if(((options.cat).length > 0) && (jQuery("#shortcode_cat")))
				jQuery("#shortcode_cat").replaceWith(options.cat);
			if(((options.listings).length > 0) && (jQuery("#shortcode_list")))
				jQuery("#shortcode_list").replaceWith(options.listings);
			if(((options.filter).length > 0) && (jQuery("#filter_search_form")))
				jQuery("#filter_search_form").replaceWith(options.filter);
			if((options.short_filter) && ((options.short_filter).length > 0) && (jQuery(".filter_search_form_shortcode")))
				jQuery(".filter_search_form_shortcode").replaceWith(options.short_filter);
			if(((options.search).length > 0) && (jQuery("#listingsearchform")))
				jQuery("#listingsearchform").replaceWith(options.search);
			if(((options.map).length > 0) && (jQuery("#shortcode_map")))
				jQuery("#shortcode_map").replaceWith(options.map);	
			bl_ajax_end();
		}});
	});
	
	jQuery("body").on("submit","#filter_search_shortcode_form", function(element){
		element.preventDefault();
		fairy_dust = jQuery("#filter_search_shortcode_form").serialize();
		shortcode_vals = get_bl_shortcode_vals();
		bl_ajax_init();
		jQuery.ajax({
			type : "POST",
			url : ajaxurl, 
			data: fairy_dust + "&action=bl_ajax_frontend_update" + shortcode_vals, 
			success : function(r_c){
			options = jQuery.parseJSON(r_c);
			bl_ajax_complete();
			if(((options.cat).length > 0) && (jQuery("#shortcode_cat")))
				jQuery("#shortcode_cat").replaceWith(options.cat);
			if(((options.listings).length > 0) && (jQuery("#shortcode_list")))
				jQuery("#shortcode_list").replaceWith(options.listings);
			if(((options.filter).length > 0) && (jQuery("#filter_search_form")))
				jQuery("#filter_search_form").replaceWith(options.filter);
			if((options.short_filter) && ((options.short_filter).length > 0) && (jQuery(".filter_search_form_shortcode")))
				jQuery(".filter_search_form_shortcode").replaceWith(options.short_filter);
			if(((options.search).length > 0) && (jQuery("#listingsearchform")))
				jQuery("#listingsearchform").replaceWith(options.search);
			if(((options.map).length > 0) && (jQuery("#shortcode_map")))
				jQuery("#shortcode_map").replaceWith(options.map);	
			bl_ajax_end();
		}});
	});
});

function get_bl_shortcode_vals(){ 
	returnstr = '';
	if(jQuery("#bl_size").length > 0)
		returnstr = returnstr + "&size=" + jQuery("#bl_size").html();
	if(jQuery("#bl_pop_up").length > 0)
		returnstr = returnstr + "&pop_up=" + jQuery("#bl_pop_up").html();
	if(jQuery("#bl_ctype").length > 0)
		returnstr = returnstr + "&ctype=" + jQuery("#bl_ctype").html();
	if(jQuery("#bl_cat").length > 0)
		returnstr = returnstr + "&cat=" + jQuery("#bl_cat").html();
	if(jQuery("#bl_l_type").length > 0)
		returnstr = returnstr + "&l_type=" + jQuery("#bl_l_type").html();
	if(jQuery("#bl_limit").length > 0)
		returnstr = returnstr + "&limit=" + jQuery("#bl_limit").html();
	if(jQuery("#bl_type").length > 0)
		returnstr = returnstr + "&type=" + jQuery("#bl_type").html();
	if(jQuery("#bl_order").length > 0)
		returnstr = returnstr + "&order_dir=" + jQuery("#bl_order").html();
	if(jQuery("#bl_show_paging").length > 0)
		returnstr = returnstr + "&show_paging=" + jQuery("#bl_show_paging").html();
	if(jQuery("#bl_form_id").length > 0)
		returnstr = returnstr + "&bl_form_id=" + jQuery("#bl_form_id").html();
		
	return returnstr;	
}

function clear_bl_shortcode_vals(){
	if(jQuery("#bl_size"))
		jQuery("#bl_size").remove();
	if(jQuery("#bl_pop_up"))
		jQuery("#bl_pop_up").remove();
	if(jQuery("#bl_ctype"))
		jQuery("#bl_ctype").remove();;
	if(jQuery("#bl_cat"))
		jQuery("#bl_cat").remove();;
	if(jQuery("#bl_limit"))
		jQuery("#bl_limit").remove();
	if(jQuery("#bl_type"))
		jQuery("#bl_type").remove();
	if(jQuery("#bl_order"))
		jQuery("#bl_order").remove();
	if(jQuery("#bl_show_paging"))
		jQuery("#bl_show_paging").remove();
	if(jQuery("#bl_form_id"))
		jQuery("#bl_form_id").remove();
	if(jQuery("#bl_l_type"))
		jQuery("#bl_l_type").remove();
}

function bl_ajax_init(){
	jQuery('body').css('cursor', 'wait'); 
}

function bl_ajax_complete(){
	clear_bl_shortcode_vals();
	jQuery('body').css('cursor', 'default'); 
}

function bl_ajax_end(){
	if(jQuery(".bl_date_input"))
		jQuery(".bl_date_input").datepicker();
}

function bl_ajax_get_page(post_id){	
	shortcode_vals = get_bl_shortcode_vals();
	bl_ajax_init();
	fairy_dust = "";
	if(jQuery("#filter_search_form")){
		fairy_dust = jQuery("#filter_search_form").serialize();
	}else if(jQuery("#listingsearchform")){
		if(jQuery("input[name=filter_search]").val(l_type))
			fairy_dust = jQuery("#listingsearchform").serialize();
	}

	fairy_dust = fairy_dust + "&bl_post_id=" + post_id;		
		
	jQuery.ajax({
		type : "POST",
		url : ajaxurl, 
		data: fairy_dust + "&action=bl_ajax_result_page" + shortcode_vals, 
		success : function(r_c){
			options = jQuery.parseJSON(r_c);
			bl_ajax_complete();
			if(((options.cat).length > 0) && (jQuery("#shortcode_cat")))
				jQuery("#shortcode_cat").replaceWith(options.cat);
			if(((options.listings).length > 0) && (jQuery("#shortcode_list")))
				jQuery("#shortcode_list").replaceWith(options.listings);
			if((options.filter) && ((options.filter).length > 0) && (jQuery("#filter_search_form")))
				jQuery("#filter_search_form").replaceWith(options.filter);
			if((options.short_filter) && ((options.short_filter).length > 0) && (jQuery(".filter_search_form_shortcode")))
				jQuery(".filter_search_form_shortcode").replaceWith(options.short_filter);	
			if(((options.search).length > 0) && (jQuery("#listingsearchform")))
				jQuery(".search_listings").replaceWith(options.search);
			if(((options.map).length > 0) && (jQuery("#shortcode_map")))
				jQuery("#shortcode_map").replaceWith(options.map);
				
			launch_bepro_listing_tabs();
			try{
				bl_launch_gallery();
			}catch(err) {}
		}
	});	
}
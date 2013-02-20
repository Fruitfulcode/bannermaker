var jQuery182 = jQuery.noConflict(); 

jQuery('.banner_maker_container').live('click',function() {
	jQuery.post(
		ajaxurl, 
		   {
			  'action'	: 'banner_click_counter',
			  'id'		: jQuery(this).attr('date_id')
		   }, 
		   function(response){
				
	   });
	});
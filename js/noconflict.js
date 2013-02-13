var jQuery182 = jQuery.noConflict(); 

jQuery('#some').live('click',function() {
	jQuery.post(
		ajaxurl, 
		   {
			  'action'	: 'short_fun'
		   }, 
		   function(response){
				alert('asd');
	   });
	});
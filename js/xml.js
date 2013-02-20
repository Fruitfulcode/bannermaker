/* custom css open */
jQuery('#custom_css').live('click',function() {
	jQuery.post(
	   ajaxurl, 
	   {
		  'action'		: 'banner_open_custom_css'
	   }, 
	   function(html){
			jQuery('#show_preview').html(html+"<span id='close_preview'></span>");
			jQuery('#show_preview').fadeIn(300);
		});
});
/* custom css add */	
jQuery('#custom_css_add').live('click',function() {
	jQuery('#show_preview').append('<div class="xml_line"><input class="class_css" type="text" value="Class"><textarea class="value_css"></textarea><a>delete</a></div>');
});
/* custom css save */	
jQuery('#custom_css_save').live('click',function() {
	
    var dataString = JSON.stringify(get_xml_value());

	jQuery.post(
	   ajaxurl, 
	   {
		  'type': "POST",
		  'action'	   : 'banner_save_xml',	
		  'dataType'   : 'json',		  
		  'xml_macive' : dataString
		  
	   }, 
	   function(response){
		alert(response);
   });
});

function get_xml_value() {
	var data = '';
	var postData = [];
	i = 0;
	jQuery('.xml_line').each(function() {
		postData[i] = {"name":jQuery(this).find('.class_css').val(),"value":jQuery(this).find('.value_css').val()}; 
		i++;
	});
	
	return postData;
}
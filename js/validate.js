jQuery('#create_submit').live('click',function() {
	var text_field = new Array("set_name"); /* add text field(id) here */
    var nummeric_field = new Array("set_width", "set_height"); /* add numeric  field(id) here */
	
		var error=0; 
		$("#banner_form_set").find(":input").each(function() {
			/* Check text field */
			for(var i=0;i<text_field.length;i++){ 
				if($(this).attr("id") == text_field[i]){ 
					if(!$(this).val()){
						$(this).css('border', 'red 1px solid');
						error=1;
					}
					else{
						$(this).css('border', 'gray 1px solid');
					}
				}              
			}
			/* Check numeric field */
			for(var i=0;i<nummeric_field.length;i++){ 
				if($(this).attr("id") == nummeric_field[i]){ 
					if(!$(this).val()){
						$(this).css('border', 'red 1px solid');
						error=2;
					}
					else{
						$(this).css('border', 'gray 1px solid');
					}
				}              
			}
	   })
});
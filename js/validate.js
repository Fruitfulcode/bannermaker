function banner_validation() {
	var text_field = new Array("set_name"); /* add text field(id) here */
    var nummeric_field = new Array("set_width", "set_height"); /* add numeric  field(id) here */
	
	var error=0; 
	jQuery("#banner_form_set").find(":input").each(function() {
		/* Check text field */
		for(var i=0;i<text_field.length;i++){ 
			if(jQuery(this).attr("id") == text_field[i]){ 
				if(!jQuery(this).val()){
					jQuery(this).css('border', 'red 1px solid');
					error=1;
				}
				else{
					jQuery(this).css('border', 'gray 1px solid');
				}
			}              
		}
		/* Check numeric field */
		for(var i=0;i<nummeric_field.length;i++){ 
			if(jQuery(this).attr("id") == nummeric_field[i]){ 
				if(!jQuery.isNumeric(jQuery(this).val())){
					jQuery(this).css('border', 'red 1px solid');
					error=2;
				}
				else {
					jQuery(this).css('border', 'gray 1px solid');
				}
			}              
		}
   });
   
   if(error == 0) { return true; }
}
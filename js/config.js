/* slider parameters */
	var slide_parameters = new Array();

		slide_parameters['b_style']		  = 2;
		slide_parameters['b_html'] 		  = 'Banner maker';
		slide_parameters['b_animation']  = 'Fade';
		slide_parameters['b_easing']	  = 'easeOutBack';
		slide_parameters['b_speed'] 	  = 300;
		slide_parameters['b_x'] 		  = '0px';
		slide_parameters['b_y'] 		  = '0px';
	
	var slide_set = '';
		slide_set += '<span class="set_b_style">'+slide_parameters['b_style']+'</span>';
		slide_set += '<span class="set_b_html">'+slide_parameters['b_html']+'</span>';
		slide_set += '<span class="set_b_animation">'+slide_parameters['b_animation']+'</span>';
		slide_set += '<span class="set_b_easing">'+slide_parameters['b_easing']+'</span>';
		slide_set += '<span class="set_b_speed">'+slide_parameters['b_speed']+'</span>';
		slide_set += '<span class="set_b_x">'+slide_parameters['b_x']+'</span>';
		slide_set += '<span class="set_b_y">'+slide_parameters['b_y']+'</span>';

/* activate the form*/
function set_active(obj) {
	if(jQuery(obj).find('.layer_type').text() == 'Image') {
		jQuery('#banner_style').attr('disabled','disabled');
		jQuery('#banner_html').attr('disabled','disabled');
	}
	else {
		jQuery('#banner_style').removeAttr('disabled');
		jQuery('#banner_html').removeAttr('disabled');
	}
	jQuery('#banner_animation').removeAttr('disabled');
	jQuery('#banner_easing').removeAttr('disabled');
	jQuery('#banner_speed').removeAttr('disabled');
	jQuery('#banner_x').removeAttr('disabled');
	jQuery('#banner_y').removeAttr('disabled');
}
/* change the form*/
function change_form() {
	/*width and height changes*/
	
	jQuery("#banner_working_board").width(jQuery("#set_width").val());
	jQuery("#banner_working_board").height(jQuery("#set_height").val());
	jQuery("#set_width").change(function()  { jQuery("#banner_working_board").width(jQuery("#set_width").val());   		});
	jQuery("#set_height").change(function() { jQuery("#banner_working_board").height(jQuery("#set_height").val()); 		});
	jQuery("#banner_x").change(function()   { jQuery(".drop_active").css('top',parseInt(jQuery("#banner_x").val()));	});
	jQuery("#banner_y").change(function()   { jQuery(".drop_active").css('left',parseInt(jQuery("#banner_y").val())); 	});
	
	/* layers changes */
	
	jQuery("#banner_style").change(function()	  { jQuery('.active_slide .banner_parameters .set_b_style').text(jQuery(this).val());		});
	jQuery("#banner_html").change(function() 	  { jQuery('.active_slide .banner_parameters .set_b_html').text(jQuery(this).val()); 	 	});
	jQuery("#banner_animation").change(function() { jQuery('.active_slide .banner_parameters .set_b_animation').text(jQuery(this).val()); 	});
	jQuery("#banner_easing").change(function() 	  { jQuery('.active_slide .banner_parameters .set_b_easing').text(jQuery(this).val()); 		});
	jQuery("#banner_speed").change(function() 	  { jQuery('.active_slide .banner_parameters .set_b_speed').text(jQuery(this).val()); 		});
	jQuery("#banner_x").change(function() 		  { jQuery('.active_slide .banner_parameters .set_b_x').text(jQuery(this).val()); 			});
	jQuery("#banner_y").change(function() 		  { jQuery('.active_slide .banner_parameters .set_b_y').text(jQuery(this).val());			});
	
	/* drop changes */
	jQuery('.slide').live('mousedown',function() {
		jQuery('#banner_working_board').find('.drop_active').removeClass('drop_active');
		jQuery("#"+jQuery(this).attr('role')).addClass('drop_active');
	});
	jQuery('.banner_block_drag').live('mousedown',function() {
		
		jQuery('#banner_working_board').find('.drop_active').removeClass('drop_active');
		jQuery(this).addClass('drop_active');
		
		var id_dorp = jQuery(this).attr('id');
		jQuery('#layers-order .slide').each(function(){
			jQuery(this).removeClass('active_slide');
			if(jQuery(this).attr('role') == id_dorp) {
				jQuery(this).addClass('active_slide');
				set_active(this);
				set_parameters(this);
			}
		});
	});
	
	jQuery('.drop_active').live('mousemove',function() {
		jQuery("#banner_x").val(jQuery(".drop_active").css('top'));
		jQuery("#banner_y").val(jQuery(".drop_active").css('left'));
		jQuery('.active_slide .banner_parameters .set_b_x').text(jQuery('#banner_x').val());
		jQuery('.active_slide .banner_parameters .set_b_y').text(jQuery('#banner_y').val());
	});
}
/* set parameters*/
function set_parameters(obj) {
	jQuery('#banner_style').val(jQuery(obj).find('.set_b_style').text());
	jQuery('#banner_html').val(jQuery(obj).find('.set_b_html').text());
	jQuery('#banner_animation').val(jQuery(obj).find('.set_b_animation').text());
	jQuery('#banner_easing').val(jQuery(obj).find('.set_b_easing').text());
	jQuery('#banner_speed').val(jQuery(obj).find('.set_b_speed').text());
	jQuery('#banner_x').val(jQuery(obj).find('.set_b_x').text());
	jQuery('#banner_y').val(jQuery(obj).find('.set_b_y').text());
}
/* change the form*/
function get_change_count_form() {
	var count_slide = jQuery('#layers-order-list .slide').length;
	var count = 0;
	jQuery('#layers-order-list .slide').each(function(){
		jQuery(this).find('.layer_counter').text(count);
		jQuery('#banner_working_board').find('#'+jQuery(this).attr('role')).css('z-index',count);
		count++;
	});
}
/* get parameters list*/
function get_parameters() {
	var count_slide = jQuery('#layers-order-list .slide').length;
	var maccive = '{';
	var count = 0;
		
	jQuery('#layers-order-list .slide').each(function(){
		
		maccive += '"'+count+'":';
		maccive += '{"type": "'+jQuery(this).find('.layer_type').text()+'",';
		if(jQuery(this).find('.layer_type').text() == 'Text') {
			maccive += '"style": "'+jQuery(this).find(".set_b_style").text()+'",';
			maccive += '"html": "'+jQuery(this).find('.set_b_html').text()+'",';
		}
		else {
			maccive += '"img": "'+jQuery(this).find('.set_b_img').text()+'",'; 	
		}
		maccive += '"animation": "'+jQuery(this).find('.set_b_animation').text()+'",';
		maccive += '"easing": "'+jQuery(this).find('.set_b_easing').text()+'",';
		maccive += '"speed": "'+jQuery(this).find('.set_b_speed').text()+'",';
		maccive += '"x": "'+jQuery(this).find('.set_b_x').text()+'",';
		maccive += '"y": "'+jQuery(this).find('.set_b_y').text()+'"}'; 		
		
		count++;
		if(count == count_slide) {maccive += '}';}
		else 					 {maccive += ','; }
	});
	
	return maccive;
}
function load_image(status_img_load = true,offset = 0) {
	window.send_to_editor = function(html) {
		imgurl = jQuery('img',html).attr('src');
		
		if(status_img_load) {
			jQuery('#banner_working_board').css('background','url('+imgurl+') no-repeat');
			jQuery('#banner_upload').val(imgurl);
		}
		else {
			/* Add drag-image layer */
			var count_slide = jQuery('#layers-order-list .slide').length;
			jQuery('#layers-order-list').append("<li class='slide' role='layer-"+(count_slide+offset)+"'><span class='layer_type'>Image</span><div class='banner_parameters'>"+slide_set+"<span class='set_b_img'>"+imgurl+"</span></div><span class='layer_counter'>"+count_slide+"</span></li>");
						
			jQuery('.slide').click(function() {
				jQuery('#layers-order').find('.active_slide').removeClass('active_slide');
				jQuery(this).addClass('active_slide');
			});
			
			/* Add drag-image layer */
			jQuery('#banner_working_board').append("<div id='layer-"+(count_slide+offset)+"' class='banner_block_drag'><img src='"+imgurl+"'/></div>");
			$( ".banner_block_drag" ).draggable({ containment: "#banner_working_board", scroll: false,cursor: "move" });
			
		}
		
		tb_remove();
	}
}
jQuery(document).ready(function() {
	/* preload init*/
	jQuery('.slide').click(function() {
		jQuery('#layers-order').find('.active_slide').removeClass('active_slide');
		jQuery(this).addClass('active_slide');
	});
	var id = jQuery('#start_submit').attr('role');
	change_form();
	var delete_counter = 0;
		
	/* ajax save function */
	jQuery('#start_submit').live('click',function() {
		data = 'name=' + get_parameters()+'&id='+id; 
		jQuery.ajax({
			type: 'POST',
		    cache: false,  
			url: 'http://localhost/Wordpress/wp-content/plugins/bannermaker/scripts/save-layers.php',
			data: data,
			success: function(html) {
				jQuery('#banner_form_set').submit();
			}
		});
	});
	
	/* Add text*/
	jQuery('#banner_add_text').live('click',function() {
		var count_slide = jQuery('#layers-order-list .slide').length;
		/* Add layer */
		jQuery('#layers-order-list').append("<li class='slide' role='layer-"+(count_slide+delete_counter)+"'><span class='layer_type'>Text</span><div class='banner_parameters'>"+slide_set+"</div><span class='layer_counter'>"+count_slide+"</span></li>");
		jQuery('.slide').click(function() {
			jQuery('#layers-order').find('.active_slide').removeClass('active_slide');
			jQuery(this).addClass('active_slide');
		});
		/* Add drag layer */
		jQuery('#banner_working_board').append("<div id='layer-"+(count_slide+delete_counter)+"' class='banner_block_drag'>"+slide_parameters['b_html']+count_slide+"</div>");
		jQuery( ".banner_block_drag" ).draggable({ containment: "#banner_working_board", scroll: false,cursor: "move" });
	});
	/* Add image*/
	jQuery('#banner_upload_image').click(function() {
		tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
		load_image(true,delete_counter);
	});
	jQuery('#banner_add_image').live('click',function() {
		tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
		load_image(false,delete_counter);
	});
	
	/* Delete layer*/
	jQuery('#banner_del_layer').live('click',function() {
		jQuery('#layers-order').find('.active_slide').remove();
		jQuery('#banner_working_board').find('.drop_active').remove();
		get_change_count_form();
		delete_counter++;
	});
	/* Delete all*/
	jQuery('#banner_del_all').live('click',function() {
		jQuery('#layers-order-list li').remove();
		jQuery('#banner_working_board .banner_block_drag').remove();
		get_change_count_form();
		delete_counter = 0;
	});
	/* Click by layer*/
	jQuery('.slide').live('mousedown',function() {
		set_active(this);
		set_parameters(this);
	});
	/* Change after drop*/
	jQuery('#layers-order').live('hover',function() {
		get_change_count_form();
	});
	
	/* init ui */
	jQuery("#layers-order-list").sortable({cursor: "move"});
	jQuery("#layers-order-list").disableSelection();
	$( ".banner_block_drag" ).draggable({ containment: "#banner_working_board", scroll: false,cursor: "move" });
});
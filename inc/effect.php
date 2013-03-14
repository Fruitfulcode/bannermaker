<?php

	global $Animation,$Easing;
	
	$Animation	     = array(  	'Fade',
								'Short from Top',
								'Short from Bottom',
								'Short from Right',
								'Short from Left',
								'Long from Top',
								'Long from Bottom',
								'Long from Right',
								'Long from Left',
								'Random Rotate' ) ;
			
	$Easing			= array(	'easeOutBack',
								'easeInQuad',
								'easeOutQuad',
								'easeInOutQuad',
								'easeInCubic',
								'easeOutCubic',
								'easeInOutCubic',
								'easeInQuart',
								'easeOutQuart',
								'easeInOutQuart',
								'easeInQuint',
								'easeOutQuint',
								'easeInOutQuint',
								'easeInSine',
								'easeOutSine',
								'easeInOutSine',
								'easeInExpo',
								'easeOutExpo',
								'easeInOutExpo',
								'easeInCirc',
								'easeOutCirc',
								'easeInOutCirc',
								'easeInElastic',
								'easeOutElastic',
								'easeInOutElastic',
								'easeInBack',
								'easeInOutBack',
								'easeInBounce',
								'easeOutBounce',
								'easeInOutBounce');

function show_Banner_effect($set = 'Animation'){
	global $Animation,$Easing;
	
	if($set == 'Animation') {
		foreach($Animation as $value)	{
			echo '<option>'.$value.'</option>';
		}
	}
	if($set == 'Easing') {
		foreach($Easing as $value)	{
			echo '<option>'.$value.'</option>';
		}
	}
}			

function get_Banner_slide($atts)	{
	
	extract(shortcode_atts(array(
	  'animation_ef' 	 => 'Fade',
	  'val_x' 		 	 => 0,
	  'val_y' 		 	 => 0,
	  'count' 		 	 => 0,
	  'temp_body'	 	 => 'none',
	  'offset_x' 		 => 0,
	  'offset_y' 	 	 => 0,
	  'speed' 		 	 => 0,
	  'easing' 		 	 => 'easeOutBack',
	  'delay' 			 => 0,
	  'animation_ef_out' => 'off',
	  'easing_out' 	  	 => '',
	  'speed_out' 		 => 0,
	  'delay_out' 	  	 => 0,
	  'style' 	  	 => 'none',
	  'id'      		 => 0
	),$atts));
		
	global $Animation;
	unset($out);
	unset($style_display);
	unset($style_x);
	unset($style_y);
	unset($prefix);
	unset($out_offset_x);
	unset($out_offset_y);
		
	/* slides */
	if($animation_ef  	  == 'Random Rotate') 	{	$animation_ef     = $Animation[rand ( 0 , 8 )];}
	if($animation_ef_out  == 'Random Rotate') 	{	$animation_ef_out = $Animation[rand ( 0 , 8 )];}
	
	if($animation_ef  == 'Fade') 				{	$style_x = $val_x; 					 	$style_y = $val_y;						 }
	if($animation_ef  == 'Short from Top') 		{	$style_x = $val_x;						$style_y = '-'.($val_y+$offset_y).'px';  }
	if($animation_ef  == 'Short from Bottom') 	{	$style_x = $val_x;						$style_y = ($val_y+$offset_y).'px';  	 }
	if($animation_ef  == 'Short from Right') 	{	$style_x = ($val_x+$offset_x).'px';		$style_y = $val_y;					 	 }
	if($animation_ef  == 'Short from Left') 	{	$style_x = '-'.($val_x+$offset_x).'px';	$style_y = $val_y; 					 	 }
	if($animation_ef  == 'Long from Top') 		{	$style_x = $val_x;						$style_y = '-'.($val_y+$offset_y).'px';  }
	if($animation_ef  == 'Long from Bottom') 	{	$style_x = $val_x;						$style_y = ($val_y+$offset_y).'px';  	 }
	if($animation_ef  == 'Long from Right') 	{	$style_x = ($val_x+$offset_x).'px';		$style_y = $val_y;   				 	 }
	if($animation_ef  == 'Long from Left') 		{	$style_x = '-'.($val_x+$offset_x).'px';	$style_y = $val_y; 						 }
	
	if($animation_ef_out == 'Fade') 				{	$out_offset_x = $val_x; 					 	$out_offset_y = $val_y;						 }
	if($animation_ef_out  == 'Short from Top') 		{	$out_offset_x = $val_x;							$out_offset_y = '-'.($val_y+$offset_y).'px';  }
	if($animation_ef_out  == 'Short from Bottom') 	{	$out_offset_x = $val_x;							$out_offset_y = ($val_y+$offset_y).'px';  	 }
	if($animation_ef_out  == 'Short from Right') 	{	$out_offset_x = ($val_x+$offset_x).'px';		$out_offset_y = $val_y;					 	 }
	if($animation_ef_out  == 'Short from Left') 	{	$out_offset_x = '-'.($val_x+$offset_x).'px';	$out_offset_y = $val_y; 					 	 }
	if($animation_ef_out  == 'Long from Top') 		{	$out_offset_x = $val_x;							$out_offset_y = '-'.($val_y+$offset_y).'px';  }
	if($animation_ef_out  == 'Long from Bottom') 	{	$out_offset_x = $val_x;							$out_offset_y = ($val_y+$offset_y).'px';  	 }
	if($animation_ef_out  == 'Long from Right') 	{	$out_offset_x = ($val_x+$offset_x).'px';		$out_offset_y = $val_y;   				 	 }
	if($animation_ef_out  == 'Long from Left') 		{	$out_offset_x = '-'.($val_x+$offset_x).'px';	$out_offset_y = $val_y; 						 }
	
	if($animation_ef == 'Fade') {
		$out['slides'] = '<div class="banner_slide '.$style.'" id="slide-layer-'.$count.'-'.$id.'" style="display: none;left: '.$style_x.';top: '.$style_y.';z-index: '.$count.';">'.$temp_body.'</div>';
		$out['reset']  = 'jQuery("#slide-layer-'.$count.'-'.$id.'").css({display: "none",left: "'.$style_x.'",top: "'.$style_y.'"});';
	} else {
		$out['slides'] = '<div class="banner_slide '.$style.'" id="slide-layer-'.$count.'-'.$id.'" style="left: '.$style_x.';top: '.$style_y.';z-index: '.$count.';display:block;">'.$temp_body.'</div>';
		$out['reset']  = 'jQuery182("#slide-layer-'.$count.'-'.$id.'").css({left: "'.$style_x.'",top: "'.$style_y.'"});';
	}
	/* Animation */
	
	if( $animation_ef == 'Fade')	{	$out['scripts'] = 'jQuery("#slide-layer-'.$count.'-'.$id.'").delay('.$delay.').fadeIn('.$speed.')'; $prefix = ';jQuery182("#slide-layer-'.$count.'-'.$id.'")'; }
	
	if(	$animation_ef == 'Short from Top' 	 or 
		$animation_ef == 'Short from Bottom' or 
		$animation_ef == 'Short from Right'  or 
		$animation_ef == 'Short from Left'	)
									{	$out['scripts'] = 'jQuery182("#slide-layer-'.$count.'-'.$id.'").delay('.$delay.').animate({left: "'.$val_x.'", top: "'.$val_y.'"},'.$speed.',"'.$easing.'")'; }
	
	if(	$animation_ef == 'Long from Top' 	 or 
		$animation_ef == 'Long from Bottom'  or 
		$animation_ef == 'Long from Right' 	 or 
		$animation_ef == 'Long from Left'	)
									{	$out['scripts'] = 'jQuery182("#slide-layer-'.$count.'-'.$id.'").delay('.$delay.').animate({left: "'.$val_x.'", top: "'.$val_y.'"},'.($speed*2).',"'.$easing.'")'; }

    if( $animation_ef_out == 'Fade'){	$out['scripts'] .= '.delay('.$delay_out.').fadeOut('.$speed_out.');';	}
	
	if(	$animation_ef_out == 'Short from Top' 	 or 
		$animation_ef_out == 'Short from Bottom' or 
		$animation_ef_out == 'Short from Right'  or 
		$animation_ef_out == 'Short from Left'	)
									{	$out['scripts'] .= $prefix.'.delay('.$delay_out.').animate({left: "'.$out_offset_x.'", top: "'.$out_offset_y.'"},'.$speed_out.',"'.$easing_out.'");'; }
	
	if(	$animation_ef_out == 'Long from Top' 	 or 
		$animation_ef_out == 'Long from Bottom'  or 
		$animation_ef_out == 'Long from Right' 	 or 
		$animation_ef_out == 'Long from Left'	)
									{	$out['scripts'] .= $prefix.'.delay('.$delay_out.').animate({left: "'.$out_offset_x.'", top: "'.$out_offset_y.'"},'.($speed_out*2).',"'.$easing_out.'");'; }
	
	if( $animation_ef_out == 'off'){	$out['scripts'] .= ';'; }
																							
	return $out;
}			
?>
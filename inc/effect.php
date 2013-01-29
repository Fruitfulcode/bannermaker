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

function get_Banner_slide($animation_ef = 'Fade', $val_x = 0, $val_y = 0, $count = 0,$temp_body ='', $offset_x = 0, $offset_y = 0)	{
	global $Animation;
	unset($out);
	
	if($animation_ef  == 'Random Rotate') 		{	$animation_ef = $Animation[rand ( 0 , 8 )];}
	
	if($animation_ef == 'Fade') 				{	$out	 .= '<div class="banner_slide" id="slide-layer-'.$count.'" style="left: '.$val_x.'; top: '.$val_y.';">'.$temp_body.'</div>';	 }
	if($animation_ef  == 'Short from Top') 		{	$out	 .= '<div class="banner_slide" id="slide-layer-'.$count.'" style="left: '.$val_x.'; top: -'.($val_y+$offset_y).'px;">'.$temp_body.'</div>';  }
	if($animation_ef  == 'Short from Bottom') 	{	$out	 .= '<div class="banner_slide" id="slide-layer-'.$count.'" style="left: '.$val_x.'; top:  '.($val_y+$offset_y).'px;">'.$temp_body.'</div>';  }
	if($animation_ef  == 'Short from Right') 	{	$out	 .= '<div class="banner_slide" id="slide-layer-'.$count.'" style="left: '.($val_x+$offset_x).'px; top: '.$val_y.';">'.$temp_body.'</div>'; 	 }
	if($animation_ef  == 'Short from Left') 	{	$out	 .= '<div class="banner_slide" id="slide-layer-'.$count.'" style="left: -'.($val_x+$offset_x).'px;  top: '.$val_y.';">'.$temp_body.'</div>'; }
	if($animation_ef  == 'Long from Top') 		{	$out	 .= '<div class="banner_slide" id="slide-layer-'.$count.'" style="left: '.$val_x.'; top: -'.($val_y+$offset_y).'px;">'.$temp_body.'</div>';  }
	if($animation_ef  == 'Long from Bottom') 	{	$out	 .= '<div class="banner_slide" id="slide-layer-'.$count.'" style="left: '.$val_x.'; top:  '.($val_y+$offset_y).'px;">'.$temp_body.'</div>';  }
	if($animation_ef  == 'Long from Right') 	{	$out	 .= '<div class="banner_slide" id="slide-layer-'.$count.'" style="left: '.($val_x+$offset_x).'px; top: '.$val_y.';">'.$temp_body.'</div>';	 }
	if($animation_ef  == 'Long from Left') 		{	$out	 .= '<div class="banner_slide" id="slide-layer-'.$count.'" style="left: -'.($val_x+$offset_x).'px;  top: '.$val_y.';">'.$temp_body.'</div>'; }
	
	return $out;
}			

function get_Banner_script($animation_ef = 'Fade', $val_x = 0, $val_y = 0, $speed = 300, $easing = 'easeOutBack', $count = 0){
	unset($script);
	
	if( $animation_ef == 'Fade') {	$script = 'jQuery182("#slide-layer-'.$count.'").fadeIn('.$speed.');'; }
	
	if(	$animation_ef == 'Short from Top' 	 or 
		$animation_ef == 'Short from Bottom' or 
		$animation_ef == 'Short from Right'  or 
		$animation_ef == 'Short from Left'	)
								{	$script = 'jQuery182("#slide-layer-'.$count.'").animate({left: "'.$val_x.'", top: "'.$val_y.'"}, '.$speed.',"'.$easing.'");'; }
	
	if(	$animation_ef == 'Long from Top' 	 or 
		$animation_ef == 'Long from Bottom'  or 
		$animation_ef == 'Long from Right' 	 or 
		$animation_ef == 'Long from Left'	)
								{	$script = 'jQuery182("#slide-layer-'.$count.'").animate({left: "'.$val_x.'", top: "'.$val_y.'"}, '.($speed*2).',"'.$easing.'");'; }
	return $script;
}


?>
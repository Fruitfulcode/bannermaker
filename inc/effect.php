<?php

	global $Animation,$Easing;
	
	$Animation	     = array(  'Fade','Short from Top',
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
?>
<?php	/* Art - shortcode */
function get_banner_out($atts) {

	extract(shortcode_atts(array(
		  'id' => ''
		  ),$atts));	
	
	global $wpdb;
	$banner_prefs_table = BASE_BANNER;
	$count = 0;
	$max_delay=0;
	unset($banner_macive);
	unset($settings_macive);
	unset($banner_out);
	unset($sql);
	unset($get_settings);
	unset($script);
		
	$sql = "select * from $banner_prefs_table where id=".$id."";
	$get_settings = $wpdb->get_results($sql);
	
	if(!$get_settings) { 
		echo '<h1 style="color: red;">Please enter the correct id banner!!!</h1>';
	}
	if( $get_settings) {
		
		$script = '<script type="text/javascript">var jQuery182 = $.noConflict(); function anim($){';
		$script_for_null = '<script type="text/javascript">function sett($){';
		
		foreach($get_settings as $line){
			foreach($line as $key  => $value){
				$banner_macive[$key] = $value;
			}
		}
				
		$banner_out = '<div class="banner_maker_container" id="bannermaker-'.$banner_macive['id'].'"style="width: '.$banner_macive['width'].'px;
																			height: '.$banner_macive['height'].'px;
																			background: '.$banner_macive['background'].' no-repeat;" >';
		$banner_out 	 .= '<a href="'.$banner_macive['url'].'" target="_blank">';
		$settings_macive = get_slide_settings($id);
		
		
		
		foreach ($settings_macive as $value_key) {
			if($value_key['img'])	{	$temp_body = '<img src="'.$value_key['img'].'"/>';	}
			else					{	$temp_body = html_entity_decode($value_key['html']);					}
		
			if( $value_key['animation']  == 'Long from Top' 	 or
				$value_key['animation']  == 'Long from Bottom' 	 or
				$value_key['animation']  == 'Long from Right'  	 or
				$value_key['animation']  == 'Long from Left' 	 or
				$value_key['animation']  == 'Random Rotate'	) {	$delay = ( $value_key['speed']*2 )+$value_key['delay']; }
			else 											  { $delay = $value_key['speed']+$value_key['delay']; 		}
			
			if ($max_delay < $delay) { $max_delay = $delay; }
			
			$get_value = get_Banner_slide (	array(	  'animation_ef' => $value_key['animation'],
													  'val_x' => $value_key['x'],
													  'val_y' => $value_key['y'],
													  'count' => $count,
													  'temp_body' => $temp_body,
													  'offset_x' => $banner_macive['width'],
													  'offset_y' => $banner_macive['height'],
													  'speed' => $value_key['speed'],
													  'easing' => $value_key['easing'],
													  'delay' => $value_key['delay'],
													  'animation_ef_out' => $value_key['animation_out'],
													  'easing_out' => $value_key['easing_out'],
													  'speed_out' => $value_key['speed_out'],
													  'delay_out' => $value_key['delay_out']
											));
			
			$banner_out .= $get_value['slides'];
			$script	.= 	$get_value['scripts'];
			$script_for_null .= $get_value['reset'];
		
			$count++;
		}
		
		$script_for_null .= 'anim();}</script>';
		$banner_out 	 .= '</a></div>';
		$script .= 'setTimeout("sett()",'.($max_delay+5000).');}anim();</script>';
		
		echo $banner_out;
		echo $script;
		echo $script_for_null;
	} 
}
add_shortcode('bannermaker','get_banner_out');
?>
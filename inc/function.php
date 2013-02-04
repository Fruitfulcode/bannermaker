<?php
function getBannerPage(){
			unset($var);
			
			if(isset($_GET['status'])) $var = $_GET['status'];
			
				switch($var){
					case "create":
						show_Banner_settings();
						$var = 'active';
					break;
					case "edit":
						show_Banner_settings();
						$var = 'active';
					break;
					case "insert":
						change_Banner();
						$var = 'active';
					break;
					case "delete":
						delete_Banner();
						$var = 'delete';
					break;
				}
	return $var;
}

function delete_Banner(){
	global $wpdb;
	$banner_prefs_table = BASE_BANNER;
	$banner_prefs_delete = BASE_SETTINGS;
	
	if(isset($_GET['id'])) {
		$id = $_GET['id'];
		$sql = "DELETE FROM $banner_prefs_table WHERE id=".$id."";
		$wpdb->query($sql);
		$sql_del = "DELETE FROM $banner_prefs_delete WHERE id=".$id."";
		$wpdb->query($sql_del);
	}
}

function change_Banner(){
	global $wpdb;
	$banner_prefs_table = BASE_BANNER;
	unset($sql);

	if(isset($_POST['banner'])) { 
	
		$maccive = $_POST['banner']; 	   

		/* add banner*/	
		$sql = "INSERT INTO $banner_prefs_table (name,height,width,url,background) 
				VALUES('$maccive[banner_name]','$maccive[banner_h]','$maccive[banner_w]','$maccive[banner_url]','$maccive[banner_upload]');";
		$wpdb->query($sql);		
		
		/*get last id*/
		unset($sql);
		$sql = "SELECT LAST_INSERT_ID()";
		$id = $wpdb->get_results($sql);
		foreach($id as $line){
			foreach($line as $key  => $value){
				$id_set = $value;
			}
		}
		
		/* add setting layer */
		unset($sql);
		$sql = "INSERT INTO wp_banner_settings (id,settings) VALUES('$id_set','NULL')";
		$wpdb->query($sql);	
	
		show_Banner_settings($id_set);
	}
}
/*show layers settings*/
function get_list_settings_layers($id = null){
	unset($out);
	unset($set_out);
	unset($set_slides);
	
	$count = 0;
	
	$settings = get_slide_settings($id);
		
	if($settings) {
		foreach ($settings as $value_key) {
			
			$out .= '<li class="slide" role="layer-'.$count.'">';
			$set_out = '<div class="banner_parameters">';
			$out     .= '<span class="layer_type">'.$value_key['type'].'</span>';	
			$set_out .= '<span class="set_b_style">'.$value_key['style'].'</span>';	
			$set_out .= '<span class="set_b_html">'.$value_key['html'].'</span>';	
			$set_out .= '<span class="set_b_animation">'.$value_key['animation'].'</span>';
			$set_out .= '<span class="set_b_easing">'.$value_key['easing'].'</span>';	
			$set_out .= '<span class="set_b_speed">'.$value_key['speed'].'</span>';	
			$set_out .= '<span class="set_b_delay">'.$value_key['delay'].'</span>';	
			$set_out .= '<span class="set_b_animation_out">'.$value_key['animation_out'].'</span>';
			$set_out .= '<span class="set_b_easing_out">'.$value_key['easing_out'].'</span>';	
			$set_out .= '<span class="set_b_speed_out">'.$value_key['speed_out'].'</span>';	
			$set_out .= '<span class="set_b_delay_out">'.$value_key['delay_out'].'</span>';	
			$set_out .= '<span class="set_b_x">'.$value_key['x'].'</span>';			
			$set_out .= '<span class="set_b_y">'.$value_key['y'].'</span>';		
   		    $set_out .= '<span class="set_b_img">'.$value_key['img'].'</span>';		
										
			if($value_key['img'])	{	$temp_body = '<img src="'.$value_key['img'].'"/>';	}
			else			{	$temp_body = html_entity_decode($value_key['html']);	}
			
			$set_slides .= '<div id="layer-'.$count.'" class="'.$value_key['style'].' banner_block_drag" style="display: inline-block;top:'.$value_key['y'].';left:'.$value_key['x'].';">'.$temp_body.'</div>';
			$set_out .='</div>';
			$out .= $set_out.'<span class="layer_counter">'.$count.'</span><span class="show_hode">'.$value_key['visibility'].'</span></li>';
			
			$count++;
		}
	}
		
	echo $set_slides;
	
	return $out;
}
/* get slide settings */
function get_slide_settings($id) {
	
	global $wpdb;
	$banner_prefs_table = BASE_SETTINGS;
	$count = 0;
	
	unset($sql);
	unset($get_settings);
	unset($settings_macive);
	unset($settings);
	
	
	$sql = "select settings from $banner_prefs_table where id=".$id."";
	$get_settings = $wpdb->get_results($sql);
		
	foreach ($get_settings as $value) {
		foreach ($value as $m_settings) {
			$settings = json_decode($m_settings);
		}
	}
	
	if($settings) {
		foreach ($settings as $value_set) {
							
				foreach ($value_set as $key => $value_key) {
					$settings_macive[$count][$key]	= $value_key;	
				}
			$count++;
		}
	}
	
	return $settings_macive;
}
/* Counter banner */
add_action('wp_ajax_banner_countre', 'banner_countre');

function banner_countre() {
	/*global $wpdb;
	$banner_prefs_table = BASE_BANNER;
	$banner_prefs_setting_table = BASE_SETTINGS;
	
	unset($sql);

	$get_json = htmlspecialchars($_POST["set_lay"]);
	$name = htmlspecialchars($_POST["name"]);
	$height = htmlspecialchars($_POST["height"]);
	$width = htmlspecialchars($_POST["width"]);
	$url = htmlspecialchars($_POST["url"]);
	$background = htmlspecialchars($_POST["background"]);
	$id = htmlspecialchars($_POST["id"]);
	$json = str_replace('/ban87;','"',$get_json);
	
	$sql = "UPDATE $banner_prefs_setting_table 
			SET id='$id',settings='$json'
			WHERE id=$id";
	$wpdb->query($sql);
	
	unset($sql);
	
	$sql = "UPDATE $banner_prefs_table 
					SET name='$name',height='$height',width='$width',url='$url',click='0',background='$background' 
					WHERE id=$id";
					
	$wpdb->query($sql);*/
	echo "some";
}

add_action('wp_ajax_banner_save_settings', 'banner_save_settings');

function banner_save_settings() {
	global $wpdb;
	$banner_prefs_table = BASE_BANNER;
	$banner_prefs_setting_table = BASE_SETTINGS;
	
	unset($sql);

	$get_json = htmlspecialchars($_POST["set_lay"]);
	$name = htmlspecialchars($_POST["name"]);
	$height = htmlspecialchars($_POST["height"]);
	$width = htmlspecialchars($_POST["width"]);
	$url = htmlspecialchars($_POST["url"]);
	$background = htmlspecialchars($_POST["background"]);
	$id = htmlspecialchars($_POST["id"]);
	$json = str_replace('/ban87;','"',$get_json);
	
	$sql = "UPDATE $banner_prefs_setting_table 
			SET id='$id',settings='$json'
			WHERE id=$id";
	$wpdb->query($sql);
	
	unset($sql);
	
	$sql = "UPDATE $banner_prefs_table 
					SET name='$name',height='$height',width='$width',url='$url',click='0',background='$background' 
					WHERE id=$id";
					
	$wpdb->query($sql);
}
function show_Banner_settings($id_creator = 0){
	global $wpdb;
	$banner_prefs_table = BASE_BANNER;
	unset($id);
	
	if(isset($_GET['id'])) { $id = $_GET['id']; } else { $id = $id_creator; }
	
	if($id)	{
		$sql = "select * from $banner_prefs_table where id=".$id."";
		$check = $wpdb->get_results($sql);
		
		foreach($check as $line){
			foreach($line as $key  => $value){
					if($key == "name")			{ $name = $value;	}
					if($key == "width")			{ $width = $value;	}
					if($key == "height")		{ $height = $value;	}
					if($key == "url")			{ $url = $value;	}
					if($key == "background")	{ $back = $value;	}
			}
		}
	}
?>
	<form id="banner_form_set" name="banner_opt" method="POST" action="<?php echo $_SERVER["PHP_SELF"];?>?page=banner&amp;status=insert">
	<div id="settings-container">
		<h3>Genneral settings</h3>
		<div class="set_general">Banner name:<input id="set_name" type='text' name="banner[banner_name]" value="<?php echo $name; ?>"></div>
		<div class="set_general">Banner size:
			<label>Height<input id="set_height" name="banner[banner_h]" type='text' value="<?php echo $height; ?>" /></label>
			<label>Width<input id="set_width" name="banner[banner_w]" type='text' value="<?php echo $width; ?>" /></label>
		</div>
		<div class="set_general">Banner URL:<input id="set_url" type='text' name='banner[banner_url]' value="<?php echo $url; ?>" /></div>
		
		<h3>Layers settings</h3>
		<div id="banner_working_board" style="background: <?php echo $back;?> no-repeat;">
			<?php $banner_layers = get_list_settings_layers($id);?>
		</div>
		<input id="banner_upload" type="text" size="36" name="banner[banner_upload]" value="<?php echo $back;?>" style="display: none"/>	
		<input id="banner_upload_image" type="button" class="blue_a_but" value="Add: Background" />
	</form>
	<?php if($id) { ?>
		<input id="banner_add_image" type="button" class="blue_a_but" value="Add: Image" />
		<input id="banner_add_text" type="button" class="blue_a_but" value="Add: Text" />
		<input id="banner_del_layer" type="button" class="delete_layer" value="Delete: layer" />
		<input id="banner_del_all" type="button" class="delete_all" value="Delete: all" />
				
		<div id="settings-area">
			<div id="layer-param">
				<h4 class="title-parameters">Layer parameters: </h4>
				<label id="css_area">Style
					<select id="banner_style" disabled="disabled">
						<option>1</option>
						<option>2</option>
						<option>3</option>
					</select>
					<a class="blue_a_but" href="">Edit CSS</a>
				</label>
				<label id="btext_layer">Text / HTML
					<textarea id="banner_html" disabled="disabled">
					</textarea>
				</label>
				<label>Animation 
					<select disabled="disabled" id="banner_animation">
						<?php show_Banner_effect(); ?>
					</select>
				</label>
				<label>Easing 
					<select disabled="disabled" id="banner_easing">
						<?php show_Banner_effect('Easing'); ?>
					</select>
				</label>
				<label>Speed 
					<input type="text" disabled="disabled" id="banner_speed"></input>
				</label>
				<label>Delay 
					<input type="text" disabled="disabled" id="banner_delay"></input>
				</label>
				<label>Out - Animation 
					<select disabled="disabled" id="banner_animation_out">
						<option> off </option>
						<?php show_Banner_effect(); ?>
					</select>
				</label>
				<label>Out - Easing 
					<select disabled="disabled" id="banner_easing_out">
						<?php show_Banner_effect('Easing'); ?>
					</select>
				</label>
				<label>Out - Speed 
					<input type="text" disabled="disabled" id="banner_speed_out"></input>
				</label>
				<label>Out - Delay 
					<input type="text" disabled="disabled" id="banner_delay_out"></input>
				</label>
				<label>X 
					<input type="text" disabled="disabled" id="banner_x"></input>
				</label>
				<label>Y 
					<input type="text" disabled="disabled" id="banner_y"></input>
				</label>
			</div>
			<div id="layers-order">
				<h4 class="title-layers">Layers order: </h4>
				<ul id="layers-order-list"><?php echo $banner_layers;?></ul>
			</div>
		</div>
		<div id="save_changes" style="display: none;position: fixed;left: 50%;top:50%;">save</div>
	<?php } ?>
	</div>
	<div style="clear:both;"></div>
	<?php 
	if($id) {	echo "<input id='update_submit' class='blue_a_but' type='button' name='banner_opt_btn' value='Save' role=".$id.">";	}
	else 	{	echo "<input id='create_submit' class='blue_a_but' type='button' name='banner_opt_btn' value='Create'>";	}
	echo "<a class='blue_a_but' href='".$_SERVER["PHP_SELF"]."?page=banner'>back</a>";
}
?>
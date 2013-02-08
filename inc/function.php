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
					case "copy":
						copy_Banner();
						$var = 'copy';
					break;
				}
	return $var;
}
function copy_Banner () {
/*	global $wpdb;
	$banner_prefs_table = BASE_BANNER;
	$banner_prefs_delete = BASE_SETTINGS;
	
	if(isset($_GET['id'])) {
		$id = $_GET['id'];
		$sql = "SELECT * INTO Tabs FROM $banner_prefs_table WHERE id=".$id." ALTER TABLE Tabs DROP COLUMN CID INSERT INTO $banner_prefs_table SELECT * FROM Tabs DROP TABLE Tabs ";
		$tabl1 = $wpdb->query($sql);
		$sql_del = "SELECT * FROM $banner_prefs_delete WHERE id=".$id."";
		$tabl2 = $wpdb->query($sql_del);
	}*/
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
			
			if($value_key['visibility'] == 'show')	{	$temp_show_class = 'show_hidden';	}
						
			$set_slides .= '<div id="layer-'.$count.'" class="'.$value_key['style'].' banner_block_drag" style="display: inline-block;top:'.$value_key['y'].';left:'.$value_key['x'].';">'.$temp_body.'</div>';
			$set_out .='</div>';
			$out .= $set_out.'<span class="layer_counter">'.$count.'.</span><span class="layer_type">'.$value_key['type'].'</span><span class="show_hode '.$temp_show_class.'" role='.$value_key['visibility'].'></span></li>';
			
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

add_action('wp_ajax_banner_show_preview', 'banner_show_preview');

function banner_show_preview() {
	$id = htmlspecialchars($_POST["id"]);
	return do_shortcode('[bannermaker id="'.$id.'"]');
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
	<h3 class="entry-header">settings</h3>
	<div id="settings-container">
	<form id="banner_form_set" name="banner_opt" method="POST" action="<?php echo $_SERVER["PHP_SELF"];?>?page=banner&amp;status=insert">
		<h3>Name</h3>
		<label>Unique name of your banner</label>
			<input id="set_name" type='text' name="banner[banner_name]" value="<?php echo $name; ?>">
		<h3>Banner size</h3>
			<label>Set needed size for banner layout</label>
		<h4>Height</h4>
			<input class="small_in" id="set_height" name="banner[banner_h]" type='text' value="<?php echo $height; ?>" value="350" />
		<h4>Width</h4>
			<input class="small_in" id="set_width" name="banner[banner_w]" type='text' value="<?php echo $width; ?>" value="700" />
		<h3>Banner URL:</h3>
		<label>This reference for banner on click</label>
			<input id="set_url" type='text' name='banner[banner_url]' value="<?php echo $url; ?>" />
		<h3>Banner background</h3>
		<label>Set background image for banner</label>
			<input id="banner_upload" type="text" size="36" name="banner[banner_upload]" value="<?php echo $back;?>" style="display: none"/>	
			<a id="banner_upload_image" class="grey_button_big left">Add Background</a><a id="del_background"></a>			
		<h3 class="clear">Layout</h3>
		<label>This is how you banner will be display</label>
		<div id="coordination">
			<span id="coordnt_start"></span>
			<span id="coordnt_x"></span>
			<span id="coordnt_y"></span>
			<div id="banner_working_board" style="<?php if($back != 'none') { echo 'background: url('.$back.') no-repeat;'; } ?>">
				<?php $banner_layers = get_list_settings_layers($id);?>
			</div>
		</div>
	</form>
	<?php if($id) { ?>
	<div class="container-full">
		<a class="action_button right show_preview" data_id="<?php echo $id ?>">View preview</a>
	</div>
	<div id="settings-area">
		<div class="setting_block">
			<div class="title-parameters"><span>Name</span><span style="margin-left: 60px;">Parameters</span></div>
			<div id="layer-param">
				<label id="css_area">Style
					<a class="grey_button" id="custom_css">Edit CSS</a>
					<select id="banner_style" disabled="disabled">
						<option>1</option>
						<option>2</option>
						<option>3</option>
					</select>
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
		</div>
		<div class="setting_block">
			<div class="title-layers"><span>Order</span><span>Type</span><span class="right">Show / Hide</span> </div>
			<div id="layers-order">
				<ul id="layers-order-list"><?php echo $banner_layers;?></ul>
			</div>
			<a id="banner_add_image" class="blue_a_but">	<img src="<?php echo BANNER_IMG.'/ico_add.png'; ?>" />Add image</a>
			<a id="banner_add_text"  class="blue_a_but">	<img src="<?php echo BANNER_IMG.'/ico_addt.png'; ?>" />Add text</a>
			<a id="banner_del_layer" class="delete_layer">	<img src="<?php echo BANNER_IMG.'/ico_del.png'; ?>"  />Remove layer</a>
		</div>
	</div>
	
		<?php } 
		
		if($id) {	echo "<div id='bottom_save_area'><a class='grey_button_big' href='".$_SERVER["PHP_SELF"]."?page=banner'>cancel</a>";
					echo "<a id='update_submit' class='action_button_big' role=".$id.">Save</a></div>";			}
		else 	{	echo "<a id='create_submit' class='action_button_big'>Create</a>";	
					echo "<a class='grey_button_big' href='".$_SERVER["PHP_SELF"]."?page=banner'>cancel</a>";		}
		?>
		<div id="save_changes" style="display: none;position: fixed;left: 50%;top:50%;">save</div>
		<div id="show_preview"></div>
	</div>
	<?php 
}
?>
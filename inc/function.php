<?php


function getBannerPage($initVar = ""){
			$var = $initVar;
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
						change_Banner(true);
						$var = 'show';
					break;
					case "update":
						change_Banner(false);
						show_Banner_settings();
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
	
	if(isset($_GET['id'])) $id = $_GET['id'];
	
	$sql = "DELETE FROM $banner_prefs_table WHERE id=".$id."";
	$wpdb->query($sql);
}

function change_Banner($status = true){
	global $wpdb;
	$banner_prefs_table = BASE_BANNER;
	unset($sql);
	
	if(isset($_POST['banner_name'])) 	   { $name = $_POST['banner_name']; 	  }
	if(isset($_POST['banner_w']))	 	   { $width = $_POST['banner_w'];  		  }
	if(isset($_POST['banner_h']))    	   { $height = $_POST['banner_h'];  	  }
	if(isset($_POST['banner_url'])) 	   { $url = $_POST['banner_url']; 		  }
	if(isset($_POST['radio_res']))   	   { $res = $_POST['radio_res']; 		  }
	if(isset($_POST['banner_upload'])) 	   { $back = $_POST['banner_upload']; }
		
	if($status == true)	 {	$sql = "INSERT INTO $banner_prefs_table (name,height,width,url,responsive,background) 
							VALUES('$name','$height','$width','$url','$res','$back')"; }
	if($status == false) {	
		if(isset($_GET['id'])) { $id = $_GET['id']; 
			$sql = "UPDATE $banner_prefs_table 
					SET name='$name',height='$height',width='$width',url='$url',responsive='$res',background='$back' 
					WHERE id=$id";
					
		}
	}
	
	if($sql)	{ $wpdb->query($sql); }
}
/*show layers settings*/
function get_list_settings_layers($id = null){
	global $wpdb;
	$banner_prefs_table = BASE_SETTINGS;
	unset($sql);
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
			$set_out .= '<span class="set_b_x">'.$value_key['x'].'</span>';			
			$set_out .= '<span class="set_b_y">'.$value_key['y'].'</span>';		
   		    $set_out .= '<span class="set_b_img">'.$value_key['img'].'</span>';		
							
			if($value_key['img'])	{	$temp_body = '<img src="'.$value_key['img'].'"/>';	}
			else			{	$temp_body = $value_key['html'];	}
			
			$set_slides .= '<div id="layer-'.$count.'" class="'.$value_key['style'].' banner_block_drag" style="display: inline-block;top:'.$value_key['x'].';left:'.$value_key['y'].';">'.$temp_body.'</div>';
			$set_out .='</div>';
			$out .= $set_out.'<span class="layer_counter">'.$count.'</span></li>';
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
function show_Banner_settings(){
	global $wpdb;
	$banner_prefs_table = BASE_BANNER;
	unset($id);
	
	if(isset($_GET['id'])) $id = $_GET['id'];
	
	if($id)	{
		$sql = "select * from $banner_prefs_table where id=".$id."";
		$check = $wpdb->get_results($sql);
		
		foreach($check as $line){
			foreach($line as $key  => $value){
					if($key == "name")			{ $name = $value;	}
					if($key == "width")			{ $width = $value;	}
					if($key == "height")		{ $height = $value;	}
					if($key == "url")			{ $url = $value;	}
					if($key == "responsive")	{ $res = $value;	}
					if($key == "background")	{ $back = $value;	}
			}
		}
	}
	
	if($id) { echo '<form id="banner_form_set" name="banner_opt" method="POST" action="'.$_SERVER["PHP_SELF"].'?page=banner&amp;status=update&amp;id='.$id.'">'; }
	else    { echo '<form id="banner_form_set" name="banner_opt" method="POST" action="'.$_SERVER["PHP_SELF"].'?page=banner&amp;status=insert">'; }
?>
	<div id="settings-container">
		<h3>Genneral settings</h3>
		<div class="set_general">Banner name:<input type='text' name="banner_name" value="<?php echo $name; ?>"></div>
		<div class="set_general">Banner size:
			<label>Height<input id="set_height" name="banner_h" type='text' value="<?php echo $height; ?>"></label>
			<label>Width<input id="set_width" name="banner_w" type='text' value="<?php echo $width; ?>"></label>
		</div>
		<div class="set_general">Banner URL:<input type='text' name='banner_url' value="<?php echo $url; ?>"></div>
		<div class="set_general">Layout type:
			<label><input class="marginleft" type="radio" name="radio_res" value="no"> Fixed</label>
			<label><input type="radio" checked="" name="radio_res" value="yes"> Responsive</label>
		</div>
		
		<h3>Layers settings</h3>
		<div id="banner_working_board" style="background: url('<?php echo $back;?>') no-repeat;">
			<?php $banner_layers = get_list_settings_layers($id);?>
		</div>
		<input id="banner_upload" type="text" size="36" name="banner_upload" value="<?php echo $back;?>" style="display: none"/>	
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
	<?php } ?>
	</div>
	<div style="clear:both;"></div>
	<?php 
	if($id) {	echo "<input id='start_submit' class='blue_a_but' type='button' name='banner_opt_btn' value='Save' role=".$id.">";	}
	else 	{	echo "<input id='start_submit' class='blue_a_but' type='button' name='banner_opt_btn' value='Create' role=".$id.">";	}
	echo "<a class='blue_a_but' href='".$_SERVER["PHP_SELF"]."?page=banner'>back</a>";
}
?>
<?php
/*
Plugin Name: Banner Maker
Plugin URI: http://fruitfulcode.com
Description: Create banners with many different effects 
Author: Artemis
Author URI: http://Art.com
*/
global $wpdb;

// base prefix
define('BASE_BANNER', $wpdb->prefix . 'banner_maker');
define('BASE_SETTINGS', $wpdb->prefix . 'banner_settings');

//file folders
define('BANNER_DIR',__FILE__);
define('BANNER_INC','/inc');
define('BANNER_SCRIPTS','/scripts');

//include  files
require_once BANNER_INC.'/effect.php';
require_once BANNER_INC.'/function.php';
require_once BANNER_SCRIPTS.'/save-layers.php';
require_once 'init.php';

register_activation_hook(BANNER_DIR,'banner_install');
register_deactivation_hook(BANNER_DIR, 'banner_deactivation');
register_uninstall_hook(BANNER_DIR, 'banner_delete'); 

function banner_install () {
	/*register function*/
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php'); 
    global $wpdb;

    $banner_prefs_table = BASE_BANNER;
    
    if($wpdb->get_var("SHOW TABLES LIKE '$banner_prefs_table'") != $banner_prefs_table) {
        $sql = "CREATE TABLE `" . $banner_prefs_table . "` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(255) NOT NULL default '',
			`height` INT NOT NULL,
			`width` INT NOT NULL,
			`url` VARCHAR(255) NOT NULL default '',
			`responsive` VARCHAR(255) NOT NULL default '',
			`background` VARCHAR(255) NOT NULL default '',
            UNIQUE KEY id (id)
        )";
        
        dbDelta($sql); 
    }
	
	$banner_prefs_table = BASE_SETTINGS;
	
	if($wpdb->get_var("SHOW TABLES LIKE '$banner_prefs_table'") != $banner_prefs_table) {
        $sql = "CREATE TABLE `" . $banner_prefs_table . "` (
            `id` INT NOT NULL,
            `settings` LONGTEXT NOT NULL default '',
			 UNIQUE KEY id (id)
        )";
        
		dbDelta($sql); 
    }
}

function banner_deactivation () {
   /*unregister function*/
}

function banner_delete () {
    /*delete function*/
    global $wpdb;
	
    $banner_prefs_table = BASE_BANNER;
	
    if($wpdb->get_var("SHOW TABLES LIKE '$banner_prefs_table'") == $banner_prefs_table) {
      $sql = "DROP TABLE `" . $banner_prefs_table . "`";
      $wpdb->query($sql);
	}
	
	$banner_prefs_table = BASE_SETTINGS;
	
	if($wpdb->get_var("SHOW TABLES LIKE '$banner_prefs_table'") != $banner_prefs_table) {
      $sql = "DROP TABLE `" . $banner_prefs_table . "`";
      $wpdb->query($sql);
    }
	
}

/*Art - add pages*/
add_action('admin_menu', 'banner_add_pages');

function banner_add_pages() {
    add_menu_page('bannercreator', 'Banners', 8, 'banner', 'banner_page');
}


function banner_page() {
    echo "<h2>Banner Maker</h2>";
	
	$active = getBannerPage();
	
	$out = '<table>';
	$out .= '<tr><td class="grid_B_1">ID</td><td class="grid_B_2">Name</td><td class="grid_B_2">Shortcode</td><td class="grid_B_3">Action</td></tr>';
	$out .= get_my_banners();
	$out .= '</table>';
	
	$out .= "<a class='blue_a_but' href='".$_SERVER["PHP_SELF"]."?page=banner&status=create'>Add layer</a>";
	
	if($active == "show" or !$active or $active == "delete")	{	echo $out;	}

}

/*Art - get banners  */
function get_my_banners() {
	global $wpdb;
	
	$banner_prefs_table = BASE_BANNER;
	
	$sql = "select * from $banner_prefs_table";
	$check = $wpdb->get_results($sql);
   	
	foreach($check as $line){
		$out .= '<tr>';
		$id = '';
			foreach($line as $key  => $value){
					if($key == "id")		{ 	$out .= '<td class="grid_B_1">'.$value.'</td>';$id = $value;	}
					if($key == "name")		{ 	$out .= '<td class="grid_B_2">'.$value.'</td>';					}
			}
		$out .= '<td class="grid_B_2">[bannermaker id="'.$id.'"]</td>'; 	
		$out .= '<td class="grid_B_3"><a href="'.$_SERVER["PHP_SELF"].'?page=banner&status=edit&id='.$id.'" class="green_e_but">edit</a>';
		$out .= '<a href="'.$_SERVER["PHP_SELF"].'?page=banner&status=delete&id='.$id.'" class="red_d_but">delete</a></td>';
		$out .= '</tr>';
	}
	
	return $out;
} 

/* Art - shortcode */
function get_banner_out($atts) {

	extract(shortcode_atts(array(
		  'id' => ''
		  ),$atts));	
	
	global $wpdb;
	$banner_prefs_table = BASE_BANNER;
	$count = 0;
	unset($banner_macive);
	unset($settings_macive);
	unset($banner_out);
	unset($sql);
	unset($get_settings);
	
	$sql = "select * from $banner_prefs_table where id=".$id."";
	$get_settings = $wpdb->get_results($sql);
	
	if(!$get_settings) { 
		echo '<h1 style="color: red;">Please enter the correct id banner!!!</h1>';
	}
	if( $get_settings) {
		
		foreach($get_settings as $line){
			foreach($line as $key  => $value){
				$banner_macive[$key] = $value;
			}
		}
				
		$banner_out = '<div class="banner_maker_container" id="bannermaker-'.$banner_macive['id'].'"style="width: '.$banner_macive['width'].'px;
																			height: '.$banner_macive['height'].'px;
																			background: url('.$banner_macive['background'].') no-repeat;" >';
		$banner_out 	 .= '<a href="'.$banner_macive['url'].'" target="_blank">';
		$settings_macive = get_slide_settings($id);
		
		foreach ($settings_macive as $value_key) {
			if($value_key['img'])	{	$temp_body = '<img src="'.$value_key['img'].'"/>';	}
			else			{	$temp_body = $value_key['html'];	}
		
			$banner_out	 .= '<div class="banner_slide" id="slide-layer-'.$count.'" style="left: '.$value_key['y'].'; top: '.$value_key['x'].';">'.$temp_body.'</div>';	
			$count++;
		}
		
		$banner_out 	 .= '</a></div>';
		
	echo $banner_out;
	} 
}
add_shortcode('bannermaker','get_banner_out');
?>
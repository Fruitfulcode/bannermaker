<?php
/*
Plugin Name: Banner Maker
Plugin URI: http://bannermakerwp.com
Description: Create banners with many different effects 
Author: fruitfulcode
Author URI: http://fruitfulcode.com
*/
global $wpdb;

$currentFile = __FILE__;
$currentFolder = dirname($currentFile);

// base prefix
define('BASE_BANNER', $wpdb->prefix . 'banner_maker');
define('BASE_SETTINGS', $wpdb->prefix . 'banner_settings');

//file folders
define('BANNER_DIR',plugin_basename( __FILE__ ));
define('BANNER_INC',$currentFolder . '/inc');
define('BANNER_SCRIPTS',$currentFolder . '/scripts');

//include  files
require_once BANNER_INC.'/effect.php';
require_once BANNER_INC.'/function.php';
require_once BANNER_INC.'/shortcode.php';
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
			`background` VARCHAR(255) NOT NULL default '',
            UNIQUE KEY id (id)
        )CHARACTER SET=utf8";
        
        dbDelta($sql); 
    }
	
	$banner_prefs_table = BASE_SETTINGS;
	
	if($wpdb->get_var("SHOW TABLES LIKE '$banner_prefs_table'") != $banner_prefs_table) {
        $sql = "CREATE TABLE `" . $banner_prefs_table . "` (
            `id` INT NOT NULL,
            `settings` LONGTEXT NOT NULL default '',
			 UNIQUE KEY id (id)
        )CHARACTER SET=utf8";
        
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
	unset($sql);
	$banner_prefs_setting_table = BASE_SETTINGS;
	
	if($wpdb->get_var("SHOW TABLES LIKE '$banner_prefs_setting_table'") != $banner_prefs_setting_table) {
      $sql = "DROP TABLE `" . $banner_prefs_setting_table . "`";
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
?>
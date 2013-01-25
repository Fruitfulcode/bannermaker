<?php
require_once realpath(__DIR__.'/../../../..').'\wp-load.php';

global $wpdb;
$banner_prefs_table = $wpdb->prefix.'banner_settings';
unset($sql);

$get_json = htmlspecialchars($_POST["name"]);
$id = htmlspecialchars($_POST["id"]);
$json = str_replace('\&quot;','"',$get_json);

$sql = "select settings from $banner_prefs_table where id=".$id."";
$status = $wpdb->get_results($sql);
unset($sql);

	if($status) {
		$sql = "UPDATE $banner_prefs_table 
				SET id='$id',settings='$json'
				WHERE id=$id";
		$wpdb->query($sql);
	}
	else {
		$sql = "INSERT INTO wp_banner_settings (id,settings) VALUES('$id','$json')";
		$wpdb->query($sql);
	}
	
?>
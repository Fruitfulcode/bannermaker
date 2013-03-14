<?php
function banner_admin_style() {
		wp_register_style( 'admin_banner_slyle', plugins_url('/css/admin.css', __FILE__));
	
		wp_enqueue_style( 'admin_banner_slyle');
		
		wp_enqueue_style('thickbox');
}
/*add_action('admin_init', 'banner_admin_style');*/

function banner_admin_scripts() {
		wp_deregister_script	("jquery-banner");
		wp_register_script		("jquery-banner", "http://code.jquery.com/jquery-1.8.2.min.js", false, "1.8.2", true);
		wp_enqueue_script		("jquery-banner");
		
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
		wp_enqueue_script('banner-config',plugins_url('/js/config.js', __FILE__),array('jquery-banner'), '20131801', false );
		wp_enqueue_script('ui-core',      plugins_url('/js/ui/jquery.ui.core.js', __FILE__),array('jquery-banner'), '20131801', false );
		wp_enqueue_script('ui-widget',    plugins_url('/js/ui/jquery.ui.widget.js', __FILE__),array('jquery-banner'), '20131801', false );
		wp_enqueue_script('ui-mouse',     plugins_url('/js/ui/jquery.ui.mouse.js', __FILE__),array('jquery-banner'), '20131801', false );
		wp_enqueue_script('ui-sortable',  plugins_url('/js/ui/jquery.ui.sortable.js', __FILE__),array('jquery-banner'), '20131801', false );
		wp_enqueue_script('ui-draggable', plugins_url('/js/ui/jquery.ui.draggable.js', __FILE__),array('jquery-banner'), '20131801', false );
		wp_enqueue_script('validate',  	  plugins_url('/js/validate.js', __FILE__),array('jquery-banner'), '20131801', false );
		wp_enqueue_script('xml',  	      plugins_url('/js/xml.js', __FILE__),array('jquery-banner'), '20131801', false );
		
		/* for preview */
		wp_enqueue_script('easing',  plugins_url('/js/easing.js', __FILE__),array('jquery-banner'), '20131801', false );
		wp_enqueue_script('no-conflict',  plugins_url('/js/noconflict.js', __FILE__),array('jquery-banner'), '20131801', false );
		wp_register_style( 'banner_slyle', plugins_url('/css/style.css', __FILE__));
		wp_enqueue_style( 'banner_slyle');
		
		wp_register_style( 'banner_custom_slyle', plugins_url('/inc/style/custom.css', __FILE__));
		wp_enqueue_style( 'banner_custom_slyle');
}

add_action( 'admin_enqueue_scripts', 'add_banner_admin_options_and_styles' );

function add_banner_admin_options_and_styles($hook) {
	if( 'toplevel_page_banner' != $hook ) return;
	banner_admin_scripts() ;
	banner_admin_style() ;
} 

function banner_init() {
	
	wp_deregister_script	("jquery-banner-show");
	wp_register_script		("jquery-banner-show", "http://code.jquery.com/jquery-1.8.2.min.js", false, "1.8.2", true);
	wp_enqueue_script		("jquery-banner-show");
	
	wp_enqueue_script('easing',  plugins_url('/js/easing.js', __FILE__),array('jquery-banner-show'), '20131801', false );
	wp_enqueue_script('no-conflict',  plugins_url('/js/noconflict.js', __FILE__),array('jquery-banner-show'), '20131801', false );
	
	wp_register_style( 'banner_slyle', plugins_url('/css/style.css', __FILE__));
	wp_enqueue_style( 'banner_slyle');
	
	wp_register_style( 'banner_custom_slyle', plugins_url('/inc/style/custom.css', __FILE__));
	wp_enqueue_style( 'banner_custom_slyle');
	
}
add_action('wp_enqueue_scripts', 'banner_init');
?>
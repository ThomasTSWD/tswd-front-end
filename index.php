<?php
/*
Plugin Name: tswd-front-End
Plugin URI: https://tswd.fr/
Description: Own Cascading Style Sheet, JavaScript & Some WP improvements
Author: Thomas Serment
Version: 2.1
Author URI: https://tswd.fr/
*/

include(plugin_dir_path( __FILE__ ) . 'functions.php');
include(plugin_dir_path( __FILE__ ) . '/core/wpload.php');
include(plugin_dir_path( __FILE__ ) . '/core/improvements.php'); 
include(plugin_dir_path( __FILE__ ) . '/core/labels.php'); 
include(plugin_dir_path( __FILE__ ) . '/core/admin-notes.php'); 
include(plugin_dir_path( __FILE__ ) . '/core/monokai.php');
include(plugin_dir_path( __FILE__ ) . '/core/shortcodes.php'); 
include(plugin_dir_path( __FILE__ ) . '/core/svg.php');
include(plugin_dir_path( __FILE__ ) . '/core/save_with_keyboard.php');




//    _______ ______ ______ _______ ______ _______ _______ 

function loadTswdJs() {   
	//wp_enqueue_script( 'ScrollMagic', plugin_dir_url( __FILE__ ) . '/js-lib/ScrollMagic/ScrollMagic.min.js', '',  '', true );
	//wp_enqueue_script( 'TweenMax', plugin_dir_url( __FILE__ ) . '/js-lib/ScrollMagic/TweenMax.min.js', '',  '', true );
	//wp_enqueue_script( 'animation.gsap', plugin_dir_url( __FILE__ ) . '/js-lib/ScrollMagic/animation.gsap.min.js', '',  '', true );
	//wp_enqueue_script( 'debug.addIndicators', plugin_dir_url( __FILE__ ) . '/js-lib/ScrollMagic/debug.addIndicators.min.js', '',  '', true );
	//wp_enqueue_script( 'slick', plugin_dir_url( __FILE__ ) . '/js-lib/slick/slick.js', '',  '', true );
	//wp_enqueue_script( 'parallaxjs', plugin_dir_url( __FILE__ ) . '/js-lib/parallax.min.js', '',  '', true );
	//wp_enqueue_script( 'gsap', plugin_dir_url( __FILE__ ) . '/js-lib/gsap/gsap-core.js', '',  '', true );
	//wp_enqueue_script( 'gsap-scroll-trigger', plugin_dir_url( __FILE__ ) . '/js-lib/gsap/ScrollTrigger.js', '',  '', true );
	//wp_enqueue_script( 'Lenis', plugin_dir_url( __FILE__ ) . '/js-lib/lenis.js', '',  '', true );
	//wp_enqueue_script( 'Ukiyo', plugin_dir_url( __FILE__ ) . '/js-lib/ukiyo.min.js', '',  '', true );
	// wp_enqueue_script( 'splitting', plugin_dir_url( __FILE__ ) . '/js-lib/splitting/splitting.js', '',  '', true );
	wp_enqueue_script( 'tswd-front-js', plugin_dir_url( __FILE__ ) . '/tswd-front-js.js', '',  '', true );
}


//    _______ ______ ______ _______ ______ _______ _______ 


function loadTswdFonts(){
    wp_register_style('tswd-fonts', plugins_url('font-lib/-tswd-fonts.css', __FILE__));
    wp_enqueue_style('tswd-fonts');
}


//    _______ ______ ______ _______ ______ _______ _______ 

function loadTswdStyle() {
	//wp_register_style('slick-css', plugins_url('/js-lib/slick/slick.css', __FILE__));
	//wp_enqueue_style('slick-css');
	//wp_register_style('slick-theme-css', plugins_url('/js-lib/slick/slick-theme.css', __FILE__));
	//wp_enqueue_style('slick-theme-css');
	//wp_register_style('splitting-css', plugins_url('/js-lib/splitting/splitting.css', __FILE__));
	//wp_enqueue_style('splitting-css');
	//wp_register_style('splitting-cells-css', plugins_url('/js-lib/splitting/splitting-cells.css', __FILE__));
	//wp_enqueue_style('splitting-cells-css');
	wp_register_style('tswd-front-css', plugins_url('tswd-front-css.css', __FILE__));
	wp_enqueue_style('tswd-front-css');
	
}



if(!is_admin() || empty($_GET['et_fb'])){
	add_action('wp_print_styles', 'loadTswdFonts');
	add_action( 'wp_print_styles', 'loadTswdStyle' );
	add_action('wp_enqueue_scripts', 'loadTswdJs');

}


//    _______ ______ ______ _______ ______ _______ _______ 

function admin_scripts() {
	wp_enqueue_script( 'ico-admin-js', plugins_url( '/tswd-front-end/core/dist/stylizer.js' , dirname(__FILE__) ) );
}
add_action('admin_enqueue_scripts', 'admin_scripts');

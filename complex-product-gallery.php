<?php
/**
 * Plugin Name: Complex gallery plugin
 * Description: Adds a custom Elementor widget.
 * Version: 1.0
 * Author: Themelocation
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Enqueue custom styles.
add_action('elementor/frontend/after_enqueue_styles', function () {
    wp_enqueue_style(
        'custom-css',
        plugin_dir_url(__FILE__) . 'css/custom-css.css',
        [],
        '1.0'
    );
    // Magnific Popup styles and scripts.
    wp_enqueue_style(
        'magnific-popup',
        'https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css',
        [],
        '1.1.0'
    );
    wp_enqueue_script(
        'magnific-popup',
        'https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js',
        ['jquery'],
        '1.1.0',
        true
    );    
    
    // slick slider
    wp_enqueue_style(
        'flex-slider',
        plugin_dir_url(__FILE__) . 'css/flexslider.css',
        [],
        '1.1.0'
    );
    wp_enqueue_script(
        'flex-slider',
        plugin_dir_url(__FILE__) . 'js/jquery.flexslider.js',
        ['jquery'],
        '1.1.0',
        true
    );    
    
    // owl carousel
    wp_enqueue_style(
        'owl-slider',
        plugin_dir_url(__FILE__) . 'css/owl.carousel.min.css',
        [],
        '1.1.0'
    );
    wp_enqueue_script(
        'owl-slider',
        plugin_dir_url(__FILE__) . 'js/owl.carousel.min.js',
        ['jquery'],
        '1.1.0',
        true
    );
    wp_enqueue_script(
        'custom-js',
        plugin_dir_url(__FILE__) . 'js/custom-js.js',
        ['jquery'],
        '1.1.0',
        true
    );
});


function register_hello_world_widget( $widgets_manager ) {

    require_once( __DIR__ . '/widget/class-my-elementor-widget.php' );

	$widgets_manager->register( new \My_Elementor_Widget() );

}
add_action( 'elementor/widgets/register', 'register_hello_world_widget' );

add_filter('wp_img_tag_add_decoding_attr', '__return_false');
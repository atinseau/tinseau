<?php
/**
 ** activation theme
 **/
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}

function dd ($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    die;
}

function catalog_shortcode() {
    wp_enqueue_script('catalog', get_theme_file_uri() . '/src/dist/app.js', [], '1.0.0', true);
    return '<div id="catalog"></div>';
}
add_shortcode('catalog', 'catalog_shortcode');

require_once 'Includes/dynamic_attribute.php';
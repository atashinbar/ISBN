<?php
// Translate
load_theme_textdomain('isbn', get_template_directory().'/languages');


// Enqueue style.css
function theme_name_scripts()
{
    wp_enqueue_style( 'style-name', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );
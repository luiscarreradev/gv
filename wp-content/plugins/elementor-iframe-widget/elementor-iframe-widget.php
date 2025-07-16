<?php
/**
 * Plugin Name: Elementor Iframe Responsive Widget
 * Description: Widget personalizado para insertar un iframe con controles responsivos (ancho y alto) en Elementor.
 * Version: 1.0.0
 * Author: Luis Carrera
 * Text Domain: elementor-iframe-widget
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Evita el acceso directo.
}

// Cargar el widget personalizado.
function register_elementor_iframe_widget( $widgets_manager ) {
	require_once( __DIR__ . '/widgets/iframe-widget.php' );
	$widgets_manager->register( new \Elementor_Iframe_Widget() );
}
add_action( 'elementor/widgets/register', 'register_elementor_iframe_widget' );

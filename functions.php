<?php
/**
 * Functions and definitions for Frankfurt Child.
 *
 * @package    WordPress
 * @subpackage Frankfurt_Child
 * @version    1.0.2
 * @author     marketpress.com
 */

add_action( 'after_setup_theme', 'frankfurt_child_setup' );
/**
 * Sets up theme defaults and registers support for various WordPress features
 * of Frankfurt Child Theme.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support for post thumbnails.
 *
 * @since   05/07/2015
 * @return  void
 */
function frankfurt_child_setup() {

	/* The .min suffix for stylesheets and scripts.
	 *
	 * In order to provide a quick start, this child theme by default will load
	 * regular CSS and javascript files (whereas its parent theme loads
	 * minified versions of its stylesheets and scripts by default).
	 *
	 * If you want your child theme to default on minified stylesheets and scripts,
	 * set the following filter:
	 *
	 * if( function_exists( 'frankfurt_get_script_suffix' ) ) {
	 *     add_filter( 'frankfurt_child_starter_get_script_suffix', 'frankfurt_get_script_suffix' );
	 * }
	 *
	 * Don’t forget to actually add applicable .min files to your child theme first!
	 *
	 * You can then temporarily switch back to unminified versions of the same
	 * files by setting the constant SCRIPT_DEBUG to TRUE in your wp-config.php:
	 * define( 'SCRIPT_DEBUG', TRUE );
	 */

	// Loads the child theme's translated strings
	load_child_theme_textdomain(
		'frankfurt-child-starter',
		get_stylesheet_directory() . '/languages'
	);

	if ( ! is_admin() ) {

		// child theme styles
		add_filter( 'frankfurt_get_styles', 'frankfurt_child_filter_frankfurt_get_styles_add_stylesheets' );

		// modify or remove social links
		// add_filter( 'frankfurt_get_social_share_links', 'frankfurt_child_get_social_share_links', 10, 2 );

	}
}

/**
 * Adding our own styles for our child theme
 *
 * @wp-hook frankfurt_get_styles
 *
 * @param   array $styles
 *
 * @return  array $styles
 */
function frankfurt_child_filter_frankfurt_get_styles_add_stylesheets( array $styles = array() ) {

	// add suffix
	$suffix = apply_filters( 'frankfurt_child_starter_get_script_suffix', '' );

	// getting the theme-data
	$theme_data = wp_get_theme();

	// adding our own styles to
	$styles[ 'frankfurt_child' ] = array(
		'src'     => get_stylesheet_directory_uri() . '/style' . $suffix . '.css',
		'deps'    => NULL,
		'version' => $theme_data->Version,
		'media'   => NULL
	);

	return $styles;

}

/**
 * Modify or remove social links output.
 *
 * @wp-hook frankfurt_get_social_share_links
 *
 * @param   string $markup
 * @param   array  $args
 *
 * @return  void|string
 */
function frankfurt_child_get_social_share_links( $markup, $args ) {

	// Page slugs to be excluded. Enter your own!
	$exclusions = array(
		'legal-information',
		'revocation-policy',
		'terms-conditions',
		'payment-methods',
		'privacy',
	);

	// Loop through exclusions.
	foreach ( $exclusions as $exclusion ) {

		// If this page is to be excluded, return nothing.
		if ( is_page( $exclusion ) ) {
			return;
		}
	}

	// Else: return markup string.
	return $markup;
}

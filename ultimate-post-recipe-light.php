<?php

/**
 *
 * @link              http://codecanyon.net/user/dedalx/
 * @since             1.0
 * @package           Ultimate_Post_Recipe Light
 *
 * @wordpress-plugin
 * Plugin Name:       Ultimate Post Recipe Light
 * Plugin URI:        #
 * Description:       Display detailed post recipes with cooking instructions.
 * Version:           1.0
 * Author:            MagniumThemes
 * Author URI:        https://magniumthemes.com/
 * License:           GPL
 * License URI:       -
 * Text Domain:       ultimate-post-recipe
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'ULTIMATE_POST_RECIPE_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ultimate-post-recipe-activator.php
 */
function ultimate_post_recipe_activate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ultimate-post-recipe-activator.php';
	Ultimate_Post_Recipe_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ultimate-post-recipe-deactivator.php
 */
function ultimate_post_recipe_deactivate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ultimate-post-recipe-deactivator.php';
	Ultimate_Post_Recipe_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'ultimate_post_recipe_activate' );
register_deactivation_hook( __FILE__, 'ultimate_post_recipe_deactivate' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ultimate-post-recipe.php';

/**
 * Display post recipe rating block, to use in themes
 */
function ultimate_post_recipe_display_post_recipe_block() {
    do_shortcode('[post_recipe_block]');
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function ultimate_post_recipe_run() {

	$plugin = new Ultimate_Post_Recipe();
	$plugin->run();

}
ultimate_post_recipe_run();

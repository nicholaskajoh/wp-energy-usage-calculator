<?php

/**
 * WP Energy Usage Calculator bootstrap file
 *
 * @link              http://github.com/nicholaskajoh/wp-energy-usage-calculator
 * @since             0.1.0
 * @package           WP Energy Usage Calculator
 *
 * @wordpress-plugin
 * Plugin Name:       WP Energy Usage Calculator
 * Plugin URI:        http://github.com/nicholaskajoh/wp-energy-usage-calculator
 * Description:       A flexible plugin for calculating electricity usage/consumption.
 * Version:           0.1.1
 * Author:            Nicholas Kajoh
 * Author URI:        http://nicholask.me
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       WP Energy Usage Calculator
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) die;

// includes
require plugin_dir_path( __FILE__ ) . "class-wpeuc.php";
require plugin_dir_path( __FILE__ ) . "public/class-wpeuc-public.php";
require plugin_dir_path( __FILE__ ) . "admin/class-wpeuc-admin.php";

// activation hook
register_activation_hook(__FILE__, array(new WPEUC, 'activate'));

// deactivation hook
register_deactivation_hook(__FILE__, array(new WPEUC, 'deactivate'));

// uninstall hook
register_uninstall_hook(__FILE__, array(new WPEUC, 'uninstall'));

// add action links
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array(new WPEUC, 'add_action_links'));

// public view
add_action('wp_enqueue_scripts', array(new WPEUC, 'enqueue_general_static'));
add_action('wp_enqueue_scripts', array(new WPEUC_Public, 'enqueue_public_static'));
add_action('init', array(new WPEUC_Public, 'get_public_view'));

// admin view
if(is_admin()) {
  add_action('admin_enqueue_scripts', array(new WPEUC, 'enqueue_general_static'));
  add_action('admin_enqueue_scripts', array(new WPEUC_Admin, 'enqueue_admin_static'));
  add_action( 'admin_menu', array(new WPEUC_Admin, 'get_admin_view'));
  add_action('admin_init', array(new WPEUC_Admin, 'register_and_build_admin_settings'));
}

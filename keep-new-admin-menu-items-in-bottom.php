<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://plit.com.br
 * @since             1.1.0
 * @package           Keep_New_Admin_Menu_Items_In_Bottom
 *
 * @wordpress-plugin
 * Plugin Name:       Keep new admin menu items in bottom
 * Plugin URI:        https://github.com/antonio24073/keep-new-admin-menu-items-in-bottom
 * Description:       Keep new admin menu items in bottom
 * Version:           1.1.0
 * Author:            Plit
 * Author URI:        https://plit.com.br
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       keep-new-admin-menu-items-in-bottom
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('KEEP_NEW_ADMIN_MENU_ITEMS_IN_BOTTOM_VERSION', '1.1.0');



function keep_new_admin_menu_items_in_bottom($menu_ord)
{

    if (!$menu_ord)
        return true;

    if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {

        $woocommerce = array(
            'woocommerce',
            // Woocommerce
            'edit.php?post_type=product',
            // Products
            'wc-admin&path=/analytics/overview',
            // Analytics
            'woocommerce-marketing',
            // Marketing
            'separator-knamiib-woo'
        );
        $menu_ord = \array_diff($menu_ord, $woocommerce);
        array_unshift($menu_ord, ...$woocommerce);
    }

    $default = array(
        'index.php',
        // Dashboard
        'separator1',
        // First separator
        'edit.php',
        // Posts
        'upload.php',
        // Media
        'link-manager.php',
        // Links
        'edit-comments.php',
        // Comments
        'edit.php?post_type=page',
        // Pages
        'separator2',
        // Second separator
        'themes.php',
        // Appearance
        'plugins.php',
        // Plugins
        'users.php',
        // Users
        'tools.php',
        // Tools
        'options-general.php',
        // Settings
        'separator-last', // Last separator
    );
    $menu_ord = \array_diff($menu_ord, $default);
    array_unshift($menu_ord, ...$default);


    return $menu_ord;
}
add_filter('custom_menu_order', 'keep_new_admin_menu_items_in_bottom', 10, 1);
add_filter('menu_order', 'keep_new_admin_menu_items_in_bottom', 10, 1);


if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    add_action('admin_menu', 'keep_new_admin_menu_items_in_bottom_set_admin_menu_separator');
    function keep_new_admin_menu_items_in_bottom_set_admin_menu_separator()
    {
        $position = 9485;
        global $menu;
        $menu[$position] = array(
            0 => '',
            1 => 'read',
            2 => 'separator-knamiib-woo',
            3 => '',
            4 => 'wp-menu-separator'
        );
    }
}
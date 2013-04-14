<?php

/*
  Plugin Name: Partner Slider (PS)
  Plugin URI: Coming soon...
  Description: a plugin to manage and display a list of partners
  Version: 1.0
  Author: Pierre Guillemot
  Author URI: Coming soon...
  License: GPL2
 */

/**
 * Directory path of the plugin
 */
define('PS_DIR', plugin_dir_path(__FILE__));

/**
 * Directory url of the plugin
 */
define('PS_URL', plugin_dir_url(__FILE__));

/**
 * Activation of the plugin
 */
register_activation_hook(__FILE__, 'ps_activation');

/**
 * Deactivation of the plugin
 */
register_deactivation_hook(__FILE__, 'ps_deactivation');

/**
 * Name of the table which holds the partners
 */
define('PARTNER_TABLE', "ps_partners");

/**
 * Name of the table which holds the lists
 */
define('LIST_TABLE', "ps_lists");

/**
 * Name of the table that holds the n to n relation between the partners and the lists 
 */
define('PARTNER_LIST_TABLE', "ps_partners_lists");

/**
 * Database version of the plugin 
 */
global $ps_db_version;
$ps_db_version = "1.0";

/**
 * Function launched at the plugin activation
 * Will create the tables in the database
 */
function ps_activation() {    
    global $wpdb;
    
    global $ps_db_version;
    
    $sql = "CREATE TABLE ".$wpdb->prefix.PARTNER_TABLE." (
        id integer not null auto_increment,
        name text not null,
        description text,
        url text not null,
        icon text not null,
        primary key(id)
    );";
    
    $sql .= "CREATE TABLE ".$wpdb->prefix.LIST_TABLE."(
        id integer not null auto_increment,
        name text not null,
        page_id integer,
        primary key(id)
    );";

    $sql .= "CREATE TABLE ".$wpdb->prefix.PARTNER_LIST_TABLE."(
        id_list integer not null,
        id_partner integer not null,
        primary key(id_list, id_partner)
    );";
    
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta($sql);
    
    add_option("ps_db_version", $ps_db_version );
    
    //Default thumbnail size
    add_option("ps_thumb_width", 100);
    add_option("ps_thumb_height", 100);   
}

/**
 * Function launched at the plugin deactivation
 * Will drop the tables in the database
 */
function ps_deactivation() {
    global $wpdb;
    
    $sql = "drop table if exists ".$wpdb->prefix.PARTNER_TABLE.";";
    $wpdb->query($sql);      

    $sql = "drop table if exists ".$wpdb->prefix.LIST_TABLE.";";
    $wpdb->query($sql);   
    
    $sql = "drop table if exists ".$wpdb->prefix.PARTNER_LIST_TABLE.";";
    $wpdb->query($sql);  
    
    delete_option("ps_db_version");
    
    delete_option("ps_widget_title");
    
    delete_option("ps_thumb_width");
    delete_option("ps_thumb_height");
}

/**
* Include the admin about page
*/
function ps_admin_about(){
        include(PS_DIR.'admin/about_controller.php');
}

/**
* Include the admin manage list page
*/
function ps_admin_manage_list(){
        include(PS_DIR.'admin/manage-list_controller.php');
}

/**
* Include the admin manage partner page
*/
function ps_admin_manage_partner(){
        include(PS_DIR.'admin/manage-partner_controller.php');
}

/**
* Include the admin overview partners page
*/
function ps_admin_overview_partners(){
         include(PS_DIR.'admin/overview-partners_controller.php');
}

/**
* Include the admin overview list page
*/
function ps_admin_overview_lists(){
         include(PS_DIR.'admin/overview-lists_controller.php');
}

/**
* Add administration pages
*/
function ps_admin_actions() {  
        add_menu_page( "Partner Slider", "Partner Slider", "add_users", "admin/about_controller.php", "ps_admin_about", null, 82);
        add_submenu_page( "admin/about_controller.php", "Partners", "Partners", "add_users", "admin/overview-partners_controller.php", "ps_admin_overview_partners" );
        add_submenu_page( "admin/about_controller.php", "Lists", "Lists", "add_users", "admin/overview-lists_controller.php", "ps_admin_overview_lists" );
        add_submenu_page( null, "Add a list", "Add a list", "add_users", "admin/manage-list_controller.php", "ps_admin_manage_list" );		
        add_submenu_page( null, "Add a partner", "Add a partner", "add_users", "admin/manage-partner_controller.php", "ps_admin_manage_partner" );	
}
add_action('admin_menu', 'ps_admin_actions');

function ps_add_scripts(){
    echo "<link rel=\"stylesheet\" href=\"".PS_URL."assets/css/partner_slider_front_end.css\" type=\"text/css\" media=\"screen\" />\n";
    //echo "<script src=\"http://code.jquery.com/jquery-latest.min.js\" type=\"text/javascript\"></script>\n";
    echo "<script src=\"".PS_URL."assets/js/jquery.tinycarousel.min.js\" type=\"text/javascript\"></script>\n";
    echo "<script src=\"".PS_URL."assets/js/partner_slider_front_end.js\" type=\"text/javascript\"></script>\n";
}

add_action('wp_head', 'ps_add_scripts');

/**
 * Include the utility functions
 */
include_once(PS_DIR.'includes/functions.php');

/**
 * Include the widget
 */
include_once(PS_DIR.'widget/ps_widget.php');



?>
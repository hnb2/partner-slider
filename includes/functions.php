<?php

//Try to find the wp-laod.php file
if ( !defined('WP_LOAD_PATH') ) {
    // classic root path if wp-content and plugins is below wp-config.php 
    $classic_root = dirname(dirname(dirname(dirname(__FILE__)))) . '/' ;

    if (file_exists( $classic_root . 'wp-load.php') )
        define( 'WP_LOAD_PATH', $classic_root);
    else
        exit("Could not find wp-load.php");
}

// Loading WP-load.php
require_once( WP_LOAD_PATH . 'wp-load.php');


/** DATABASE FUNCTIONS **/

/**
 * Return all the partners of the table
 * @return array of objects
 */
function ps_getAllPartners() {
    global $wpdb;

    $partners = $wpdb->get_results('select * from ' . $wpdb->prefix . PARTNER_TABLE.' order by name ASC');

    return $partners;
}

/**
 * Return a partner by its ID or null if not found
 * @param integer $id id of the list
 */
function ps_getPartnerById($id) {
    global $wpdb;

    $partner = $wpdb->get_row($wpdb->prepare('select * from ' . $wpdb->prefix . PARTNER_TABLE . ' where id=%d', intval($id)));

    return $partner;
}

/**
 * Return all the lists of the table
 * @return array of objects
 */
function ps_getAllLists() {
    global $wpdb;

    $lists = $wpdb->get_results('select * from ' . $wpdb->prefix . LIST_TABLE . ' order by id ASC');

    return $lists;
}

/**
 * Return a list by its ID or null if not found
 * @param integer $id id of the list
 */
function ps_getListById($id) {
    global $wpdb;

    $list = $wpdb->get_row($wpdb->prepare('select * from ' . $wpdb->prefix . LIST_TABLE . ' where id=%d', intval($id)));

    return $list;
}

/**
 * Return a list by its page ID or null if not found
 * @param integer $id id of the page
 */
function ps_getListByPageId($page_id) {
    global $wpdb;

    $list = $wpdb->get_row($wpdb->prepare('select * from ' . $wpdb->prefix . LIST_TABLE . ' where page_id=%d', intval($page_id)));

    return $list;
}

/**
 * Return the title of a page by its ID
 * @param integer $page_id ID of a page
 * @return string title of the page 
 */
function ps_getPageTitleById($page_id) {
    global $wpdb;

    $page = $wpdb->get_row($wpdb->prepare('select * from ' . $wpdb->prefix . 'posts where id=%d', intval($page_id)));

    return $page->post_name;
}

/**
 * Add a list 
 * @param string $name name of the list
 * @param integer $page_id id of the page (optionnal)
 * @return false if failed to add the row or integer ID if success 
 */
function ps_addList($name, $page_id = 0) {

    $page_id = intval($page_id);

    $data = array(
        'name' => $name,
        'page_id' => $page_id
    );

    $format = array(
        '%s',
        '%d'
    );

    global $wpdb;

    $result = $wpdb->insert($wpdb->prefix . LIST_TABLE, $data, $format);

    return $result==true?$wpdb->insert_id:false;
}

/**
 * Update a list
 * @param integer $list_id Id of the list to update
 * @param string $name new name of the list
 * @param integer $page_id (optionnal) new page id of the list
 * @return boolean false if the list was not found or could not be updated or true if successful
 */
function ps_updateList($list_id, $name, $page_id = 0){
    
    $page_id = intval($page_id);
    
    $data = array(
        'name' => $name,
        'page_id' => $page_id
    );
    
    $format = array(
        '%s',
        '%d'
    );
    
    global $wpdb;
    
    $result = $wpdb->update($wpdb->prefix . LIST_TABLE, $data, array( 'id' => $list_id ), $format, array( '%d' ));
    
    return $result==1?true:false;
}

/**
 * Add a partner
 * @param string $name name of the partner
 * @param string $description description of the partner
 * @param string $url url of the website of the partner
 * @param string $icon name of the icon (with extension) of the partner
 * @return false if failed to add the row or integer ID if success 
 */
function ps_addPartner($name, $description, $url, $icon){
    
    $data = array(
        'name' => $name,
        'description' => $description,
        'url' => $url,
        'icon' => $icon
    );

    $format = array(
        '%s',
        '%s',
        '%s',
        '%s'
    );

    global $wpdb;

    $result = $wpdb->insert($wpdb->prefix . PARTNER_TABLE, $data, $format);

    return $result==true?$wpdb->insert_id:false;
}

/**
 * Update a partner
 * @param integer $partner_id ID of the partner to update
 * @param string $name name of the partner
 * @param string $description description of the partner
 * @param string $url url of the website of the partner
 * @param string $icon name of the icon (with extension) of the partner
 * @return boolean false if the partner was not found or could not be updated or true if successful
 */
function ps_updatePartner($partner_id, $name, $description, $url, $icon){
    
    $partner_id = intval($partner_id);
    
    $data = array(
        'name' => $name,
        'description' => $description,
        'url' => $url,
        'icon' => $icon
    );

    $format = array(
        '%s',
        '%s',
        '%s',
        '%s'
    );
    
    global $wpdb;
    
    $result = $wpdb->update($wpdb->prefix . PARTNER_TABLE, $data, array( 'id' => $partner_id ), $format, array( '%d' ));
    
    return $result==1?true:false;
}

/**
 * Retrieve a list of partners ID which belong to a list
 * @param integer $list_id ID of the list
 * @return array an array of partner's ID
 */
function ps_getPartnersIdsByListId($list_id){
    global $wpdb;
    
    $result = $wpdb->get_results($wpdb->prepare('select id_partner from '.$wpdb->prefix . PARTNER_LIST_TABLE.' where id_list= %d', $list_id));
    
    $partners_ids = array();
    
    foreach($result as $res)
        $partners_ids[] = intval($res->id_partner);
    
    return $partners_ids;
}

/**
 * Return a list of partners which belong to a list
 * @param integer $list_id ID of the list 
 * @return array array of partners object
 */
function ps_getPartnersByListId($list_id){
    global $wpdb;
    
    $partners = $wpdb->get_results($wpdb->prepare('select wp.* 
            from wp_ps_partners_lists wpl, wp_ps_partners wp
            where wpl.id_list = %d
            and wpl.id_partner = wp.id;', $list_id));
    
    return $partners;
}

/**
 * Set a list of partners to a list
 * @param integer $list_id ID of the list
 * @param array $partners array of partners id
 */
function ps_updatePartnerList($list_id, $partners){
    
    global $wpdb;
    
    //Delete all the partners of the list
    $wpdb->query($wpdb->prepare('delete from '.$wpdb->prefix . PARTNER_LIST_TABLE.' where id_list= %d', $list_id));
    
    //Add the new ones
    foreach($partners as $partner){
        $wpdb->insert($wpdb->prefix.PARTNER_LIST_TABLE, array('id_list' => $list_id, 'id_partner' => $partner), array( '%d', '%d' ));
    }
}

/** END OF DATABASE FUNCTIONS **/


/** UTILITY FUNCTIONS **/

/**
 * Check if an array contains a value
 * @param integer $value the value to look for
 * @param array $array the array to look into
 * @return boolean true if contained
 */
function ps_contains($value, $array){
    if(!is_array($array))
        return false;

    foreach($array as $item){
        if(intval($item) == intval($value)){
            return true;
        }
    }
    
    return false;
}

/**
* Function that return the ID of the parent page if any.
* Do not call directly, use the wrapper ps_get_page_id()
* @return integer Id of the parent page
*/
function ps_get_top_parent_page_id() {

    global $post;

    // Check if page is a child page (any level)
    if ($post->ancestors) {
        //  Grab the ID of top-level page from the tree
        return end($post->ancestors);
    } else {
        // Page is the top level, so use  it's own id
        return $post->ID;
    }
}

/**
 * Return the ID of the parent page or 0 if it is the home page
 * @return integer 0 if home page, else parent page
 */
function ps_get_page_id(){
    $page_id = get_queried_object_id();
    if($page_id != 0)
        $page_id = ps_get_top_parent_page_id ();
    
    return $page_id;
}

/** END OF UTILITY FUNCTIONS **/

?>
<?php

//Register the widget
wp_register_sidebar_widget(
        'ps_widget', // your unique widget id
        'Partner slider', // widget name
        'ps_widget_display', // callback function to display widget
        array(// options
            'description' => 'Will display your lists of partners'
        )
);

//Register the widget control
wp_register_widget_control(
        'ps_widget', // id
        'ps_widget', // name
        'ps_widget_control' // callback function
);

/**
 * Widget form in the admin panel
 * @param array $args
 * @param array $params
 */
function ps_widget_control($args = array(), $params = array()) {
    if (isset($_POST['submitted']))
        update_option('ps_widget_title', $_POST['ps_widget_title']);
    
    //load options
    $widget_title = get_option('ps_widget_title');
    
    ?>
    Widget Title:<br />
    <input type="text" class="widefat" name="ps_widget_title" value="<?php echo stripslashes($widget_title); ?>" />
    <br /><br />
    
    <p>This is the Partner Slider widget. It will automatically select the lists to display based on your settings.</p>
    
    <input type="hidden" name="submitted" value="1" />
    
    <?php
}

/**
 * Widget display in the front end
 * @param array $args
 * @param array $params
 */
function ps_widget_display($args = array(), $params = array()) {
    //Get the current page ID and its parent ID if any
    $current_page_id = ps_get_page_id();
    
    //Search if there is a list for this page
    $list = ps_getListByPageId($current_page_id);
    
    //If not, check for a default list
    if($list == null)
        $list = ps_getListByPageId(0);
    
    //If there is a list (default or not)
    if($list != null){
    
        //Get the partners
        $partners = ps_getPartnersByListId($list->id);

        //Begin to display the widget
        echo stripslashes($args['before_widget']);

        //load options
        $widget_title = get_option('ps_widget_title');
        $thumb_width = get_option('ps_thumb_width');
        $thumb_height = get_option('ps_thumb_height');
        
        //Display title
        if(!empty($widget_title)){
            echo stripslashes($args['before_title']);
            echo stripslashes($widget_title);
            echo stripslashes($args['after_title']);
        }
        
        //Display the partners
        echo '<div id="slider-code">';
        echo '<a class="buttons prev" href="#">left</a>';
        echo '<div class="viewport">';
        echo '<ul class="overview">';
        
        //width="'.$thumb_width.'" height="'.$thumb_height.'"
        foreach($partners as $partner){
            echo '<li><a href="'.$partner->url.'" target="_newtab" ><img src="'.PS_URL.'assets/images/partners/thumbs/'.$partner->icon.'" title="'.stripslashes($partner->description).'" alt="'.stripslashes($partner->name).'"  /></a></li>';
        }
        
        echo '</ul>';
        echo '</div>';
        echo '<a class="buttons next" href="#">right</a>';
        echo '</div>';
        
        //Finish displaying the widget
        echo stripslashes($args['after_widget']);
    }
}

?>

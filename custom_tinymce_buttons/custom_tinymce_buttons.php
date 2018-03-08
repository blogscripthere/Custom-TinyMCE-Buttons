<?php
/**
 * @package Custom_Tinymce_Buttons
 * @version 1.0
 */
/*
Plugin Name: ScriptHere's Simple Custom TinyMCE Buttons
Plugin URI: https://github.com/blogscripthere/custom-tinymce-buttons
Description: Simple way to add custom buttons to wordpress post or page edit screen.
Author: Narendra Padala
Author URI: https://in.linkedin.com/in/narendrapadala
Text Domain: shc
Version: 1.0
Last Updated: 10/03/2018
*/
//https://wordpress.stackexchange.com/questions/72394/how-to-add-a-shortcode-button-to-the-tinymce-editor


/*
 * Initialize process for registering your custom TinyMCE buttons hook
 */
add_action('init', 'sh_custom_shortcode_button_init_callback');
/*
 * Initialize process for registering your custom TinyMCE buttons callback
 */
function sh_custom_shortcode_button_init_callback() {

    //If the user can not see the TinyMCE please stop early
    if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') && get_user_option('rich_editing') == 'true') {
        return;
    }

    //Add a callback request to register the tinymce plugin hook
    add_filter("mce_external_plugins", "sh_custom_register_tinymce_plugin_callback");
    //Add a callback request to add the button to the TinyMCE toolbar hook
    add_filter('mce_buttons', 'sh_custom_add_tinymce_button_callback');
}
/*
 * This callback is process our TinyMCE Editor plug-in.
 */
function sh_custom_register_tinymce_plugin_callback($plugin_array) {
    // if your using code in theme use get_template_directory_uri with - 'path/to/custom_editor.js';
    //$url = get_template_directory_uri().'/assets/custom_editor.js';
    // if your using code in plugin use plugins_url with - 'path/to/custom_editor.js';
    $url = plugins_url().'/custom_tinymce_buttons/assets/custom_editor.js';
    //set custom js url path
    $plugin_array['sh_custom_button'] = $url;
    //return
    return $plugin_array;
}

/*
 * This callback adds our button to the TinyMCE Editor toolbar
 */
function sh_custom_add_tinymce_button_callback($buttons) {
    //Set the custom button identifier to the $buttons array
    $buttons[] = "sh_custom_button";
    //return $buttons
    return $buttons;
}

/*
 * TinyMCE buttons filter hook to set new available custom  buttons.
 */
add_filter( 'mce_buttons_2', 'sh_custom_hidden_tinymce_buttons_callback' );
/*
 * TinyMCE buttons filter hook callback to append custom  buttons
 * return $buttons
 */
function sh_custom_hidden_tinymce_buttons_callback( $buttons ) {
    //set cut button
    $buttons[] = 'cut';
    //set copy button
    $buttons[] = 'copy';
    //set copy button
    $buttons[] = 'paste';
    //return appended button list
    return $buttons;
}
/*
 * TinyMCE buttons filter hook to hide existing buttons at TinyMCE editor.
 * return $buttons
 */
function sh_hide_tinymce_buttons_callback( $buttons ) {
    //init array list of buttons don't wont show in TinyMCE editor tool bar
    //ex : hr,cut
    $hideButtons = array( 'hr','cut' );
    //Skip over the hidden buttons from the button list and return
    return array_diff( $buttons, $hideButtons );
}
/*
 * TinyMCE buttons filter hook callback to hide existing buttons at TinyMCE editor.
 */
add_filter( 'mce_buttons_2', 'sh_hide_tinymce_buttons_callback' );
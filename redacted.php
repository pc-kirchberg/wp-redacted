<?php
/*
Plugin Name: Redacted
Version: 1.1.0
Description: Adds a shortcode to make certain things only visible to PupCom members.
Author: PupCom/Marks Polakovs
*/
defined('ABSPATH') or die('No script kiddies please!');

function redacted_stylesheet()
{
    wp_enqueue_style('redacted_stylesheet', plugins_url('style.css', __FILE__));
}


// Add Shortcode
function redacted_shortcode($atts, $content = null)
{
    $style = isset($atts["style"]) ? $atts["style"] : "default";
    $result = '';
    $userCan = !(empty(types_render_usermeta_field('role', array("user_current" => true))));

    if ($userCan) {
        $result = "<span class='redacted'>$content</span>";
    } else {

        if ($style == "default")
            $result = "<span class='redacted'>REDACTED</span>";

        if ($style == "hidden")
            $result = '';

        if ($style == "declassified")
            $result = "<span class='redacted'>$content</span>";

    }


    return $result;
}

add_shortcode('redacted', 'redacted_shortcode');
add_action('wp_enqueue_scripts', 'redacted_stylesheet');

?>

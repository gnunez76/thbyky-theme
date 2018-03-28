<?php
/**
 * Created by ThinkingSize.
 * URL: http://www.thinkingsize.com/
 */


add_filter( 'jpeg_quality', 'custom_image_quality' );
add_filter( 'wp_editor_set_quality', 'custom_image_quality' );
function custom_image_quality( $quality ) {

    return 70;

}
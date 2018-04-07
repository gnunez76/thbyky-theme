<?php
/**
 * Created by ThinkingSize.
 * URL: http://www.thinkingsize.com/
 */

require_once(__DIR__ . '/vendor/autoload.php');


require_once __DIR__ .'/lib/Metabox/meta-box.php';
require_once __DIR__ .'/lib/Metabox/mb-term-meta/mb-term-meta.php';
require_once __DIR__ .'/lib/Metabox/meta-box-group/meta-box-group.php';
require_once __DIR__ .'/lib/Metabox/meta-box-show-hide/meta-box-show-hide.php';
require_once __DIR__ .'/lib/Metabox/mb-user-meta/mb-user-meta.php';
//        require_once __DIR__ .'/../../..//lib/Metabox/mb-custom-post-type/mb-custom-post-type.php';
require_once __DIR__ .'/lib/Metabox/meta-box-tooltip/meta-box-tooltip.php';
require_once __DIR__ . '/lib/Metabox/meta-box-conditional-logic/meta-box-conditional-logic.php';
require_once __DIR__ . '/lib/Metabox/mb-settings-page/mb-settings-page.php';

require_once __DIR__ . '/src/nifField.php';
require_once __DIR__ . '/src/statics.php';
require_once __DIR__ . '/src/htmlblock.php';

$timber = new \Timber\Timber();

add_filter( 'jpeg_quality', 'custom_image_quality' );
add_filter( 'wp_editor_set_quality', 'custom_image_quality' );
function custom_image_quality( $quality ) {

    return 70;

}


add_action('wp_enqueue_scripts', function () {

    wp_dequeue_script( 'lolfmk-google-maps-api' );
    wp_deregister_script( 'lolfmk-google-maps-api' );
    wp_dequeue_script( 'lolfmk-google-maps' );
    wp_deregister_script( 'lolfmk-google-maps' );
});
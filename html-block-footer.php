<?php

?><!DOCTYPE html>
<?php
$responsive_check = ((get_option('lol_check_responsive')  == 'true') ? 'yes-responsive' : 'no-responsive');
$preloader_check = ((get_option('lol_check_preloader')  == 'true') ? 'lol-preloader-yes' : 'lol-preloader-no');
$animations_check = ((get_option('lol_check_animations')  == 'true') ? 'lol-animations-yes' : 'lol-animations-no');
$animations_touch_check = ((get_option('lol_check_animations_touch')  == 'true') ? 'lol-animations-touch-yes' : 'lol-animations-touch-no');
$animations_sticky_check = ((get_option('lol_check_sticky')  == 'true') ? 'lol-sticky-header-yes' : 'lol-sticky-header-no');
$animations_top_header_check = ((get_option('lol_check_top_header')  == 'true') ? 'lol-top-header-yes' : 'lol-top-header-no');
?>
<!--[if IE 8]> <html class="no-js lt-ie9 <?php echo $responsive_check.' '.$preloader_check.' '.$animations_check.' '.$animations_touch_check.' '.$animations_sticky_check.' '.$animations_top_header_check; ?>" <?php language_attributes();?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js <?php echo $responsive_check.' '.$preloader_check.' '.$animations_check.' '.$animations_touch_check.' '.$animations_sticky_check.' '.$animations_top_header_check; ?>" <?php language_attributes();?>> <!--<![endif]-->
<head>
    <meta charset="<?php bloginfo('charset'); ?>">

    <?php if (get_option('lol_check_responsive') == 'true') { ?>
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
    <?php } ?>

    <title><?php
        /*
         * Print the <title> tag based on what is being viewed.
         */
        global $page, $paged;
        wp_title('|', true, 'right');
        // Add the blog name.
        bloginfo('name');
        // Add the blog description for the home/front page.
        $site_description = get_bloginfo('description', 'display');
        if ($site_description && (is_home() || is_front_page())) {
            echo " | $site_description";
        }
        // Add a page number if necessary:
        if ($paged >= 2 || $page >= 2) {
            echo ' | ' . sprintf(__('Page %s', 'lollum'), max($paged, $page));
        }
        ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php // if (is_singular() && get_option('thread_comments')) wp_enqueue_script('comment-reply'); ?>
    <link rel="alternate" title="<?php printf(__('%s RSS Feed', 'lollum'), get_bloginfo('name')); ?>" href="<?php bloginfo('rss2_url'); ?>">
    <link rel="alternate" title="<?php printf(__('%s Atom Feed', 'lollum'), get_bloginfo('name')); ?>" href="<?php bloginfo('atom_url'); ?>">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php if (get_option('lol_custom_favicon')) { ?>
        <link rel="shortcut icon" href="<?php echo get_option('lol_custom_favicon'); ?>">
    <?php } ?>
    <script>document.documentElement.className += " js";</script>
    <!-- BEGIN WP -->
    <?php wp_head(); ?>
    <!-- END WP -->
</head>
<body <?php body_class();?>>

<?php
if (get_option('lol_check_preloader') == 'true') :
    if (wp_is_mobile() && get_option('lol_check_preloader_mobile') == 'true') {
        get_template_part('preloader');
    } else if (!wp_is_mobile()) {
        get_template_part('preloader');
    }
endif;
?>

<?php
$has_cart_header = (lollum_check_is_woocommerce() && (get_option('lol_check_cart_header') == 'true')) ? true : false;
?>

<!-- BEGIN wrap -->
<div id="wrap" class="<?php echo (get_option('lol_layout') == 'layout-boxed') ? 'boxed' : ''; ?>">

<?php get_footer(); ?>
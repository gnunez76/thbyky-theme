<?php


add_filter('style_loader_src', function ($url) {

    if (preg_match('#^'.site_url().'#', $url)) {

        $url = preg_replace ('#^'.site_url().'#','http://ykys2.mrjack.es', $url);
    }

    return $url;
});

add_filter('script_loader_src', function ($url) {

    if (preg_match('#^'.site_url().'#', $url)) {
        $url = preg_replace ('#^'.site_url().'#','http://ykys2.mrjack.es', $url);
    }

    return $url;
});

add_filter ( 'get_site_icon_url', function ($url) {

    if (preg_match('#^'.site_url().'#', $url)) {
        $url = preg_replace ('#^'.site_url().'#','http://ykys2.mrjack.es', $url);
    }

    return $url;
});

// Url de STATIC en media
add_filter('wp_get_attachment_url', function ($url)  {

    $url = preg_replace ('#^'.site_url().'#','http://ykys2.mrjack.es', $url);
    return $url;
}, 10, 1);
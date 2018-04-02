<?php


function thbgetDomain ($url) {

    $staticHosts = array ('https://ykys1.eirendor.com','https://ykys2.eirendor.com');

    $url = preg_replace ('#^'.site_url().'#','', $url);

    if (!empty ($url)) {
        if (count($staticHosts) > 0) {

            $_aux = abs(crc32($url)) % count($staticHosts);
            if (!empty ($staticHosts[$_aux])) {
                $url = $staticHosts[$_aux] . $url;
            } else {
                $url = home_url() . $url;
            }

        } else {
            $url = home_url() . $url;
        }

    }

    return $url;
}

add_filter('style_loader_src', function ($url) {

    if (preg_match('#^'.site_url().'#', $url)) {

//        $url = preg_replace ('#^'.site_url().'#','https://ykys2.mrjack.es', $url);
        $url = thbgetDomain($url);
    }

    return $url;
});

add_filter('script_loader_src', function ($url) {

    if (preg_match('#^'.site_url().'#', $url)) {

//        $url = preg_replace ('#^'.site_url().'#','https://ykys2.mrjack.es', $url);
        $url = thbgetDomain($url);
    }

    return $url;
});

add_filter ( 'get_site_icon_url', function ($url) {

    if (preg_match('#^'.site_url().'#', $url)) {

//        $url = preg_replace ('#^'.site_url().'#','https://ykys2.mrjack.es', $url);
        $url = thbgetDomain($url);
    }

    return $url;
});

// Url de STATIC en media
add_filter('wp_get_attachment_url', function ($url)  {

//    $url = preg_replace ('#^'.site_url().'#','https://ykys2.mrjack.es', $url);
    $url = thbgetDomain($url);

    return $url;
}, 10, 1);
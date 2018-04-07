<?php

if (preg_match('#^/thb-html-block/(?P<type>[^/]+)/#', $_SERVER["REQUEST_URI"], $match)) {

    add_filter('show_admin_bar', '__return_false');
    add_action('template_include', function ($template) use ($match) {

        switch (strtoupper($match['type'])) {
            case 'FOOTER-BLOCK':
                $template = __DIR__ . '/../html-block-footer.php';
                break;
            case 'HEADER-BLOCK':
                $template = __DIR__ . '/../html-block-header.php';
                break;
        }
        return $template;
    }, 99);
}
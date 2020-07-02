<?php

class BlogGenerator extends ContentGenerator {
    public $blog;

    function __construct() {

        $this->prepare_blog();
    }

    function prepare_blog() {
        $homepage_url = get_post_field( 'post_name', (get_option('page_on_front')) );
        $homepage_json = ord($homepage_url[0]) .'/'.ord($homepage_url[1]).'/'.$homepage_url.'.json';


        $this->blog = [
            'logo' => get_custom_logo(),
            'home_id' => get_option('page_on_front'),
            'title' => get_bloginfo('title'),
            'description' => get_bloginfo('description'),
            'homepage_json' => $homepage_json,
            'backend_url' => get_home_url(),
            'header' => $this->header_styles(get_option('page_on_front'))
        ];
    }

    function header_styles($frontpage_id) {
        ob_start();
        get_header();
        $head = ob_get_clean();

        $styles = '';
        $css = [ get_home_url().'/wp-includes/css/dist/block-library/style.min.css?ver=5.3.2' ];

        if( class_exists('DOMDocument') ) {

            $dom = new DOMDocument();
            $dom->loadHTML($head);
            $nodes = $dom->getElementsByTagName("link");

            foreach ($nodes as $node) {
                $href = $node->getAttribute('href');

                if( strpos($href, '.css') ) {
                    $css[] = $href;
                }
            }

            $nodes = $dom->getElementsByTagName("style");

            foreach ($nodes as $node) {
                $styles .= $node->textContent;
            }
        }

        if( class_exists('SiteOrigin_Panels_Renderer') ){
            $renderer = new SiteOrigin_Panels_Renderer();
            $styles .= $renderer->generate_css($frontpage_id);
            $css[] = $renderer->front_css_url();
        }

        return compact('styles', 'css');
    }

    function generate_json() {
        $filepath = WP_CONTENT_DIR . '/data/blog.json';
        file_put_contents($filepath, json_encode($this->blog));
    }
}
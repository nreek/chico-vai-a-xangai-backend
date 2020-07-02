<?php 

class Page extends ContentGenerator {
    public $post;

    function __construct($post, $request_data) {
        parent::__construct($post, $request_data);
    }

    function extend_post() {
        if( class_exists('SiteOrigin_Panels_Renderer') ){
            $renderer = new SiteOrigin_Panels_Renderer();
            $this->post['styles'] = $renderer->generate_css($this->post->ID);
        }
    }

    function save_post() {
        $this->extend_post();
        $this->generate_json();
    }
}
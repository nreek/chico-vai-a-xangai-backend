<?php 

class Colunistas extends ContentGenerator {
    public $post;

    function __construct($post, $request_data) {
        parent::__construct($post, $request_data);
    }

    public static function extended_data ($post_id) {
        $last_post = false;

        $last_post_query = new WP_Query([
            'posts_per_page' => 1,
            'meta_key' => 'colunista',
            'meta_value' => $post_id,
            'post_status' => 'publish'
        ]);

        foreach ( $last_post_query->posts as $post ) {
            $last_post = [
                'ID'    => $post->ID,
                'title' => $post->post_title,
                'permalink' => get_the_permalink($post->ID)
            ];
        }
        
        wp_reset_postdata();
        return [ 'last_post' => $last_post ];
    }
    
    function extend_post() {
        $extended_data = $this->extended_data(get_the_ID());
        
        $main_menu = get_post_meta(get_the_ID(), 'colunista_menu-principal', true);
        $social_networks = get_post_meta(get_the_ID(), 'colunista_redes-sociais', true);

        $this->post['last_post'] = $extended_data['last_post'];
        $this->post['main_menu'] = $main_menu;
        $this->post['social_networks'] = $social_networks;
    }

    function save_post() {
        $this->extend_post();
        $this->generate_json();
    }
}
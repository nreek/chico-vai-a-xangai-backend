<?php 

class Post extends ContentGenerator {
    public $post;

    function __construct($post, $request_data, $ignore = []) {
        parent::__construct($post, $request_data, $ignore);
    }

    public static function extended_data ($post_id) {
        $author = get_post_meta($post_id, 'author', true);
        $colunista_id = get_post_meta($post_id, 'colunista', true);
        $colunista = false;

        if( $colunista_id && !empty($colunista_id) ) {
            $colunista = [
                'ID' => $colunista_id,
                'title' => get_the_title($colunista_id),
                'permalink' => replace_home_url(get_the_permalink($colunista_id)),
                'slug' => get_post_field('post_name', $colunista_id),
            ];
        }

        return [ 'author' => $author, 'colunista' => $colunista ];
    }
    
    function extend_post() {
        $extended_data = $this->extended_data(get_the_ID());
        
        $this->post['author'] = $extended_data['author'];
        $this->post['colunista'] = $extended_data['colunista'];
        $this->post['related_posts'] = get_post_meta(get_the_ID(), 'related_posts', true);
    }

    function save_post() {
        $this->extend_post();
        $this->generate_json();
    }
}
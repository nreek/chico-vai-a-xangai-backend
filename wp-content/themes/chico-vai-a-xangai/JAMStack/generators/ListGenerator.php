<?php 

class ListGenerator extends ContentGenerator {
    public $postList = [];
    public $postListByType = [];

    function __construct() {
        $this->prepare_list();
    }

    function prepare_list() {
        $cpts = get_post_types( [ 'show_in_rest' => true, 'public' => true ] );
        $cpts = array_keys( array_filter( $cpts, function ($cpt) {
            return $cpt != 'attachment' && $cpt != 'page'; 
        }) );

        $content_query = new WP_Query([
            'post_type'     => $cpts,
            'posts_per_page'           => 100,
            'post_status'   => 'publish',
        ]);
    

        while ($content_query->have_posts()) {
            $content_query->the_post();
            global $post;

            $extended_data = [];

            $class_name = str_replace(' ', '', ucwords(str_replace('-', ' ', $post->post_type)));
            if ( class_exists($class_name) ) {
                $extended_data = $class_name::extended_data($post->ID);
            }

            $final_post = array_merge( $this->prepare_post( $post, [ 'content', 'tags', 'meta' ] ), $extended_data);
            $this->postList[] = $final_post;
            $this->postListByType[$post->post_type][] = $final_post;
        }

        \wp_reset_query();
    }

    function generate_json() {
        $filepath = WP_CONTENT_DIR.'/data/content.json';

        file_put_contents($filepath, json_encode($this->postList));

        foreach( $this->postListByType as $type => $postList ) {
            file_put_contents(WP_CONTENT_DIR.'/data/'. $type .'.json', json_encode($postList));
        }
    }
}
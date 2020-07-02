<?php

class TermsGenerator extends ContentGenerator {
    public $terms = [];
    public $post = [];
    public $postList = [];

    function __construct($post, $request_data){
        
        $taxonomies = get_taxonomies([ 'public'   => true ]);
        $this->post = $post;

        $taxonomy_relations = [
            'category' => 'categories',
            'post_tag' => 'tags'
        ];

        foreach ( $taxonomies as $taxonomy ) {
            if(isset($taxonomy_relations[$taxonomy])) {
                $request_taxonomy = $taxonomy_relations[$taxonomy];
            }

            $terms = $request_data->$request_taxonomy;

            if($terms) {
                $this->prepare_list($taxonomy, $terms);
                $this->terms = array_merge($this->terms, $terms);
                $this->generate_json();
            }
        }

    }

    function prepare_list($taxonomy, $terms) {
        foreach ($terms as $term) {

            $terms_query = new WP_Query( [
                'posts_per_page' => '40',
                'post_status' => 'publish',
                'tax_query' => array(
                    array(
                        'taxonomy' => $taxonomy,
                        'field'    => 'term_id',
                        'terms'    => $term,
                    ),
                ),
            ] );
    
            $term_data = get_term($term);
            $this->postList[$term] = [
                'ID' => $term,
                'title' => $term_data->name,
                'order' => $term_data->order,
            ];

            while($terms_query->have_posts()) {
                $terms_query->the_post();
                global $post;

                $this->postList[$term]['relations'] = $this->prepare_post( $post, [ 'content', 'tags', 'meta' ] );
            }

            \wp_reset_query();
        }
    }

    function generate_json() {
        foreach($this->terms as $term) {
            $filepath = $this->get_dir_path('term_'.$term);
            file_put_contents($filepath, json_encode($this->postList[$term]));
        }
    }
}
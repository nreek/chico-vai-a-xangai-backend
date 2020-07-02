<?php 

class ContentGenerator implements IContentGenerator{
    public $post;
    public $request_data;

    function __construct($post, $request_data, $ignore = []) {
        $this->request_data = $request_data;
        $this->post = $this->prepare_post($post, $ignore);
    }

    function prepare_post( $post, $ignore = [] ) {
        GLOBAL $pb_scripts;

        $content = get_the_content( null, false, $post->ID );
        $content = apply_filters( 'the_content', $content );
        $content = str_replace( ']]>', ']]&gt;', $content );
        $content = str_replace('<style type="text/css"></style>', '', $content);
        $excerpt = has_excerpt( $post->ID ) ? get_the_excerpt( $post->ID ) : '';

        // Exclude unuseful meta data such as "_ping" and etc, which conventionaly starts with a _
        $post_metas = get_post_meta($post->ID);

        $meta = $yoast = [];
        foreach( $post_metas as $key => $value ) {
            if( $key[0] != '_' ) {
                $meta[$key] = is_serialized($value[0]) ? unserialize($value[0]) : $value[0];
            }
        }

        $yoast = $this->prepare_yoast($post_metas);

        $utils = new Utils($this->request_data);

        $post = [
            'ID'        => $post->ID,
            'title'     => $post->post_title,
            'type'      => get_post_type($post->ID),
            'excerpt'   => $excerpt,
            'time'      => get_the_date('U', $post->ID),
            'slug'      => $post->post_name,
            'thumbnail' => $utils->get_thumbnail_info( $post->ID ),
            'permalink' => replace_home_url(get_permalink($post->ID)),
            'scripts'   => $pb_scripts[$post->ID]
        ];

        $this->prepare_taxonomies($post, $ignore);

        $ignorable_fields = [ 'content', 'meta', 'yoast' ];

        // Itera entre os campos que são passíveis de serem excluídos e os atribui ao objeto post caso não devam ser ignorados. Utilizado para diminuir o tamanho do objeto resultado. 
        foreach($ignorable_fields as $field){
            if( !in_array( $field, $ignore ) ) {
                $post[$field] = $$field;
            }
        }

        return $post;
    }

    function prepare_taxonomies(&$post, $ignore) {
        $post_type  = get_post_type($post['ID']);
        $taxonomies = get_object_taxonomies($post_type, 'objects');

        foreach( (array)$taxonomies as $taxonomy ) {
            if(!in_array($taxonomy->name, $ignore )){
                $taxonomy_relations = [
                    'category' => 'categories',
                    'post_tag' => 'tags'
                ];

                $taxonomy_name = isset($taxonomy_relations[$taxonomy->name]) ? $taxonomy_relations[$taxonomy->name] :  $taxonomy->name; 

                $post[$taxonomy_name] = $this->prepare_taxonomy($post['ID'], $taxonomy_name);
            }
        }
    }

    function prepare_taxonomy($post_ID, $taxonomy = 'categories') {
        $tags = [];

        // The request payload category/tag attribute doesn't always match the taxonomy, so here we define the right taxonomy name
        if( in_array($taxonomy, [ 'categories', 'tags' ]) ){
            $taxonomy_relations = [
                'categories' => 'category',
                'tags' => 'post_tag'
            ];

            $rd_taxonomy = $taxonomy;
            $taxonomy = $taxonomy_relations[$taxonomy];
        }
        
        // As save_post is executed before the update of the terms, we fetch and set the updated terms from the request payload. 
        if(isset($this->request_data->$rd_taxonomy) && count($this->request_data->$rd_taxonomy) > 0){
            $tags_array = get_terms([
                'taxonomy' => $taxonomy,
                'hide_empty' => false,
                'include' => $this->request_data->$rd_taxonomy
            ]);
        }else{
            // If no term was updated, we fetch the existing terms from the DB.
            $tags_array = wp_get_post_terms($post_ID, $taxonomy);
        }

        foreach($tags_array as $tag) {
            $tags[] = [
                'ID' => $tag->term_id,
                'title' => $tag->name,
                'slug' => $tag->slug,
                'parent' => $tag->parent,
                'permalink' => replace_home_url( get_term_link($tag->term_id, $taxonomy) )
            ];
        }

        return $tags;
    }

    function prepare_yoast($meta) {

        $image = wp_get_attachment_image_src( issetOrDefault( $meta["_thumbnail_id"], $meta['_yoast_wpseo_opengraph-image-id']) , 'full');

        $yoast = array(
            [ 'property' => "og:title", 'content' => $this->yoast_replace(issetOrDefault($meta['_yoast_wpseo_opengraph-title'], $meta['_yoast_wpseo_title'] ) )],
            [ 'property' => "og:description", 'content' => $this->yoast_replace(issetOrDefault($meta["_yoast_wpseo_opengraph-description"], $meta['_yoast_wpseo_metadesc'] ) )],
            [ 'property' => "article:published_time", 'content' => get_post_time('c', false, $this->post['ID']) ],
            [ 'property' => "article:modified_time", 'content' => get_post_modified_time('c', false, $this->post['ID']) ],
            [ 'property' => "og:updated_time", 'content' => get_post_modified_time('c', false, $this->post['ID']) ],
            [ 'property' => "og:image", 'content' => issetOrDefault($meta['_yoast_wpseo_opengraph-image'], $image ) ],
            [ 'property' => "og:image:width", 'content' => $image[1] ],
            [ 'property' => "og:image:height", 'content' => $image[2] ],
            [ 'name' =>"twitter:card", 'content' =>  "summary_large_image" ],
            [ 'name' =>"twitter:description", 'content' =>  $this->yoast_replace(issetOrDefault($meta['_yoast_wpseo_twitter-description'], $meta['_yoast_wpseo_title'] ) )],
            [ 'name' =>"twitter:title", 'content' =>  $this->yoast_replace(issetOrDefault($meta['_yoast_wpseo_twitter-title'], $meta['_yoast_wpseo_metadesc'] ) )],
            [ 'name' =>"twitter:image", 'content' =>  issetOrDefault($meta['_yoast_wpseo_twitter-image'], $image  ) ],
        );

        return $yoast;
    }

    function yoast_replace($str) {
        return  str_replace('%%page%%', '', str_replace('%%sep%%', '-', str_replace('%%sitename%%', get_bloginfo('title'), $str)));
    }

    function generate_json() {
        $filepath = $this->get_dir_path($this->post['slug']);
        
        file_put_contents($filepath, json_encode($this->post));
    }

    function save_post() {
        $this->generate_json();
    }

    function get_dir_path( $slug, $extension = 'json' ) {
        if(empty($slug) || strlen($slug) < 2){
            $slug = 'ab';
        }
        
        $directories = [
            WP_CONTENT_DIR,
            'data',
            ord($slug[0]),
            ord($slug[1]),
        ];

        $dir_path = implode('/', $directories);
        Utils::recursively_mkdir($dir_path);

        return $dir_path . '/' . $slug . '.' . $extension;
    }
}
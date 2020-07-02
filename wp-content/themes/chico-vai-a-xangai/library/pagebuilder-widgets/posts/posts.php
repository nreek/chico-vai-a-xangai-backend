<?php

/*
  Widget Name: Posts
  Description: Lista de Posts
  Author: Smart Fit
  Author URI: https://Smart Fiteducacaofisica.com.br
 */

namespace widgets;

class Posts extends \SiteOrigin_Widget {

    function __construct() {
        $fields = [
            'columns' => [
                'type' => 'number',
                'label' => 'Quantidade de cards por linha',
                'default' => '3'
            ],
            'show' => [
                'type' => 'select',
                'label' => 'Exibição',
                'options' => [
                    'vertical' => 'Vertical',
                    'horizontal' => 'Horizontal'
                ]
            ],
            'posts' => [
                'type' => 'posts',
                'label' => 'Conteúdos',
            ],
        ];

        parent::__construct('posts', 'Posts', [
            'panels_groups' => [WIDGETGROUP_BANNERS],
            'description' => 'Componente de Lista de Posts'
        ], [], $fields, plugin_dir_path(__FILE__));
    }

    function get_template_name($instance) {
        return 'template';
    }

    function get_style_name($instance) {
        return 'style';
    }

    function get_template_variables( $instance ) {
        $post_id = $_POST['post_ID'];

        $hash = 'posts_'. md5($instance['posts']);
        $processed_query = siteorigin_widget_post_selector_process_query( $instance['posts'] );
        $posts_query = new \WP_Query( $processed_query );
        $posts = [];

        
        if($posts_query->have_posts()){
            while($posts_query->have_posts()){
                $posts_query->the_post();
                global $post;

                $posts[] = $post->post_name;
            }
        }

        localize_scripts($post_id, $hash, [ 'relations' => $posts ] );
        wp_reset_postdata();
        
        return array(
            'hash' => $hash
        );
    }

}

Siteorigin_widget_register('posts', __FILE__, 'widgets\Posts');

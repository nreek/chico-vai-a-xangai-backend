<?php

/*
  Widget Name: Posts Relacionados
  Description: Lista de Posts Relacionados
  Author: Smart Fit
  Author URI: https://Smart Fiteducacaofisica.com.br
 */

namespace widgets;

class PostsRelatedSmall extends \SiteOrigin_Widget {

    function __construct() {
        $fields = [
            'title' => [
                'type' => 'text',
                'label' => 'Título',
            ],
            'size' => [
                'type' => 'select',
                'label' => 'Tamanho',
                'options' => [
                    'small' => 'Pequeno (50%)',
                    'large' => 'Grande (100%)'
                ]
            ],
            'posts' => [
                'type' => 'posts',
                'label' => 'Conteúdos',
            ],
        ];

        parent::__construct('posts-related-small', 'Posts Relacionados', [
            'panels_groups' => [WIDGETGROUP_BANNERS],
            'description' => 'Componente de Lista de Posts Relacionados'
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

        return array(
            'query' => $posts_query
        );
    }

}

Siteorigin_widget_register('posts-related-small', __FILE__, 'widgets\PostsRelatedSmall');

<?php

/*
  Widget Name: Slider
  Description: Slider
  Author: Smart Fit
  Author URI: https://Smart Fiteducacaofisica.com.br
 */

namespace widgets;

class Slider extends \SiteOrigin_Widget {

    function __construct() {
        $fields = [
            'posts' => [
                'type' => 'posts',
                'label' => 'Conteúdos',
            ],
        ];

        parent::__construct('slider', 'Slider', [
            'panels_groups' => [WIDGETGROUP_BANNERS],
            'description' => 'Componente de Slider'
        ], [], $fields, plugin_dir_path(__FILE__));
    }

    function get_template_name($instance) {
        return 'template';
    }

    function get_style_name($instance) {
        return 'style';
    }

    function get_template_variables( $instance ) {
        $post_id = get_the_ID();
        $hash = 'slider_'. md5($instance['posts']);
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

        localize_scripts( $post_id, $hash, [ 'relations' => $posts ]);
        wp_reset_postdata();
        
        return array(
            'hash' => $hash
        );
    }
}

Siteorigin_widget_register('slider', __FILE__, 'widgets\Slider');

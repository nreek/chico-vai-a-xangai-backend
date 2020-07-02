<?php

/*
  Widget Name: Posts em Destaque
  Description: Lista de Posts em Destaque
  Author: Smart Fit
  Author URI: https://Smart Fiteducacaofisica.com.br
 */

namespace widgets;

class FeaturedPosts extends \SiteOrigin_Widget {

    function __construct() {
        $fields = [
            'columns' => [
                'type' => 'number',
                'label' => 'Quantidade de cards por linha',
                'default' => '1'
            ],
            'posts' => [
                'type' => 'posts',
                'label' => 'Conteúdos',
            ],
        ];

        parent::__construct('featured-posts', 'Posts em Destaque', [
            'panels_groups' => [WIDGETGROUP_BANNERS],
            'description' => 'Componente de Lista de Posts em Destaque'
        ], [], $fields, plugin_dir_path(__FILE__));
    }

    function get_template_name($instance) {
        return 'template';
    }

    function get_style_name($instance) {
        return 'style';
    }

}

Siteorigin_widget_register('featured-posts', __FILE__, 'widgets\FeaturedPosts');

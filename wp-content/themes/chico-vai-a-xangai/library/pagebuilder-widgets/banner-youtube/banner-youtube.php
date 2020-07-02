<?php

/*
  Widget Name: Banner de Vídeos
  Description: Banner de Vídeos
  Author: Smart Fit
  Author URI: https://smartfit.com.br/conteudo
 */

namespace widgets;

class BannerYoutube extends \SiteOrigin_Widget {

    function __construct() {
        $fields = [
            'title' => [
                'type' => 'text',
                'label' => 'Título',
            ],
            'description' => [
                'type' => 'text',
                'label' => 'Descrição',
            ],
            'button_text' => [
                'type' => 'text',
                'label' => 'Texto do botão',
            ],
        ];

        parent::__construct('banner-youtube', 'Banner de Vídeos', [
            'panels_groups' => [WIDGETGROUP_BANNERS],
            'description' => 'Componente de Banner de Vídeos'
        ], [], $fields, plugin_dir_path(__FILE__));
    }

    function get_template_name($instance) {
        return 'template';
    }

    function get_style_name($instance) {
        return 'style';
    }

}

Siteorigin_widget_register('banner-youtube', __FILE__, 'widgets\BannerYoutube');

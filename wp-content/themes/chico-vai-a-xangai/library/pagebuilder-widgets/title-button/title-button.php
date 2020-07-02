<?php

/*
  Widget Name: Título com Botão
  Description: Título com Botão
  Author: Smart Fit
  Author URI: https://smartfit.com.br/conteudo
 */

namespace widgets;

class TitleButton extends \SiteOrigin_Widget {

    function __construct() {
        $fields = [
            'title' => [
                'type' => 'text',
                'label' => 'Título',
            ],
            'button_text' => [
                'type' => 'text',
                'label' => 'Texto do botão',
            ],
            'button_url' => [
                'type' => 'link',
                'label' => 'Link do botão',
            ],
        ];

        parent::__construct('title-button', 'Título com Botão', [
            'panels_groups' => [WIDGETGROUP_BANNERS],
            'description' => 'Componente de Título com Botão'
        ], [], $fields, plugin_dir_path(__FILE__));
    }

    function get_template_name($instance) {
        return 'template';
    }

    function get_style_name($instance) {
        return 'style';
    }

}

Siteorigin_widget_register('title-button', __FILE__, 'widgets\TitleButton');

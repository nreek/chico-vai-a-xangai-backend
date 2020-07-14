<?php

/*
  Widget Name: Box de Perfil de Filme/Personalidade
  Description: Box de Perfil de Filme/Personalidade
  Author: Smart Fit
  Author URI: https://smartfit.com.br/conteudo
 */

namespace widgets;

class BoxProfile extends \SiteOrigin_Widget {

    function __construct() {
        $fields = [
            'posts' => [
                'type' => 'posts',
                'label' => 'Conteúdos',
            ],
            'body' => [
                'type' => 'select',
                'label' => 'Exibir conteúdo do:',
                'options' => [
                    'excerpt' => 'Resumo',
                    'content' => 'Corpo do Texto'
                ]
            ],
        ];

        parent::__construct('box-profile', 'Box de Perfil de Filme/Personalidade', [
            'panels_groups' => [WIDGETGROUP_BANNERS],
            'description' => 'Componente de Box de Perfil de Filme/Personalidade'
        ], [], $fields, plugin_dir_path(__FILE__));
    }

    function get_template_name($instance) {
        return 'template';
    }

    function get_style_name($instance) {
        return 'style';
    }

}

Siteorigin_widget_register('box-profile', __FILE__, 'widgets\BoxProfile');

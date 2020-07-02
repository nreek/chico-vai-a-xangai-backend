<?php

/*
  Widget Name: Banner de Smart Coach
  Description: Banner de Smart Coach
  Author: Smart Fit
  Author URI: https://smartfit.com.br/conteudo
 */

namespace widgets;

class BannerCoach extends \SiteOrigin_Widget {

    function __construct() {
        $fields = [
            'title' => [
                'type' => 'text',
                'label' => 'Título',
                'default' => 'Treine em casa e conquiste os melhores resultados'
            ],
            'description' => [
                'type' => 'text',
                'label' => 'Descrição',
                'default' => 'Com a consultoria semanal de um <strong>personal trainer</strong> e uma sequência de exercícios personalizada pra você ter'
            ],
            'button_text' => [
                'type' => 'text',
                'label' => 'Texto do Botão',
                'default' => 'Agende sua consulta grátis'
            ],
            'button_url' => [
                'type' => 'text',
                'label' => 'Link do botão',
            ],
            'image' => [
                'type' => 'media',
                'label' => 'Imagem',
            ],
        ];

        parent::__construct('banner-coach', 'Banner de Smart Coach', [
            'panels_groups' => [WIDGETGROUP_BANNERS],
            'description' => 'Componente de Banner de Smart Coach'
        ], [], $fields, plugin_dir_path(__FILE__));
    }

    function get_template_name($instance) {
        return 'template';
    }

    function get_style_name($instance) {
        return 'style';
    }

}

Siteorigin_widget_register('banner-coach', __FILE__, 'widgets\BannerCoach');

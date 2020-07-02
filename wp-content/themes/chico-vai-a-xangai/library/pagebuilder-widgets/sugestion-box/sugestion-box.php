<?php

/*
  Widget Name: Caixa de Feedback
  Description: Caixa de Feedback
  Author: Smart Fit
  Author URI: https://smartfit.com.br/conteudo
 */

namespace widgets;

class SugestionBox extends \SiteOrigin_Widget {

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
            'success_message' => [
                'type' => 'text',
                'label' => 'Mensagem de sucesso',
            ],
        ];

        parent::__construct('sugestion-box', 'Caixa de Feedback', [
            'panels_groups' => [WIDGETGROUP_BANNERS],
            'description' => 'Componente de Caixa de Feedback'
        ], [], $fields, plugin_dir_path(__FILE__));
    }

    function get_template_name($instance) {
        return 'template';
    }

    function get_style_name($instance) {
        return 'style';
    }

}

Siteorigin_widget_register('sugestion-box', __FILE__, 'widgets\SugestionBox');

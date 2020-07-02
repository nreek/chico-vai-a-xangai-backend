<?php

/*
  Widget Name: Treine em Casa
  Description: Treine em Casa
  Author: Smart Fit
  Author URI: https://smartfit.com.br/conteudo
 */

namespace widgets;

class TreineEmCasa extends \SiteOrigin_Widget {

    function __construct() {
        $json_str = file_get_contents('https://treineemcasa.smartfit.com.br/wp-content/data/br.json');

        $json_workouts = json_decode($json_str);
        $workouts = [ '' => 'Os mais recentes' ];

        foreach( $json_workouts as $workout ) {
            $workouts[$workout->ID] = $workout->title;
        }

        $fields = [
            'title' => [
                'type' => 'text',
                'label' => 'Título',
                'description' => 'Pode ser vazio',
            ],
            'subtitle' => [
                'type' => 'text',
                'label' => 'Subtítulo',
                'default' => 'sem pagar nada!',
                'description' => 'Pode ser vazio',
            ],
            'workouts' => [
                'type' => 'select',
                'label' => 'Treinos',
                'multiple' => true,
                'options' => $workouts,
            ]
        ];

        parent::__construct('treine-em-casa', 'Treine em Casa', [
            'panels_groups' => [WIDGETGROUP_BANNERS],
            'description' => 'Componente de Treine em Casa'
        ], [], $fields, plugin_dir_path(__FILE__));
    }

    function get_template_name($instance) {
        return 'template';
    }

    function get_style_name($instance) {
        return 'style';
    }

}

Siteorigin_widget_register('treine-em-casa', __FILE__, 'widgets\TreineEmCasa');

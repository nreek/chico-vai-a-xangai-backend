<?php

/*
  Widget Name: Eventos
  Description: Eventos
  Author: Smart Fit
  Author URI: https://Smart Fiteducacaofisica.com.br
 */

namespace widgets;

class Events extends \SiteOrigin_Widget {

    function __construct() {
        $fields = [
            'title' => [
                'type' => 'text',
                'default' => 'Eventos',
                'label' => 'Título do component',
            ],
        ];

        parent::__construct('events', 'Eventos', [
            'panels_groups' => [WIDGETGROUP_BANNERS],
            'description' => 'Componente com uma lista de eventos'
        ], [], $fields, plugin_dir_path(__FILE__));
    }

    function get_template_name($instance) {
        return 'template';
    }

    function get_style_name($instance) {
        return 'style';
    }

}

Siteorigin_widget_register('events', __FILE__, 'widgets\Events');

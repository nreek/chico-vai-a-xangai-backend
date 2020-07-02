<?php

/*
  Widget Name: Colunistas
  Description: Colunistas
  Author: Smart Fit
  Author URI: https://smartfit.com.br/conteudo
 */

namespace widgets;

class Colunistas extends \SiteOrigin_Widget {

    function __construct() {
        $fields = [

        ];

        parent::__construct('colunistas', 'Colunistas', [
            'panels_groups' => [WIDGETGROUP_BANNERS],
            'description' => 'Componente de Colunistas'
        ], [], $fields, plugin_dir_path(__FILE__));
    }

    function get_template_name($instance) {
        return 'template';
    }

    function get_style_name($instance) {
        return 'style';
    }

}

Siteorigin_widget_register('colunistas', __FILE__, 'widgets\Colunistas');

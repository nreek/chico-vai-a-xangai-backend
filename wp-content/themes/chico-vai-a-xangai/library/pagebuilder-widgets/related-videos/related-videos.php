<?php

/*
  Widget Name: Vídeos Relacionados
  Description: Lista de Vídeos Relacionados
  Author: Smart Fit
  Author URI: https://Smart Fiteducacaofisica.com.br
 */

namespace widgets;

class RelatedVideos extends \SiteOrigin_Widget {

    function __construct() {
        $fields = [
            'title' => array ( 
                'type' => 'text',
                'label' => 'Título',
            ),
            'videos' => array(
                'type' => 'repeater',
                'label' => __( 'Vídeos Relacionados.' , 'widget-form-fields-text-domain' ),
                'item_name'  => __( 'Vídeos', 'siteorigin-widgets' ),
                'fields' => array(
                    'repeat_text' => array(
                        'type' => 'text',
                        'label' => __( 'ID do vídeo no youtube.', 'widget-form-fields-text-domain' )
                    ),
                )
            )
        ];

        parent::__construct('related-videos', 'Vídeos Relacionados', [
            'panels_groups' => [WIDGETGROUP_BANNERS],
            'description' => 'Componente de Lista de Vídeos Relacionados'
        ], [], $fields, plugin_dir_path(__FILE__));
    }

    function get_template_name($instance) {
        return 'template';
    }

    function get_style_name($instance) {
        return 'style';
    }
}

Siteorigin_widget_register('related-videos', __FILE__, 'widgets\RelatedVideos');

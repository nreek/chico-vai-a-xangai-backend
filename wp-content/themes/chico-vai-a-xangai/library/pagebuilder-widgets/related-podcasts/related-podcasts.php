<?php

/*
  Widget Name: Podcasts Relacionados
  Description: Lista de Podcasts Relacionados
  Author: Smart Fit
  Author URI: https://Smart Fiteducacaofisica.com.br
 */

namespace widgets;

class RelatedPodcasts extends \SiteOrigin_Widget {

    function __construct() {

        $xml_string = file_get_contents('https://anchor.fm/s/100b9ec8/podcast/rss');
        $xml = simplexml_load_string($xml_string);
        $podcasts = [];

        foreach ($xml->channel->item as $i) { 
            $podcasts[(string)$i->guid[0]] = (string)$i->title[0]; 
        }

        $fields = [
            'title' => array ( 
                'type' => 'text',
                'label' => 'Título',
            ),
            'podcasts' => array(
                'type' => 'repeater',
                'label' => __( 'Podcasts Relacionados.' , 'widget-form-fields-text-domain' ),
                'item_name'  => __( 'Podcast', 'siteorigin-widgets' ),
                'fields' => array(
                    'repeat_text' => array(
                        'type' => 'select',
                        'label' => __( 'Selecione o podcast.', 'widget-form-fields-text-domain' ),
                        'options' => $podcasts
                    ),
                )
            )
        ];

        parent::__construct('related-videos', 'Podcasts Relacionados', [
            'panels_groups' => [WIDGETGROUP_BANNERS],
            'description' => 'Componente de Lista de Podcasts Relacionados'
        ], [], $fields, plugin_dir_path(__FILE__));
    }

    function get_template_name($instance) {
        return 'template';
    }

    function get_style_name($instance) {
        return 'style';
    }
}

Siteorigin_widget_register('related-videos', __FILE__, 'widgets\RelatedPodcasts');

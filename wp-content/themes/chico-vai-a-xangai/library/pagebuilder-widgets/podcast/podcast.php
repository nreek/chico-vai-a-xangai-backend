<?php

/*
  Widget Name: Banner de Podcast
  Description: Banner de Podcast
  Author: Smart Fit
  Author URI: https://smartfit.com.br/conteudo
 */

namespace widgets;

class Podcast extends \SiteOrigin_Widget {

    function __construct() {
        $fields = [
            'title' => [
                'type' => 'text',
                'label' => 'Título',
                'default' => 'Vai que é fácil'
            ],
            'description' => [
                'type' => 'text',
                'label' => 'Descrição',
            ],
            'image' => [
                'type' => 'media',
                'label' => 'Imagem',
            ],
            'podcast_url' => [
                'type' => 'link',
                'label' => 'URL do RSS do Podcast',
                'default' => 'https://anchor.fm/s/100b9ec8/podcast/rss'
            ],
            'button_text' => [
                'type' => 'text',
                'label' => 'Texto do botão',
                'default' => 'Confira todos os programas'
            ],
            'button_url' => [
                'type' => 'link',
                'label' => 'Link do botão',
                'default' => '/podcast'
            ],
            'network_text' => [
                'type' => 'text',
                'label' => 'Texto da chamada para assinar às redes',
                'default' => 'Assine: '
            ],
            'networks' => array(
                'type' => 'repeater',
                'label' => __( 'Links de Podcast' , 'widget-form-fields-text-domain' ),
                'item_name'  => __( 'Links', 'siteorigin-widgets' ),
                'fields' => array(
                    'url' => array(
                        'type' => 'text',
                        'label' => __( 'URL do link.', 'widget-form-fields-text-domain' )
                    ),
                    'icon' => array(
                        'type' => 'text',
                        'label' => __( 'Ícone', 'example-text-domain' )
                    ),
                    'image' => [
                        'type' => 'media',
                        'label' => 'ou Imagem',
                        'description' => '(para quando não houver ícone no fontawesome)'
                    ],
                )
            )
        ];

        parent::__construct('podcast', 'Banner de Podcast', [
            'panels_groups' => [WIDGETGROUP_BANNERS],
            'description' => 'Componente de Banner de Podcast'
        ], [], $fields, plugin_dir_path(__FILE__));
    }

    function get_template_name($instance) {
        return 'template';
    }

    function get_style_name($instance) {
        return 'style';
    }

}

Siteorigin_widget_register('podcast', __FILE__, 'widgets\Podcast');

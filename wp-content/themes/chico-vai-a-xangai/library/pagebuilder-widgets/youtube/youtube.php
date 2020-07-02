<?php

/*
  Widget Name: Canal do YouTube
  Description: Adiciona uma seção com vídeos do canal do YouTube
  Author: hacklab/
  Author URI: https://hacklab.com.br/
 */

namespace widgets;

class YoutubeChannel extends \SiteOrigin_Widget {

    function __construct() {
        wp_enqueue_script( 'youtube-channel', get_stylesheet_directory_uri() . '/library/pagebuilder-widgets/youtube/youtube.js', array( 'jquery' ) );

        $fields = [
            'title' => [
                'type' => 'text',
                'label' => __('Título da seção', 'lula'),
                'default' => 'Nosso canal de vídeos'
            ],
            'description' => [
                'type' => 'text',
                'label' => __('Descrição da seção', 'lula'),
            ],
            'button_href' => [
                'type' => 'link',
                'sanitize' => 'url',
                'label' => __('Link do botão "ver mais vídeos"', 'lula'),
            ],
            'button_external_link' => [
                'type' => 'checkbox',
                'label' => 'Link externo',
                'description' => __('O link do botão deve abrir numa nova aba', 'lula'),
                'default' => FALSE,
            ],
            'youtube_api_key' => [
                'type' => 'text',
                'label' => __('Chave da API do YouTube', 'lula'),
            ],
            'youtube_list' => [
                'type' => 'select',
                'label' => 'Tipo de lista do YouTube',
                'default' => 'channel',
                'options' => [
                    'channel' => __('Canal', 'lula'),
                    'playlist' => __('Playlist', 'lula'),
                ]
            ],
            'youtube_list_id' => [
                'type' => 'text',
                'label' => __('ID da lista (canal ou playlist)', 'lula'),
            ],

            'youtube_channel_id' => [
                'type' => 'text',
                'label' => __('ID do canal', 'lula'),
            ],
        ];

        parent::__construct('youtube-channel', 'Canal do YouTube', [
            'panels_groups' => [WIDGETGROUP_MAIN],
            'description' => 'Adiciona uma seção com vídeos do canal do YouTube'
                ], [], $fields, plugin_dir_path(__FILE__)
        );

        wp_enqueue_script( 'youtube-plataform', 'https://apis.google.com/js/platform.js' );
    }

    function get_template_name($instance) {
        return 'template';
    }

    function get_style_name($instance) {
        return 'style';
    }

}

Siteorigin_widget_register('youtube-channel', __FILE__, 'widgets\YoutubeChannel');

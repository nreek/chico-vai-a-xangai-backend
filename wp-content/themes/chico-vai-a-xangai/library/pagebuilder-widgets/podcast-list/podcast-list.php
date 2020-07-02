<?php

/*
  Widget Name: Lista de Episódios de Podcast
  Description: Lista de Episódios de Podcast
  Author: Smart Fit
  Author URI: https://smartfit.com.br/conteudo
 */

namespace widgets;

class PodcastList extends \SiteOrigin_Widget {

    function __construct() {
        $fields = [
            'podcast_url' => [
                'type' => 'link',
                'label' => 'URL do RSS do Podcast',
                'default' => 'https://anchor.fm/s/100b9ec8/podcast/rss'
            ],
        ];

        parent::__construct('podcast-list', 'Lista de Episódios de Podcast', [
            'panels_groups' => [WIDGETGROUP_BANNERS],
            'description' => 'Componente de Lista de Episódios de Podcast'
        ], [], $fields, plugin_dir_path(__FILE__));
    }

    function get_template_name($instance) {
        return 'template';
    }

    function get_style_name($instance) {
        return 'style';
    }

}

Siteorigin_widget_register('podcast-list', __FILE__, 'widgets\PodcastList');

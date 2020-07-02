<?php

/*
  Widget Name: Banner Genérico
  Description: Banner Genérico
  Author: Smart Fit
  Author URI: https://Smart Fiteducacaofisica.com.br
 */

namespace widgets;

class Banner extends \SiteOrigin_Widget {

    function __construct() {
        $fields = [
            'title' => [
                'type' => 'text',
                'label' => 'Título',
            ],
            'text' => [
                'type' => 'tinymce',
                'label' => 'Conteúdo',
            ],
            'align' => [
                'type' => 'select',
                'label' => 'Alinhamento do texto',
                'options' => [
                    'left' => 'À direita',
                    'center' => 'Centro'
                ]
            ],
            'image' => [
                'type' => 'media',
                'label' => 'Imagem de Fundo',
                'description' => '(Opcional)'
            ],
            'button_text' => [
                'type' => 'text',
                'label' => 'Texto do Botão',
                'description' => '(Opcional)'
            ],
            'button_url' => [
                'type' => 'link',
                'label' => 'Link do Botão',
                'description' => '(Opcional)'
            ],
        ];

        parent::__construct('banner', 'Banner Genérico', [
            'panels_groups' => [WIDGETGROUP_BANNERS],
            'description' => 'Componente de Banner Genérico'
        ], [], $fields, plugin_dir_path(__FILE__));
    }

    function get_template_name($instance) {
        return 'template';
    }

    function get_style_name($instance) {
        return 'style';
    }

}

Siteorigin_widget_register('banner', __FILE__, 'widgets\Banner');

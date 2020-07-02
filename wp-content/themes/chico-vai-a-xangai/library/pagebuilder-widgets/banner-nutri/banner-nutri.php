<?php

/*
  Widget Name: Banner de Smart Nutri
  Description: Banner de Smart Nutri
  Author: Smart Fit
  Author URI: https://smartfit.com.br/conteudo
 */

namespace widgets;

class BannerNutri extends \SiteOrigin_Widget {

    function __construct() {
        $fields = [
            'title' => [
                'type' => 'text',
                'label' => 'Título Esquerdo',
                'default' => 'Tá descontando a ansiedade na comida?'
            ],
            'description' => [
                'type' => 'text',
                'label' => 'Descrição Esquerda',
                'default' => 'A gente tem como ajudar!'
            ],
            'title_right' => [
                'type' => 'text',
                'label' => 'Título Direito',
                'default' => 'Consulta online com nutricionista'
            ],
            'benefits' => [
                'type' => 'text',
                'label' => 'Benefícios (separados por ponto-e-vírgula!)',
                'default' => '+ Cardápio personalizado;+ Chat para dúvidas diárias;+ Avaliação do seu prato'
            ],
            'button_text' => [
                'type' => 'text',
                'label' => 'Texto do Botão',
                'default' => 'Teste por 7 dias grátis'
            ],
            'button_url' => [
                'type' => 'text',
                'label' => 'Link do botão',
            ],
            'image' => [
                'type' => 'media',
                'label' => 'Imagem',
            ],
        ];

        parent::__construct('banner-nutri', 'Banner de Smart Nutri', [
            'panels_groups' => [WIDGETGROUP_BANNERS],
            'description' => 'Componente de Banner de Smart Nutri'
        ], [], $fields, plugin_dir_path(__FILE__));
    }

    function get_template_name($instance) {
        return 'template';
    }

    function get_style_name($instance) {
        return 'style';
    }

}

Siteorigin_widget_register('banner-nutri', __FILE__, 'widgets\BannerNutri');

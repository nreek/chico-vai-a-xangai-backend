<?php
@ini_set('upload_max_size', '64M');
@ini_set('post_max_size', '64M');
@ini_set('max_execution_time', '300');

add_theme_support('align-wide');
add_theme_support('custom-logo');

add_theme_support('align-wide');
add_theme_support('post-thumbnails');
add_post_type_support('page', 'excerpt');

function custom_menus()
{
    register_nav_menu('main-menu', __('Menu Principal'));
    register_nav_menu('social-networks', __('Redes Sociais'));
}
add_action('init', 'custom_menus');

function dd($var)
{
    var_dump($var);
    die;
}

include __DIR__ . '/library/wp_wrapper/bootstrap.php';

require __DIR__ . '/library/images.php';
require __DIR__ . '/library/templates.php';
require __DIR__ . '/library/pagebuilder.php';
require __DIR__ . '/library/post_types.php';
require __DIR__ . '/library/metaboxes.php';
require __DIR__ . '/library/taxonomies.php';
require __DIR__ . '/library/api.php';

require_once 'JAMStack/JAMStack.php';
require_once 'JAMStack/Utils.php';
require_once 'JAMStack/interfaces/IContentGenerator.php';
require_once 'JAMStack/generators/ContentGenerator.php';
require_once 'JAMStack/generators/ListGenerator.php';

$pb_scripts = [];
$jamstack = new JAMStack();

/*
* * * Globally set page builder component's data
*/
function localize_scripts($object_name, $hash, $l10n)
{
    global $pb_scripts;

    foreach ((array) $l10n as $key => $value) {
        if (!is_scalar($value)) {
            continue;
        }

        $l10n[$key] = html_entity_decode((string) $value, ENT_QUOTES, 'UTF-8');
    }

    $pb_scripts[$object_name][$hash] = $l10n;
}

function replace_home_url($url)
{
    if (strpos($url, get_home_url()) > -1) {
        $url = str_replace('category', 'categoria', $url);
        return str_replace('index.php/', '', str_replace(get_home_url(), '', $url));
    }

    return str_replace('index.php/', '', $url);
}

function issetOrDefault($var, $default)
{
    $val = isset($var) ? $var : $default;

    return is_array($val) ? $val[0] : $val;
}

// function disable_wp_auto_p( $content ) {
//     remove_filter( 'the_content', 'wpautop' );
//     remove_filter( 'the_excerpt', 'wpautop' );
//     return $content;
//   }
//   add_filter( 'the_content', 'disable_wp_auto_p', 0 );


add_action('add_meta_boxes', 'film_meta_box_add');
function film_meta_box_add()
{
    add_meta_box('my-meta-box-id', 'Buscar informações na API', 'film_meta_box_film', 'film', 'normal', 'high');
}

//FORMULARIO PARA SALVAS OS DADOS
function film_meta_box_film()
{
    wp_nonce_field('my_meta_box_nonce', 'meta_box_nonce');
?>
    <p>
        <label for="texto_meta_box">Nome do filme (em inglês)</label>
        <input type="text" name="texto_meta_box" id="texto_meta_box" />
        <button class="is-button is-primary components-button" onclick="fetchApi()">Buscar</button>
        <a href="javascript:void(0);" onclick="clearFilmsHtml()">Limpar resultados</a>
        <div id="movie_results"></div>

        <style>
            #movie_results { 
                display: flex; 
                flex-wrap: wrap; 
            }

            .film {
                text-align: center;
                cursor: pointer;
                display: flex;
                flex-direction: column;
                margin-right: 15px;
            }

            .film-poster {
                border: 1px solid black;
                border-radius: 5px;
                margin: 0 auto 10px auto;
                width: 120px;
            }
        </style>

        <script>
            function setFilm(imdbID) {
                fetch(`http://www.omdbapi.com/?i=${imdbID}&apikey=4a4da14b`)
                .then( response => {
                    response.json().then( data => {
                        document.querySelector('.editor-post-title__input').value = data.Title
                    })
                })
            }

            function clearFilmsHtml(){
                let $results = document.getElementById('movie_results');
                $results.innerHTML = '';
            }

            function fetchApi(){
                let q = document.getElementById('texto_meta_box').value;
                let $results = document.getElementById('movie_results');
                $results.innerHTML = '';

                fetch(`http://www.omdbapi.com/?s=${q}&apikey=4a4da14b`)
                .then( response => {
                    response.json().then( data => {
                        if(data.Response) {
                            data.Search.map(result => {
                                $results.innerHTML += `
                                <div class="film" onclick="setFilm('${result.imdbID}')">
                                    <img src="${result.Poster}" alt="" class="film-poster">
                                    <strong>${result.Title}</strong> (${result.Year})
                                </div>
                                `
                            })
                        } else {
                            $results.innerHTML = '<h4>Filme não encontrado</h4>'
                        }
                        
                    })
                })
            }
        </script>
    </p>
<?php
}

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
            function addContent(type, title, el) {
                console.log(type, title)

                let form = new FormData();
                form.append('type', type)
                form.append('title', title)

                fetch('/wp-json/chico/v1/admin_add', {
                    method : 'POST',
                    body : form 
                }).then(response => response.json())
                .then(data => {
                    if(data.post) {
                        console.log(el)
                        el.style.display = 'none'
                    }
                })
            }

            function setFilm(imdbID) {
                fetch(`http://www.omdbapi.com/?i=${imdbID}&apikey=4a4da14b`)
                .then( response => {
                    clearFilmsHtml();

                    response.json().then( data => {
                        let { Title, Runtime, Year, Language, Production } = data;

                        document.querySelector('.editor-post-title__input').value = Title
                        document.querySelector('#length').value = Runtime
                        document.querySelector('#year').value = Year
                        document.querySelector('#language').value = Language
                        document.querySelector('#production').value = Production

                        let $results = document.getElementById('movie_results');
                        $results.innerHTML = `
                            <div style='display: flex; align-items: flex-start; font-size: 0'>
                                <a href='${data.Poster}' target="_blank" download><img src="${data.Poster}" style="margin-right: 15px;max-width: 200px;border-radius: 10px;border: 1px solid black;"></a>
                                <div style="column-count: 3; column-gap: 20px">
                                    ${ Object.keys(data).map(key => {
                                        if(key != 'Poster' && key != 'Ratings'){
                                            return (['Director', 'Writer', 'Actors']).indexOf(key) == -1 ? 
                                                `<p style="margin-bottom: 0"><strong>${ key }</strong>: ${ data[key] }</p>` :
                                                `<p style="margin-bottom: 0; font-weight: bold">${key}:</p>
                                                ${data[key].split(',').map(p => {
                                                    if(p != 'N/A')
                                                        return `
                                                        <div style="text: center; font-size: 13px; margin-bottom: 5px;">
                                                            <span>${p.replace(/ *\([^)]*\) */g, "")}</span>
                                                            <a onclick="addContent('person', '${p.replace(/ *\([^)]*\) */g, "")}', this)" style="background: #efefef;text-decoration: none;border-radius: 5px;padding: 2px 10px;text-transform: uppercase;font-size: 10px;border: 1px solid;" href='javascript:void(0);'>Cadastrar</a>
                                                        </div>`
                                                })}`
                                        }
                                    }) }
                                </div>
                            </div>
                        `;
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

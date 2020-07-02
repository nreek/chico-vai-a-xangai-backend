<?php 

class Nav_menu_item extends ContentGenerator {
    public $menus = [];

    function save_post() {
        $nav_menus = wp_get_nav_menus(); 
        $menus = [];

        foreach ($nav_menus as $menu){
            $nav_items = wp_get_nav_menu_items($menu);
            $menus[$menu->slug] = [
                'ID' => $menu->term_id,
                'name' => $menu->name,
                'slug' => $menu->slug,
                'parent' => $menu->parent, 
                'items' => $menu->term_id == $_REQUEST['menu'] ? $this->prepare_updated_menu() : $this->prepare_menu($menu, $nav_items),
            ];
        }

        $this->menus = $menus;
        $this->generate_json();
    }

    function prepare_updated_menu(){
        $request_items = ($_REQUEST['menu-item-type']);
        $items = [];

        foreach( $request_items as $request_id => $type ){
            $url = isset($_REQUEST['menu-item-url'][$request_id]) ? $_REQUEST['menu-item-url'][$request_id] : get_the_permalink($_REQUEST['menu-item-object-id'][$request_id]);
            

            $items[] = [
                'ID' => $request_id,
                'title' => $_REQUEST['menu-item-title'][$request_id],
                'permalink' => replace_home_url($url),
                'type' => $type,
                'slug' =>  sanitize_title($_REQUEST['menu-item-title'][$request_id]),
                'order' => $_REQUEST['menu-item-position'][$request_id],
                'parent' => $_REQUEST['menu-item-parent-id'][$request_id],
            ];
        }

        return $items;
    }

    function prepare_menu($menu, $nav_items){
        $items = [];

        
        foreach($nav_items as $item){
            $items[] = [
                'ID' => $item->ID,
                'title' => $item->title,
                'permalink' => replace_home_url($item->url),
                'object' => $item->object,
                'type' => $item->type,
                'slug' => $item->post_name,
                'order' => $item->menu_order,
                'parent' => $item->menu_item_parent
            ];
        }

        return $items;
    }

    function generate_json(){
        $filepath = WP_CONTENT_DIR . '/data/menus.json';

        file_put_contents($filepath, json_encode($this->menus));
    }
}
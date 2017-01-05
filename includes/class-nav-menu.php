<?php
/**
 * Moves the nav-menu out of the Appearance tab. We don't need clients in there.
 */
class AnunaPress_NavMenu {

    /**
     * Hook everything up
     * @return void
     */
    public static function init() {
        add_action('admin_menu', array(__CLASS__, 'move_menu'));
        add_action('parent_file', array(__CLASS__, 'menu_parent_file'));
        add_action('user_has_cap', array(__CLASS__, 'has_cap'), 20, 4);
    }

    /**
     * Move the nav-menu to become a top-level page
     * @return void
     */
    public static function move_menu() {
        global $submenu, $menu;

        if(isset($submenu['themes.php'])) {

            foreach($submenu['themes.php'] as $key => $item) {
                if($item[2] === 'nav-menus.php') {
                    unset($submenu['themes.php'][$key]);
                }
            }
        }

        $user = wp_get_current_user();

        if(in_array('editor', $user->roles)) {
            unset($menu[60]);
        }


        add_menu_page( __('Menus'), __('Menus'), 'delete_others_pages', 'nav-menus.php', '', 'dashicons-list-view', 61 );
    }

    /**
     * Change which file is the parent
     * @param  string $parent_file
     * @return string
     */
    public static function menu_parent_file($parent_file) {
        global $current_screen;

        // Set correct active/current menu and submenu in the WordPress Admin menu for the "example_cpt" Add-New/Edit/List
        if($current_screen->base == 'nav-menus') {
            $parent_file = 'nav-menus.php';
        }

        return $parent_file;
    }

    /**
     * Makes sure the editor had the correct caps
     * @param  array  $caps
     * @param  string  $cap
     * @param  array  $args
     * @param  WP_User  $user
     * @return boolean
     */
    public static function has_cap($caps, $cap, $args, $user) {
        $url = $_SERVER['REQUEST_URI'];

        if(strpos($url, 'nav-menus.php') !== false && in_array('edit_theme_options', $cap) && in_array('editor', $user->roles)) {
            $caps['edit_theme_options'] = true;
        }
        return $caps;
    }
}

AnunaPress_NavMenu::init();

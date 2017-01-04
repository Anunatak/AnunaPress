<?php

class AnunaPress_Public {

    public static function init() {
        add_action( 'after_theme_setup', array(__CLASS__, 'prepare_theme') );
    }

}

AnunaPress_Public::init();

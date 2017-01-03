<?php
/**
 * Modifies emails
 */
class AnunaPress_Mail {

    /**
     * Initialize the modifications
     * @return void
     */
    public static function init() {
        add_filter('wp_mail_from', array(__CLASS__, 'from'));
        add_filter('wp_mail_from_name', array(__CLASS__, 'from_name'));
    }

    /**
     * Sets a from-email based on the current website domain
     * @param  string $from
     * @return string
     */
    public static function from($from) {
        return apply_filters('anunapress_mail_from', 'no-reply@' . AnunaPress()->helpers->get_domain());
    }

    /**
     * Sets the from name to the blog name
     * @param  string $from_name
     * @return string
     */
    public static function from_name($from_name) {
        return apply_filters('anunapress_mail_from_name', get_bloginfo( 'name' ));
    }

}

AnunaPress_Mail::init();

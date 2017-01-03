<?php
/**
 * A set of neat helper functions within the AnunaPress plugin
 *
 * Can be called using AnunaPress()->helpers->function_name()
 */
class AnunaPress_Helpers {

    /**
     * Gets the domain name of the current website
     * @return string
     */
    public function get_domain() {
        $domain = str_replace(['http://', '/'], '', home_url('', 'http'));
        return $domain;
    }
}

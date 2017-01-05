<?php

/**
 * Performs updates against the Github repo
 */
class AnunaPress_Update {

    protected $updater = null;

    public function __construct() {
        require 'vendor/plugin-update-checker/plugin-update-checker.php';
        $className = PucFactory::getLatestClassVersion('PucGitHubChecker');
        $this->updater = new $className(
            'https://github.com/Anunatak/anunapress/',
            ANUNAPRESS_FILE,
            'master'
        );

        if(is_admin() && isset($_REQUEST['anunapress_force_update_check'])) {
            $this->updater->checkForUpdates();
        }
    }

    public function getUpdater() {
        return $this->updater;
    }

}

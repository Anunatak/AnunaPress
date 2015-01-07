<?php

/**
 * Enables plugin updates
 *
 * @link       https://github.com/Anunatak/AnunaPress
 * @since      1.0.0
 *
 * @package    Anunapress
 * @subpackage Anunapress/includes
 */

/**
 * Enables plugin updates
 *
 * This class enables updates through the the GitHub repository
 *
 * @since      1.0.0
 * @package    Anunapress
 * @subpackage Anunapress/includes
 * @author     Tor Morten Jensen <tormorten@anunatak.no>
 */
class Anunapress_Update {

	/**
	 * Initiates the update process
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function init( $file ) {

		include_once 'update/updater.php';

		defined( 'WP_GITHUB_FORCE_UPDATE' ) || define( 'WP_GITHUB_FORCE_UPDATE', true );

		if ( is_admin() ) { // note the use of is_admin() to double check that this is happening in the admin

			$config = array(
				'slug' => plugin_basename( $file ),
				'proper_folder_name' => 'anunapress',
				'api_url' => 'https://api.github.com/repos/Anunatak/AnunaPress',
				'raw_url' => 'https://raw.github.com/Anunatak/AnunaPress/master',
				'github_url' => 'https://github.com/Anunatak/AnunaPress',
				'zip_url' => 'https://github.com/Anunatak/AnunaPress/archive/master.zip',
				'sslverify' => true,
				'requires' => '4.1',
				'tested' => '4.1',
				'readme' => 'README.md',
				'access_token' => '',
			);

			new WP_GitHub_Updater( $config );

		}

	}

}

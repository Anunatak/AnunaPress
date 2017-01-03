<?php
/**
 * Cleans up the dashboard and adds som widgets
 */
class AnunaPress_Dashboard {

    /**
     * Initialize the cleanup process
     * @return void
     */
    public static function init() {
        // remove unwanted widgets and add custom ones
        add_action('wp_dashboard_setup', array(__CLASS__, 'dashboard_setup'));

        // remove welcome and add a custom one
        remove_action('welcome_panel', 'wp_welcome_panel');
        add_action('welcome_panel', array(__CLASS__, 'welcome_panel'));

        // add a script to the dashboard
        add_action('admin_enqueue_scripts', array(__CLASS__, 'script'));

        // add ajax action for sending email
        add_action('wp_ajax_anunapress_contact_us', array(__CLASS__, 'contact_submit'));

    }

    /**
     * Handle form submission
     * @return void
     */
    public static function contact_submit() {
        $email = $_REQUEST['email'];
        $name = $_REQUEST['name'];
        $text = $_REQUEST['text'];

        if(!is_email( $email )) {
            wp_send_json_error( __('This is not a valid email address', 'anunapress') );
        }

        $to = 'web@anunatak.no';
        $subject = sprintf( __( '[%s]: Enquiry from %s', 'anunapress' ), AnunaPress()->helpers->get_domain(), $name);

        $message = sprintf( __('%s submitted an enquiry from their WordPress dashboard.', 'anunapress'), $name ) . "\n\n";
        $message .= 'Site URL :'. home_url() . "\n\n";
        $message .= "Enquiry: \n $text";

        $headers = array(
            'Reply-To: '.$name.' <'.$email.'>'
        );

        wp_mail( $to, $subject, $message, $headers );

        wp_send_json_success( __('Thank you for your enquiry. It has been submitted to our web team, and we will respond shortly.', 'anunapress') );
    }

    /**
     * Enqueues a script on the dashboard page
     * @param  string $hook
     * @return void
     */
    public static function script($hook) {
        if($hook === 'index.php') {
            wp_enqueue_script( 'anunapress/dashboard', plugins_url( 'assets/js/dashboard.js', ANUNAPRESS_FILE ), array('jquery'), AnunaPress()->version );
        }
    }

    /**
     * Organizes the dashboard and gets rid of core widgets
     * @return void
     */
    public static function dashboard_setup() {
        global $wp_meta_boxes;

        // remove unwanted
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);

        // add custom metabox
        wp_add_dashboard_widget('contact_anunatak_widget', __('Contact Anunatak', 'anunapress'), array(__CLASS__, 'dashboard_widget'));
    }

    /**
     * Prints the contact form
     * @return void
     */
    public static function dashboard_widget() {
        $user = wp_get_current_user();
        ?>
        <div id="contact-anunatak-form">
        <p><?php _e('If you have any questions regarding this website, please contact us via this form.', 'anunapress') ?></p>
        <div id="error"></div>
        <form action="" method="POST">
            <p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="contact_name"><?php _e('Your Name', 'anunapress') ?> <span class="required">*</span></label></p>
            <input type="text" class="widefat" id="contact_name" name="contact_name" value="<?php echo $user->user_firstname .' ' .$user->user_lastname ?>">

            <p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="contact_email"><?php _e('Your Email', 'anunapress') ?> <span class="required">*</span></label></p>
            <input type="text" class="widefat" id="contact_email" name="contact_email" value="<?php echo $user->user_email ?>">

            <p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="contact_text"><?php _e('Question/Enquiry', 'anunapress') ?> <span class="required">*</span></label></p>
            <textarea class="widefat" rows="5" id="contact_text" name="contact_text" style="margin-bottom:1em"></textarea>

            <?php submit_button( __('Submit', 'anunapress') ) ?>
        </form>
        </div>
        <?php
    }

    /**
     * Prints the welcome panel
     * @return void
     */
    public static function welcome_panel() {
        ?>
        <div class="welcome-panel-content">
        <h2><?php _e( 'Welcome to WordPress from Anunatak!', 'anunapress' ); ?></h2>
        <p class="about-description"><?php _e( 'Anunatak builds all sites on the WordPress platform. WordPress is used by 25% of websites in the world that have a known publishing platform.', 'anunapress' ); ?></p>
        <div class="welcome-panel-column-container">
        <div class="welcome-panel-column">
            <h3><?php _e( 'Contact Anunatak', 'anunapress' ); ?></h3>
            <p><?php _e('If you have any questions about your website, do not hesitate to contact Anunatak. You can use the form below to send your enquiry.', 'anunapress') ?></p>
        </div>
        <div class="welcome-panel-column">
            <h3><?php _e( 'What do I do now?' ); ?></h3>
            <ul>
                <li><?php printf( '<a href="%s" class="welcome-icon welcome-write-blog">' . __( 'Edit your pages', 'anunapress' ) . '</a>', admin_url( 'edit.php?post_type=page' ) ); ?></li>
                <li><?php printf( '<a href="%s" class="welcome-icon welcome-view-site">' . __( 'View your site' ) . '</a>', home_url( '/' ) ); ?></li>
            </ul>
        </div>
        <div class="welcome-panel-column welcome-panel-last">
            <h3><?php _e( 'Get Help' ); ?></h3>
            <p><?php _e('WordPress is thoroughly documented through its codex, and help can be found simply by Googling it.', 'anunapress') ?></p>
            <ul>
                <li><?php printf( '<a href="%s" class="welcome-icon welcome-widgets-menus">' . __( 'Contact Anunatak', 'anunapress' ) . '</a>', '#contact_anunatak_widget' ); ?></li>
                <li><?php printf( '<a href="%s" class="welcome-icon welcome-view-site" target="_blank">' . __( 'Find your contact person', 'anunapress' ) . '</a>', __( 'https://anunatak.no/ansatte/' ) ); ?></li>
                <li><?php printf( '<a href="%s" class="welcome-icon welcome-learn-more" target="_blank">' . __( 'Learn more about getting started' ) . '</a>', __( 'https://codex.wordpress.org/First_Steps_With_WordPress' ) ); ?></li>
            </ul>
        </div>
        </div>
        </div>
        <?php

    }

}

AnunaPress_Dashboard::init();

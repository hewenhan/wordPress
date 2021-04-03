<?php
/**
 * Admin Setup Class
 *
 * Setup Agama backend.
 *
 * @since 1.0.0
 */

namespace Agama\Admin;

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Setup {
    
    /**
     * Instance
     *
	 * Single instance of this object.
	 *
	 * @since 1.0.0
	 * @access public
	 * @var null|object
	 */
	public static $instance = null;
    
    /**
     * Get Instance
     *
	 * Access the single instance of this class.
	 *
     * @since 1.0.0
     * @access public
	 * @return object
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
    
    /**
     * Class Constructor
     */
    function __construct() {
        
        add_action( 'tgmpa_register', [ $this, 'tgmpa_register' ] );
        
        $this->get_template_parts();
        
    }
    
    /**
     * Admin Notices
     *
     * The Agama admin notices.
     *
     * @since 1.4.52
     * @access public
     * @return mixed
     */
    public function admin_notices() {}
    
    /**
     * Register the required plugins for this theme.
     *
     * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
     *
     * @since 1.3.5
     */
    function tgmpa_register() {

        /**
         * Array of plugin arrays. Required keys are name and slug.
         * If the source is NOT from the .org repo, then source is also required.
         */
        $plugins = [
            [
                'name'              => 'Elementor',
                'slug'              => 'elementor',
                'required'          => false,
                'force_activation'  => false
            ]
        ];

        /**
         * If Elementor plugin active let's suggest a Gold Addons
         * for Elementor plugin.
         */
        if( is_plugin_active( 'elementor/elementor.php' ) ) {
            $additional = [
                [
                    'name'              => 'Gold Addons for Elementor',
                    'slug'              => 'gold-addons-for-elementor',
                    'required'          => false,
                    'force_activation'  => false
                ]
            ];

            $plugins = array_merge( $plugins, $additional );
        }

        /*
         * Array of configuration settings. Amend each line as needed.
         *
         * TGMPA will start providing localized text strings soon. If you already have translations of our standard
         * strings available, please help us make TGMPA even better by giving us access to these translations or by
         * sending in a pull-request with .po file(s) with the translations.
         *
         * Only uncomment the strings in the config array if you want to customize the strings.
         */
        $config = [
            'id'           => 'agama',                 // Unique ID for hashing notices for multiple instances of TGMPA.
            'default_path' => '',                      // Default absolute path to bundled plugins.
            'menu'         => 'tgmpa-install-plugins', // Menu slug.
            'has_notices'  => true,                    // Show admin notices or not.
            'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
            'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
            'is_automatic' => false,                   // Automatically activate plugins after installation or not.
            'message'      => '',                      // Message to output right before the plugins table.
            'strings'      => [
                'page_title'                      => esc_html__( 'Install Required Plugins', 'agama' ),
                'menu_title'                      => esc_html__( 'Install Plugins', 'agama' ),
                'installing'                      => esc_html__( 'Installing Plugin: %s', 'agama' ),
                'updating'                        => esc_html__( 'Updating Plugin: %s', 'agama' ),
                'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'agama' ),
                'notice_can_install_required'     => _n_noop(
                    'This theme requires the following plugin: %1$s.',
                    'This theme requires the following plugins: %1$s.',
                    'agama'
                ),
                'notice_can_install_recommended'  => _n_noop(
                    'This theme recommends the following plugin: %1$s.',
                    'This theme recommends the following plugins: %1$s.',
                    'agama'
                ),
                'notice_ask_to_update'            => _n_noop(
                    'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
                    'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
                    'agama'
                ),
                'notice_ask_to_update_maybe'      => _n_noop(
                    'There is an update available for: %1$s.',
                    'There are updates available for the following plugins: %1$s.',
                    'agama'
                ),
                'notice_can_activate_required'    => _n_noop(
                    'The following required plugin is currently inactive: %1$s.',
                    'The following required plugins are currently inactive: %1$s.',
                    'agama'
                ),
                'notice_can_activate_recommended' => _n_noop(
                    'The following recommended plugin is currently inactive: %1$s.',
                    'The following recommended plugins are currently inactive: %1$s.',
                    'agama'
                ),
                'install_link'                    => _n_noop(
                    'Begin installing plugin',
                    'Begin installing plugins',
                    'agama'
                ),
                'update_link' 					  => _n_noop(
                    'Begin updating plugin',
                    'Begin updating plugins',
                    'agama'
                ),
                'activate_link'                   => _n_noop(
                    'Begin activating plugin',
                    'Begin activating plugins',
                    'agama'
                ),
                'return'                          => __( 'Return to Required Plugins Installer', 'agama' ),
                'plugin_activated'                => __( 'Plugin activated successfully.', 'agama' ),
                'activated_successfully'          => __( 'The following plugin was activated successfully:', 'agama' ),
                'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'agama' ),
                'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'agama' ),
                'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'agama' ),
                'dismiss'                         => __( 'Dismiss this notice', 'agama' ),
                'notice_cannot_install_activate'  => __( 'There are one or more required or recommended plugins to install, update or activate.', 'agama' ),
                'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'agama' ),

                'nag_type'                        => '', // Determines admin notice type - can only be one of the typical WP notice classes, such as 'updated', 'update-nag', 'notice-warning', 'notice-info' or 'error'. Some of which may not work as expected in older WP versions.
            ]
        ];

        tgmpa( $plugins, $config );
    }
    
    /**
     * Get Template Part
     *
     * Include all template parts for backend.
     *
     * @since 1.0.0
     * @access private
     * @return void
     */
    private function get_template_parts() {
        if ( is_admin() ) {
            get_template_part( 'framework/admin/class-plugin-activation' );
            get_template_part( 'framework/admin/class-menu' );
        }
        
        get_template_part( 'framework/admin/class-animate' );
        get_template_part( 'framework/admin/kirki/kirki' );
        get_template_part( 'framework/admin/customizer' );
    }
    
}

Setup::get_instance();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */

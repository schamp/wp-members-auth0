<?php
/**
 * Plugin Name: WP-Members / Auth0 Integration Plugin 
 * Description: Integrate WP-Members plugin 'admin approval required' feature with Auth0 login flow
 * Version: 1.0.0
 * Author: Capstone Performance Systems
 * Author URI: https://www.capstoneperformancesystems.com
 */

define( 'WPMA0P_PLUGIN_FILE', __FILE__ );
define( 'WPMA0P_PLUGIN_DIR',  trailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'WPMA0P_PLUGIN_URL',  trailingslashit( plugin_dir_url( __FILE__ ) ) );

/**
 * Main plugin class
 */
class WP_Members_Auth0_Plugin {

    public function init() {
        add_action( 'auth0_before_login', array( $this, 'check_user_activated' ), 1);
    }

    public function check_user_activated( $user ) {
        $settings = get_option( 'wpmembers_settings' );

        if ( $settings['mod_reg'] == 1 ) {
            $user_active_flag = get_user_meta( $user->ID, 'active', true );
            if ( $user_active_flag != 1 ) {
                throw new Exception(" - your account must be activated by an administrator.");
            }
        }
    }

}

$wpma0_plugin = new WP_Members_Auth0_Plugin();
$wpma0_plugin->init();


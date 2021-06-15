<?php

namespace SovereignStack\SecuritySafe;

// Prevent Direct Access
defined( 'ABSPATH' ) || die;
/**
 * Class Security
 *
 * @package SecuritySafe
 * @todo Add @since version
 */
class Security extends Plugin
{
    /**
     * Logged In Status
     * @var boolean
     */
    public  $logged_in = false ;
    /**
     * Is the current IP allowed?
     * @var bool
     * @since  2.0.0
     */
    public  $whitelisted = false ;
    /**
     * Is the current IP blacklisted?
     * @var bool
     * @since  2.0.0
     */
    public  $blacklisted = false ;
    /**
     * @var string
     */
    public  $date_expires = false ;
    /**
     * Detect whether a login error has occurred
     * @var boolean
     */
    public  $login_error = false ;
    /**
     * List of all policies running.
     * @var array
     * @todo Add @since version
     */
    protected  $policies ;
    /**
     * Security constructor
     *
     * @param $session array
     *
     * @todo Add @since version
     */
    function __construct( $session )
    {
        // Run parent class constructor first
        parent::__construct( $session );
    }
    
    /**
     * Start Security policies after the instance is created
     */
    function start_security()
    {
        //Janitor::log( 'running Security.php' );
        
        if ( isset( $this->settings['general']['on'] ) && $this->settings['general']['on'] == '1' ) {
            // Run All Policies
            $this->access();
            $this->privacy();
            $this->files();
            $this->content();
        }
    
    }
    
    /**
     * Access Policies
     *
     * @since  0.2.0
     */
    private function access()
    {
        //Janitor::log( 'running access().' );
        $settings = $this->settings['access'];
        
        if ( $settings['on'] == "1" ) {
            // Disable xmlrpc.php
            $this->add_firewall_policy( $settings, 'PolicyXMLRPC', 'xml_rpc' );
            // Check only if not logged in
            
            if ( !$this->logged_in ) {
                $firewall = new Firewall();
                // Determine Allowed / Denied
                
                if ( $firewall->is_whitelisted() ) {
                    $this->whitelisted = true;
                } else {
                    //Janitor::log( 'Not Whitelisted' );
                    if ( $firewall->is_blacklisted() ) {
                        $this->blacklisted = true;
                    }
                }
            
            }
            
            // Generic Login Errors
            $this->add_policy( $settings, 'PolicyLoginErrors', 'login_errors' );
            // Disable Login Password Reset
            $this->add_policy( $settings, 'PolicyLoginPasswordReset', 'login_password_reset' );
            // Disable Login Remember Me Checkbox
            $this->add_policy( $settings, 'PolicyLoginRememberMe', 'login_remember_me' );
            // Log Logins
            $this->add_firewall_policy( [], 'PolicyLogLogins' );
        }
    
    }
    
    /**
     * Runs specified firewall policy class then adds it to the policies list.
     *
     * @param $settings array
     * @param $policy string Name of security policy
     * @param $slug string Setting slug associated with policy
     * @param $plan string Used to distinguish premium files
     *
     * @since  2.0.0
     */
    private function add_firewall_policy(
        $settings,
        $policy,
        $slug = '',
        $plan = ''
    )
    {
        //Janitor::log( 'add policy().' );
        // Include Specific Policy
        require_once SECSAFE_DIR_FIREWALL . '/' . $policy . $plan . '.php';
        //Janitor::log( 'add policy ' . $policy );
        $policy = __NAMESPACE__ . '\\' . $policy;
        
        if ( isset( $settings[$slug] ) ) {
            // Pass setting value
            new $policy( $settings[$slug] );
        } else {
            new $policy();
        }
        
        $this->policies[] = $policy;
        //Janitor::log( $policy );
    }
    
    /**
     * Runs specified policy class then adds it to the policies list.
     *
     * @param $settings array
     * @param $policy string Name of security policy
     * @param $slug string Setting slug associated with policy
     * @param $plan string Used to distinguish premium files
     *
     * @since  0.2.0
     */
    private function add_policy(
        $settings,
        $policy,
        $slug = '',
        $plan = ''
    )
    {
        //Janitor::log( 'add policy().' );
        
        if ( $slug == '' || isset( $settings[$slug] ) && $settings[$slug] ) {
            // Include Specific Policy
            require_once SECSAFE_DIR_PRIVACY . '/' . $policy . $plan . '.php';
            //Janitor::log( 'add policy ' . $policy );
            $policy = __NAMESPACE__ . '\\' . $policy;
            new $policy();
            $this->policies[] = $policy;
            //Janitor::log( $policy );
        }
    
    }
    
    /**
     * Privacy Policies
     *
     * @since  0.2.0
     */
    private function privacy()
    {
        //Janitor::log( 'running privacy().' );
        $settings = $this->settings['privacy'];
        
        if ( $settings['on'] == "1" ) {
            // Hide WordPress Version
            $this->add_policy( $settings, 'PolicyHideWPVersion', 'wp_generator' );
            if ( is_admin() ) {
                // Hide WordPress Version Admin Footer
                $this->add_policy( $settings, 'PolicyHideWPVersionAdmin', 'wp_version_admin_footer' );
            }
            // Hide Script Versions
            $this->add_policy( $settings, 'PolicyHideScriptVersions', 'hide_script_versions' );
            // Make Website Anonymous
            $this->add_policy( $settings, 'PolicyAnonymousWebsite', 'http_headers_useragent' );
        }
    
    }
    
    /**
     * File Policies
     *
     * @since  0.2.0
     */
    private function files()
    {
        //Janitor::log( 'running files().' );
        global  $wp_version ;
        $settings = $this->settings['files'];
        
        if ( $settings['on'] == '1' ) {
            // Disallow Theme File Editing
            $this->add_constant_policy( $settings, 'PolicyDisallowFileEdit', 'DISALLOW_FILE_EDIT' );
            // Protect WordPress Version Files
            $this->add_policy( $settings, 'PolicyWordPressVersionFiles', 'version_files_core' );
            // Auto Updates: https://codex.wordpress.org/Configuring_Automatic_Background_Updates
            
            if ( version_compare( $wp_version, '3.7.0' ) >= 0 && !defined( 'AUTOMATIC_UPDATER_DISABLED' ) ) {
                
                if ( !defined( 'WP_AUTO_UPDATE_CORE' ) ) {
                    // Automatic Nightly Core Updates
                    $this->add_filter_bool( $settings, 'PolicyUpdatesCoreDev', 'allow_dev_auto_core_updates' );
                    // Automatic Major Core Updates
                    $this->add_filter_bool( $settings, 'PolicyUpdatesCoreMajor', 'allow_major_auto_core_updates' );
                    // Automatic Minor Core Updates
                    $this->add_filter_bool( $settings, 'PolicyUpdatesCoreMinor', 'allow_minor_auto_core_updates' );
                }
                
                // Automatic Plugin Updates
                $this->add_filter_bool( $settings, 'PolicyUpdatesPlugin', 'auto_update_plugin' );
                // Automatic Theme Updates
                $this->add_filter_bool( $settings, 'PolicyUpdatesTheme', 'auto_update_theme' );
            }
        
        }
    
    }
    
    /**
     * Adds policy constant variable and then adds it to the policies list.
     *
     * @param $settings array
     * @param $policy string Name of security policy
     * @param $slug string Setting slug associated with policy
     * @param $value bool Set the value of new constant variable
     *
     * @since  0.2.0
     */
    private function add_constant_policy(
        $settings,
        $policy,
        $slug,
        $value = true
    )
    {
        
        if ( is_array( $settings ) && $policy && $slug && $value ) {
            
            if ( isset( $settings[$slug] ) && $settings[$slug] ) {
                
                if ( !defined( $slug ) ) {
                    define( $slug, $value );
                    $this->policies[] = $policy;
                } else {
                    //Janitor::log( $slug . ' already defined' );
                }
            
            } else {
                //Janitor::log( $slug . ': Setting not set.' );
            }
        
        } else {
            //Janitor::log( $slug . ': Problem adding Constant.' );
        }
    
    }
    
    /**
     * Adds a filter with a forced boolean result.
     *
     * @param $settings array
     * @param $policy string Name of security policy
     * @param $slug string Setting slug associated with policy
     *
     * @since  0.2.0
     */
    private function add_filter_bool( $settings, $policy, $slug )
    {
        // Get Value
        $value = ( isset( $settings[$slug] ) && $settings[$slug] == '1' ? '__return_true' : '__return_false' );
        // Add Filter
        add_filter( $slug, $value, 1 );
        // Add Policy
        $this->policies[] = $policy . $value;
    }
    
    /**
     * Content Policies
     *
     * @since  0.2.0
     */
    private function content()
    {
        //Janitor::log( 'running content().' );
        $settings = $this->settings['content'];
        $skip = false;
        
        if ( $settings['on'] == "1" ) {
            if ( isset( $this->user['roles']['author'] ) || isset( $this->user['roles']['editor'] ) || isset( $this->user['roles']['administrator'] ) || isset( $this->user['roles']['super_admin'] ) ) {
                // Skip Conditional Policies
                $skip = true;
            }
            
            if ( !$skip ) {
                // Disable Text Highlighting
                $this->add_policy( $settings, 'PolicyDisableTextHighlight', 'disable_text_highlight' );
                // Disable Right Click
                $this->add_policy( $settings, 'PolicyDisableRightClick', 'disable_right_click' );
            }
            
            // Hide Password Protected Posts
            $this->add_policy( $settings, 'PolicyHidePasswordProtectedPosts', 'hide_password_protected_posts' );
            // Log 404s
            $this->add_firewall_policy( [], 'PolicyLog404s' );
        }
    
    }
    
    /**
     * Checks to see if the IP has been whitelisted yet
     *
     * @return bool
     *
     * @since 2.0.0
     */
    function is_whitelisted()
    {
        return $this->whitelisted;
    }
    
    /**
     * Checks to see if the IP has been blacklisted yet
     *
     * @return bool
     *
     * @since 2.0.0
     */
    function is_blacklisted()
    {
        return $this->blacklisted;
    }

}
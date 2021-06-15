<?php

namespace SovereignStack\SecuritySafe;

// Prevent Direct Access
defined( 'ABSPATH' ) || die;
use  DateTime ;
use  DateInterval ;
/**
 * Class Firewall
 * @package SecuritySafe
 * @since 2.0.0
 */
class Firewall
{
    /**
     * Firewall constructor.
     */
    function __construct()
    {
        // Placeholder
    }
    
    /**
     * Determine if user is whitelisted in the DB
     *
     * @since  2.0.0
     */
    public function is_whitelisted()
    {
        //Janitor::log( 'Checking DB for whitelist. is_whitelisted()' );
        return $this->get_listed( 'allow' );
    }
    
    /**
     * Determine if user is denied/allowed
     *
     * @param string $status
     *
     * @return bool
     *
     * @since  2.4.0
     */
    private function get_listed( $status = 'deny' )
    {
        global  $wpdb, $SecuritySafe ;
        $status = ( $status == 'allow' ? 'allow' : 'deny' );
        $ip_valid = filter_var( Yoda::get_ip(), FILTER_VALIDATE_IP );
        
        if ( $ip_valid ) {
            $table_name = Yoda::get_table_main();
            $now = date( 'Y-m-d H:i:s' );
            /**
             * @todo this is currently sanitized but it should be refactored to use standard wp security measures.
             * @since 03/15/2020
             */
            $query = "SELECT * FROM {$table_name} WHERE `ip` = '{$ip_valid}' AND `type` = 'allow_deny' AND `status` = '{$status}' AND `date_expire` > '{$now}' LIMIT 1";
            $results = $wpdb->get_results( $query );
        }
        
        $SecuritySafe->date_expires = ( isset( $results[0]->date_expire ) ? $results[0]->date_expire : false );
        return isset( $results[0] );
    }
    
    /**
     * Determine if user is blacklisted in the DB
     *
     * @since  2.0.0
     */
    public function is_blacklisted()
    {
        //Janitor::log( 'Checking DB for blacklist. is_blacklisted()' );
        return $this->get_listed( 'deny' );
    }
    
    /**
     * Rate limit activity by IP address
     *
     * @since  2.4.0
     */
    public function rate_limit()
    {
        global  $wpdb, $SecuritySafe ;
        //Janitor::log( 'rate_limit()' );
        $settings_page = $SecuritySafe->get_page_settings( 'access' );
        $default_settings = Plugin::get_page_settings_min( 'access' );
        // Bail if listed
        if ( $SecuritySafe->is_blacklisted() || $SecuritySafe->is_whitelisted() ) {
            //Janitor::log( 'blacklisted or whitelisted' );
            return;
        }
        $ip_valid = filter_var( Yoda::get_ip(), FILTER_VALIDATE_IP );
        $autoblock_enabled = ( isset( $settings_page['autoblock'] ) ? (int) $settings_page['autoblock'] : (int) $default_settings['autoblock'] );
        
        if ( $ip_valid && $autoblock_enabled > 0 ) {
            $method = ( isset( $settings_page['autoblock_method'] ) ? (int) $settings_page['autoblock_method'] : (int) $default_settings['autoblock_method'] );
            $table_name = Yoda::get_table_main();
            $now = date( 'Y-m-d H:i:s' );
            // Get User Defined Mins
            $mins = ( isset( $settings_page['autoblock_timespan'] ) ? $settings_page['autoblock_timespan'] : (int) $default_settings['autoblock_timespan'] );
            //Janitor::log( 'mins: ' . $mins );
            $mins = ( $mins && is_numeric( $mins ) ? filter_var( $mins, FILTER_SANITIZE_NUMBER_INT ) : (int) $default_settings['autoblock_timespan'] );
            //Janitor::log( 'mins: ' . $mins );
            //Janitor::log( 'autoblock_timespan settings: ' . $settings_page['autoblock_timespan'] );
            //Janitor::log( 'autoblock_timespan default: ' . $default_settings['autoblock_timespan'] );
            $ago = date( 'Y-m-d H:i:s', strtotime( '-' . $mins . ' minutes', strtotime( $now ) ) );
            /**
             * @todo this is currently sanitized but it should be refactored to use standard wp security measures.
             * @since 03/15/2020
             */
            // Default to Failed Login Blocking
            $query = "SELECT SUM(`threats`) FROM {$table_name} WHERE `ip` = '{$ip_valid}' AND `type` = 'logins' AND `status` = 'failed' AND `date` >= '{$ago}' AND `date` <= '{$now}'";
            /**
             * @todo this is currently sanitized but it should be refactored to use standard wp security measures.
             * @since 03/15/2020
             */
            $total_score = $wpdb->get_var( $query );
            $total_score = ( isset( $total_score ) ? (int) $total_score : 0 );
            // Get User Defined Score
            $ban_score = ( isset( $settings_page['autoblock_threat_score'] ) ? $settings_page['autoblock_threat_score'] : (int) $default_settings['autoblock_threat_score'] );
            $ban_score = ( $ban_score && is_numeric( $ban_score ) ? filter_var( $ban_score, FILTER_SANITIZE_NUMBER_INT ) : (int) $default_settings['autoblock_threat_score'] );
            //Janitor::log( $total_score . ' >= ' . $ban_score  );
            
            if ( $total_score >= $ban_score ) {
                $SecuritySafe->blacklisted = true;
                //Janitor::log( 'running blacklist' );
                // Blacklist IP For X mins / X hrs / X days
                $table_name = Yoda::get_table_main();
                /**
                 * @todo this is currently sanitized but it should be refactored to use standard wp security measures.
                 * @since 03/15/2020
                 */
                $query = "SELECT * FROM {$table_name} WHERE `ip` = '{$ip_valid}' AND `type` = 'allow_deny' AND `status` = 'deny' AND `date_expire` != '0000-00-00 00:00:00' ORDER BY `date` DESC LIMIT 1";
                $results = $wpdb->get_results( $query );
                // First offense known in the database
                // Get User Defined Mins
                $ban_mins = ( isset( $settings_page['autoblock_ban_1'] ) ? $settings_page['autoblock_ban_1'] : (int) $default_settings['autoblock_ban_1'] );
                $ban_mins = ( $ban_mins && is_numeric( $ban_mins ) ? filter_var( $ban_mins, FILTER_SANITIZE_NUMBER_INT ) : (int) $default_settings['autoblock_ban_1'] );
                
                if ( $results ) {
                    // The user has been banned before
                    $ban_mins_check = $ban_mins + 1;
                    // The threshold above the first offense ban time
                    foreach ( $results as $r ) {
                        $date = new DateTime( $r->date );
                        $date_expire = new DateTime( $r->date_expire );
                        $diff = $date->diff( $date_expire );
                        $mins = $diff->format( '%i' );
                        $mins = $mins * 1;
                        
                        if ( $mins < $ban_mins_check && $mins !== 0 ) {
                            // Get User Defined Hours
                            $ban_hrs = ( isset( $settings_page['autoblock_ban_2'] ) ? $settings_page['autoblock_ban_2'] : (int) $default_settings['autoblock_ban_2'] );
                            $ban_hrs = ( $ban_hrs && is_numeric( $ban_hrs ) ? filter_var( $ban_hrs, FILTER_SANITIZE_NUMBER_INT ) : (int) $default_settings['autoblock_ban_2'] );
                            $ban_time = ( $ban_hrs > 1 ? 'PT' . $ban_hrs . 'H' : 'PT1H' );
                            $ban_text = ( $ban_hrs > 1 ? sprintf( __( '%d hours', SECSAFE_SLUG ), $ban_hrs ) : __( '1 hour', SECSAFE_SLUG ) );
                        } else {
                            $ban_days = 1;
                            $ban_days = ( $ban_days && is_numeric( $ban_days ) ? filter_var( $ban_days, FILTER_SANITIZE_NUMBER_INT ) : (int) $default_settings['autoblock_ban_3'] );
                            $ban_time = ( $ban_days > 1 ? 'P' . $ban_days . 'D' : 'P1D' );
                            $ban_text = ( $ban_days > 1 ? sprintf( __( '%d days', SECSAFE_SLUG ), $ban_days ) : __( '1 day', SECSAFE_SLUG ) );
                        }
                        
                        break;
                    }
                } else {
                    $ban_time = 'PT' . $ban_mins . 'M';
                    $ban_text = sprintf( __( '%d minutes', SECSAFE_SLUG ), $ban_mins );
                }
                
                $date = new DateTime();
                $date = $date->add( new DateInterval( $ban_time ) );
                $args = [];
                // reset
                $args['date_expire'] = $date->format( 'Y-m-d H:i:s' );
                $args['details'] = sprintf( __( 'Too many offenses . Blacklisted for %s . ', SECSAFE_SLUG ), $ban_text );
                $args['ip'] = $ip_valid;
                $this->blacklist_ip( $args );
            }
        
        } else {
            // Not a valid IP or rate limiting is disabled.
            //Janitor::log( 'autoblock not running' );
            return;
        }
    
    }
    
    /**
     * Blacklist IP for period of time
     *
     * @param array $args
     *
     * @since  2.4.0
     */
    public function blacklist_ip( $args )
    {
        $args['ip'] = Yoda::get_ip();
        
        if ( isset( $args['date_expire'] ) && $args['date_expire'] && filter_var( $args['ip'], FILTER_VALIDATE_IP ) ) {
            $args['status'] = 'deny';
            $args['details'] = ( isset( $args['details'] ) ? filter_var( $args['details'], FILTER_SANITIZE_STRING ) : '' );
            $args['type'] = 'allow_deny';
            Janitor::add_entry( $args );
        }
    
    }
    
    /**
     * Logs the blocked attempt.
     *
     * @param array $args
     * @param bool $die Used to kill the PHP session. True by default.
     *
     * @since  2.0.0
     */
    protected function block( $args = array(), $die = true )
    {
        global  $SecuritySafe ;
        // Bail if whitelisted
        if ( $SecuritySafe->is_whitelisted() ) {
            return;
        }
        $args['status'] = 'blocked';
        $args['threats'] = 1;
        // Add blocked Entry & Prevent Caching
        Janitor::add_entry( $args );
        
        if ( $die ) {
            $message = sprintf( __( '%s: Access blocked.', SECSAFE_SLUG ), SECSAFE_NAME );
            $message .= ( SECSAFE_DEBUG ? ' - ' . $args['type'] . ': ' . $args['details'] : '' );
            status_header( '406', $message );
            // Block Attempt
            die( $message );
        }
    
    }
    
    /**
     * Logs the threat attempt.
     *
     * @param array $type
     * @param string $details
     *
     * @since  2.0.0
     */
    protected function threat( $type, $details = '' )
    {
        global  $SecuritySafe ;
        // Bail if whitelisted
        if ( $SecuritySafe->is_whitelisted() ) {
            return;
        }
        $args = [];
        $args['type'] = $type;
        $args['details'] = ( $details ? $details : '' );
        $args['threats'] = 1;
        // Add threat Entry & prevent Caching
        Janitor::add_entry( $args );
    }

}
<?php
/** Plugin Name: BW Login Guard
 * Description: Limits failed login attempts and disables unused XML-RPC authentication.
 * Version: 1.0.0
 */
namespace BW\LoginGuard;
defined('ABSPATH') || exit;
function key(){return 'bw_login_'.substr(hash_hmac('sha256',$_SERVER['REMOTE_ADDR']??'unknown',wp_salt('auth')),0,32);}
add_filter('authenticate',function($user){$attempts=(int)get_transient(key());if($attempts>=10)return new \WP_Error('bw_login_rate_limited','Te veel mislukte pogingen. Probeer het over 15 minuten opnieuw.');return $user;},99);
add_action('wp_login_failed',function(){$k=key();set_transient($k,(int)get_transient($k)+1,15*MINUTE_IN_SECONDS);});
add_action('wp_login',function(){delete_transient(key());});
add_filter('xmlrpc_enabled','__return_false');

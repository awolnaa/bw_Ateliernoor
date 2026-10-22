<?php
/** Plugin Name: BW Site Favicon
 * Description: Compact logo-based browser and touch icons; no external services.
 */
namespace BW\SiteFavicon;
defined('ABSPATH')||exit;
add_filter('get_site_icon_url',function($url,$size,$blog_id){if($blog_id&&$blog_id!==get_current_blog_id())return $url;$file=$size<=32?'icon-32.png':($size<=180?'icon-180.png':($size<=192?'icon-192.png':'icon-512.png'));return content_url('mu-plugins/bw-site-icon/'.$file).'?v=20261022';},10,3);
add_action('wp_head',function(){echo '<link rel="icon" type="image/svg+xml" href="'.esc_url(content_url('mu-plugins/bw-site-icon/icon.svg')).'?v=20261022">'."\n";},99);

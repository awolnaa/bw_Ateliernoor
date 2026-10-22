<?php
/** Plugin Name: BW Mobile Navigation
 * Description: Centered full-width navigation overlays with inline, smaller submenus.
 * Version: 1.0.0
 */
defined('ABSPATH') || exit;
add_action('wp_enqueue_scripts',function(){
 $path=__DIR__.'/bw-mobile-navigation.css';
 wp_enqueue_style('bw-mobile-navigation',content_url('mu-plugins/bw-mobile-navigation.css'),[],filemtime($path));
},200);

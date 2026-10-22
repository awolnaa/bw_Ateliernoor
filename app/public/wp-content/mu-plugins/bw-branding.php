<?php
/** Plugin Name: BW Brand Credits
 * Description: Shared accessible Monday Makers footer credit and consistent main-site branding.
 * Version: 1.0.0
 */
namespace BW\Branding;
defined('ABSPATH') || exit;
function asset($name){return content_url('mu-plugins/bw-branding/'.$name);}
function logo($variant='white'){return '<img class="bw-brand-logo" src="'.esc_url(asset('mondaymakers-'.$variant.'.svg')).'" alt="Monday Makers" width="126" height="59" decoding="async" loading="lazy">';}
function credit(){return '<div class="bw-brand-credit"><a href="https://mondaymakers.be" class="bw-brand-credit-link"><span>powered by</span><picture><source media="(forced-colors: active)" srcset="'.esc_url(asset('mondaymakers-black.svg')).'">'.logo().'</picture></a></div>';}
// A template-part may contain its own footer element or be wrapped by WordPress.
add_filter('render_block_core/template-part',function($html,$block){
 if(($block['attrs']['slug']??'')!=='footer'||is_admin()||str_contains($html,'bw-brand-credit'))return $html;
 $credit=credit();$pos=strripos($html,'</footer>');
 return $pos===false?$html.$credit:substr_replace($html,$credit,$pos,0);
},30,2);
// Main-site header and footer use the same image on every template, including saved overrides.
add_filter('render_block',function($html,$block){
 if(get_stylesheet()!=='monday-makers-gutenberg-theme')return $html;
 if(($block['blockName']??'')==='core/image'&&str_contains($block['attrs']['className']??'','mm-logo-image'))
 return '<figure class="wp-block-image mm-logo-image"><a href="'.esc_url(home_url('/')).'" aria-label="Monday Makers — homepage">'.logo().'</a></figure>';
 return $html;
},40,2);
add_action('wp_enqueue_scripts',function(){
 $dir=__DIR__.'/bw-branding/';
 wp_enqueue_style('bw-branding',asset('brand.css'),[],filemtime($dir.'brand.css'));
 wp_enqueue_script('bw-branding',asset('brand.js'),[],filemtime($dir.'brand.js'),true);
 $theme=get_stylesheet();
 if(in_array($theme,['bw-kids','bw-driving','bw-healthcoach','bw-fincoach','bw-realestate','bw-actor','bw-lifecoaching','bw-fitness'],true)){
  wp_enqueue_style('bw-expressive-motion',asset('motion.css'),[],filemtime($dir.'motion.css'));
  wp_enqueue_script('bw-expressive-motion',asset('motion.js'),[],filemtime($dir.'motion.js'),true);
 }
},100);

<?php
add_action('after_setup_theme',function(){add_theme_support('woocommerce');add_theme_support('wc-product-gallery-zoom');add_theme_support('wc-product-gallery-lightbox');add_theme_support('wc-product-gallery-slider');add_theme_support('editor-styles');add_editor_style('assets/site.css');});
add_action('wp_enqueue_scripts',function(){wp_enqueue_style('noor',get_theme_file_uri('assets/site.css'),[],filemtime(get_theme_file_path('assets/site.css')));wp_enqueue_script('noor',get_theme_file_uri('assets/site.js'),[],filemtime(get_theme_file_path('assets/site.js')),true);});
add_filter('woocommerce_enqueue_styles','__return_empty_array');
add_filter('loop_shop_columns',fn()=>4);
add_filter('woocommerce_product_related_products_heading',fn()=>'Mooi erbij');

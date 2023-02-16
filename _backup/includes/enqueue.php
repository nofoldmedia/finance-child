<?php

// Enqueue the child stylesheets
function enqueue_styles() {
	if (!is_admin()) :
        $url = get_template_directory() . '/build/manifest.json';
        $assetstr = file_get_contents($url);
		$assets = json_decode($assetstr, true);
		$assets     = array(
			'css' => '/build/css/styles.min.css' . '?' . $assets['build/css/styles.min.css']['hash'],
        );
        
        wp_register_style( 'parent-theme', get_template_directory_uri() . $assets['css'], array(), '', 'all' );
        wp_enqueue_style( 'parent-theme' );

        $url = get_stylesheet_directory() . '/build/manifest.json';

        $child_manifest = file_get_contents($url);
        $ch_assets = json_decode($child_manifest, true);
        $ch_assets  = array(
			'css' => '/build/css/styles.min.css' . '?' . $ch_assets['build/css/styles.min.css']['hash'],
        );

        wp_enqueue_style('child-theme', get_stylesheet_directory_uri() . $ch_assets['css'], array(), '', 'all');
        
    endif;
	
}
add_action('wp_enqueue_scripts', 'enqueue_styles');

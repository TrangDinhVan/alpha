<?php
define("CSS", get_template_directory_uri().'/css');
define("JS", get_template_directory_uri().'/js');
define("IMG", get_template_directory_uri().'/images');
define("LAZY_IMG", "data:image/gif;base64,R0lGODdhAQABAPAAAMPDwwAAACwAAAAAAQABAAACAkQBADs=");

global $cu; $cu = false;
if( is_user_logged_in() ) $cu = wp_get_current_user();

// 1. customize ACF path
add_filter('acf/settings/path', 'my_acf_settings_path');
function my_acf_settings_path( $path ) {
    $path = get_template_directory() . '/acf/';
    return $path;
}

// 2. customize ACF dir
add_filter('acf/settings/dir', 'my_acf_settings_dir');
function my_acf_settings_dir( $dir ) {
    $dir = get_template_directory_uri() . '/acf/';
    return $dir;
}

// 3. Hide ACF field group menu item
add_filter('acf/settings/show_admin', '__return_true');
// 4. Include ACF
include_once( get_template_directory() . '/acf/acf.php' );

function z_include( $folder ){ foreach (glob("{$folder}/*.php") as $filename){ include $filename; } } z_include( dirname(__FILE__).'/z_inc' );

if( !function_exists('fw_print') ):
	function fw_print($value){
		static $first_time = true;
		if ($first_time) {
			ob_start();
			echo '<style type="text/css">
			div.fw_print_r {
				max-height: 500px;
				overflow-y: scroll;
				background: #23282d;
				margin: 10px 30px;
				padding: 0;
				border: 1px solid #F5F5F5;
				border-radius: 3px;
				position: relative;
				z-index: 11111;
			}

			div.fw_print_r pre {
				color: #78FF5B;
				background: #23282d;
				text-shadow: 1px 1px 0 #000;
				font-family: Consolas, monospace;
				font-size: 12px;
				margin: 0;
				padding: 5px;
				display: block;
				line-height: 16px;
				text-align: left;
			}

			div.fw_print_r_group {
				background: #f1f1f1;
				margin: 10px 30px;
				padding: 1px;
				border-radius: 5px;
			}
			div.fw_print_r_group div.fw_print_r {
				margin: 9px;
				border-width: 0;
			}
			</style>';
			echo str_replace(array('  ', "\n"), '', ob_get_clean());
			$first_time = false;
		}
		if (func_num_args() == 1) {
			echo '<div class="fw_print_r"><pre>';
			echo htmlspecialchars(FW_Dumper::dump($value));
			echo '</pre></div>';
		} else {
			echo '<div class="fw_print_r_group">';
			foreach (func_get_args() as $param) {
				fw_print($param);
			}
			echo '</div>';
		}
	}
endif; ?>
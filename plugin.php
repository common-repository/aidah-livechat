<?php
/*
Plugin Name: 	Aidah Livechat
Plugin URI: 	http://aidah.ai
Description: 	Live chat widget plugin.Connect with your websites visitors in a new, personal and exiting way.
Version: 		1.0.1
Author: 		Aidah
Author URI:
License:		GPL2

Copyright 2019  Aidahbot

Aidah plugin is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Aidah is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Aidah.
*/

if( !defined( 'ABSPATH' ) ) die();


//settings
add_action( 'admin_menu', 'aidah_add_admin_menu' );
add_action( 'admin_init', 'aidah_settings_init' );


function aidah_add_admin_menu(  ) {

	add_menu_page( 'Aidah', 'Aidah', 'manage_options', 'Aidah', 'aidah_options_page' );

}
function aidah_settings_init(  ) {
	register_setting( 'pluginPage', 'aidah_id' );
}
function aidah_options_page(  ) {
 if (isset($_GET["aidah_id"]) && !empty($_GET["aidah_id"])) {
    update_option("aidah_id", $_GET["aidah_id"]);
  }

 $aidah_id = get_option('aidah_id');
 $http_callback = "http" . (($_SERVER['SERVER_PORT'] == 443) ? "s://" : "://") . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
 $add_signup_link = "https://app.aidah.ai/signup?wpcb=$http_callback";
 $add_login_link = "https://app.aidah.ai/login?wpcb=$http_callback";
?>
	<form action='options.php' method='post'>
	<div class="aidah-main-wrap">
	<?php
 if(isset($aidah_id) && !empty($aidah_id)){
	?>
<div class="aidah-wrapper">
          <h2 class="aidah-title">Connected to Aidah</h2>
          <p class="aidah-subtitle">Aidah can now be used from the homepage.</p>
          <a class="aidah-btn aidah-inbox" href="https://app.aidah.ai/chat">Go to Aidah Inbox </a>
          <a class="aidah-btn" href="https://app.aidah.ai/settings/accounts">Go to Aidah settings</a>
          <a></a>
        </div>
	<?php
}else{
?>
<div class="aidah-wrapper">
          <h2 class="aidah-title">Connect with aidah</h2>
          <p class="aidah-subtitle">Connect your wordpress account to Aidah.</p>
          <a class="aidah-btn aidah-login" href="<?php echo $add_login_link; ?>">Login</a>
          <a class="aidah-btn" href="<?php echo $add_signup_link; ?>">Signup</a>
        </div>

	<?php
}
?>
 <p class="aidah-lovin">Made with ♥ by <a target="_blank" href="aidah.ai">Aidah.ai</a></p>

</div>
	</form>

	<?php
}

//load aidah

function aidah_load_Aidah( ) { // load external file
   $aidah_id = get_option('aidah_id');
     if(isset($aidah_id) && !empty($aidah_id)){
          wp_register_script('aidah', ("https://livechat.aidahbot.com/static/plugin/index.js"), false);
          wp_enqueue_script('aidah');
      }
}
function aidah_css(){
 wp_register_style( 'aidah_css', plugins_url('assets/css/aidah_setting.css', __FILE__), false, '1.0.1', 'all');
 wp_enqueue_style( 'aidah_css' );
}

add_action('wp_enqueue_scripts', 'aidah_load_Aidah');

add_action('admin_enqueue_scripts', 'aidah_css');

function aidah_add_data_attribute($tag, $handle) {
 $aidah_id = get_option('aidah_id');
 $replace_with="page_id=\"".$aidah_id."\" src";
   if ( 'aidah' !== $handle )
    return $tag;
     if(isset($aidah_id) && !empty($aidah_id)) {
        return str_replace( ' src', $replace_with, $tag );
      } else {
        echo '<script>console.error(\'No page id provided,please add the id in aidah\'s settings page and try again\')</script>';
      }

}

add_filter('script_loader_tag', 'aidah_add_data_attribute', 10, 2);

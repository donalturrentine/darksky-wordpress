<?php
/*
Plugin Name: DarkSky Wordpress
Plugin URI: https://github.com/donalturrentine/darksky-wordpress
Description: This plugin implements the Dark Sky API for time-coordinated posts.
Version: 0.1
Author: Donal Turrentine
Author URI: https://yourcomputergenius.com
License: MIT
*/
/* 
	Copyright (c) 2015 Donal Turrentine
	
	Permission is hereby granted, free of charge, to any person obtaining a copy
	of this software and associated documentation files (the "Software"), to deal
	in the Software without restriction, including without limitation the rights
	to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
	copies of the Software, and to permit persons to whom the Software is
	furnished to do so, subject to the following conditions:
	
	The above copyright notice and this permission notice shall be included in
	all copies or substantial portions of the Software.
	
	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
	IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
	FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
	AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
	LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
	OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
	THE SOFTWARE.
*/

add_action( 'admin_menu', 'darksky_wordpress' );

function darksky_wordpress(){

  $page_title = 'DarkSky Wordpress';
  $menu_title = 'DarkSky Wordpress Settings';
  $capability = 'manage_options';
  $menu_slug  = 'darksky-wordpress';
  $function   = 'darksky_wordpress_Settings';
  $icon_url   = 'dashicons-media-code';
  $position   = 4;

  add_menu_page( $page_title,
                 $menu_title, 
                 $capability, 
                 $menu_slug, 
                 $function, 
                 $icon_url, 
                 $position );
}
function darksky_wordpress_shortcode($atts, $content = null) {
    //https://api.forecast.io/forecast/APIKEY/LATITUDE,LONGITUDE
    //https://api.forecast.io/forecast/APIKEY/LATITUDE,LONGITUDE,TIME

   return '';
}
add_shortcode('darksky-wordpress', 'darksky_wordpress_shortcode');
?>

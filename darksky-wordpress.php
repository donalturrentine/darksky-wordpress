<?php
/*
Plugin Name: DarkSky Wordpress
Plugin URI: https://github.com/donalturrentine/darksky-wordpress
Description: This plugin implements the Dark Sky API for time-coordinated posts.
Version: 0.2
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

if( !function_exists("darksky_wordpress") ) {
	
	function darksky_wordpress(){
	
	  $page_title = 'DarkSky Wordpress';
	  $menu_title = 'DarkSky';
	  $capability = 'manage_options';
	  $menu_slug  = 'darksky-wordpress';
	  $function   = 'darksky_wordpress_settings';
	  $icon_url   = 'dashicons-admin-site';
	  $position   = 65;
	
	  add_menu_page( $page_title,
	                 $menu_title, 
	                 $capability, 
	                 $menu_slug, 
	                 $function, 
	                 $icon_url, 
	                 $position );
	                 
	function extra_post_info($content)
	{
    	$extra_info = "EXTRA INFO";
		return $content . $extra_info;
		}
		
		
	
function darksky_wordpress_settings() {
	
}

function darksky_wordpress_shortcode($atts, $content = null) {

	// Contants TODO Look up these from Plugin Settings
    $api_key="cfca55e1d1f87598ac4d8b2c95bdbb62";
    $lat_and_lon="37.863888,-122.502982,";


    //https://api.forecast.io/forecast/APIKEY/LATITUDE,LONGITUDE
    //https://api.forecast.io/forecast/APIKEY/LATITUDE,LONGITUDE,TIME

				// Setup our Animated Weather Icons for this page display
				
				$weather_icons=array();
				$iCounter=0;
									
				// This loop needs to be restricted to the Current Month
				
				$today = getdate();
				
				//$args = array( 'numberposts' => 5, 'offset'=> 0, 'category' => 1 );
				$args = array( 
					'year' => $today['year'],
					'monthnum' => $today['mon'],
					'offset'=> 0, 
					'category' => 1 
				);    
						    
						//$date_and_time=get_the_date("Y-m-d")."T".get_the_time("H:i:s");
						//$date_and_time=get_the_time("c");
   						//$date_and_time=get_the_time("U");

  						$date_and_time=$atts['date_and_time'];   						
   						
						$url_parameters=$lat_and_lon.$date_and_time;
						    
						$request_url="https://api.forecast.io/forecast/".$api_key."/".$url_parameters;
						    //echo("<h2>".$date_and_time."</h2>");
						    
						$request=file_get_contents($request_url);
						
						$requestArray = json_decode($request, true);
						
						// Weather Variables to Display
						
						$weatherSummary=$requestArray['currently']['summary'];
						
						// Weather Icon processing ... a bit more complicated, put it into an array
						
						$weatherIcon=$requestArray['currently']['icon'];
						
						// comes back with something like 'clear-day'
						
						// Add to Array
						
						$weather_icons[]=array('id'=>$iCounter, 'time'=>$date_and_time, 'icon'=> $weatherIcon);
						
						// Create the canvas						
						
						$weatherIcon="<canvas id=\"".$date_and_time."\" width=\"128\" height=\"128\"> </canvas>";
						
						$weatherTemperature=$requestArray['currently']['temperature'];
						$weatherWind=$requestArray['currently']['windSpeed']." mph @ ".$requestArray['currently']['windBearing'];
						$weatherHumidity=$requestArray['currently']['humidity'];
						$weatherPressure=$requestArray['currently']['pressure'];
						$weatherVisibility=$requestArray['currently']['visibility'];
						
						if (!($weatherHumidity)) { $weatherHumidity='--'; }
						if (!($weatherVisibility)) { $weatherVisibility='--'; }					

					    echo '<div class="weather-embed" style="">
					    		<div style="color: inherit; margin-left: auto; margin-right: auto; text-align: center;">
					    		'.$weatherIcon.'<br/>
					    		'.$weatherSummary.' </div>
					    		<div class="weather-embed-bar">
					    		TEMP: '.$weatherTemperature.'&deg; 
					    		WIND: '.$weatherWind.'&deg; 
					    		Humidity: '.$weatherHumidity.' 
					    		Visibility: '.$weatherVisibility.'					    		
					    		Pressure: '.$weatherPressure.' mb 
					    		</div></div>';
					    		
   return '';
}
add_shortcode('darksky-wordpress', 'darksky_wordpress_shortcode');

add_filter('the_content', 'extra_post_info');


	}
}


?>

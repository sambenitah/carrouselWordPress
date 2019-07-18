<?php
/*
Plugin Name: Slider Carousel
Plugin URI: http://slider-carousel-esgi.com
Description: Slider de médias personnalisable
Author: U Know ...
Author URI: http://nous.com
Version: 0.1
*/

require_once plugin_dir_path(__FILE__).'includes/functions.php';
register_activation_hook(__FILE__, 'init');
register_deactivation_hook( __FILE__, 'remove_database' );

class carouselPlugin
{
  public function __construct()
  {
    include_once plugin_dir_path( __FILE__ ).'/PluginInit.php';
    new PluginInit();
  }
}

new carouselPlugin;

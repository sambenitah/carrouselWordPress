<?php

add_action( 'wp_enqueue_scripts', 'Bootstrap_style' );
function Bootstrap_style() {
    wp_enqueue_style( 'myStyle', get_stylesheet_uri());
    wp_enqueue_style('Bootstrap', "https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css");
    wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js', array(), null, true);
    wp_enqueue_script('BootJs', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js');
    wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css' );
}

function load_plugin_css() {
    $plugin_url = plugin_dir_url( __FILE__ );
    wp_enqueue_style( 'style1', $plugin_url . 'css/carousel-plugin-style.css' );
}
add_action( 'wp_enqueue_scripts', 'load_plugin_css' );


//hook 'admin_menu'
add_action('admin_menu', 'carousel_add_admin_link');

function carousel_add_admin_link(){
  add_menu_page(
    'carousel Slider',
    'Carousel',
    'manage_options',
    'carousel/includes/carousel-config.php'
  );
}

add_action('admin_head',  'add_bootstrap_admin_head');

function add_bootstrap_admin_head() {
  wp_enqueue_style('AdminBootstrap', "https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css");
  wp_enqueue_script('AdminJquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js', array(), null, true);
  wp_enqueue_script('jsCustom', plugin_dir_url( __FILE__ ).'script.js', array(), null, true);
  wp_enqueue_style( 'AdminFA', '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css' );
}

function init(){
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $carousel_table_name = $wpdb->prefix . 'carousel';

    $carousel_sql = "CREATE TABLE IF NOT EXISTS $carousel_table_name (
                        id INT NOT NULL AUTO_INCREMENT,
                        navigation  bit NOT NULL,
                        autoplay bit NOT NULL,
                        delay float not null,
                        direction bit not null,
                        text varchar(255) not null,
                        transition bit not null,
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                        PRIMARY KEY  (id)
                    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($carousel_sql);


    $carousel_sql = "CREATE TABLE IF NOT EXISTS wp_carouselMedia (
                        id INT NOT NULL AUTO_INCREMENT,
                        url varchar(255) not null,
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                        PRIMARY KEY  (id)
                    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($carousel_sql);


    $results = $wpdb->get_results("insert into  wp_carousel (navigation,autoplay,direction,delay,text,transition) 
    values (1,1,1,5,'',1)");
}

function remove_database() {
    global $wpdb;
    $carousel_table_name = $wpdb->prefix . 'carousel';
    $sql = "DROP TABLE IF EXISTS $carousel_table_name;";
    $wpdb->query($sql);
    $sql = "DROP TABLE IF EXISTS wp_carouselMedia;";
    $wpdb->query($sql);
}

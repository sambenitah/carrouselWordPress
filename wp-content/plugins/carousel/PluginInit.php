<?php

class PluginInit
{
    public function __construct()
    {
        add_shortcode('carousel_plugin', 'create_slider');


        function create_slider($atts = [])
        {

            if(count($atts) > 0)

            global $wpdb;


            $config = $wpdb->get_row("select * from wp_carousel");

            $nbArticles = get_option( 'posts_per_page' );


            $args = array(
                'posts_per_page'   => $nbArticles,
                'offset'           => 0,
                'category'    => (isset($atts['cat']) ? $atts['cat'] : ""),
                'orderby'          => 'date',
                'order'            => 'DESC',
                'include'          => '',
                'exclude'          => '',
                'meta_key'         => '',
                'meta_value'       => '',
                'post_type'        => 'post',
                'post_mime_type'   => '',
                'post_parent'      => '',
                'author'	   => '',
                'author_name'	   => '',
                'post_status'      => 'publish',
                'suppress_filters' => true,
                'fields'           => '',
            );



            $defaultImage =  plugin_dir_url('./images/').'/carousel/images/default.jpg';

            $articles = get_posts($args);

            $html = '
                  <div id="carouselExampleIndicators" class="carousel slide '.($config->transition?"carousel-fade":"").'" data-ride="carousel"
                  '.(($config->autoplay ) ? "data-interval=".(($config->delay)*1000) : "").'>
                      <ol class="carousel-indicators">';

            $cpt = 0;

            foreach ($articles as $article){
                $html.='<li data-target="#carouselExampleIndicators" data-slide-to="'.$cpt.'" class="'.($cpt ==  0? "active" : "").'"></li>';
                $cpt++;
            }

            $html.='
                      </ol>
                      <div class="carousel-inner">';

            $cpt = 0;

         foreach ($articles as $article){

             $html.='<div class="carousel-item '.($cpt ==  0? "active" : "").'">      
                      <img src="'.(has_post_thumbnail($article->ID) ? get_the_post_thumbnail_url($article->ID) : $defaultImage).'" alt="...">
                      <div class="carousel-caption d-none d-md-block">
                      <h5>'.$article->post_title.'</h5>
                      </div>
                    </div>';

             $cpt++;
            }

            if($config->navigation) {
            $html .= '
                  </div>
                  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                  </a>
               </div> 
              ';
            }
            return $html;
        }

        function create_form()
        {

        }
    }

}

<?php

/**
 * Plugin Name: MakerVsVirus LogoScroller-Plugin
 * Plugin URI: https://www.makervsvirus.org
 * Description: Add's a Logo-Scroller to the FrontPage
 * Version: 0.1
 * Text Domain: makervsvirus-logoscroller
 * Author: Benedikt Hübschen
 * Author URI: https://www.makervsvirus.org
 */

add_shortcode('scroller', 'scroller');


function init() {

    $show_ui = false;

    $capability = apply_filters('slider_capability', 'edit_others_posts' );

    if ( is_admin() ) {
        $show_ui = true;
    }

    register_post_type( 'scroller', 
        array(
            'query_var' => false,
            'rewrite' => false,
            'public' => false,
            'exclude_from_search' => true,
            'publicly_queryable' => false,
            'show_in_nav_menus' => false,
            'show_ui' => $show_ui,
            'labels' => array(
                'name' => 'MVSV-Sliderbild'
            )
        )
    );
}

function my_load_scripts() {
    wp_enqueue_script("slick-script", "https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js", array('jquery'), true);
    wp_enqueue_script("scroller-script", plugins_url("assets/js/script.js", __FILE__ ), array('jquery'), true);
    wp_enqueue_style("scroller-style", plugins_url("assets/css/style.css", __FILE__ ));

}

function scroller($atts)
{
    ob_start(); 
    $logos = get_posts(array(
        'post_type'         => 'scroller',
        'posts_per_page'    =>  -1,
        'orderby'           => 'title',
        'order'              => 'ASC'
    ));
?>
</div>
</div>
</div>
    <div class="customer-logos" style="width:100%; background-color:#FA6400; height: 190px; padding: 20px">
<?php
    foreach ($logos as $logo) {
        $logoImg = $logo->post_content;
        $logoImg = substr($logoImg,strpos($logoImg,"src="));
        $logoImg = substr($logoImg,strpos($logoImg,"\"")+1);
        $logoImg = substr($logoImg,0,strpos($logoImg,"\""));
?>
        <div class="slide"><img src="<?= $logoImg ?>" style="max-height:150px; width:auto"></div>
<?php
    };
?>
    </div>
<div class="container"><div class="row justify-content-center"><div class="col-md-8">
<?php
    return ob_get_clean();
}
add_action('init','init');
add_action('wp_enqueue_scripts', 'my_load_scripts');

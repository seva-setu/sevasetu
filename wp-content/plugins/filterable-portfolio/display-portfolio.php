<?php

function filterableportfolio_controls() {

    $terms = get_terms("portfolio_cat");    //To get custom taxonomy catagory name
    $count = count($terms);

    $controls ='<div id="filter" class="controls">';
    $controls .='<ul>';

    if ($count > 0) {

        $controls .= '<li><a class="active" href="#" data-group="all">'.__('All','filterable-portfolio').'</a></li>';

        foreach ( $terms as $term ) {

            $termname = strtolower($term->name);
            $termname = str_replace(' ', '-', $termname);
            $controls .= '<li><a href="#" data-group="'.$termname.'">'.$term->name.'</a></li>';

        }

    }

    $controls .='</ul>';
    $controls .='</div>';

    return $controls;
}


function filterableportfolio_contents( $thumbnail, $thumb_size ) {
    global $post;
    ob_start();
    ?>
    
    <div id="grid" class="myportfolio">

    <?php

        $args = array(
            'post_type' => 'portfolio',
            'posts_per_page' => -1,
        );

        $the_query = new WP_Query( $args );

        if( $the_query->have_posts() ) :
        while( $the_query->have_posts() ): $the_query->the_post();

        if( ! has_post_thumbnail() ) continue;

            $terms = get_the_terms( get_the_ID(), 'portfolio_cat' );   //To get custom taxonomy catagory name
                                             
            if ( $terms && ! is_wp_error( $terms ) ) :
                $links = array();
         
                foreach ( $terms as $term ) {
                    $links[] = $term->name;
                }
                            
                $links = str_replace(' ', '-', $links);
                $tax = join( " ", $links );

                $tax = strtolower($tax);
                $tax = json_encode(explode(' ', $tax));
            else :
                $tax = '';
            endif;
            ?>
            <div id="portfolio-<?php the_ID(); ?>" class="item portfolio_thumb_<?php echo $thumbnail; ?>" data-groups='<?php echo $tax; ?>'>
                <div class="portfolio_single">
                    <div class="portfolio_image">
                        <?php
                            if ( has_post_thumbnail() ) {
                                the_post_thumbnail( $thumb_size );
                            }
                        $full = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
                        ?>
                        <div class="mask">
                            <a href="<?php echo $full[0]; ?>" rel="prettyPhoto[gallery]">
                                <i title="<?php _e('View original image','filterable-portfolio'); ?>" class="picture_icon fa fa-search"></i>
                            </a>
                            <?php
                                if (  get_post_meta( get_the_ID(), 'filterableportfolio_post_live_link', true ) ) { 

                                    ?><a target="_blank" href="<?php echo get_post_meta($post->ID, 'filterableportfolio_post_live_link', true); ?>"><i title="<?php _e('Live view','filterable-portfolio'); ?>" class="link_icon fa fa-link"></i></a><?php

                                } else {
                                    ?><a href="<?php the_permalink(); ?>"><i title="<?php _e('View detail','filterable-portfolio'); ?>" class="link_icon fa fa-plus"></i></a><?php
                                }
                            ?>
                            <h1 class="portfolio_title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                                
        endwhile;
        endif;

        wp_reset_postdata();

    ?>

    </div>

    <?php 
    return ob_get_clean();
    
}


function filterableportfolio_shortcode( $atts, $content = null ) {

	extract(shortcode_atts(array(
        'thumbnail'         =>'2',
        'prettyphoto_theme' =>'facebook',
        'thumbnail_size'    =>'full'
    ), $atts));

    return filterableportfolio_controls().filterableportfolio_contents($thumbnail, $thumbnail_size).'<script>jQuery(window).load(function() { jQuery("a[rel^=\'prettyPhoto\']").prettyPhoto({ theme: "'.$prettyphoto_theme.'", social_tools:false }); });</script>';

}

add_shortcode('filterable_portfolio', 'filterableportfolio_shortcode');
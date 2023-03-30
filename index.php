<?php get_header(); ?>

<div class="container">
    <div class="row">
        <?php
        $args = array(
            'post_type' => array( 'post', 'book' ),
            'posts_per_page' => 10,
        );
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post();
                if ( get_post_type() === 'book' ) {
                    get_template_part( 'template-parts/card', 'book' );
                } else {
                    get_template_part( 'template-parts/card', get_post_type() );
                }
            }
            wp_reset_postdata();
        } else {
            echo esc_html__('No posts found', 'gamelounge');
        }
        ?>
    </div>
</div>

<?php get_footer(); ?>


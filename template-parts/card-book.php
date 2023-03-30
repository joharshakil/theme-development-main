<div class="col-md-4">
    <div class="card mb-4 box-shadow">
        <div class="card-body">
            <h2><?php the_title(); ?></h2>
            <span class="badge bg-success"><?php echo get_post_type(); ?></span>
            <?php
            $tagline = get_post_meta( get_the_ID(), '_my_book_tagline', true );
            if ( ! empty( $tagline ) ) {
                echo wp_kses_post( wpautop( $tagline ) );
            } else {
                the_excerpt();
            }
            ?>
            <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                    <a href="<?php the_permalink(); ?>" class="btn btn-sm btn-primary btn-green"><?php _e('Go somewhere', 'gamelounge'); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>

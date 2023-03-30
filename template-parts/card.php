<div class="col-md-4">
    <div class="card mb-4 box-shadow">
        <div class="card-body">
            <h2><?php the_title(); ?></h2>
            <span class="badge bg-primary"><?php echo get_post_type(); ?></span>
            <?php the_excerpt(); ?>
            <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                <a href="<?php the_permalink(); ?>" class="btn btn-sm btn-primary"><?php _e('Go somewhere', 'gamelounge'); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>

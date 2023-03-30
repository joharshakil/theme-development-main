<?php
// Add support for title-tag and HTML5
add_theme_support( 'title-tag' );
add_theme_support( 'html5', array( 'style', 'script' ) );

function mytheme_setup() {
    load_theme_textdomain( 'mytheme', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'mytheme_setup' );


// Enqueue stylesheets and scripts
function my_theme_scripts() {
    wp_enqueue_style( 'bootstrap', '//cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css' );
    wp_enqueue_style( 'my-theme-style', get_stylesheet_uri() );
    wp_enqueue_script( 'app', get_template_directory_uri() . '/src/js/app.js', array( 'jquery' ), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'my_theme_scripts' );

// Register a custom post type
function register_book_post_type() {
    $labels = array(
        'name'               => _x( 'Books', 'post type general name', 'gamelounge' ),
        'singular_name'      => _x( 'Book', 'post type singular name', 'gamelounge' ),
        'menu_name'          => _x( 'Books', 'admin menu', 'gamelounge' ),
        'name_admin_bar'     => _x( 'Book', 'add new on admin bar', 'gamelounge' ),
        'add_new'            => _x( 'Add New', 'book', 'gamelounge' ),
        'add_new_item'       => __( 'Add New Book', 'gamelounge' ),
        'new_item'           => __( 'New Book', 'gamelounge' ),
        'edit_item'          => __( 'Edit Book', 'gamelounge' ),
        'view_item'          => __( 'View Book', 'gamelounge' ),
        'all_items'          => __( 'All Books', 'gamelounge' ),
        'search_items'       => __( 'Search Books', 'gamelounge' ),
        'parent_item_colon'  => __( 'Parent Books:', 'gamelounge' ),
        'not_found'          => __( 'No books found.', 'gamelounge' ),
        'not_found_in_trash' => __( 'No books found in Trash.', 'gamelounge' )
    );

    $args = array(
        'labels'             => $labels,
        'description'        => __( 'Description.', 'gamelounge' ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'books' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 10,
        'menu_icon'          => 'dashicons-book-alt',
        'supports'           => array( 'title', 'editor', 'excerpt' )
    );

    register_post_type( 'book', $args );
}
add_action( 'init', 'register_book_post_type' );

// Add a custom meta box to the book post type
function my_add_book_meta_box() {
    add_meta_box(
        'my_book_tagline',
        'Tagline',
        'my_book_tagline_callback',
        'book'
    );
}
add_action( 'add_meta_boxes_book', 'my_add_book_meta_box' );

function my_book_tagline_callback( $post ) {
    $tagline = get_post_meta( $post->ID, '_my_book_tagline', true );
    wp_nonce_field( 'my_save_book_tagline', 'my_book_tagline_nonce' );
    ?>
    <textarea name="my_book_tagline" id="my_book_tagline" class="widefat"><?php echo esc_html( $tagline ); ?></textarea>
    <?php
}

function my_save_book_tagline( $post_id ) {
    if ( ! isset( $_POST['my_book_tagline_nonce'] ) || ! wp_verify_nonce( $_POST['my_book_tagline_nonce'], 'my_save_book_tagline' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    $tagline = sanitize_textarea_field( $_POST['my_book_tagline'] );
    update_post_meta( $post_id, '_my_book_tagline', $tagline );
}
add_action( 'save_post_book', 'my_save_book_tagline' );


// Replace the post-title with the post-meta tagline, if there is one stored for the current post
function filter_document_title( $title ) {
    if ( is_singular( 'book' ) ) {
        $tagline = get_post_meta( get_the_ID(), '_my_book_tagline', true );
        if ( ! empty( $tagline ) ) {
            $title = $tagline;
        }
    }
    return $title;
}
add_filter( 'pre_get_document_title', 'filter_document_title' );

// Alter main query to include books in the index.php template
function add_book_to_index_query($query) {
    if ($query->is_main_query() && $query->is_home()) {
      $query->set('post_type', array('post', 'book'));
    }
}
add_action('pre_get_posts', 'add_book_to_index_query');

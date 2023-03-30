<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1" />  
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php
    /**
     * Added backward compatibility for wp_body_open() function.
     */
    if ( function_exists( 'wp_body_open' ) ) {
        wp_body_open();
    } else {
        do_action( 'wp_body_open' );
    }
    ?>

    <header>
        <!-- header content goes here -->
    </header>
    <div id="content">
        <main>
            <!-- main content goes here -->        

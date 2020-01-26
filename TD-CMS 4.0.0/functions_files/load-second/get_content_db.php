<?php

function get_content_database() {
    if (if_404()) {
        get_404();
    }
    elseif (if_on_post()) {
        get_posts();
    }
    elseif (if_search()) {
        get_search();
    }
    else {
        ?>
        <h1><?php get_title(); ?></h1>
        <?php get_content(); ?>
        <?php get_posts(); ?>
        <br>
        <?php
    }
}

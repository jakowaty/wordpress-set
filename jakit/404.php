<?php
/*
 * Jakit Wordpress Theme
 * Author: Piotr Be <herbalist@herbalist.hekko24.pl>
 */
?>

<?php get_header(); ?>

    <article class="content-article <?php if (is_home()): ?>article-shadowed<?php endif ?> br-solid-white-1 w96p mauto" id="post-404-not-found">


        <div class="jakit-entry-meta">
        </div>

        <div class="jakit-entry-content">
            <h1 class="jakit-404 txt-cnt">Requested page not found... 404</h1>
        </div>

    </article>

<?php get_footer(); ?>

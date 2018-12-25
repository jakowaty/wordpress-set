<?php
/*
 * Jakit Wordpress Theme
 * Author: Piotr Be <herbalist@herbalist.hekko24.pl>
 */
?>

<?php get_header(); ?>

    <div class="content-article w96p mauto mbot1e">


        <!-- MAIN CONTENT -->

        <h1 class="jakit-entry-title color-monochrome">Category:
            <span class="jakit-badge jakit-badge-1 color-monochrome">
                <?= single_cat_title(); ?>
            </span>
        </h1>
        <hr class="jakit-separator mtop2p">

        <div class="jakit-gallery-excerpt f-size-08em">
                <?= category_description() ?>
        </div>

        <ul>
            <?php while ( have_posts() ) : the_post();
                get_template_part('content', 'enumerable');
            endwhile; ?>
        </ul>

        <!-- END MAIN CONTENT -->

    </div>

<?php get_footer(); ?>
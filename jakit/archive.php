<?php
/*
 * Jakit Wordpress Theme
 * Author: Piotr Be <herbalist@herbalist.hekko24.pl>
 */
?>

<?php
    $year     = get_query_var('year');
    $monthnum = get_query_var('monthnum');
    $day      = get_query_var('day');

    switch (true) {
        case is_year() :
            $msg = $year;
            break;
        case is_month() :
            $msg = $monthnum . '/' . $year;
            break;
        case is_day() :
        case is_date() :
            $msg = $day . '/' . $monthnum . '/' . $year;
            break;
        default :
            $msg = "error";
            break;
    }
?>

<?php get_header(); ?>

    <div class="content-article w96p mauto mbot1e">


        <!-- MAIN CONTENT -->

        <h1 class="jakit-entry-title color-monochrome">Posts dated:
            <span class="jakit-badge jakit-badge-1 color-monochrome">
                <?= $msg ?>
            </span>
        </h1>
        <hr class="jakit-separator mtop2p">

        <ul>
            <?php while ( have_posts() ) : the_post();
                get_template_part('content', 'enumerable');
            endwhile; ?>
        </ul>

        <!-- END MAIN CONTENT -->

    </div>

<?php get_footer(); ?>
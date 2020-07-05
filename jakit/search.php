<?php
/*
Template Name: Search Page Jakit
*/

/*
 * Jakit Wordpress Theme
 * Author: Piotr Be. <herbalist@herbalist.hekko24.pl>
 */
?>

<?php $q = get_search_query(); ?>
<?php get_header(); ?>

    <div class="content-article w96p mauto">

        <div class="jakit-entry-header">
            <h3 class="jakit-entry-title color-monochrome">
                Results for "<?= $q ?>" (<?= $wp_query->found_posts ?>):
            </h3>
        </div>

        <hr class="jakit-separator mtop2p color-monochrome">

    <?php if (have_posts()): ?>

        <?php while (have_posts()): the_post() ?>
            <div class="search-result br-solid-monochrome-1">

                <a href="<?= get_permalink($post->ID)?>" class="color-dark-grey-1 block-noclear decoration-none">

                    <div class="search-post-type-description w65p jakit-badge">
                        <h4 class="margin0">
                            <?= $post->post_title; ?>
                            <span class="f-size-06em">
                                <?= $post->post_date; ?>, <?php the_author(); ?>
                            </span>
                            <?php $format = get_post_format($post->ID); ?>
                            <?php if ($format === 'gallery'): ?>
                                <span class="glyphicon glyphicon-picture" aria-hidden="true"></span>
                            <?php elseif ($format === 'image'): ?>
                                <span class="glyphicon glyphicon-picture" aria-hidden="true"></span>
                            <?php elseif ($format ==='standard'): ?>
                                <span class="glyphicon glyphicon-text-background" aria-hidden="true"></span>
                            <?php else: ?>
                                <span class="glyphicon glyphicon-text-background" aria-hidden="true"></span>
                            <?php endif ?>
                        </h4>

                        <span class="f-size-08em">
                            <?= get_the_excerpt($post->ID); ?>
                        </span>
                    </div>

                </a>

            </div>
        <?php endwhile ?>



        <?php
            //pagination
            the_posts_pagination(array(
                'prev_text' => __('Previous page',''),
                'next_text'=> __('Next page',''),
                'before_page_number' => '<span class="meta-nav screen-reader-text">' . __('Page', '') . ' </span>',
            ));
        ?>

    <?php else: ?>
        Well, didn't find anything like "<?= $q ?>"....
    <?php endif ?>

    </div>

<?php get_footer(); ?>


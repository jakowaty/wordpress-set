
<?php get_header(); ?>



    <?php
        while ( have_posts() ) : the_post();
        $postId = get_the_ID();
        $src = wp_get_attachment_image_src($postId, 'large');
        $meta = wp_get_attachment_metadata($postId);
        $imageViewHelper = \Jak\Wordpress\Util\Image\ImageViewHelper
            ::create($post->post_parent)
            ->setCurrent(\home_url($wp->request) . "/");

        $prevLink = $imageViewHelper->getPreviousLink() ? \key($imageViewHelper->getPreviousLink()) : false;
        $nextLink = $imageViewHelper->getNextLink() ? \key($imageViewHelper->getNextLink()) : false;
    ?>

    <article class="content-article w96p mauto mbot1e" id="image-<?= $postId ?>">

        <h1 class="jakit-entry-title color-monochrome"><?= the_title('', '', false) ?></h1>

        <div class="jakit-entry-meta color-monochrome">
            <span class="post-date">
                <span class="glyphicon glyphicon-calendar f-size-08em" aria-hidden="false"></span>
                <?= $post->post_date; ?>
            </span>
            <span class="post-author">
                <span class="glyphicon glyphicon-user f-size-08em" aria-hidden="false"></span>
                <b><?php the_author(); ?></b>
            </span>

        </div>

        <div class="jakit-entry-content ov-hid">

                <div id="img-container" class="mauto">
                    <div class="image-nav-button left-button vertical-middle-button
                    <?= $prevLink ? '' : 'img-nav-button-disabled' ?>">
                        <?php if ($prevLink): ?>
                            <a href="<?= $prevLink ?>">
                        <?php endif ?>
                                &laquo;
                        <?php if ($prevLink): ?>
                            </a>
                        <?php endif ?>
                    </div>
                        <a class="jakit-gallery-image-anchor" href="<?= $src[0] ?>" title="<?= $post->post_title ?>">
                            <img
                                class="img-fluid jakit-gallery-image block mauto"
                                src="<?= $src[0] ?>"
                                alt="<?= get_post_meta($attachment_id, '_wp_attachment_image_alt', true)?>"
                                title="<?= $post->post_title ?>"
                            />
                        </a>
                    <div class="image-nav-button right-button vertical-middle-button
                    <?=  $nextLink ? '' : 'img-nav-button-disabled' ?>">
                        <?php if ($nextLink): ?>
                            <a href="<?= $nextLink ?>">
                        <?php endif ?>
                                &raquo;
                        <?php if ($nextLink): ?>
                            </a>
                        <?php endif ?>
                    </div>
                </div>
            </a>

        </div>

        <div class="jakit-gallery-excerpt l-spac-2p f-size-08em f-stretch-exp color-grey1 mauto" style="margin-top: 0.4em; ">
            <?php the_excerpt() ?>
        </div>

        <?php if (is_single()): ?>
            <div class="jakit-entry-footer">
                <!--            <hr class="jakit-separator">-->
                <span class="post-edited color-monochrome">
                <span class="glyphicon glyphicon-edit f-size-08em" aria-hidden="true"></span>
                Edited: <?= $post->post_modified ?>
            </span>
            </div>
        <?php endif ?>

        <hr class="jakit-separator">
    </article>

    <?php endwhile ?>

    <?php if (is_single()): ?>
        <div class="jakit-pagination w96p mauto mbot1e pad3px color-monochrome">
            <?=
                get_previous_post_link(
                    '<div class="nav-previous">%link</div>',
                    'Back to %title',
                    false,
                    '',
                    'category'
                );
            ?>
        </div>
    <?php endif ?>


<?php get_footer(); ?>
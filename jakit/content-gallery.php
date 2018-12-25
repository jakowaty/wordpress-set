<?php
/*
 * Jakit Wordpress Theme
 * Author: Piotr B <herbalist@herbalist.hekko24.pl>
 */
?>

<?php $isHome = is_home(); ?>

<article class="content-article w96p mauto" id="post-<?= $post->ID ?>">

    <div class="jakit-entry-header">
        <?php if ($isHome): ?>
            <a href="<?= get_permalink($post->ID)?>">
        <?php endif; ?>

        <?php if (has_post_thumbnail($post->ID)): ?>
            <img class="w100p mauto block" src="<?php the_post_thumbnail_url(); ?>">
        <?php endif ?>

        <h1 class="jakit-entry-title color-monochrome"><?= the_title(); ?></h1>

        <?php if ($isHome): ?>
            </a>
        <?php endif; ?>
    </div>


    <div class="jakit-entry-meta mbot1e color-monochrome">
        <span class="post-date">
            <span class="glyphicon glyphicon-calendar f-size-08em" aria-hidden="false"></span>
            <?= $post->post_date; ?>
        </span>
        <span class="post-author">
            <span class="glyphicon glyphicon-user f-size-08em" aria-hidden="false"></span>
            <b><?php the_author(); ?></b>
        </span>
        <?php include '_tags.php';?>
        <?php include '_categories.php'; ?>
    </div>


    <div class="jakit-gallery-excerpt l-spac-2p f-size-08em f-stretch-exp color-grey1">
        <?php the_excerpt() ?>
    </div>


    <div class="jakit-entry-content txt-cnt">
        <?php foreach (jakit_get_post_images_array($post) as $imgUrl => $imgThumb): ?>
            <a href="<?= $imgUrl ?>" class="jakit-thumbnail-anchor">
                <img src="/wp-content/themes/jakit/images/default_img.jpg" data-src="<?= $imgThumb[0] ?>" width="<?= $imgThumb[1] ?>" height="<?= $imgThumb[2] ?>" class="jakit-thumbnail-icon mbot5p jakit-loadable-image" />
            </a>
        <?php endforeach ?>
    </div>


    <?php if (is_single()): ?>
        <div class="jakit-entry-footer">
            <span class="post-edited poiret-font color-monochrome">
                <span class="glyphicon glyphicon-edit f-size-08em" aria-hidden="true"></span>
                Edited: <?= $post->post_modified ?>
            </span>
        </div>
    <?php endif ?>
    <hr class="jakit-separator">
</article>

<?php
/*
 * Jakit Wordpress Theme
 * Author: Piotr B <herbalist@herbalist.hekko24.pl>
 */
?>

<?php
    $isHome = is_home();
    $dtPostDate = DateTime::createFromFormat('Y-m-d H:i:s', $post->post_date);

    if (!$dtPostDate) {
        throw new \LogicException("Post should have date");
    }
?>

<article
        class="content-article w96p mauto"
        id="post-<?= $post->ID ?>"
>

    <div class="jakit-entry-header prelative">
        <?php if ($isHome): ?>
            <a href="<?= get_permalink($post->ID)?>" class="header-anchor">

            <span class="post-author f-size-05em l-spac-2p color-monochrome">
                <span class="glyphicon glyphicon-user" aria-hidden="false"></span>
                <b class="orbitron-font">By <?php the_author(); ?>, <?= $dtPostDate->format('l'); ?> <?= $dtPostDate->format('j'); ?> <?= $dtPostDate->format('M'); ?> <?= $dtPostDate->format('Y'); ?></b>
            </span>
        <?php endif; ?>

            <?php if (has_post_thumbnail($post->ID)): ?>
                <img class="w100p mauto block jakit-loadable-image" src="<?php the_post_thumbnail_url(); ?>" data-subscript="<?php the_post_thumbnail_url(); ?>">
            <?php endif ?>

            <div class="prelative color-monochrome ovrfl-hid">

                <div class="orbitron-font inline-block f-size-3em">
                    <?= the_title(); ?>
                </div>
                <?php if (!$isHome): ?>
                <div class="jakit-entry-meta color-monochrome">
                    <span class="post-date">
                        <span class="glyphicon glyphicon-calendar f-size-08em" aria-hidden="false"></span>
                        <span class="orbitron-font"><?= $post->post_date; ?></span>
                    </span>
                            <span class="post-author">
                        <span class="glyphicon glyphicon-user f-size-08em" aria-hidden="false"></span>
                        <span class="orbitron-font"><?php the_author(); ?></span>
                    </span>
                </div>
                <?php endif ?>

            </div>

            <?php if ($isHome): ?>
        </a>
    <?php endif; ?>
    </div>

    <?php if (!$isHome): ?>
    <div class="jakit-entry-meta mbot1e color-monochrome">
        <?php include '_tags.php'; ?>
        <?php include '_categories.php'; ?>
    </div>
    <?php endif ?>

    <div class="jakit-entry-content">
        <?php the_content() ?>
    </div>

    <?php if (is_single()): ?>
        <div class="jakit-entry-footer">

            <span class="post-edited color-monochrome poiret-font">
                <span class="glyphicon glyphicon-edit f-size-08em" aria-hidden="true"></span>
                Edited: <?= $post->post_modified ?>
            </span>
        </div>
    <?php endif ?>
    <hr class="jakit-separator">
    <hr class="jakit-separator">
</article>

<?php
/*
 * Jakit Wordpress Theme
 * Author: Piotr Be <herbalist@herbalist.hekko24.pl>
 */
?>

<?php $postTags = wp_get_object_terms($post->ID, 'category'); ?>
<?php if (!($postTags instanceof WP_Error) && !empty($postTags)): ?>
    <div class="post-tags">
        <span class="orbitron-font">Categories:</span>
        <?php foreach ($postTags as $postTag): ?>
            <span class="jakit-badge jakit-badge-small-1">
                <a href="<?= get_term_link($postTag->term_id); ?>">
                    <?= $postTag->name ?>
                </a>
            </span>
        <?php endforeach ?>
    </div>
<?php endif ?>

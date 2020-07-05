<?php
/*
 * Jakit Wordpress Theme
 * Author: Piotr Be <herbalist@herbalist.hekko24.pl>
 */
?>

<li>
    <a href="<?= get_permalink($post->ID); ?>" class="jakit-enumerated-link">
        <?= the_title()?> - <span class="post-date"><?= get_the_date() ?></span>
    </a>
</li>

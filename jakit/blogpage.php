<?php
/*
Template Name: Blog Page
*/

?>

<?php get_header(); ?>

<?php while ( have_posts() ) : the_post();
    $postFormat = get_post_format();
    get_template_part('content', $postFormat);
endwhile; ?>
<div class="jakit-pagination w96p mauto mbot1e pad3px color-monochrome">
    <?php if (is_home()): ?>
        <?php if (is_array(jakit_pagination_array([]))): ?>
            <?php foreach (jakit_pagination_array([]) as $key => $value):?>
                <?php if ($key == 'page'): ?>
                <?php else: ?>
                    <a href="<?= $value?>" > <?= $key ?></a>
                <?php endif ?>
            <?php endforeach; ?>
        <?php endif; ?>

    <?php elseif (is_single() && !is_home()): ?>

        <span class="poiret-font">
                <?php previous_post_link() ?>
        </span>
        <span class="poiret-font">
                <?php next_post_link() ?>
        </span>

    <?php endif ?>
</div>


<?php get_footer(); ?>

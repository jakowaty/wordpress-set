<?php
/*
Template Name: Splash Page
*/

/*
 * Jakit Wordpress Theme
 * Author: Piotr Be <herbalist@herbalist.hekko24.pl>
 */
?>


<?php get_header(); ?>

<article class="content-article w96p mauto mbot1e">

    <div class="jakit-entry-header">

        <h3 class="jakit-entry-title color-monochrome">
            About me
        </h3>
    </div>

    <hr class="jakit-separator mtop2p color-monochrome">

    <?php
        $post = get_post($post->ID);
        $postContent = !((bool)$post->post_content) ?
            "Nothing here yet..." : $post->post_content;
    ?>
    <?= $postContent; ?>
</article>
<script src="<?= get_template_directory_uri(); ?>/js/splashme.js"></script>
<?php get_footer(); ?>

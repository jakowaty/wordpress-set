<?php
/*
Template Name: Splash Page
*/

/*
 * Jakit Wordpress Theme
 * Author: Piotr Be <herbalist@herbalist.hekko24.pl>
 */
?>

<?php
    $post = get_post($post->ID);
    $postContent = (bool)$post->post_content ?
        $post->post_content : "Nothing here yet...";
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Jakit</title>
        <?php wp_head(); ?>
        <link rel="stylesheet" href="<?= get_template_directory_uri() ?>/styles/jakit-generic.css">
        <link rel="stylesheet" href="<?= get_template_directory_uri() ?>/styles/jakit-responsive.css">
        <link rel="stylesheet" href="<?= get_template_directory_uri() ?>/styles/jakit-splashme.css">
        <link rel="stylesheet" href="<?= get_template_directory_uri() ?>/bootstrap337/css/bootstrap.css" integrity="sha256-fmMNkMcjSw3xcp9iuPnku/ryk9kaWgrEbfJfKmdZ45o=">
        <link rel="stylesheet" href="<?= get_template_directory_uri() ?>/bootstrap337/css/bootstrap-theme.css" integrity="sha256-xOpS+e/dER8z72w+qryCieOGysQI8cELAVt3MHG0phY=">
    </head>

    <body>
        <div class="splashme-field prelative">
            <div class="fadeiner splashme-first-container">
                <div class="splashme-title txt-cnt">
                    <?= get_bloginfo('name'); ?>
                </div>
                <div class="splashme-content mauto">
                    <?= $postContent; ?>
                </div>
            </div>
        </div>
        
        <div class="splashme-field prelative">
            <div class="splashme-content-button mauto">
                <a class="splashme-button block txt-cnt fadeiner" href="/blog">
                    Visit
                </a>
            </div>
        </div>

    </body>
</html>

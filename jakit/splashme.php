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

        <div class="br-solid-white-1 br-nosides">
            <div class="splashme-content mauto">
                <div class="fadeiner">
                    I have worked as PHP developer for:<br>
                    <span class="splashme-badge">prokantor.pl</span>
                    <span class="splashme-badge">edu-forma.pl</span>
                    <span class="splashme-badge">merlin.pl</span>
                    <span class="splashme-badge">miinto.com</span>.
                    <br>
                    I was volunteer PHP programmer in non-governmental organisation:
                    <span class="splashme-badge">Sieć Obywatelska Watchdog</span>.
                    <br>
                    <br>
                    My current language stack is:<br>
                    <span class="splashme-badge">PHP</span>
                    <span class="splashme-badge">SQL</span>
                    <span class="splashme-badge">Javascript</span>
                    <span class="splashme-badge">CSS</span>
                    <span class="splashme-badge">HTML</span>
                    <br>
                    where the former two are the least used (I'm mostly focusing on backend).
                    <br>
                    Currently I'm contributing to <span class="splashme-badge">Opensource System of Archivization (OSA)</span> https://kodujdlapolski.pl/projects/otwarty-system-archiwizacji-osa/
                    <br>
                    <br>
                    During few years of my work and other projects I had occasions to try technologies like: <br>
                    <span class="splashme-badge">Zend 1.12</span>
                    <span class="splashme-badge">Symfony 2/3</span>
                    <span class="splashme-badge">Doctrine</span>
                    <span class="splashme-badge">REST</span>
                    <span class="splashme-badge">PHPUnit</span>
                    <span class="splashme-badge">jQuery</span>
                    <span class="splashme-badge">git</span>
                    <span class="splashme-badge">Docker</span>
                    <span class="splashme-badge">Vagrant</span>
                    <span class="splashme-badge">Java 8</span>
                    <span class="splashme-badge">Swagger UI</span>
                    <span class="splashme-badge">Spring</span>
                    <span class="splashme-badge">Vagrant</span>
                    <span class="splashme-badge">SOLR</span>
                    <span class="splashme-badge">RabbitMQ</span>
                    <span class="splashme-badge">Redis</span>.
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

<!--        <script src="--><?//= get_template_directory_uri(); ?><!--/js/splashme.js"></script>-->
    </body>
</html>

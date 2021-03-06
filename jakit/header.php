<?php
/*
 * Jakit Wordpress Theme
 * Author: Piotr B. <herbalist@herbalist.hekko24.pl>
 */
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
        <link rel="stylesheet" href="<?= get_template_directory_uri() ?>/styles/jakit-image-container.css">
        <link rel="stylesheet" href="<?= get_template_directory_uri() ?>/styles/style2.css">
        <link rel="stylesheet" href="<?= get_template_directory_uri() ?>/bootstrap337/css/bootstrap.css" integrity="sha256-fmMNkMcjSw3xcp9iuPnku/ryk9kaWgrEbfJfKmdZ45o=">
        <link rel="stylesheet" href="<?= get_template_directory_uri() ?>/bootstrap337/css/bootstrap-theme.css" integrity="sha256-xOpS+e/dER8z72w+qryCieOGysQI8cELAVt3MHG0phY=">
        <script src="<?= get_template_directory_uri() . '/js/image-lazy-loader.js'; ?>"></script>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-141272138-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-141272138-1');
        </script>

    </head>
    <body <?php body_class(); ?>>
        <?php require_once '_cookie-info.php'; ?>

        <nav class="navbar navbar-default jakit-nav w100p mauto">

        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed jakit-collapsed-button" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <a class="navbar-brand jakit-blog-title brand-font" href="/blog">
                    <?= get_bloginfo('name'); ?>
                </a>

            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">


                    <?php $pages = jakit_return_pages_list(['Blog']); ?>
                    <?php foreach ($pages as $page): ?>
                        <li class="jakit-navbar-item-li">
                            <a href="<?= $page->link; ?>" class="navbar-font navbar-item"><?= $page->title; ?></a>
                        </li>
                    <?php endforeach ?>

                    <li class="dropdown no-outline jakit-navbar-item-li">
                        <a href="#" class="dropdown-toggle navbar-font navbar-item color-white" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            Blog
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu menu-dropdown">

                            <!-- categories -->
                            <li role="presentation" class="disabled">
                                <a class="navbar-menu-list-divider orbitron-font" href="#">
                                    Categories
                                </a>
                            </li>
                            <?php foreach (jakit_list_categories() as $name => $link): ?>
                                <li>
                                    <a class="navbar-menu-list-position color-white" href="<?= $link ?>" ><?= $name ?></a>
                                </li>
                            <? endforeach ?>
                            <li role="separator" class="divider"></li>


                            <!-- archives -->
                            <li role="presentation" class="disabled">
                                <a class="navbar-menu-list-divider orbitron-font" href="#">
                                    Archives
                                </a>
                            </li>
                            <?php foreach (jakit_archives_array() as $archLink => $archPos): ?>
                                <li>
                                    <a class="navbar-menu-list-position color-white" href="<?= $archLink ?>"><?= $archPos['m'] ?> / <?= $archPos['y'] ?></a>
                                </li>
                            <?php endforeach ?>
                            <li role="separator" class="divider"></li>


                            <!-- tags -->
                            <li role="presentation" class="disabled">
                                <a class="navbar-menu-list-divider orbitron-font" href="#">
                                    Tags
                                </a>
                            </li>
                            <!--                                        <li role="separator" class="divider"></li>-->
                            <?php wp_tag_cloud() ?>

                        </ul>
                    </li>
                </ul>

                <!--search-->
                <form role="search" method="get" id="searchform" class="searchform navbar-form navbar-right" action="/">
                    <div>
                        <div class="form-group">
                            <div class="input-group w100p">
                                <input type="text" value="" name="s" id="s" class="form-control" placeholder="Search" />
                            </div>
                        </div>
                    </div>
                </form>
                <!--end search-->

            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->

    </nav>

        <!-- MAIN CONTENT col-lg-9 col-md-9 -->
        <div class="main">

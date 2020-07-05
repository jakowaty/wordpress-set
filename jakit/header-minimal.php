<?php
/*
 * Jakit Wordpress Theme
 * Author: Piotr Be <herbalist@herbalist.hekko24.pl>
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
    <link rel="stylesheet" href="<?= get_template_directory_uri() ?>/styles/style2.css">
    <link rel="stylesheet" href="<?= get_template_directory_uri() ?>/bootstrap337/css/bootstrap.css" integrity="sha256-fmMNkMcjSw3xcp9iuPnku/ryk9kaWgrEbfJfKmdZ45o=">
    <link rel="stylesheet" href="<?= get_template_directory_uri() ?>/bootstrap337/css/bootstrap-theme.css" integrity="sha256-xOpS+e/dER8z72w+qryCieOGysQI8cELAVt3MHG0phY=">
</head>
<body <?php body_class(); ?>>

<!-- MAIN CONTENT col-lg-9 col-md-9 -->
<div class="main mauto">
    <br>
    <nav class="navbar navbar-default jakit-nav w96p mauto">

        <div class="container-fluid">
            <span class="navbar-brand jakit-blog-title brand-font">
                <?= get_bloginfo('name'); ?>
            </span>

        </div><!-- /.container-fluid -->

    </nav>
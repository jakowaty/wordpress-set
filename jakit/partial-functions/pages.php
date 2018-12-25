<?php
/*
 * Jakit Wordpress Theme
 * Author: Piotr Be <herbalist@herbalist.hekko24.pl>
 */

/**
 * @return array|WP_Post[]
 */
function jakit_get_pages_as_query()
{
    $wpPageQuery = new WP_Query(['post_type' => 'page']);
    $wpPages = [];

    if ($wpPageQuery->have_posts()) {
        $wpPages = $wpPageQuery->get_posts();
    }

    return $wpPages;
}

/**
 * @param string $listItemClass
 * @param string $activeItemClass
 */
function jakit_print_pages_list(
    $listItemClass = 'jakit-navbar-item-li',
    $activeItemClass = 'jakit-navbar-item-li-active'
) {
    $currentUri = jakit_get_current_url();
    $liClass = $listItemClass;

    /** @var WP_Post $page */
    foreach (jakit_get_pages_as_query() as $page) {

        $pagePermalink = rtrim(get_permalink($page), '/');
        $liClass = ($pagePermalink === $currentUri) ? $activeItemClass : $listItemClass;

        echo <<<LI
        <li class="$liClass">
            <a href="{$pagePermalink}">{$page->post_title}</a>
        </li>
LI;
    }
}

/**
 * @return StdClass[]|[]
 */
function jakit_return_pages_list()
{
    $result = [];
    $currentUri = jakit_get_current_url();

    /** @var WP_Post $page */
    foreach (jakit_get_pages_as_query() as $page) {
        $pagePermalink = rtrim(get_permalink($page), '/');
        $isActive = $pagePermalink === $currentUri;

        $row = new StdClass;
        $row->link = $pagePermalink;
        $row->isActive = $isActive;
        $row->title = $page->post_title;

        $result[] = $row;
    }

    return $result;
}
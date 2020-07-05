<?php
/*
 * Jakit Wordpress Theme
 * Author: Piotr Be <herbalist@herbalist.hekko24.pl>
 */

/**
 * @return array|bool|string|WP_Error|WP_Term[]
 */
function jakit_tags_array()
{
    /** @var WP_Term[] $terms */
    $terms = get_tags();

    if (empty($terms)) {
        return [];
    }

    $tags = array();

    foreach ($terms as $term) {
        $link = get_term_link($term, 'post_tag');

        if (is_wp_error($link)) {
            return $link;
        }

        $tags[$term->name] = $link;
    }

    return $tags;
}


/**
 * @param string $args
 * @return array|bool
 */
function jakit_list_categories($args = '')
{
    $defaults = array(
        'child_of'            => 0,
        'current_category'    => 0,
        'depth'               => 0,
        'echo'                => 1,
        'exclude'             => '',
        'exclude_tree'        => '',
        'feed'                => '',
        'feed_image'          => '',
        'feed_type'           => '',
        'hide_empty'          => 1,
        'hide_title_if_empty' => false,
        'hierarchical'        => true,
        'order'               => 'ASC',
        'orderby'             => 'name',
        'separator'           => '',
        'show_count'          => 0,
        'show_option_all'     => '',
        'show_option_none'    => __( 'No categories' ),
        'style'               => 'list',
        'taxonomy'            => 'category',
        'title_li'            => __( 'Categories' ),
        'use_desc_for_title'  => 1,
    );

    $r = wp_parse_args($args, $defaults);

    if ( !isset( $r['pad_counts'] ) && $r['show_count'] && $r['hierarchical'] )
        $r['pad_counts'] = true;

    // Descendants of exclusions should be excluded too.
    if ( true == $r['hierarchical'] ) {
        $exclude_tree = array();

        if ( $r['exclude_tree'] ) {
            $exclude_tree = array_merge( $exclude_tree, wp_parse_id_list( $r['exclude_tree'] ) );
        }

        if ( $r['exclude'] ) {
            $exclude_tree = array_merge( $exclude_tree, wp_parse_id_list( $r['exclude'] ) );
        }

        $r['exclude_tree'] = $exclude_tree;
        $r['exclude'] = '';
    }

    if ( ! isset( $r['class'] ) )
        $r['class'] = ( 'category' == $r['taxonomy'] ) ? 'categories' : $r['taxonomy'];

    if ( ! taxonomy_exists( $r['taxonomy'] ) ) {
        return false;
    }

    /** @var WP_Term[] $categories */
    $categories = get_categories($r);

    $output = [];
    $taxonomy_object = get_taxonomy( $r['taxonomy'] );

    foreach ($categories as $category) {
        /** @var WP_Term $category */
        $output[$category->name] = get_term_link($category, $taxonomy_object);
    }

    return $output;
}


function jakit_archives_array()
{
    global $wpdb;
    $args = [
        'type' => 'monthly',
        'post_type' => 'post',
        'limit' => '',
        'order' => 'DESC'
    ];
    $result = [];
    $sql_where = $wpdb->prepare("WHERE post_type = %s AND post_status = 'publish'", $args['post_type']);
    $last_changed = wp_cache_get_last_changed('posts');
    $query = "
        SELECT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, count(ID) as posts
        FROM $wpdb->posts $sql_where 
        GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date $args[order]
    ";

    $key = md5($query);
    $key = "wp_get_archives:$key:$last_changed";

    if (!$resultsDB = wp_cache_get($key, 'posts' )) {
        $resultsDB = $wpdb->get_results($query);
        wp_cache_set($key, $resultsDB, 'posts');
    }

    if ($resultsDB) {
        foreach ((array) $resultsDB as $resultDB) {
            $result[get_month_link($resultDB->year, $resultDB->month)] =
                ['y' => $resultDB->year, 'm' => $resultDB->month];
        }
    }

    return $result;
}
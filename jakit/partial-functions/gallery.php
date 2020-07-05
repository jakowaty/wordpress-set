<?php
/*
 * Jakit Wordpress Theme
 * Author: Piotr Be <herbalist@herbalist.hekko24.pl>
 */
/**********************/
/*  GALLERY FUNCTIONS */
/**********************/
/**
 * @param string $attr
 * @param $instance
 * @return string
 */
function jakit_gallery_post_format($attr, $instance)
{
    global $post;

    $output = '';
    $gallerySelector = "jakit-gallery-{$post->ID}";

    $atts = shortcode_atts([
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post->ID,
        'itemtag'    => 'div',
        'icontag'    => 'div',
        'captiontag' => 'span',
        'columns'    => 3,
        'size'       => 'thumbnail',
        'include'    => '',
        'exclude'    => '',
        'link'       => ''
    ], $attr);

    $id = intval($atts['id']);

    if (!empty($atts['include'])) {
        $_attachments = get_posts([
            'include' => $atts['include'],
            'post_status' => 'inherit',
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
            'order' => $atts['order'],
            'orderby' => $atts['orderby']
        ]);

        $attachments = [];
        foreach ( $_attachments as $key => $val ) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    } elseif (!empty($atts['exclude'])) {
        $attachments = get_children([
            'post_parent' => $id,
            'exclude' => $atts['exclude'],
            'post_status' => 'inherit',
            'post_type' => 'attachment',
            'post_mime_type' => 'image',
            'order' => $atts['order'],
            'orderby' => $atts['orderby']
        ]);
    } else {
        $attachments = get_children([
            'post_parent' => $id,
            'post_status' => 'inherit','post_type' => 'attachment',
            'post_mime_type' => 'image',
            'order' => $atts['order'],
            'orderby' => $atts['orderby']
        ]);
    }

    if (empty($attachments)) {
        $output = 'There are no images in this gallery!';
    }

    foreach ($attachments as $id => $attachment) {
        $output .= jakit_gallery_image_entry_formatter(
            $id,
            $attachment,
            $atts['size'],
            IMAGE_THUMB_CSS,
            IMAGE_THUMBNAIL_ANCHOR_CSS
        );
    }

    return jakit_gallery_main_formatter($gallerySelector, $output);
}

/**
 * @param $id
 * @param $attachment
 * @return string
 */
function jakit_gallery_image_entry_formatter(
    $id,
    $attachment,
    $size,
    $img_class,
    $anchor_class
)
{
    $url = get_attachment_link($id);
    $src = wp_get_attachment_image_src($id, $size, true);
    return <<<IMG_HTML
    <a href="$url" class="$anchor_class" title="$attachment->post_title">
        <img src="$src[0]" height="$src[2]" width="$src[1]" class="$img_class" alt="$attachment->post_title" title="$attachment->post_title" />
    </a>
IMG_HTML;

}

/**
 * @param string $selector
 * @param string $class
 * @param string $content
 * @return string
 */
function jakit_gallery_main_formatter($selector, $content = '', $class = '')
{
    return <<<HTML_DIV
    <div id="$selector" class="$class">
        $content
    </div>
HTML_DIV;
}

function jakit_get_post_images_array(WP_Post $post, $attachment_size = 'thumbnail')
{
    $query_images_args = array(
        'post_type'      => 'attachment',
        'post_mime_type' => 'image',
        'post_status'    => 'inherit',
        'posts_per_page' => - 1,
        'post_parent'    => $post->ID
    );

    $query_images = new WP_Query( $query_images_args );

    $images = array();
    foreach ( $query_images->posts as $image ) {
        $images[get_permalink($image->ID)] = wp_get_attachment_image_src($image->ID, $attachment_size, false);
    }

    return $images;
}
/*************************/
/* END GALLERY FUNCTIONS */
/*************************/

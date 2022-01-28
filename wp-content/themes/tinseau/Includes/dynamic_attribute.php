<?php

$event_date_attribute = "pa_event_date";

add_action('init', function () use ($event_date_attribute) {
    // if the attribute doesn't exist, create it
    if (!is_admin()) {
        if (!taxonomy_exists($event_date_attribute)) {
            $args = array(
                'slug'    => 'event_date',
                'name'   => 'Date de l\'évenement',
                'type'    => 'select',
                'orderby' => 'menu_order',
                'id' => $event_date_attribute,
                'has_archives'  => false,
            );
            wc_create_attribute( $args );
        }
    }
});


add_filter('woocommerce_attribute_added', function ($id) use ($event_date_attribute) {

    $new_terms = array();
    $query = new WP_Query(array(
        'post_type' => 'product',
        'posts_per_page'   => -1,
        'product_cat' => 'tinseau-test-day',
    ));
    foreach ($query->posts as $post) {
        $new_terms[] = $post->post_title;
    }
    $res = wp_set_object_terms($id, $new_terms, $event_date_attribute);
}, 10, 3);


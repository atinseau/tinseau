<?php



add_action('admin_init', function () {

    $event_date_attribute = "pa_event_date";

    // if the attribute doesn't exist, create it
    if (!taxonomy_exists($event_date_attribute)) {

        $args = array(
            'slug'    => 'event_date',
            'name'   => 'Date de l\'évenement',
            'type'    => 'select',
            'orderby' => 'menu_order',
            'id' => $event_date_attribute,
            'has_archives'  => false,
        );
        $id = wc_create_attribute( $args );

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

    }
});

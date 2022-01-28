<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $wp;

$url = home_url( $wp->request );
$url_replace = substr(str_replace(get_site_url(), '', $url), 1);
$url_split = explode("/", $url_replace);

if ($url_split[0] === "categorie-produit") {
    $shop_url = get_permalink( wc_get_page_id( 'shop' ));
    wp_redirect($shop_url . "?category=" . $url_split[1]);
    exit(0);
}

get_header( 'shop' );


/**
 * Hook: woocommerce_archive_description.
 *
 * @hooked woocommerce_taxonomy_archive_description - 10
 * @hooked woocommerce_product_archive_description - 10
 */
do_action( 'woocommerce_archive_description' );

echo do_shortcode('[catalog]');

get_footer( 'shop' );

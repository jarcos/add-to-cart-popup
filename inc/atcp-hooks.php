<?php
/**
 * Hooks
 *
 * @package Add_To_Cart_Popup
 */

function atcp_get_product_info() {
	$product_id = $_POST['product_id'];
	$product    = wc_get_product( $product_id );

	$product_info = array(
		'product_id' => $product_id,
		'name'       => $product->get_name(),
		'price'      => $product->get_price(),
		'image'      => wp_get_attachment_image_src( $product->get_image_id(), 'woocommerce_thumbnail' )[0],
		'permalink'  => get_permalink( $product_id ),
		'currency'   => get_woocommerce_currency_symbol(),
	);

	wp_send_json_success( $product_info );
}

add_action( 'wp_ajax_atcp_get_product_info', 'atcp_get_product_info' );
add_action( 'wp_ajax_nopriv_atcp_get_product_info', 'atcp_get_product_info' );

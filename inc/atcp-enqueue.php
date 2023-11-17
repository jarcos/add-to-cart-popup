<?php
/**
 * Enqueue scripts and styles.
 *
 * @package Add_To_Cart_Popup
 */

/**
 * Enqueue scripts
 */
function atcp_enqueue_scripts() {
	$display_conditions = get_option( 'woocommerce_add_to_cart_popup_display_conditions' );

	if ( atcp_should_enqueue_script( $display_conditions ) ) {

		wp_enqueue_script( 'add-to-cart-popup', plugin_dir_url( __DIR__ ) . '/js/atcp-scripts.js', array( 'jquery' ), '1.0', true );
		wp_add_inline_script(
			'add-to-cart-popup',
			'const ATCP_AJAX = ' . wp_json_encode(
				array(
					'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
					'nonce'    => wp_create_nonce( 'atcp_nonce' ),
					'layout'   => get_option( 'woocommerce_add_to_cart_popup_layout' ),
					'position' => get_option( 'woocommerce_add_to_cart_popup_position' ),
					'close'    => get_option( 'woocommerce_add_to_cart_popup_close' ),
				)
			),
			'before'
		);

		wp_enqueue_style( 'add-to-cart-popup', plugin_dir_url( __DIR__ ) . '/css/styles.css', array(), '1.0' );
	}
}
add_action( 'wp_enqueue_scripts', 'atcp_enqueue_scripts' );

/**
 * Enqueue admin scripts
 *
 * @return boolean True if the script should be enqueued, false otherwise.
 */
function is_product_attribute() {
	global $wp_query;

	if ( is_archive() ) {
		$attribute_taxonomies = wc_get_attribute_taxonomies();

		if ( $attribute_taxonomies ) {
			foreach ( $attribute_taxonomies as $tax ) {
				$taxonomy_name = wc_attribute_taxonomy_name( $tax->attribute_name );

				if ( is_tax( $taxonomy_name ) ) {
					return true;
				}
			}
		}
	}

	return false;
}

/**
 * Check if the script should be enqueued.
 *
 * @param array $conditions Array of conditions.
 * @return boolean True if the script should be enqueued, false otherwise.
 */
function atcp_should_enqueue_script( $conditions ) {
	if ( in_array( 'all', $conditions, true ) ) {
		return true;
	}

	if ( is_shop() && in_array( 'Shop Archive', $conditions, true ) ) {
		return true;
	}

	if ( is_product_category() && in_array( 'Shop Archive Categories', $conditions, true ) ) {
		return true;
	}

	if ( is_product_tag() && in_array( 'Shop Archive Tags', $conditions, true ) ) {
		return true;
	}

	if ( is_product_attribute() && in_array( 'Shop Archive Product Attributes', $conditions, true ) ) {
		return true;
	}

	if ( is_product() && in_array( 'Single Products', $conditions, true ) ) {
		return true;
	}

	return false;
}

<?php
/**
 * Settings.
 *
 * @package Add_To_Cart_Popup
 */

/**
 * Enqueue scripts and styles.
 *
 * @return void
 */
function atcp_check_woocommerce() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		deactivate_plugins( plugin_basename( __FILE__ ) );
		wp_die( esc_html__( 'Add to Cart Popup requires WooCommerce to be installed and activated.', 'add-to-cart-popup' ) );
	}
}
add_action( 'plugins_loaded', 'atcp_check_woocommerce' );

/**
 * Add to Cart Popup settings.
 *
 * @param array $settings_tabs Array of Woo setting tabs & their labels, excluding the Subscription tab.
 * @return array $settings_tabs Array of Woo setting tabs & their labels, including the Subscription tab.
 */
function atcp_add_wc_settings_tab( $settings_tabs ) {
	$settings_tabs['add_to_cart_popup'] = __( 'Add to Cart Popup', 'add-to-cart-popup' );
	return $settings_tabs;
}
add_filter( 'woocommerce_settings_tabs_array', 'atcp_add_wc_settings_tab', 50 );

/**
 * Add to Cart Popup settings.
 *
 * @return void
 */
function atcp_settings_tab() {
	woocommerce_admin_fields( atcp_get_settings() );
}
add_action( 'woocommerce_settings_tabs_add_to_cart_popup', 'atcp_settings_tab' );

/**
 * Add to Cart Popup settings.
 *
 * @return array Array of setting fields.
 */
function atcp_get_settings() {
	$settings = array(
		'title'              => array(
			'name' => __( 'Add To Cart Popup', 'add-to-cart-popup' ),
			'type' => 'title',
			'desc' => '',
			'id'   => 'woocommerce_add_to_cart_popup_settings',
		),
		'layout'             => array(
			'name'    => __( 'Layout', 'add-to-cart-popup' ),
			'type'    => 'radio',
			'desc'    => __( 'Select the layout of the popup.', 'add-to-cart-popup' ),
			'id'      => 'woocommerce_add_to_cart_popup_layout',
			'options' => array(
				'layout-left' => __( 'Within the Content Product Image', 'add-to-cart-popup' ),
				'layout-bg'   => __( 'Background Product Image', 'add-to-cart-popup' ),
			),
		),
		'position'           => array(
			'name'    => __( 'Position', 'add-to-cart-popup' ),
			'type'    => 'radio',
			'desc'    => __( 'Select the position of the popup.', 'add-to-cart-popup' ),
			'id'      => 'woocommerce_add_to_cart_popup_position',
			'options' => array(
				'position-top'    => __( 'Top', 'add-to-cart-popup' ),
				'position-bottom' => __( 'Bottom', 'add-to-cart-popup' ),
			),
		),
		'close'              => array(
			'name' => __( 'Close After (Seconds)', 'add-to-cart-popup' ),
			'type' => 'number',
			'desc' => __( 'Select the number of seconds before the popup closes.', 'add-to-cart-popup' ),
			'id'   => 'woocommerce_add_to_cart_popup_close',
		),
		'display_conditions' => array(
			'name'    => __( 'Display Conditions', 'add-to-cart-popup' ),
			'type'    => 'multiselect',
			'desc'    => __( 'Select the conditions that must be met before the popup is displayed.', 'add-to-cart-popup' ),
			'id'      => 'woocommerce_add_to_cart_popup_display_conditions',
			'options' => array(
				'all'                     => __( 'All Pages', 'add-to-cart-popup' ),
				'Shop Archive'            => __( 'Shop Archive', 'add-to-cart-popup' ),
				'Shop Archive Categories' => __( 'Shop Archive Categories', 'add-to-cart-popup' ),
				'Shop Archive Tags'       => __( 'Shop Archive Tags', 'add-to-cart-popup' ),
				'Shop Archive Attributes' => __( 'Shop Archive Attributes', 'add-to-cart-popup' ),
				'Single Products'         => __( 'Single Products', 'add-to-cart-popup' ),
			),
		),
		'section_end'        => array(
			'type' => 'sectionend',
			'id'   => 'woocommerce_add_to_cart_popup_settings',
		),
	);
	return apply_filters( 'woocommerce_add_to_cart_popup_settings', $settings );
}
add_action( 'woocommerce_settings_tabs_add_to_cart_popup', 'atcp_get_settings' );

/**
 * Update settings.
 *
 * @return void
 */
function atcp_update_settings() {
	woocommerce_update_options( atcp_get_settings() );
}
add_action( 'woocommerce_update_options_add_to_cart_popup', 'atcp_update_settings' );

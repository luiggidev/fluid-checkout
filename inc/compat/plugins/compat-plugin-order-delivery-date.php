<?php
defined( 'ABSPATH' ) || exit;

/**
 * Compatibility with plugin: Order Delivery Date Pro for WooCommerce (by Tyche Softwares).
 */
class FluidCheckout_OrderDeliveryDate extends FluidCheckout {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->hooks();
	}


	/**
	 * Initialize hooks.
	 */
	public function hooks() {
		if ( ! is_plugin_active( 'order-delivery-date/order_delivery_date.php' ) ) {
			return;
		}

		// Skip delivery date fields.
		add_filter( 'fc_hide_optional_fields_skip_field', array( $this, 'skip_delivery_date_fields' ), 10, 4 );

		// Register and enqueue checkout-only assets.
		add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ), 5 );
		add_action( 'wp_enqueue_scripts', array( $this, 'maybe_enqueue_assets' ), 10 );
	}


	/**
	 * Keep the delivery date field visible when optional fields are hidden.
	 *
	 * @param  bool   $skip   Whether to skip hiding the field.
	 * @param  string $key    Field key.
	 * @param  array  $args   Field arguments.
	 * @param  mixed  $value  Field value.
	 *
	 * @return bool
	 */
	public function skip_delivery_date_fields( $skip, $key, $args, $value ) {
		// Match fields whose keys start with "e_deliverydate" no matter the vendor/product suffix.
		if ( 0 === strpos( $key, 'e_deliverydate' ) ) {
			return true;
		}

		return $skip;
	}

	/**
	 * Enqueue inline script so Order Delivery Date re-runs initialization after FC updates fragments.
	 */
	public function maybe_enqueue_assets() {
		// Bail if not on a checkout context.
		if ( ! function_exists( 'is_checkout' ) ) {
			return;
		}

		if ( ! is_checkout() || is_order_received_page() || is_checkout_pay_page() ) {
			return;
		}

		wp_enqueue_script( 'fc-compat-order-delivery-date' );
	}

	/**
	 * Register the compatibility asset.
	 */
	public function register_assets() {
		wp_register_script(
			'fc-compat-order-delivery-date',
			FluidCheckout_Enqueue::instance()->get_script_url( 'js/compat/plugins/order-delivery-date/order-delivery-date' ),
			array( 'fc-utils' ),
			NULL,
			array( 'in_footer' => true, 'strategy' => 'defer' )
		);
	}
}

FluidCheckout_OrderDeliveryDate::instance();


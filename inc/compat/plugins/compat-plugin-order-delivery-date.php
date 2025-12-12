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
		add_action( 'wp_enqueue_scripts', array( $this, 'register_compatibility_script' ), 5 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_compatibility_script' ), 10 );

		// Skip delivery date fields.
		add_filter( 'fc_hide_optional_fields_skip_field', array( $this, 'skip_delivery_date_fields' ), 10, 4 );
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
	public function enqueue_compatibility_script() {
		wp_enqueue_script( 'fc-compat-order-delivery-date' );
	}

	/**
	 * Register the compatibility asset.
	 */
	public function register_compatibility_script() {
		// Bail if not at checkout page, and not an AJAX request to update checkout fragment
		if ( ! FluidCheckout_Steps::instance()->is_checkout_page_or_fragment() ) { return; }
		
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


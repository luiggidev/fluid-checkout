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
		// Match fields whose keys start with "e_deliverydate" or "orddd_time_slot" no matter the vendor/product suffix.
		if ( 0 === strpos( $key, 'e_deliverydate' ) || 0 === strpos( $key, 'orddd_time_slot' ) ) {
			return true;
		}

		return $skip;
	}

}

FluidCheckout_OrderDeliveryDate::instance();


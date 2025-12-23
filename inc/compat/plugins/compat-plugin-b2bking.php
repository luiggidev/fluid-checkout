<?php
defined( 'ABSPATH' ) || exit;

/**
 * Compatibility with plugin: B2BKing.
 */
class FluidCheckout_B2bking extends FluidCheckout {

	/**
	 * Flag to indicate the next validation run should capture `wc_print_notice` output.
	 *
	 * @var bool
	 */
	protected $should_capture_dynamic_notices = false;

	/**
	 * Buffered notices from the last fragments request.
	 *
	 * @var string
	 */
	protected $captured_dynamic_notices = '';

	/**
	 * __construct function.
	 */
	public function __construct() {
		$this->hooks();
	}

	/**
	 * Initialize hooks.
	 */
	public function hooks() {
		add_action( 'wp', array( $this, 'late_hooks' ), 100 );
	}

	/**
	 * Add or remove late hooks.
	 */
	public function late_hooks() {
		$this->checkout_hooks();
	}

	/**
	 * Add or remove checkout hooks.
	 */
	public function checkout_hooks() {
		// Bail if not on checkout page
		if ( ! FluidCheckout_Steps::instance()->is_checkout_page_or_fragment() ) { return; }

		// Bail if B2BKing dynamic min/max order amount function is not callable
		if ( ! is_callable( array( 'B2bking_Dynamic_Rules', 'b2bking_dynamic_minmax_order_amount' ) ) ) { return; }

		add_action( 'wc_ajax_fc_update_fragments', array( $this, 'prepare_fragments_capture' ), 5 );
		add_action( 'woocommerce_check_cart_items', array( $this, 'capture_dynamic_notices' ), 10 );
		add_filter( 'fc_update_fragments', array( $this, 'inject_notices_fragment' ), 20 );
		add_action( 'woocommerce_before_checkout_form', array( $this, 'output_dynamic_notices_container' ), 5 );

		$this->remove_plugin_dynamic_minmax_actions();
	}

	/**
	 * Informs the validator that it should buffer direct output and resets the cache.
	 */
	public function prepare_fragments_capture() {
		$this->should_capture_dynamic_notices = true;
		$this->captured_dynamic_notices       = '';
	}

	/**
	 * Runs the B2BKing dynamic rules and captures their notices when needed.
	 */
	public function capture_dynamic_notices() {
		if ( ! $this->should_capture_dynamic_notices ) { return; }

		ob_start();
		call_user_func( array( 'B2bking_Dynamic_Rules', 'b2bking_dynamic_minmax_order_amount' ) );
		$this->captured_dynamic_notices .= ob_get_clean();

		$this->should_capture_dynamic_notices = false;
	}

	/**
	 * Injects the captured B2BKing notices into the dynamic notices fragment.
	 *
	 * @param array $fragments Current fragments.
	 * @return array
	 */
	public function inject_notices_fragment( $fragments ) {
		if ( '' === $this->captured_dynamic_notices ) {
			return $fragments;
		}

		$fragments['.fc-b2bking-dynamic-notices'] = $this->get_dynamic_notices_fragment( $this->captured_dynamic_notices );
		$this->captured_dynamic_notices = '';

		return $fragments;
	}

	/**
	 * Output the placeholder element for the dynamic notices container.
	 */
	public function output_dynamic_notices_container() {
		echo '<div class="fc-b2bking-dynamic-notices" aria-live="polite"></div>';
	}

	/**
	 * Build the dynamic notices fragment.
	 *
	 * @return string
	 */
	public function get_dynamic_notices_fragment( $captured_notices = '' ) {
		return '<div class="fc-b2bking-dynamic-notices" aria-live="polite">' . $captured_notices . '</div>';
	}

	/**
	 * Prevent B2BKing from registering the default dynamic min/max notices.
	 */
	public function remove_plugin_dynamic_minmax_actions() {
		$callback = array( 'B2bking_Dynamic_Rules', 'b2bking_dynamic_minmax_order_amount' );

		foreach ( array(
			'woocommerce_check_cart_items',
			'woocommerce_before_cart',
			'woocommerce_before_checkout_form',
			'woocommerce_checkout_process',
		) as $hook ) {
			if ( has_action( $hook, $callback ) ) {
				remove_action( $hook, $callback, 10 );
			}
		}
	}
}

FluidCheckout_B2bking::instance();


(function(){
	// Ensure Tyche Order Delivery Date hooks rerun when FC replaces fragments.
	var rerun = function(){
		console.log( 'fc-compat-order-delivery-date: rerun triggered' );
		console.log( window.tyche );
		console.log( window.tyche.orddd );
		if ( ! ( window.tyche && window.tyche.orddd ) ) {
			console.debug( 'fc-compat-order-delivery-date: tyche.orddd not ready yet' );
			return;
		}

		var orderDelivery = window.tyche.orddd;
		if ( typeof orderDelivery.init_datepicker === 'function' ) {
			console.log( 'fc-compat-order-delivery-date: init_datepicker triggered' );
			orderDelivery.init_datepicker();
		}
		if ( typeof orderDelivery.init_datepicker_fields === 'function' ) {
			console.log( 'fc-compat-order-delivery-date: init_datepicker_fields triggered' );
			orderDelivery.init_datepicker_fields();
		}
		if ( typeof orderDelivery.style_widget === 'function' ) {
			console.log( 'fc-compat-order-delivery-date: style_widget triggered' );
			orderDelivery.style_widget();
		}
	};

	// Reapply right after fragments are replaced and at least once on page load.
	document.body.addEventListener( 'fc_checkout_fragments_replace_after', rerun );
	if ( document.readyState === 'complete' ) {
		console.log( 'fc-compat-order-delivery-date: rerun triggered' );
		rerun();
	} else {
		window.addEventListener( 'load', rerun );
	}
})();
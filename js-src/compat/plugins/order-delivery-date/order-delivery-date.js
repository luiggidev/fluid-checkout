(function(){
	// Force Order Delivery Date to reinitialize after FC replaces checkout fragments.
	var rerun = function(){
		console.debug( 'fc-compat-order-delivery-date: rerun triggered', {
			hasTyche: !!window.tyche,
			hasOrderDeliveryDate: !!( window.tyche && tyche.orddd ),
		} );

		if ( window.tyche && tyche.orddd && typeof tyche.orddd.init_datepicker === 'function' ) {
			tyche.orddd.init_datepicker();
			if ( typeof tyche.orddd.init_datepicker_fields === 'function' ) {
				tyche.orddd.init_datepicker_fields();
			}
			if ( typeof tyche.orddd.style_widget === 'function' ) {
				tyche.orddd.style_widget();
			}
		} else {
			console.debug( 'fc-compat-order-delivery-date: tyche.orddd not ready yet' );
		}
	};

	// Reapply right after we replace fragments and once on load.
	document.body.addEventListener( 'fc_checkout_fragments_replace_after', rerun );
	if ( document.readyState === 'complete' ) {
		rerun();
	} else {
		window.addEventListener( 'load', rerun );
	}
})();


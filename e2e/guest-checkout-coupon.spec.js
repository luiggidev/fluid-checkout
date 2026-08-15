'use strict';

const path = require( 'path' );
const { test, expect } = require( '../fluid-checkout-standards/playwright/lib/test' );
const { completeGuestCheckoutWithCoupon } = require( '../fluid-checkout-standards/playwright/flows/guest-checkout-coupon' );
const { selectors } = require( '../fluid-checkout-standards/playwright/lib/selectors' );

const pluginRoot = path.join( __dirname, '..' );

// Baseline seed pins coupon at payment substep (substep_before_payment).
test( 'guest can place order with coupon applied @smoke', async ( { page } ) => {
	await completeGuestCheckoutWithCoupon( page, { pluginRoot } );

	await expect( page.locator( selectors.orderReceived ) ).toBeVisible();
} );

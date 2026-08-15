'use strict';

const path = require( 'path' );
const { test, expect } = require( '@playwright/test' );
const { completeGuestCheckout } = require( '../fluid-checkout-standards/playwright/flows/guest-checkout' );
const { selectors } = require( '../fluid-checkout-standards/playwright/lib/selectors' );

test( 'guest can place an order with cash on delivery', async ( { page } ) => {
	await completeGuestCheckout( page, { pluginRoot: path.join( __dirname, '..' ) } );

	await expect( page.locator( selectors.orderReceived ) ).toBeVisible();
} );

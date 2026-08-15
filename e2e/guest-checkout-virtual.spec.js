'use strict';

const path = require( 'path' );
const { test, expect } = require( '../fluid-checkout-standards/playwright/lib/test' );
const { completeGuestCheckoutVirtual } = require( '../fluid-checkout-standards/playwright/flows/guest-checkout-virtual' );
const { selectors } = require( '../fluid-checkout-standards/playwright/lib/selectors' );

const pluginRoot = path.join( __dirname, '..' );

test( 'guest can place order for virtual product @smoke', async ( { page } ) => {
	await completeGuestCheckoutVirtual( page, { pluginRoot } );

	await expect( page.locator( selectors.orderReceived ) ).toBeVisible();
	await expect( page.locator( selectors.substep( 'shipping_address' ) ) ).toHaveCount( 0 );
} );

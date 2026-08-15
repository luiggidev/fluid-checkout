'use strict';

const path = require( 'path' );
const { test, expect } = require( '../fluid-checkout-standards/playwright/lib/test' );
const { goFromCartToCheckout } = require( '../fluid-checkout-standards/playwright/flows/cart-to-checkout' );
const { selectors } = require( '../fluid-checkout-standards/playwright/lib/selectors' );

const pluginRoot = path.join( __dirname, '..' );

test( 'guest can proceed from cart to checkout @smoke', async ( { page } ) => {
	await goFromCartToCheckout( page, { pluginRoot } );

	await expect( page.locator( selectors.checkoutSteps ) ).toBeVisible();
} );

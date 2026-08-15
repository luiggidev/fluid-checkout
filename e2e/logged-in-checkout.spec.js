'use strict';

const path = require( 'path' );
const { test, expect } = require( '../fluid-checkout-standards/playwright/lib/test' );
const { completeLoggedInCheckout } = require( '../fluid-checkout-standards/playwright/flows/logged-in-checkout' );
const { applySettingsProfile } = require( '../fluid-checkout-standards/playwright/lib/settings' );
const { selectors } = require( '../fluid-checkout-standards/playwright/lib/selectors' );

const pluginRoot = path.join( __dirname, '..' );

test.describe.configure( { mode: 'serial' } );

test( 'logged-in customer can place an order @smoke', async ( { page } ) => {
	await completeLoggedInCheckout( page, { pluginRoot } );
	await expect( page.locator( selectors.orderReceived ) ).toBeVisible();
} );

test.describe( 'billing separate from shipping', () => {
	test.beforeAll( () => {
		applySettingsProfile( pluginRoot, 'billing-separate' );
	} );

	test.afterAll( () => {
		applySettingsProfile( pluginRoot, 'baseline' );
	} );

	test( 'logged-in customer with billing separate from shipping @smoke', async ( { page } ) => {
		await completeLoggedInCheckout( page, { pluginRoot } );
		await expect( page.locator( selectors.orderReceived ) ).toBeVisible();
	} );
} );

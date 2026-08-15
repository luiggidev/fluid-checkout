'use strict';

const path = require( 'path' );
const { test, expect } = require( '../fluid-checkout-standards/playwright/lib/test' );
const { completeGuestCheckout } = require( '../fluid-checkout-standards/playwright/flows/guest-checkout' );
const { applySettingsProfile } = require( '../fluid-checkout-standards/playwright/lib/settings' );
const { selectors } = require( '../fluid-checkout-standards/playwright/lib/selectors' );

const pluginRoot = path.join( __dirname, '..' );

test.describe.configure( { mode: 'serial' } );

test.beforeAll( () => {
	applySettingsProfile( pluginRoot, 'single-step' );
} );

test.afterAll( () => {
	applySettingsProfile( pluginRoot, 'baseline' );
} );

test( 'guest can place order in single-step layout @smoke', async ( { page } ) => {
	await completeGuestCheckout( page, { pluginRoot } );
	await expect( page.locator( selectors.orderReceived ) ).toBeVisible();
} );

'use strict';

/**
 * Do not run Playwright from this plugin root.
 * Specs and the authoritative runner live in fluid-checkout-standards.
 *
 *   cd ../fluid-checkout-standards && npm run test:e2e
 *
 * Or use: npm run test:e2e  (delegates via package.json)
 */
throw new Error(
	'E2E runner is fluid-checkout-standards. ' +
	'Run: cd ../fluid-checkout-standards && npm run test:e2e ' +
	'(or npm run test:e2e from this plugin — it delegates).'
);

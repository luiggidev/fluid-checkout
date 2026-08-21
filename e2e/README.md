# E2E specs

For now, the authoritative suite lives in **fluid-checkout-standards**:

```bash
cd ../fluid-checkout-standards
npm install
npx playwright install chromium   # once
npm run test:e2e
```

This plugin’s `npm run test:e2e*` scripts delegate there so you are not maintaining two runners.

Product issue branches do **not** need local `e2e/` specs. Switch Lite/PRO branches freely; the library runs against whatever is active on Local.

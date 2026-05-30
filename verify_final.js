const { chromium } = require('playwright');
(async () => {
  const browser = await chromium.launch();
  const page = await browser.newPage();
  await page.setViewportSize({ width: 1280, height: 1080 });

  // Main Index
  await page.goto('file://' + process.cwd() + '/docs/index.html');
  await page.screenshot({ path: 'final_index.png', fullPage: true });

  // Code Page
  await page.goto('file://' + process.cwd() + '/docs/code.html');
  await page.screenshot({ path: 'final_code.png', fullPage: true });

  await browser.close();
})();

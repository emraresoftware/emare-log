const puppeteer = require('puppeteer');

(async () => {
  const browser = await puppeteer.launch({ headless: 'new' });
  const page = await browser.newPage();
  await page.setViewport({ width: 1920, height: 1080 });
  
  // Login
  await page.goto('https://hiper.isskontrol.com.tr/login', { waitUntil: 'networkidle2', timeout: 30000 });
  
  const usernameInput = await page.$('input[type="text"], input[name*="user"], input[name*="email"]');
  if (usernameInput) {
    await usernameInput.click({ clickCount: 3 });
    await usernameInput.type('elmsravyödeme');
  }
  const passwordInput = await page.$('input[type="password"]');
  if (passwordInput) {
    await passwordInput.click({ clickCount: 3 });
    await passwordInput.type('123456');
  }
  const submitBtn = await page.$('button[type="submit"], input[type="submit"]');
  if (submitBtn) await submitBtn.click();
  
  await page.waitForNavigation({ waitUntil: 'networkidle2', timeout: 15000 }).catch(() => {});
  await new Promise(r => setTimeout(r, 3000));
  
  console.log('Logged in. URL:', page.url());
  
  // Get COMPLETE sidebar/navigation menu
  const fullNavigation = await page.evaluate(() => {
    // Try to get all menu links from sidebar
    const allLinks = document.querySelectorAll('a[href]');
    const results = [];
    const seen = new Set();
    
    for (const link of allLinks) {
      const href = link.href;
      const text = link.textContent?.trim().replace(/\s+/g, ' ');
      if (href && text && !seen.has(href) && href.includes('hiper.isskontrol.com.tr') && !href.includes('#')) {
        seen.add(href);
        results.push({ text, href });
      }
    }
    return results;
  });
  
  console.log('=== ALL NAVIGATION LINKS ===');
  console.log(JSON.stringify(fullNavigation, null, 2));
  
  // Now get the full sidebar HTML structure
  const sidebarHtml = await page.evaluate(() => {
    const sidebar = document.querySelector('.app-sidebar, .sidebar, [class*="sidebar"], aside, nav.main-menu');
    if (!sidebar) return 'No sidebar found';
    
    // Get all menu items with their nesting structure
    const menuItems = [];
    const processElement = (el, depth = 0) => {
      if (el.tagName === 'A' || el.tagName === 'SPAN') {
        const text = el.textContent?.trim().replace(/\s+/g, ' ');
        const href = el.href || '';
        if (text && text.length > 0 && text.length < 200) {
          menuItems.push({ depth, text, href, tag: el.tagName });
        }
      }
      for (const child of el.children) {
        processElement(child, el.classList?.contains('sub-menu') || el.classList?.contains('submenu') || el.tagName === 'UL' ? depth + 1 : depth);
      }
    };
    processElement(sidebar);
    return JSON.stringify(menuItems, null, 2);
  });
  console.log('=== SIDEBAR STRUCTURE ===');
  console.log(sidebarHtml);
  
  // Get the main content area structure - all sections and their headers
  const mainContent = await page.evaluate(() => {
    const main = document.querySelector('.main-content, .content, [class*="content"], main, .app-content');
    if (!main) return 'No main content found';
    
    const sections = main.querySelectorAll('.card, .panel, .widget, section, [class*="card"]');
    return Array.from(sections).map(s => ({
      title: s.querySelector('h1,h2,h3,h4,h5,h6,.card-title,.panel-title,.widget-title')?.textContent?.trim(),
      class: s.className?.substring(0, 100),
      content: s.textContent?.trim().substring(0, 300)
    })).filter(s => s.title || s.content);
  });
  console.log('=== MAIN CONTENT SECTIONS ===');
  console.log(JSON.stringify(mainContent, null, 2));

  // Now let's visit key pages to understand their structure
  const pagesToVisit = [
    '/musteriler',
    '/musteriler/ekle', 
    '/basvurular',
    '/teknik-servis',
    '/odeme',
    '/raporlar',
    '/ayarlar',
    '/sms',
    '/is-emirleri',
    '/tarifeler',
    '/cihazlar',
    '/mikrotik',
    '/finans',
    '/faturalar',
    '/tahsilat',
    '/bayi',
    '/kullanicilar',
    '/roller',
    '/loglar'
  ];
  
  for (const path of pagesToVisit) {
    try {
      const url = `https://hiper.isskontrol.com.tr${path}`;
      const response = await page.goto(url, { waitUntil: 'networkidle2', timeout: 10000 });
      const status = response?.status();
      
      if (status === 200 && !page.url().includes('login')) {
        const pageTitle = await page.evaluate(() => {
          const h = document.querySelector('h1,h2,.page-title,.content-header');
          return h?.textContent?.trim().substring(0, 100) || document.title;
        });
        
        // Get table headers if any
        const tableHeaders = await page.evaluate(() => {
          const ths = document.querySelectorAll('th');
          return Array.from(ths).map(th => th.textContent?.trim()).filter(t => t && t.length < 100);
        });
        
        // Get form fields if any
        const formFields = await page.evaluate(() => {
          const inputs = document.querySelectorAll('input, select, textarea');
          return Array.from(inputs).map(inp => ({
            type: inp.type || inp.tagName.toLowerCase(),
            name: inp.name,
            id: inp.id,
            label: inp.closest('.form-group')?.querySelector('label')?.textContent?.trim() || ''
          })).filter(f => f.name || f.id);
        });
        
        console.log(`\n=== PAGE: ${path} (${status}) ===`);
        console.log('Title:', pageTitle);
        if (tableHeaders.length > 0) console.log('Table headers:', tableHeaders);
        if (formFields.length > 0) console.log('Form fields:', JSON.stringify(formFields.slice(0, 20)));
      } else {
        console.log(`\n=== PAGE: ${path} - Status: ${status}, Redirected: ${page.url().includes('login') ? 'YES (login)' : 'NO'} ===`);
      }
    } catch (err) {
      console.log(`\n=== PAGE: ${path} - Error: ${err.message?.substring(0, 100)} ===`);
    }
  }
  
  await browser.close();
})();

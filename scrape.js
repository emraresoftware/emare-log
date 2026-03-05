const puppeteer = require('puppeteer');

(async () => {
  const browser = await puppeteer.launch({ headless: 'new' });
  const page = await browser.newPage();
  await page.setViewport({ width: 1920, height: 1080 });
  
  // Go to login page
  await page.goto('https://hiper.isskontrol.com.tr/login', { waitUntil: 'networkidle2', timeout: 30000 });
  console.log('=== LOGIN PAGE LOADED ===');
  
  // Get the HTML structure of the login form
  const loginFormHtml = await page.evaluate(() => {
    const form = document.querySelector('form');
    return form ? form.innerHTML : 'No form found';
  });
  console.log('Login form HTML:', loginFormHtml.substring(0, 500));
  
  // Find input fields
  const inputs = await page.evaluate(() => {
    const allInputs = document.querySelectorAll('input');
    return Array.from(allInputs).map(i => ({
      type: i.type, name: i.name, id: i.id, placeholder: i.placeholder
    }));
  });
  console.log('Inputs found:', JSON.stringify(inputs, null, 2));
  
  // Try to fill in login credentials
  // Look for username field
  const usernameSelector = await page.evaluate(() => {
    const inputs = document.querySelectorAll('input');
    for (const inp of inputs) {
      if (inp.type === 'text' || inp.name?.includes('user') || inp.name?.includes('email') || inp.id?.includes('user') || inp.id?.includes('email') || inp.placeholder?.includes('Kullanıcı')) {
        return inp.name || inp.id || `input[type="${inp.type}"]`;
      }
    }
    return null;
  });
  console.log('Username selector:', usernameSelector);
  
  // Try filling the form
  try {
    // Type username
    const usernameInput = await page.$('input[type="text"], input[name*="user"], input[name*="email"], input[id*="user"], input[id*="email"]');
    if (usernameInput) {
      await usernameInput.click({ clickCount: 3 });
      await usernameInput.type('elmsravyödeme');
      console.log('Username typed');
    }
    
    // Type password
    const passwordInput = await page.$('input[type="password"]');
    if (passwordInput) {
      await passwordInput.click({ clickCount: 3 });
      await passwordInput.type('123456');
      console.log('Password typed');
    }
    
    // Click submit
    const submitBtn = await page.$('button[type="submit"], input[type="submit"], button:not([type])');
    if (submitBtn) {
      await submitBtn.click();
      console.log('Submit clicked');
    }
    
    // Wait for navigation
    await page.waitForNavigation({ waitUntil: 'networkidle2', timeout: 15000 }).catch(() => console.log('Navigation timeout - checking page anyway'));
    
    console.log('=== AFTER LOGIN ===');
    console.log('Current URL:', page.url());
    
    // Wait a bit for any dynamic content
    await new Promise(r => setTimeout(r, 3000));
    
    console.log('Current URL after wait:', page.url());
    
    // Get page title
    const title = await page.title();
    console.log('Page title:', title);
    
    // Get all navigation links / menu items
    const menuItems = await page.evaluate(() => {
      const links = document.querySelectorAll('a, .nav-link, .menu-item, [class*="menu"], [class*="nav"], .sidebar a, .sidebar-menu a');
      return Array.from(links).map(el => ({
        text: el.textContent?.trim().substring(0, 100),
        href: el.href,
        class: el.className?.substring(0, 100)
      })).filter(item => item.text && item.text.length > 0);
    });
    console.log('Menu items:', JSON.stringify(menuItems, null, 2));
    
    // Get sidebar content
    const sidebarContent = await page.evaluate(() => {
      const sidebar = document.querySelector('.sidebar, .nav-sidebar, [class*="sidebar"], [class*="aside"], nav');
      return sidebar ? sidebar.textContent?.trim().substring(0, 2000) : 'No sidebar found';
    });
    console.log('Sidebar content:', sidebarContent);
    
    // Get full page text content for overview
    const bodyText = await page.evaluate(() => {
      return document.body?.textContent?.trim().substring(0, 5000) || 'No body content';
    });
    console.log('=== PAGE CONTENT ===');
    console.log(bodyText);
    
    // Get full HTML structure
    const htmlStructure = await page.evaluate(() => {
      // Get main structural elements
      const elements = document.querySelectorAll('[class*="card"], [class*="widget"], [class*="stat"], h1, h2, h3, h4, h5, h6, table');
      return Array.from(elements).map(el => ({
        tag: el.tagName,
        class: el.className?.substring(0, 150),
        text: el.textContent?.trim().substring(0, 200)
      }));
    });
    console.log('=== STRUCTURAL ELEMENTS ===');
    console.log(JSON.stringify(htmlStructure.slice(0, 50), null, 2));
    
  } catch (err) {
    console.error('Error during login:', err.message);
  }
  
  await browser.close();
})();

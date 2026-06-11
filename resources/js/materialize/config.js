/* global TemplateCustomizer */
'use strict';

const html = document.documentElement;
const coreUrl = html.getAttribute('data-materialize-core') || '';
const cssPath = coreUrl.replace(/core\.css(\?.*)?$/, '');
const insertStylesheet = (className, href) => {
  const existing = document.querySelector(`.${className}`);
  const link = document.createElement('link');
  link.setAttribute('rel', 'stylesheet');
  link.setAttribute('type', 'text/css');
  link.className = className;
  link.setAttribute('href', href);
  if (existing && existing.parentNode) {
    existing.parentNode.insertBefore(link, existing.nextSibling);
    existing.parentNode.removeChild(existing);
  } else {
    document.head.appendChild(link);
  }
};

window.config = {
  colors: {
    primary: '#666cff',
    secondary: '#6d788d',
    success: '#72e128',
    info: '#26c6f9',
    warning: '#fdb528',
    danger: '#ff4d49',
    dark: '#4b4b4b',
    black: '#000',
    white: '#fff',
    cardColor: '#fff',
    bodyBg: '#f7f7f9',
    bodyColor: '#676a7b',
    headingColor: '#3b4055',
    textMuted: '#a8aab4',
    borderColor: '#e5e5e8'
  },
  colors_label: {
    primary: '#666cff29',
    secondary: '#6d788d29',
    success: '#72e12829',
    info: '#26c6f929',
    warning: '#fdb52829',
    danger: '#ff4d4929',
    dark: '#4b4b4b29'
  },
  colors_dark: {
    cardColor: '#30334e',
    bodyBg: '#282a42',
    bodyColor: '#b2b3ca',
    headingColor: '#d7d8ee',
    textMuted: '#7b7d95',
    borderColor: '#464964'
  },
  enableMenuLocalStorage: true
};

window.assetsPath = html.getAttribute('data-assets-path') || cssPath;
window.templateName = html.getAttribute('data-template');
window.rtlSupport = true;

if (typeof TemplateCustomizer !== 'undefined') {
  TemplateCustomizer.prototype._insertStylesheet = function (className, href) {
    insertStylesheet(className, href);
  };
  window.templateCustomizer = new TemplateCustomizer({
    cssPath,
    themesPath: cssPath,
    displayCustomizer: true,
    lang: localStorage.getItem('templateCustomizer-' + window.templateName + '--Lang') || 'en',
    defaultTextDir: html.getAttribute('dir') === 'rtl' ? 'rtl' : 'ltr',
    defaultTheme: 'theme-semi-dark',
    defaultStyle: 'light',
    defaultContentLayout: 'wide',
    defaultMenuCollapsed: true,
    defaultNavbarType: 'static',
    controls: ['style', 'contentLayout', 'layoutCollapsed', 'layoutNavbarOptions', 'themes']
  });
}

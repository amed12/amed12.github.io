import React from 'react'
import ReactDOM from 'react-dom/client'
import App from './App.jsx'
import './index.css'

// Handle GitHub Pages SPA redirect (spa-github-pages 404.html encoding).
// e.g. /?p=/cv&q=positions=android~and~flutter -> /cv?positions=android&flutter
const redirectParams = new URLSearchParams(window.location.search);
const redirectPath = redirectParams.get('p');
if (redirectPath) {
  const redirectQuery = redirectParams.get('q');
  const newUrl =
    redirectPath.replace(/~and~/g, '&') +
    (redirectQuery ? '?' + redirectQuery.replace(/~and~/g, '&') : '') +
    window.location.hash;
  window.history.replaceState({}, '', newUrl);
}

ReactDOM.createRoot(document.getElementById('root')).render(
  <React.StrictMode>
    <App />
  </React.StrictMode>,
)

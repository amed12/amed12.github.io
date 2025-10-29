import React from 'react'
import ReactDOM from 'react-dom/client'
import App from './App.jsx'
import './index.css'

// Handle GitHub Pages redirect
const path = window.location.search;
if (path.includes('p=')) {
  const newPath = path.split('p=')[1].split('&')[0];
  window.history.replaceState({}, '', newPath);
}

ReactDOM.createRoot(document.getElementById('root')).render(
  <React.StrictMode>
    <App />
  </React.StrictMode>,
)

# GitHub Pages Setup Guide

## ✅ Changes Pushed Successfully

Your code has been pushed to GitHub and the deployment workflow should now run automatically.

## 🔧 Configure GitHub Pages Settings

1. Go to your GitHub repository: https://github.com/amed12/amed12.github.io

2. Click on **Settings** (top menu)

3. In the left sidebar, click on **Pages**

4. Under **Build and deployment**:
   - **Source**: Select "Deploy from a branch"
   - **Branch**: Select `gh-pages` and `/ (root)`
   - Click **Save**

5. Wait 2-3 minutes for the deployment to complete

## 🌐 Your Site URL

After configuration, your site will be live at:
**https://amed12.github.io/amed12.github.io/**

## ✨ How It Works

1. **Automatic**: Push to `master` branch → GitHub Actions builds and deploys
2. **Manual**: Run `npm run deploy` locally to deploy immediately

## 🔍 Check Deployment Status

1. Go to the **Actions** tab in your GitHub repository
2. You should see a workflow run called "Deploy to GitHub Pages"
3. Wait for it to complete (green checkmark)
4. Then check the **Pages** section in Settings to see the live URL

## 🐛 If Still Not Working

If you see the MIME type error:
- Clear your browser cache (Cmd+Shift+R on Mac)
- Wait a few more minutes for GitHub Pages to fully deploy
- Make sure you're accessing the correct URL with the base path

## 📝 Notes

- The site needs the base path `/amed12.github.io/` in the URL
- Direct navigation to routes like `/cv` should work after the 404.html is deployed
- If you change the repository name, update the `base` in `vite.config.js` and `basename` in `src/App.jsx`

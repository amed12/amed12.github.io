# Portfolio CMS - Setup Guide

## 🚀 Quick Start

This is your new portfolio website with a built-in admin panel for easy content management. Built with React, Tailwind CSS, and JSON-based data storage.

### Prerequisites

- Node.js (v16 or higher)
- npm or yarn

### Installation

1. **Install dependencies:**
   ```bash
   npm install
   ```

2. **Start development server:**
   ```bash
   npm run dev
   ```

3. **Open your browser:**
   - Portfolio: `http://localhost:5173`
   - Click the ⚙️ button (bottom-right) to open Admin Panel

### Build for Production

```bash
npm run build
```

The built files will be in the `dist` folder.

### Preview Production Build

```bash
npm run preview
```

## 📁 Project Structure

```
portfolio-cms/
├── public/
│   └── data.json          # Your portfolio data
├── src/
│   ├── components/
│   │   ├── Admin/         # Admin panel components
│   │   │   ├── AdminPanel.jsx
│   │   │   ├── ProfileEditor.jsx
│   │   │   ├── SkillsEditor.jsx
│   │   │   ├── ExperienceEditor.jsx
│   │   │   ├── ProjectsEditor.jsx
│   │   │   ├── EducationEditor.jsx
│   │   │   ├── CertificationsEditor.jsx
│   │   │   └── TestimonialsEditor.jsx
│   │   └── Portfolio/     # Public-facing components
│   │       ├── Header.jsx
│   │       ├── About.jsx
│   │       ├── Skills.jsx
│   │       ├── Experience.jsx
│   │       ├── Projects.jsx
│   │       ├── Education.jsx
│   │       ├── Certifications.jsx
│   │       ├── Testimonials.jsx
│   │       └── Footer.jsx
│   ├── pages/
│   │   └── PortfolioPage.jsx
│   ├── utils/
│   │   └── dataManager.js  # Data loading/saving utilities
│   ├── App.jsx
│   ├── main.jsx
│   └── index.css
├── backup-old-site/        # Your old HTML site (backup)
├── package.json
├── vite.config.js
├── tailwind.config.js
└── README.md
```

## 🎨 How to Use the Admin Panel

### Accessing the Admin Panel

1. Click the **⚙️ Settings** button in the bottom-right corner
2. The admin panel will open as a modal overlay

### Editing Content

The admin panel has 7 tabs:

1. **Profile** - Your personal information, contact details, social links
2. **Skills** - Add/edit/remove skills with proficiency levels
3. **Experience** - Manage work experience entries
4. **Projects** - Add/edit projects with images, links, and technologies
5. **Education** - Educational background
6. **Certifications** - Professional certifications
7. **Testimonials** - Client/colleague testimonials

### Saving Changes

- **Save Changes** - Saves to browser localStorage (persists across sessions)
- **Download JSON** - Downloads your data as a JSON file for backup
- **Reset to Original** - Restores the original data from `public/data.json`

### Important Notes

⚠️ **Data Storage:**
- Changes are saved to **browser localStorage** by default
- This means your edits persist even after closing the browser
- To make permanent changes, download the JSON and replace `public/data.json`

⚠️ **Images:**
- Place images in the `public` folder
- Reference them as `/image-name.jpg` in the admin panel
- Or use external URLs (https://...)

## 📝 Editing Data Directly

You can also edit `public/data.json` directly with a text editor:

```json
{
  "profile": {
    "name": "Your Name",
    "title": "Your Title",
    ...
  },
  "skills": [...],
  "experience": [...],
  ...
}
```

After editing, refresh the browser to see changes.

## 🎯 Deployment

### GitHub Pages

1. Update `vite.config.js` base path:
   ```js
   export default defineConfig({
     plugins: [react()],
     base: '/your-repo-name/',  // Change this
   })
   ```

2. Build and deploy:
   ```bash
   npm run build
   # Deploy the 'dist' folder to GitHub Pages
   ```

### Netlify / Vercel

1. Build command: `npm run build`
2. Publish directory: `dist`
3. Deploy!

## 🔧 Customization

### Colors

Edit `tailwind.config.js` to change the color scheme:

```js
theme: {
  extend: {
    colors: {
      primary: {
        // Change these values
        500: '#0ea5e9',
        600: '#0284c7',
        ...
      },
    },
  },
}
```

### Fonts

Add Google Fonts in `index.html`:

```html
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
```

Then update `tailwind.config.js`:

```js
theme: {
  extend: {
    fontFamily: {
      sans: ['Inter', 'sans-serif'],
    },
  },
}
```

## 🐛 Troubleshooting

### Images not showing

- Make sure images are in the `public` folder
- Use paths like `/avatar.jpg` (not `./avatar.jpg`)
- Or use full URLs: `https://example.com/image.jpg`

### Changes not saving

- Check browser console for errors
- Make sure localStorage is enabled
- Try downloading JSON and replacing `public/data.json`

### Admin panel not opening

- Check browser console for JavaScript errors
- Make sure you clicked the ⚙️ button
- Try refreshing the page

## 📦 Old Site Backup

Your old HTML site is backed up in `backup-old-site/` folder. You can:

1. View it by opening `backup-old-site/index.html` in a browser
2. Restore it by copying files back to the root
3. Delete it once you're happy with the new site

## 🆘 Need Help?

- Check the browser console (F12) for errors
- Review `public/data.json` for data structure
- Make sure all dependencies are installed: `npm install`

## 📄 License

© 2025 Achmad Fathullah. All Rights Reserved.

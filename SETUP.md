# Portfolio CMS - Setup Guide

## 🚀 Quick Start

This is your new portfolio website with a built-in admin panel for easy content management. Built with React, Tailwind CSS, and JSON-based data storage.

### Prerequisites

- Node.js 22 (see `.nvmrc`; `nvm use` picks it up)
- npm (the lockfile is npm's — don't mix in yarn/pnpm)

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
   - Admin: `http://localhost:5173/admin` → enter the passphrase from `.env` → click the ⚙️ button (bottom-right)

`npm install` also points git at `.githooks/` (via the `prepare` script) so the
pre-commit guard for `internal/` is active. Before opening a PR run
`npm run check` (lint + test + build — the same gates CI runs).

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
├── public/
│   ├── data.json            # ALL site content (public, feeds the CV)
│   ├── projects/            # project screenshots
│   └── 404.html             # GitHub Pages SPA redirect
├── src/
│   ├── components/
│   │   ├── Admin/           # admin panel, passphrase gate, editors
│   │   ├── CV/              # CV template (layout only)
│   │   └── Portfolio/       # public site sections
│   ├── config/positions.js  # position keywords + skill priorities (single source)
│   ├── pages/               # PortfolioPage, CVPage (/cv), SharePage (/share)
│   ├── utils/               # dataManager, cvScoring, githubPublish, adminSession
│   ├── App.jsx              # routes; CV/Share/Admin are lazy-loaded
│   └── *.test.js(x)         # vitest (incl. data.json hygiene checks)
├── scripts/                 # repo guards used by hooks and CI
├── .githooks/               # pre-commit (installed by npm install)
├── .agents/skills/          # career-dump-scanner agent skill
├── .github/                 # CI/deploy workflow, templates, dependabot
└── internal/                # LOCAL ONLY, gitignored — private notes, never committed
```

## 🎨 How to Use the Admin Panel

### Accessing the Admin Panel

1. Open `/admin` and enter the passphrase (see "Admin Passphrase Gate" below)
2. Click the **⚙️** button in the bottom-right corner — the admin panel opens as a modal overlay

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

- **Save Changes** - Saves a draft to browser localStorage only. This is **not published** — the live site is unaffected, and a yellow "unpublished changes" banner appears on the site until you publish or discard.
- **Publish to GitHub** - Enter a GitHub Personal Access Token and click Confirm Publish. This commits your changes directly to `public/data.json` on `master` via the GitHub Contents API, which triggers GitHub Actions to build and deploy automatically. This is the only way changes reach the live site.
- **Download JSON** - Downloads your data as a JSON file for manual backup.
- **Reset to Original** - Discards the local draft and restores data from `public/data.json`.

### Creating a GitHub Personal Access Token

1. Go to GitHub → Settings → Developer settings → Personal access tokens.
2. Create a **fine-grained token** scoped to this repository only, with **Contents: Read and write** permission (or a classic token with the `repo` scope if fine-grained isn't available).
3. Set a short expiration — the token is only needed while you're publishing.

⚠️ **Security notes:**
- The token is entered in a password field and kept only in the browser's memory for the current session — it is never saved to localStorage, a file, or sent anywhere except GitHub's API.
- It disappears when you close the admin panel or reload the page; you'll need to re-enter it next time you publish.
- Don't use it on a shared or public computer, and don't share the token with anyone.
- `/admin` is gated by a passphrase prompt (see below) before the publish form appears, but this is a deterrent, not real authentication — don't rely on it while the admin panel is exposed on a machine others can access.

### Admin Passphrase Gate

Visiting `/admin` now shows a passphrase prompt before the gear button/publish form appear.

1. Copy `.env.example` to `.env` and set `VITE_ADMIN_PASSPHRASE` to a value only you know.
2. For the deployed site, add the same value as a GitHub Actions repository secret named `VITE_ADMIN_PASSPHRASE` (Settings → Secrets and variables → Actions) — the deploy workflow bakes it into the build.
3. Unlocking is remembered for the browser tab session (`sessionStorage`) — closing the tab requires re-entering the passphrase.

⚠️ This site is static (GitHub Pages, no backend), so the passphrase is bundled into the client JavaScript like any other build-time value — anyone can extract it by reading the deployed bundle. Treat it as a way to keep casual visitors out, not as access control against a motivated attacker.

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

After editing, run `npm test` — `src/data.test.js` rejects `TODO:` markers,
internal notes, duplicate ids and incomplete projects. Then commit via a PR.
If the admin panel has a local draft, it shadows the file until you discard it.

## 🔗 Sharing a Curated Portfolio

The `/share` route lets you build a shareable link curated for one or more positions, e.g.:

```
https://your-domain/share?positions=android,flutter
```

- Visit `/share` without a query to open the builder: toggle positions, then use **Copy Link**.
- The `positions` value is a comma-separated list of position keys from `src/config/positions.js` (e.g. `flutter`, `android`, `ios`, `react-native`, `mobile`, `web`).
- The linked page shows a bio (from `profile.positionSummaries`), skills sorted by relevance, and projects filtered by the union of the selected positions' keywords — no login required.
- This works with GitHub Pages' SPA redirect (`public/404.html` + `src/main.jsx`), so a deep link with a query string opens directly, even on first load.

## 🎯 Deployment

Deployment is automatic. `.github/workflows/deploy.yml` runs on every PR and
push to `master`:

1. **verify** — internal/ guard, `npm ci`, lint, test, build
2. **deploy** — only on `master`, only if verify passed; publishes the verified
   `dist/` to the `gh-pages` branch, which GitHub Pages serves

There is no manual deploy step. The site is at the root domain, so
`vite.config.js` keeps `base: '/'`.

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
- Use paths like `/avatar.jpeg` (not `./avatar.jpeg`)
- Or use full URLs: `https://example.com/image.jpg`

### Changes not saving

- Check browser console for errors
- Make sure localStorage is enabled
- Try downloading JSON and replacing `public/data.json`

### Admin panel not opening

- Check browser console for JavaScript errors
- The ⚙️ button only appears on `/admin` after the passphrase is accepted
- Try refreshing the page

## 🆘 Need Help?

- Check the browser console (F12) for errors
- Review `public/data.json` for data structure
- Make sure all dependencies are installed: `npm install`

## 📄 License

© 2025 Achmad Fathullah. All Rights Reserved.

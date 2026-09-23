# amed12.github.io

Portfolio and CV site of **Achmad Fathullah**, Mobile Engineer (iOS, Android,
Flutter, React Native) at Qiscus. Live at **https://amed12.github.io/**.

| Route | What it is |
|---|---|
| `/` | Public portfolio |
| `/cv` | Position-tailored CV with text-based PDF export and print |
| `/share?positions=android,flutter` | Curated portfolio for one or more positions, shareable by URL |
| `/admin` | Content editor behind a passphrase; publishes `data.json` to GitHub |

All content lives in [`public/data.json`](public/data.json). It is public and
feeds the exported CV.

## Quick start

```bash
nvm use            # Node 22, from .nvmrc
npm install        # also installs the git pre-commit hook
cp .env.example .env   # set VITE_ADMIN_PASSPHRASE
npm run dev        # http://localhost:5173
npm run check      # lint + test + build: the same gates as CI
```

## How changes reach the site

Every PR and every push to `master` runs **lint, test and build** in
[`.github/workflows/deploy.yml`](.github/workflows/deploy.yml). Deploy to
GitHub Pages runs only on `master`, and only after those pass. There is no
manual deploy.

Content can be changed in two ways:
- **Admin panel** (`/admin`): Publish to GitHub commits `data.json` directly.
- **A PR** that edits `public/data.json`. `npm test` rejects `TODO:` markers,
  internal notes, duplicate ids and incomplete projects.

## Stack

React 18, Vite, Tailwind CSS 3, React Router, jsPDF, Vitest, ESLint, GitHub
Actions and GitHub Pages (served from the `gh-pages` branch).

## Docs

| File | For |
|---|---|
| [CONTRIBUTING.md](CONTRIBUTING.md) | Workflow, branch/commit conventions, what may and may not be published |
| [SETUP.md](SETUP.md) | Setup, admin panel, publish token, passphrase, `/share` |
| [PANDUAN-CLIENT.md](PANDUAN-CLIENT.md) | Handover guide for the owner (Bahasa Indonesia) |
| [CAREER_DUMP_GUIDE.md](CAREER_DUMP_GUIDE.md) | Importing projects from local repos with the scanner skill |
| [BACKLOG.md](BACKLOG.md) | Planned and completed work |
| [CLAUDE.md](CLAUDE.md) | Architecture notes for AI-assisted maintenance |
| [docs/archive/](docs/archive/) | Docs for removed features |

## License

© Achmad Fathullah. All Rights Reserved.

# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project

Personal portfolio/CV site (React 18 + Vite 5 + Tailwind CSS 3, React Router v6), deployed to GitHub Pages at the root domain. No TypeScript, no tests (yet — vitest is planned, see BACKLOG.md B11).

## Commands

- `npm run dev` — dev server
- `npm run build` — production build to `dist/`
- `npm run lint` — ESLint (`--max-warnings 0`, so any warning fails)
- `npm run preview` — preview the build
- Deploy: automatic via GitHub Actions on push to `master` (`.github/workflows/deploy.yml`). `npm run deploy` / `deploy.sh` is a redundant manual path slated for removal (BACKLOG.md B8).

## Backlog discipline

`BACKLOG.md` at the repo root is the single source of truth for planned work (items B1–B12 across 4 sprints, from a 2026-08 full project review). When you work on or complete a backlog item, update its checkbox, the sprint status column, and the "Terakhir diupdate" date in the same session.

## Architecture

**Data flow — the key thing to understand:**
- Single source of truth for all site content is `public/data.json` (~1100 lines: profile, skills, experience, education, certifications, projects[46], testimonials).
- `src/utils/dataManager.js` `getData()` returns `localStorage.portfolioData` **if present**, otherwise fetches `data.json`. This means localStorage silently shadows the real file — edits made in the admin panel look live locally but never reach the deployed site.
- `saveData()` writes only to localStorage. Publishing currently requires: Download JSON from the admin panel (file is named `portfolio-data.json`) → manually overwrite `public/data.json` → commit/push. Fixing this is BACKLOG.md B5/B6.
- `src/App.jsx` loads data once and prop-drills it to all pages. No global state library.

**Three loosely-coupled subsystems** (they do not share a data layer):
1. **Portfolio** (`src/components/Portfolio/`, route `/`) — public site rendered from `data.json`.
2. **Admin** (`src/components/Admin/`, route `/admin`) — content editors in a modal. No authentication; gated only by the URL path.
3. **Settings dashboard** (`src/components/Settings/`, route `/settings`) — career-tracking modules that read/write their own localStorage keys via `src/utils/storageManager.js` (523 lines, includes hardcoded personal default datasets).

**CV generation** (route `/cv`):
- `src/pages/CVPage.jsx` holds `positionOptions` with per-position keyword arrays; scores/filters projects by keyword hits, passes filtered data to `src/components/CV/CVTemplate.jsx`.
- `CVTemplate.jsx` holds a second, overlapping hardcoded config (`bioTemplates`, `skillPriorities`) — these two configs are duplicated and must be kept in sync (consolidation planned as B9). It also references `profile.yearsOfExperience`, which does not exist in `data.json` (falls back to "5+").
- Export paths: `window.print()` (letter-size print CSS) and html2canvas→jsPDF (A4, **rasterized image** — the PDF text is not selectable despite the UI's "ATS-friendly" label; fix is B3).
- Experience `description` strings are split on `\n` into CV bullets — any stray text in `data.json` descriptions (e.g. leftover `TODO:` lines) renders directly in the exported CV.

## Content rules

- `public/data.json` is public and feeds the exported CV. Never add meta/internal content to it (AI notes, strategy blocks, `TODO:` markers) — cleaning existing ones is B1.
- Content rewrites should match the natural voice of the older authentic entries (freelance/PLN experience, Sitamoto/Ceklok/SIBEA projects), not buzzword boilerplate.

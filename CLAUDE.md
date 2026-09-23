# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project

Personal portfolio/CV site (React 18 + Vite 5 + Tailwind CSS 3, React Router v6), deployed to GitHub Pages at the root domain. No TypeScript; vitest for utils, App and `public/data.json` hygiene.

## Commands

- `npm run dev` — dev server
- `npm run build` — production build to `dist/`
- `npm run lint` — ESLint (`--max-warnings 0`, so any warning fails)
- `npm run preview` — preview the build
- `npm test` — vitest
- `npm run check` — lint + test + build (what CI runs)
- Deploy: automatic via GitHub Actions on push to `master` (`.github/workflows/deploy.yml`); the deploy job only runs after lint/test/build pass.

## `internal/` — never commit

This repo is **public**. `internal/` (gitignored) holds the owner's private work
notes (employer tickets, client names, runbooks). Never read from it into
committed files, never `git add -f` it. `.githooks/pre-commit` and CI
(`scripts/check-no-internal.sh`) both fail if anything under it is tracked.

## Backlog discipline

`BACKLOG.md` at the repo root is the single source of truth for planned work. When you work on or complete a backlog item, update its checkbox, the sprint status column, and the "Terakhir diupdate" date in the same session.

## Architecture

**Data flow — the key thing to understand:**
- Single source of truth for all site content is `public/data.json` (profile, skills, languages, experience, education, certifications, honors, projects, testimonials). Its hygiene is enforced by `src/data.test.js`.
- `src/utils/dataManager.js` `getData()` returns the `localStorage.portfolioData` draft **if present**, otherwise fetches `data.json` (resolves to `null` on failure; `App.jsx` shows a retry screen). A draft shadows the published file; `UnpublishedBanner` warns about it.
- Admin "Save" writes the draft only. "Publish to GitHub" (`src/utils/githubPublish.js`) commits `public/data.json` to `master` via the Contents API with a per-session PAT, which triggers deploy.
- `src/App.jsx` loads data once and prop-drills it to all pages. No global state library. `CVPage`, `SharePage` and `AdminPanel` are `React.lazy` chunks (jsPDF/html2canvas stay out of the main bundle).

**Subsystems:**
1. **Portfolio** (`src/components/Portfolio/`, route `/`) — public site rendered from `data.json`.
2. **Admin** (`src/components/Admin/`, route `/admin`) — editors in a modal, behind `AdminGate` (passphrase from `VITE_ADMIN_PASSPHRASE`, bundled at build time — a deterrent, not auth). Session flag in `src/utils/adminSession.js`.
3. **CV** (route `/cv`) and **Share** (route `/share?positions=a,b`).

**CV generation:**
- Position keywords and skill priorities live only in `src/config/positions.js`. Scoring/filtering is in `src/utils/cvScoring.js` (single and multi-position); bio/skills/certs helpers in `src/utils/cvTemplateHelpers.js`. `CVTemplate.jsx` is layout-only.
- Per-position bios come from `profile.positionSummaries`; years from `profile.yearsOfExperience`.
- PDF export builds a text-based A4 PDF with jsPDF (selectable text); print uses `@media print`.
- Experience `description` strings are split on `\n` into CV bullets — any stray text in `data.json` renders directly in the exported CV.
- GitHub Pages deep links rely on `public/404.html` + the decoder in `index.html`/`src/main.jsx`, which keep the query string intact.

## Content rules

- `public/data.json` is public and feeds the exported CV. Never add meta/internal content to it (AI notes, strategy blocks, `TODO:` markers). `npm test` fails if they appear.
- Don't publish employer-client work (client names, internal service names) or third-party repos as projects. The career-dump scanner imports everything it finds; its output needs this review before commit.
- Content rewrites should match the natural voice of the older authentic entries (freelance/PLN experience, Sitamoto/Ceklok/SIBEA projects), not buzzword boilerplate.

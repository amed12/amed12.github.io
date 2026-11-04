# Contributing

Short version: branch → change → `npm run check` → PR → owner review → merge.
Merging to `master` deploys.

## Setup

```bash
nvm use && npm install && cp .env.example .env
```

`npm install` sets `core.hooksPath` to `.githooks/`. Don't bypass the hook
with `--no-verify`.

## Workflow

1. Branch from `master`: `feat/…`, `fix/…`, `content/…`, `chore/…`, `docs/…`.
2. Keep each PR to one purpose. Content edits (`public/data.json`) and code
   changes go in separate PRs.
3. Commits follow [Conventional Commits](https://www.conventionalcommits.org/)
   (`feat:`, `fix:`, `content:`, `perf:`, `ci:`, `docs:`, `chore:`,
   `build(deps):`).
4. Run `npm run check` before pushing. CI runs the same lint, test and build,
   and a PR can't deploy anything.
5. Open the PR and fill in the template. `@amed12` reviews everything
   (`.github/CODEOWNERS`).
6. If you finish a `BACKLOG.md` item, tick it in the same PR.

## Rules for code

- ESLint runs with `--max-warnings 0`, so any warning fails CI.
- Put logic in `src/utils/` and add tests there. Components stay presentational.
- Position keywords and skill priorities live only in `src/config/positions.js`.
- Keep heavy libraries out of the main bundle; lazy-load them per route
  (see `src/App.jsx`).

## What may be published

This repo is public, and `public/data.json` is both the live site and the CV.
Before a change touches content, check:

- **No employer-client work.** Don't add projects or text that name Qiscus
  clients or internal services. When in doubt, leave it out and ask the owner.
- **No third-party repos** presented as the owner's projects.
- **No internal notes.** No `TODO:`, AI notes or strategy blocks. `npm test`
  enforces part of this.
- **No secrets.** Tokens and passphrases go in `.env` or GitHub Actions
  secrets, never in a commit.
- **`internal/` is never committed.** It holds the owner's private notes
  locally and is gitignored. The pre-commit hook and CI both block it.

## Where to start

- Architecture: [CLAUDE.md](CLAUDE.md)
- Setup, admin panel, publishing: [SETUP.md](SETUP.md)
- Open work: [BACKLOG.md](BACKLOG.md)

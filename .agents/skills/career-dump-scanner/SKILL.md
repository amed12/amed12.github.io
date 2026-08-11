---
name: career-dump-scanner
description: >
  Scans a given root folder for git repositories, extracts project metadata
  from config files (package.json, pubspec.yaml, build.gradle, Podfile, README, etc.),
  and adds newly discovered projects to public/data.json. Skips projects that
  already exist (dedup by fuzzy title match). Use when doing a "career dump"
  to discover projects across any folder on the machine.
---

# Career Dump Scanner

## When to use

- User wants to scan a folder for projects and add them to their portfolio
- User mentions "career dump", "scan repos", "find my projects", "update portfolio from repos"
- User wants to discover what projects they have across their machine

## Prerequisites

- Python 3 must be available on the system
- The portfolio project must have `public/data.json` with a `projects` array

## How to run

1. User provides a **root folder path** to scan.
2. Run the scan script **from the portfolio project root directory**:

```bash
bash .agents/skills/career-dump-scanner/scripts/scan-repos.sh <ROOT_FOLDER> [DATA_JSON_PATH]
```

### Arguments

| Argument | Required | Default | Description |
|---|---|---|---|
| `ROOT_FOLDER` | ✅ | — | Absolute path to scan recursively for git repos |
| `DATA_JSON_PATH` | ❌ | `public/data.json` | Path to the portfolio data file to update |

### Examples

```bash
# Scan a specific folder
bash .agents/skills/career-dump-scanner/scripts/scan-repos.sh /Users/john/projects public/data.json

# Scan the user's entire home directory
bash .agents/skills/career-dump-scanner/scripts/scan-repos.sh /Users/john public/data.json

# Scan multiple folders (run multiple times — dedup is safe)
bash .agents/skills/career-dump-scanner/scripts/scan-repos.sh /Users/john/work public/data.json
bash .agents/skills/career-dump-scanner/scripts/scan-repos.sh /Users/john/personal public/data.json
```

## After running

1. Show the user the printed summary (new projects added, skipped, etc.)
2. Suggest the user review changes: `git diff public/data.json`
3. Point out any projects with `"TODO: Add description"` that need manual editing
4. Suggest adding screenshots to `public/projects/` for new projects
5. The user can commit and push when satisfied

## Important notes

- **Re-runnable**: Running multiple times on the same folder is safe — dedup prevents duplicates
- **Portable**: No hardcoded paths. Works on macOS, Linux, and WSL
- **Non-destructive**: Only appends new projects. Never modifies or deletes existing projects
- **Static analysis only**: Reads config files (package.json, pubspec.yaml, build.gradle, Podfile, etc.) — does not execute any project code

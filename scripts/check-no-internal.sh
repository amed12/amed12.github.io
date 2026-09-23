#!/usr/bin/env bash
# Fails if anything under internal/ is tracked or staged. internal/ holds the
# owner's private work notes (see .gitignore); this repo is public, so those
# files must never be committed. Used by the pre-commit hook and by CI.
set -euo pipefail

cd "$(git rev-parse --show-toplevel)"

leaked="$( { git ls-files -- internal; git diff --cached --name-only -- internal; } | sort -u )"

if [ -n "$leaked" ]; then
  echo "ERROR: files under internal/ are tracked or staged — this repo is PUBLIC." >&2
  echo "$leaked" | sed 's/^/  /' >&2
  echo "Unstage with: git rm -r --cached internal" >&2
  exit 1
fi

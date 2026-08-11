#!/usr/bin/env bash
# ─────────────────────────────────────────────────────────────────────────────
# Career Dump Scanner
# Scans a root folder for git repositories, extracts project metadata from
# config files, deduplicates against existing portfolio data, and appends
# newly discovered projects to data.json.
#
# Usage:
#   bash scan-repos.sh <SCAN_ROOT> [DATA_JSON_PATH]
#
# Arguments:
#   SCAN_ROOT       — Absolute path to the folder to scan recursively
#   DATA_JSON_PATH  — Path to data.json to update (default: public/data.json)
#
# Requirements: bash, python3
# Portable: macOS, Linux, WSL — no hardcoded paths
# ─────────────────────────────────────────────────────────────────────────────
set -euo pipefail

# ── Arguments ────────────────────────────────────────────────────────────────
SCAN_ROOT="${1:?❌ Usage: scan-repos.sh <SCAN_ROOT> [DATA_JSON_PATH]}"
DATA_JSON="${2:-public/data.json}"

# Resolve scan root to absolute path
if [ -d "$SCAN_ROOT" ]; then
  SCAN_ROOT="$(cd "$SCAN_ROOT" && pwd)"
else
  echo "❌ Error: '$SCAN_ROOT' is not a directory." >&2
  exit 1
fi

if [ ! -f "$DATA_JSON" ]; then
  echo "❌ Error: '$DATA_JSON' not found." >&2
  echo "   Run this script from the portfolio project root directory." >&2
  exit 1
fi

# Check python3 is available
if ! command -v python3 &>/dev/null; then
  echo "❌ Error: python3 is required but not found." >&2
  exit 1
fi

echo "🔍 Career Dump Scanner"
echo "   Scanning:  $SCAN_ROOT"
echo "   Updating:  $DATA_JSON"
echo ""

# ── Phase 1: Discover git repos ─────────────────────────────────────────────
TMPDIR_SCAN="$(mktemp -d)"
REPO_LIST="$TMPDIR_SCAN/repos.txt"
DISCOVERED_JSON="$TMPDIR_SCAN/discovered.json"

trap 'rm -rf "$TMPDIR_SCAN"' EXIT

# Find all git repos, filter out non-project dirs
# Use a temp file to avoid pipefail issues with find on permission-denied dirs
GITDIRS="$TMPDIR_SCAN/gitdirs.txt"
find "$SCAN_ROOT" -maxdepth 5 -name ".git" -type d 2>/dev/null > "$GITDIRS" || true

# Filter out non-project directories and convert .git paths to repo paths
GITDIRS_PATH="$GITDIRS" REPO_LIST_OUT="$REPO_LIST" python3 << 'FILTER_PYEOF'
import os, re

gitdirs_path = os.environ["GITDIRS_PATH"]
output_path = os.environ["REPO_LIST_OUT"]

skip_basenames = {
    "node_modules", ".oh-my-zsh", ".asdf", ".codex", ".gemini",
    "dotfiles", ".tmp", "plugin-index", "vendor_imports",
    "Library", ".cargo", ".rustup", ".nvm", ".npm", ".pub-cache",
    ".cocoapods", ".gradle", "Library/Caches", ".Trash"
}
skip_path_parts = {
    "node_modules", "Pods", ".codex", ".gemini", "Library", 
    ".cargo", ".rustup", ".nvm", ".npm", ".pub-cache", ".gradle", ".Trash"
}

with open(gitdirs_path) as f:
    gitdirs = [line.strip() for line in f if line.strip()]

repos = []
for gitdir in gitdirs:
    repo_dir = os.path.dirname(gitdir)
    basename = os.path.basename(repo_dir)

    if basename in skip_basenames:
        continue

    # Skip version numbers like 3.38.6 or 3.27.4
    if re.match(r'^\d+\.\d+(\.\d+)?.*$', basename):
        continue

    path_parts = set(repo_dir.split(os.sep))
    if path_parts & skip_path_parts:
        continue

    repos.append(repo_dir)

with open(output_path, 'w') as f:
    for r in repos:
        f.write(r + '\n')
FILTER_PYEOF

REPO_COUNT=$(wc -l < "$REPO_LIST" | tr -d ' ')
echo "📂 Found $REPO_COUNT repositories"
echo ""

# ── Phase 2 & 3: Extract metadata + Dedup + Merge ───────────────────────────
REPO_LIST_PATH="$REPO_LIST" DATA_JSON_PATH="$DATA_JSON" python3 << 'PYEOF'
import json
import os
import re
import sys

repo_list_path = os.environ["REPO_LIST_PATH"]
data_json_path = os.environ["DATA_JSON_PATH"]

# ── Read repo list ──
with open(repo_list_path) as f:
    repos = [line.strip() for line in f if line.strip()]

# ── Read existing data.json ──
with open(data_json_path) as f:
    data = json.load(f)

existing_projects = data.get("projects", [])

# ── Helpers ──

def humanize(s):
    """Convert 'my-cool-project' or 'my_cool_project' to 'My Cool Project'"""
    return re.sub(r'[-_]+', ' ', s).title()

def normalize(s):
    """Normalize a title for fuzzy matching"""
    s = s.lower()
    s = re.sub(r'[^a-z0-9\s]', ' ', s)
    s = re.sub(r'\s+', ' ', s).strip()
    for suffix in ['app', 'apps', 'mobile', 'web', 'project', 'sample', 'demo', 'example']:
        s = re.sub(rf'\b{suffix}\b', '', s)
    return re.sub(r'\s+', ' ', s).strip()

def extract_metadata(repo):
    """Extract project metadata from a single repo directory."""
    name = os.path.basename(repo)
    techs = set()
    category = "other"
    description = ""

    # 1. package.json
    pkg_path = os.path.join(repo, "package.json")
    if os.path.isfile(pkg_path):
        try:
            with open(pkg_path) as f:
                pj = json.load(f)
            description = pj.get("description", "") or ""

            all_deps = {}
            for key in ("dependencies", "devDependencies", "peerDependencies"):
                all_deps.update(pj.get(key, {}))

            dep_map = {
                "react-native": "React Native",
                "react": "React",
                "react-dom": "React",
                "vue": "Vue.js",
                "nuxt": "Nuxt.js",
                "next": "Next.js",
                "express": "Express.js",
                "fastify": "Fastify",
                "vite": "Vite",
                "tailwindcss": "Tailwind CSS",
                "typescript": "TypeScript",
                "firebase": "Firebase",
                "redux": "Redux",
                "mobx": "MobX",
                "axios": "Axios",
                "socket.io": "Socket.IO",
                "mongoose": "MongoDB (Mongoose)",
                "sequelize": "Sequelize ORM",
                "prisma": "Prisma",
                "jest": "Jest",
                "mocha": "Mocha",
                "webpack": "Webpack",
                "rollup": "Rollup",
                "electron": "Electron",
                "expo": "Expo",
                "jquery": "jQuery",
                "bootstrap": "Bootstrap",
                "svelte": "Svelte",
                "angular": "Angular",
                "nestjs": "NestJS",
                "@nestjs/core": "NestJS",
                "koa": "Koa",
                "three": "Three.js",
                "d3": "D3.js",
                "chart.js": "Chart.js",
                "styled-components": "Styled Components",
                "@mui/material": "Material UI",
                "lucide-react": "Lucide Icons",
                "jspdf": "jsPDF",
            }

            for dep in all_deps:
                dep_lower = dep.lower()
                for key, label in dep_map.items():
                    if key in dep_lower:
                        techs.add(label)

            if "react-native" in all_deps or "React Native" in techs:
                category = "mobile"
                techs.add("React Native")
            elif "Electron" in techs:
                category = "desktop"
            elif any(t in techs for t in ["React", "Vue.js", "Next.js", "Svelte", "Angular"]):
                category = "web"
            elif any(t in techs for t in ["Express.js", "Fastify", "NestJS", "Koa"]):
                category = "web"
        except (json.JSONDecodeError, IOError):
            pass

    # 2. pubspec.yaml (Flutter/Dart)
    pubspec_path = os.path.join(repo, "pubspec.yaml")
    if os.path.isfile(pubspec_path):
        category = "mobile"
        techs.add("Flutter")
        techs.add("Dart")
        try:
            with open(pubspec_path) as f:
                content = f.read()
            if not description:
                m = re.search(r'description:\s*(.+)', content)
                if m:
                    desc_val = m.group(1).strip().strip("'\"")
                    if desc_val and "a new flutter project" not in desc_val.lower():
                        description = desc_val

            flutter_deps = {
                "bloc": "BLoC Pattern (Flutter)",
                "flutter_bloc": "BLoC Pattern (Flutter)",
                "provider": "Provider",
                "riverpod": "Riverpod",
                "hooks_riverpod": "Riverpod",
                "get_it": "GetIt (DI)",
                "injectable": "Injectable (DI)",
                "dio": "Dio HTTP Client",
                "http": "HTTP Client",
                "hive": "Hive DB",
                "sqflite": "SQLite (Flutter)",
                "firebase_core": "Firebase",
                "firebase_auth": "Firebase Auth",
                "firebase_messaging": "Firebase FCM",
                "cloud_firestore": "Cloud Firestore",
                "go_router": "GoRouter",
                "auto_route": "AutoRoute",
                "freezed": "Freezed (Code Gen)",
                "json_serializable": "JSON Serializable",
                "shared_preferences": "Shared Preferences",
                "flutter_secure_storage": "Secure Storage",
                "cached_network_image": "Cached Network Image",
                "equatable": "Equatable",
                "dartz": "Dartz (FP)",
            }
            for key, label in flutter_deps.items():
                if re.search(rf'^\s*{re.escape(key)}:', content, re.MULTILINE):
                    techs.add(label)
        except IOError:
            pass

    # 3. build.gradle / build.gradle.kts (Android)
    gradle_files = ["build.gradle", "build.gradle.kts",
                    "app/build.gradle", "app/build.gradle.kts"]
    for gf in gradle_files:
        gradle_path = os.path.join(repo, gf)
        if os.path.isfile(gradle_path):
            category = "mobile"
            techs.add("Android Development")
            try:
                with open(gradle_path) as f:
                    gc = f.read().lower()
                android_deps = {
                    "kotlin": "Kotlin",
                    "org.jetbrains.kotlin": "Kotlin",
                    "compose": "Jetpack Compose",
                    "retrofit": "Retrofit",
                    "room": "Android Room Persistence",
                    "hilt": "Hilt (DI)",
                    "dagger": "Dagger (DI)",
                    "coroutines": "Kotlin Coroutine",
                    "lifecycle": "Jetpack Component",
                    "glide": "Glide",
                    "coil": "Coil",
                    "okhttp": "OkHttp",
                    "rxjava": "RxJava",
                    "rxandroid": "RxAndroid",
                    "firebase": "Firebase",
                    "navigation": "Jetpack Navigation",
                    "viewmodel": "ViewModel",
                    "livedata": "LiveData",
                    "databinding": "Data Binding",
                    "paging": "Paging Library",
                    "workmanager": "WorkManager",
                    "butterknife": "Butter Knife",
                    "material": "Material Design",
                    "gson": "Gson",
                    "moshi": "Moshi",
                }
                for key, label in android_deps.items():
                    if key in gc:
                        techs.add(label)
                if "kotlin" in gc:
                    techs.add("Kotlin")
            except IOError:
                pass
            break

    # 4. Podfile / *.xcodeproj (iOS)
    podfile_path = os.path.join(repo, "Podfile")
    try:
        has_xcode = any(
            f.endswith(".xcodeproj") or f.endswith(".xcworkspace")
            for f in os.listdir(repo)
            if not f.startswith('.')
        )
    except OSError:
        has_xcode = False

    if os.path.isfile(podfile_path) or has_xcode:
        category = "mobile"
        techs.add("iOS Development")
        techs.add("Swift")
        if os.path.isfile(podfile_path):
            try:
                with open(podfile_path) as f:
                    pc = f.read()
                ios_deps = {
                    "SwiftUI": "SwiftUI",
                    "Alamofire": "Alamofire",
                    "SnapKit": "SnapKit",
                    "Firebase": "Firebase",
                    "Combine": "Combine",
                    "Kingfisher": "Kingfisher",
                    "SDWebImage": "SDWebImage",
                    "Moya": "Moya",
                    "RxSwift": "RxSwift",
                    "RealmSwift": "Realm",
                    "CoreData": "Core Data",
                }
                for key, label in ios_deps.items():
                    if key in pc:
                        techs.add(label)
            except IOError:
                pass

    # 5. go.mod (Go)
    gomod_path = os.path.join(repo, "go.mod")
    if os.path.isfile(gomod_path):
        if category == "other":
            category = "web"
        techs.add("Go")
        try:
            with open(gomod_path) as f:
                gc = f.read()
            if "gin-gonic" in gc:
                techs.add("Gin Framework")
            if "echo" in gc.lower():
                techs.add("Echo Framework")
            if "grpc" in gc.lower():
                techs.add("gRPC")
            if "docker" in gc.lower():
                techs.add("Docker")
            if "gorm" in gc.lower():
                techs.add("GORM")
        except IOError:
            pass

    # 6. requirements.txt / pyproject.toml (Python)
    py_files = ["requirements.txt", "pyproject.toml", "setup.py", "Pipfile"]
    for pf in py_files:
        pyfile_path = os.path.join(repo, pf)
        if os.path.isfile(pyfile_path):
            if category == "other":
                category = "web"
            techs.add("Python")
            try:
                with open(pyfile_path) as f:
                    pc = f.read().lower()
                if "django" in pc:
                    techs.add("Django")
                if "flask" in pc:
                    techs.add("Flask")
                if "fastapi" in pc:
                    techs.add("FastAPI")
                if "celery" in pc:
                    techs.add("Celery")
                if "sqlalchemy" in pc:
                    techs.add("SQLAlchemy")
                if "pandas" in pc:
                    techs.add("Pandas")
                if "numpy" in pc:
                    techs.add("NumPy")
                if "tensorflow" in pc or "keras" in pc:
                    techs.add("TensorFlow")
                if "pytorch" in pc or "torch" in pc:
                    techs.add("PyTorch")
            except IOError:
                pass
            break

    # 7. Cargo.toml (Rust)
    if os.path.isfile(os.path.join(repo, "Cargo.toml")):
        techs.add("Rust")
        if category == "other":
            category = "web"

    # 8. Dockerfile / docker-compose
    if os.path.isfile(os.path.join(repo, "Dockerfile")) or \
       os.path.isfile(os.path.join(repo, "docker-compose.yml")) or \
       os.path.isfile(os.path.join(repo, "docker-compose.yaml")):
        techs.add("Docker")

    # 9. README.md fallback for description
    if not description:
        readme_path = os.path.join(repo, "README.md")
        if os.path.isfile(readme_path):
            try:
                with open(readme_path, encoding="utf-8", errors="replace") as f:
                    lines = f.readlines()
                desc_lines = []
                started = False
                for line in lines[1:20]:
                    stripped = line.strip()
                    if not stripped and started:
                        break
                    if stripped and not stripped.startswith('#') and not stripped.startswith('!['):
                        started = True
                        desc_lines.append(stripped)
                if desc_lines:
                    description = ' '.join(desc_lines)[:300]
            except IOError:
                pass

    if not description:
        description = "TODO: Add description"

    # 10. Git remote URL → link
    link = ""
    git_config_path = os.path.join(repo, ".git", "config")
    if os.path.isfile(git_config_path):
        try:
            with open(git_config_path) as f:
                gc = f.read()
            m = re.search(r'url\s*=\s*(.+)', gc)
            if m:
                url = m.group(1).strip()
                if url.startswith("git@github.com:"):
                    url = url.replace("git@github.com:", "https://github.com/")
                if url.endswith(".git"):
                    url = url[:-4]
                if "github.com" in url:
                    link = url
        except IOError:
            pass

    # Determine learningProject
    is_learning = False
    learning_signals = [
        "learn", "tutorial", "example", "sample", "demo",
        "dicoding", "udacity", "coursera", "practice", "exercise",
        "challenge", "chalenge", "bootcamp", "starter", "boilerplate",
    ]
    name_lower = name.lower()
    for sig in learning_signals:
        if sig in name_lower:
            is_learning = True
            break

    return {
        "title": humanize(name),
        "category": category,
        "description": description,
        "image": "",
        "link": link,
        "learningProject": is_learning,
        "technologies": sorted(list(techs)),
        "_source_path": repo,
    }


# ── Extract metadata for all repos ──
discovered = []
for repo in repos:
    try:
        meta = extract_metadata(repo)
        if meta:
            discovered.append(meta)
    except Exception as e:
        print(f"   ⚠️  Error scanning {repo}: {e}", file=sys.stderr)

# ── Build dedup index from existing projects ──
existing_titles_lower = [p["title"].lower() for p in existing_projects]
existing_normalized = [normalize(p["title"]) for p in existing_projects]
existing_links_lower = [p.get("link", "").lower().rstrip("/") for p in existing_projects]

# Find max existing ID number
max_id = 0
for p in existing_projects:
    m = re.match(r'proj(\d+)', p.get("id", ""))
    if m:
        max_id = max(max_id, int(m.group(1)))

# ── Dedup and collect new projects ──
new_projects = []
skipped = []
new_titles_lower = set()

for proj in discovered:
    title = proj["title"]
    title_lower = title.lower()
    title_norm = normalize(title)

    # 1. Exact match against existing
    if title_lower in existing_titles_lower:
        skipped.append({
            "title": title,
            "reason": "exact match",
            "path": proj.get("_source_path", ""),
        })
        continue

    # 2. URL match against existing (check GitHub remote vs existing links)
    proj_link = proj.get("link", "").lower().rstrip("/")
    if proj_link:
        # Direct URL match
        if proj_link in existing_links_lower:
            idx = existing_links_lower.index(proj_link)
            skipped.append({
                "title": title,
                "reason": f"URL match → '{existing_projects[idx]['title']}'",
                "path": proj.get("_source_path", ""),
            })
            continue

        # Extract GitHub slug (e.g., "amed12/amed12.github.io") and check
        # if it appears in any existing link, or if the repo name is a *.github.io
        # site matching an existing link's domain
        gh_match = re.search(r'github\.com/([^/]+/[^/]+)', proj_link)
        if gh_match:
            slug = gh_match.group(1).lower()
            repo_name = slug.split("/")[-1]

            url_matched = False
            for idx, elink in enumerate(existing_links_lower):
                # Check if existing link contains the slug
                if slug in elink:
                    skipped.append({
                        "title": title,
                        "reason": f"URL slug match → '{existing_projects[idx]['title']}'",
                        "path": proj.get("_source_path", ""),
                    })
                    url_matched = True
                    break
                # Check *.github.io pattern: repo "user.github.io" → site "user.github.io"
                if repo_name.endswith(".github.io") and repo_name in elink:
                    skipped.append({
                        "title": title,
                        "reason": f"GitHub Pages match → '{existing_projects[idx]['title']}'",
                        "path": proj.get("_source_path", ""),
                    })
                    url_matched = True
                    break
                # Check if existing link's GitHub URL matches this repo
                eh_match = re.search(r'github\.com/([^/]+/[^/]+)', elink)
                if eh_match and eh_match.group(1).lower() == slug:
                    skipped.append({
                        "title": title,
                        "reason": f"GitHub repo match → '{existing_projects[idx]['title']}'",
                        "path": proj.get("_source_path", ""),
                    })
                    url_matched = True
                    break
            if url_matched:
                continue

    # 3. Fuzzy title match against existing (word-overlap Jaccard similarity)
    title_words = set(title_norm.split()) if title_norm else set()
    matched = False
    if len(title_words) >= 2:
        for i, en in enumerate(existing_normalized):
            en_words = set(en.split()) if en else set()
            if len(en_words) < 2:
                continue
            overlap = title_words & en_words
            union = title_words | en_words
            jaccard = len(overlap) / len(union) if union else 0
            # Also check substring containment as before
            substring_match = (title_norm in en or en in title_norm) if (title_norm and en and min(len(title_norm), len(en)) >= 3) else False
            if jaccard >= 0.5 or substring_match:
                skipped.append({
                    "title": title,
                    "reason": f"fuzzy match ({len(overlap)}/{len(union)} words) → '{existing_projects[i]['title']}'",
                    "path": proj.get("_source_path", ""),
                })
                matched = True
                break
    if matched:
        continue

    # 4. Dedup within this scan batch
    if title_lower in new_titles_lower:
        continue

    # New project!
    max_id += 1
    proj["id"] = f"proj{max_id}"
    source_path = proj.pop("_source_path", "")
    new_projects.append(proj)
    new_titles_lower.add(title_lower)

# ── Merge into data.json ──
# Preserve original formatting by surgically inserting new projects
# before the closing bracket of the projects array, rather than
# re-serializing the entire JSON (which changes compact array formatting).
if new_projects:
    with open(data_json_path, 'r', encoding='utf-8') as f:
        original_content = f.read()

    # Find the last ] that closes the "projects" array.
    # Strategy: find the position of the last project's closing }, then the ] after it.
    # We search for the last occurrence of the projects array closing bracket.
    # The projects array ends with: }\n  ]  (followed by more JSON like testimonials)
    # We look for the pattern: last project } followed by \n  ]
    
    # More robust: use json to find insertion point
    # Re-parse, find the end of projects array, and splice
    import io
    
    # Find "projects" key and its array end
    # Simple approach: find last ] before "testimonials" or end of projects
    proj_key_pos = original_content.find('"projects"')
    if proj_key_pos == -1:
        # Fallback: just rewrite the whole thing
        data["projects"].extend(new_projects)
        with open(data_json_path, 'w', encoding='utf-8') as f:
            json.dump(data, f, indent=2, ensure_ascii=False)
            f.write('\n')
    else:
        # Find the opening [ of projects array
        arr_start = original_content.index('[', proj_key_pos)
        # Find matching closing ] by counting brackets
        depth = 0
        arr_end = -1
        for i in range(arr_start, len(original_content)):
            if original_content[i] == '[':
                depth += 1
            elif original_content[i] == ']':
                depth -= 1
                if depth == 0:
                    arr_end = i
                    break
        
        if arr_end == -1:
            # Fallback
            data["projects"].extend(new_projects)
            with open(data_json_path, 'w', encoding='utf-8') as f:
                json.dump(data, f, indent=2, ensure_ascii=False)
                f.write('\n')
        else:
            # Build the new projects JSON text
            new_entries_text = ""
            for p in new_projects:
                new_entries_text += ",\n    " + json.dumps(p, indent=6, ensure_ascii=False)
                # Fix indentation: json.dumps with indent=6 uses 6-space nesting,
                # but we need the top-level object at 4 spaces.
                # Re-indent: replace first level
            
            # Actually, let's format each project to match existing style
            formatted_entries = []
            for p in new_projects:
                entry = json.dumps(p, indent=2, ensure_ascii=False)
                # Indent each line by 4 spaces (to match array element indentation)
                lines = entry.split('\n')
                indented = lines[0]  # { line
                for line in lines[1:]:
                    indented += '\n    ' + line
                formatted_entries.append(indented)
            
            insert_text = ""
            for entry in formatted_entries:
                insert_text += ",\n    " + entry
            
            # Insert before the closing ]
            new_content = original_content[:arr_end] + insert_text + "\n  " + original_content[arr_end:]
            
            with open(data_json_path, 'w', encoding='utf-8') as f:
                f.write(new_content)

# ── Print summary ──
print(f"🔍 Career Dump Scanner — Complete")
print(f"")
print(f"📊 Summary:")
print(f"   Repos scanned:          {len(discovered)}")
print(f"   Already in portfolio:   {len(skipped)}")
print(f"   New projects added:     {len(new_projects)}")

if new_projects:
    print(f"")
    print(f"✅ New projects added:")
    for p in new_projects:
        tech_str = ", ".join(p["technologies"][:3])
        if len(p["technologies"]) > 3:
            tech_str += f" +{len(p['technologies']) - 3}"
        elif not p["technologies"]:
            tech_str = "no tech detected"
        desc_flag = " ⚠️  needs description" if p["description"] == "TODO: Add description" else ""
        print(f"   • [{p['id']}] {p['title']} ({tech_str}){desc_flag}")

if skipped:
    print(f"")
    print(f"⏭️  Skipped (already exists):")
    for s in skipped:
        print(f"   • {s['title']} — {s['reason']}")

if new_projects:
    needs_desc = sum(1 for p in new_projects if p["description"] == "TODO: Add description")
    print(f"")
    print(f"📝 Next steps:")
    print(f"   1. Review changes:  git diff {data_json_path}")
    if needs_desc > 0:
        print(f"   2. Edit {needs_desc} project(s) with 'TODO: Add description'")
    print(f"   3. Add screenshots to public/projects/")
    print(f"   4. Commit & push to deploy")
else:
    print(f"")
    print(f"✨ No new projects to add — portfolio is up to date!")

PYEOF

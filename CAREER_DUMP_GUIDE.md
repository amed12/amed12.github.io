# Panduan Penggunaan Career Dump Scanner

Skill **`career-dump-scanner`** dibuat untuk membantu kamu mengumpulkan semua project yang pernah kamu kerjakan di komputer secara otomatis, lalu memasukannya ke portfolio (`public/data.json`) sebagai bahan dasar CV.

---

## 🚀 Cara Menjalankan Scanner

Kamu hanya perlu meminta AI Agent (Antigravity/Claude Code) untuk menjalankannya. Buka chat Antigravity di root folder project portfolio ini, lalu ketik perintah seperti berikut:

### 1. Scan Folder Spesifik (Rekomendasi)
Jika proyek-proyek kamu dikelompokkan di folder tertentu:
```
Tolong jalankan career-dump-scanner untuk folder /Users/asani/kantor-mobile
```
atau
```
Scan folder /Users/asani/CascadeProjects untuk career dump
```

### 2. Scan Seluruh Komputer
Jika kamu ingin menyapu bersih folder user kamu untuk mencari sisa-sisa git repo:
```
Tolong jalankan career-dump-scanner untuk folder /Users/asani
```

---

## 🛠️ Cara Kerja di Balik Layar

Ketika kamu memanggil perintah di atas, Agent akan mengeksekusi script:
```bash
bash .agents/skills/career-dump-scanner/scripts/scan-repos.sh <PATH_FOLDER_YANG_DISCAN>
```

1. **Discovery**: Script mencari folder berakhiran `.git` di bawah path yang kamu berikan (maksimal kedalaman 5 sub-folder).
2. **Exclusion (Penyaringan)**: Folder-folder seperti `node_modules`, `Library/`, cache `.cargo`, `.npm`, `.gradle`, cache Flutter, `.Trash`, serta folder versi (seperti `3.38.6`) otomatis diabaikan agar data tidak kotor.
3. **Extraction**: Membaca file konfigurasi project (`package.json`, `pubspec.yaml`, `build.gradle`, `Podfile`, `go.mod`, `pyproject.toml`) untuk mendeteksi kategori (web/mobile/desktop) dan daftar teknologi yang dipakai.
4. **Dedup (Pencegahan Duplikat)**: 
   - **Exact Match**: Jika nama project sama persis.
   - **URL/GitHub Match**: Jika Git remote URL-nya cocok dengan link project yang sudah ada di portfolio (misalnya mencocokan repo `amed12.github.io` dengan "Personal Portfolio").
   - **Fuzzy Match (Fuzzy Word-Overlap)**: Jika judul folder memiliki kesamaan kata >= 50% dengan project yang ada.
5. **Preserved Merge**: Project baru di-append langsung ke `public/data.json` dengan rapi tanpa merusak format data profil atau skill kamu di atasnya.

---

## 📝 Langkah Setelah Scanning (Next Steps)

Setelah script selesai berjalan:

1. **Review Perubahan**:
   Jalankan git diff di terminal untuk memeriksa project apa saja yang baru ditambahkan:
   ```bash
   git diff public/data.json
   ```

2. **Lengkapi Deskripsi & Gambar**:
   Project yang tidak memiliki deskripsi di README-nya akan ditandai dengan `"description": "TODO: Add description"`. Buka `public/data.json`, cari kata kunci `TODO` dan lengkapi deskripsinya secara manual. Kamu juga bisa menambahkan screenshot project ke folder `public/projects/` dan menuliskan path-nya di properti `"image"`.

3. **Gunakan Admin Panel (Alternatif)**:
   Kamu juga bisa membuka Admin Panel portfolio kamu di browser (`localhost:5173/admin` atau `/admin`) untuk mengedit deskripsi project baru tersebut secara visual lewat UI yang nyaman.

4. **Deploy**:
   Jika semua data project baru sudah rapi, tinggal commit dan push ke repository kamu untuk men-deploy perubahan ke GitHub Pages:
   ```bash
   git add public/data.json
   git commit -m "feat: auto-import new projects via career dump scanner"
   git push origin master
   ```

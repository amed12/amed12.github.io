# Project Backlog & Sprint Plan

> Sumber acuan tunggal untuk perbaikan portfolio/CV site.
> **Aturan:** setiap kali ada pekerjaan dari backlog ini dikerjakan/selesai, update status di file ini (checkbox + kolom status sprint).
>
> Dibuat: 2026-08-07 (hasil review total project). Terakhir diupdate: 2026-08-07 (Sprint 5 selesai: fitur share multi-posisi B13–B16).

## Hasil Review (Ringkasan)

### 1. Konten CV/Porto — ❌ Masih terasa "by AI"
- `public/data.json` bercampur: data lama otentik vs lapisan AI boilerplate ("seamless user experiences", "proven expertise", deskripsi proyek Qiscus SDK yang templated seragam).
- Skill bernama `"TODO: Jetpack Compose"` dan tiap experience diakhiri `TODO: Add quantifiable metrics...` — TODO ini **ikut ter-render sebagai bullet di CV hasil export** (CVTemplate split description per `\n`).
- Blok `cv_improvement_notes` (strategi lamaran + match score + pep-talk AI) ter-commit & dipublikasi di JSON publik.
- `bioTemplates` hardcoded generik di `CVTemplate.jsx`; referensi `profile.yearsOfExperience` yang tidak ada di data (selalu fallback "5+").
- Klaim "ATS-Friendly" salah: PDF via html2canvas → gambar raster, teks tidak bisa dibaca ATS. Print CSS `letter` vs PDF `A4` inkonsisten.

### 2. Kemudahan manage — ❌ Friksi sangat tinggi, "Save" menyesatkan
- "Save Changes" di admin hanya menulis ke **localStorage**, tidak pernah sampai ke site. Publish nyata butuh ~6 langkah manual (download `portfolio-data.json` → rename → overwrite `public/data.json` → commit → push).
- localStorage men-shadow `data.json` (`getData()` prefer localStorage) → edit terlihat "live" padahal site tidak berubah.
- `/admin` tanpa auth apa pun (gated hanya path URL).
- SETUP.md tidak menyebut mismatch nama file & langkah commit/deploy.

### 3. Long-term / clean arch — ⚠️ Cukup rapi tapi ada utang
- `storageManager.js` 523 baris, data pribadi hardcoded di source; `CVTemplate.jsx` 399 baris campur data+logic+layout.
- Duplikasi config posisi/keyword antara `CVPage.jsx` dan `CVTemplate.jsx`.
- Zero tests; tidak ada test script.
- 3 sistem paralel tanpa data layer bersama (Portfolio / Admin / Settings dashboard).
- Redundant deploy path (GH Actions + `deploy.sh`), stray file `src/job posting.txt`, avatar ~1 MB.

## Backlog

### P0 — Kredibilitas & data hygiene
- [x] **B1.** Bersihkan `data.json`: hapus semua string `TODO:` (skills + experience), hapus seluruh blok `cv_improvement_notes`.
- [x] **B2.** Rewrite konten AI-boilerplate → human voice: bio profil, deskripsi experience (dengan metrik nyata), deskripsi proyek Qiscus SDK yang templated. Acuan tone: entri lama yang otentik (freelance/PLN, Sitamoto, Ceklok, SIBEA). *(Bio profil + 5 deskripsi proyek Qiscus SDK selesai sprint 1; sisa 28 deskripsi proyek non-SDK lain selesai di sprint 3.)*
- [x] **B3.** Fix klaim ATS: ganti PDF raster dengan text-based PDF (print-to-PDF via `@media print` rapi, atau jsPDF text/react-pdf); samakan ukuran kertas A4 vs letter.
- [x] **B4.** Hapus/fix `bioTemplates` hardcoded: pindah per-position summary (human-written) ke `data.json`; tambah field `yearsOfExperience`.

### P1 — Publish flow (akar masalah "susah di-manage")
- [x] **B5.** Publish 1-klik: Admin "Save" → commit langsung ke repo via GitHub Contents API (PAT). *(Token diminta di field password per-session, tidak disimpan; lihat `src/utils/githubPublish.js` + `AdminPanel.jsx`.)*
- [x] **B6.** Hilangkan jebakan localStorage-shadowing: banner "unpublished changes" bila localStorage ≠ data.json + tombol discard/publish.
- [x] **B7.** Auth sederhana untuk `/admin` (passphrase, atau admin hanya aktif di dev build — didokumentasikan). *(Passphrase gate via `VITE_ADMIN_PASSPHRASE` env var + `AdminGate.jsx`, unlock disimpan di sessionStorage; keterbatasan "obscurity, bukan auth nyata" didokumentasikan di SETUP.md.)*
- [x] **B8.** Update SETUP.md/README: alur update konten end-to-end yang benar; satu deploy path saja (hapus `deploy.sh`, pakai GH Actions).

### P2 — Clean architecture & long-term
- [x] **B9.** Ekstrak config posisi/keyword/skill-priority ke satu module bersama (`src/config/positions.js`), dipakai CVPage + CVTemplate.
- [x] **B10.** Ekstrak logic filtering/scoring CV ke `src/utils/cvScoring.js` & `src/utils/cvTemplateHelpers.js`; `CVTemplate.jsx` kini layout-only. *(Bagian "pisahkan data pribadi dari storageManager.js" gugur — Settings dashboard diarsipkan, lihat B12.)*
- [x] **B11.** Tambah vitest + test untuk relevance scoring/filtering CV (`cvScoring.test.js`) & dataManager (`dataManager.test.js`).
- [x] **B12.** Housekeeping: hapus `src/job posting.txt`, hapus `avatar.jpg` (1MB, tidak dipakai — `avatar.jpeg` 53KB yang dipakai sudah di bawah target), hapus `cv_markdown.md` tak terpakai. Settings dashboard (`src/components/Settings/`, `SettingsPage.jsx`, `storageManager.js`) **diarsipkan** (dihapus dari app aktif, tetap ada di git history) karena tidak pernah di-link dari nav dan punya data layer terpisah — keputusan pemilik project.

### P3 — Fitur: share portofolio multi-posisi (`/share`)

> Latar: pemilihan posisi saat ini hanya di `/cv`, single-select, state lokal (tidak masuk URL) → tidak bisa dibagikan ke recruiter. Tujuan: route khusus `/share` yang menampilkan portofolio ter-kurasi untuk **beberapa posisi terpilih**, shareable via URL (`/share?positions=android,flutter`). Detail rancangan: plan 2026-08-07.

- [x] **B13.** Fix shim redirect GitHub Pages di `src/main.jsx`: saat ini hanya merestore `p=` dan **membuang `q=`** dari `public/404.html` (spa-github-pages) → query string hilang pada deep-link. Ganti dengan decoder standar (rekonstruksi `path + '?' + q.replace(/~and~/g,'&') + hash` via `history.replaceState`). Prasyarat semua deep-link ber-query.
- [x] **B14.** Utility multi-posisi: `filterProjectsByPositions(projects, positionValues[])` di `src/utils/cvScoring.js` — union keywords (dedup) dari `getPositionKeywords()` per posisi, score via `scoreProject`, drop skor 0, sort desc, fallback ke daftar penuh bila tak ada match; posisi tak dikenal/`all` diabaikan. + unit test di `cvScoring.test.js`.
- [x] **B15.** Halaman `src/pages/SharePage.jsx` + route `/share` di `App.jsx`: baca `?positions=` via `useSearchParams` (validasi terhadap `POSITION_OPTIONS`); tanpa param → mode builder (checkbox multi-select posisi + tombol Copy Link, pilihan sinkron ke URL via `setSearchParams`); tampilan kurasi read-only: header profil + bio dari `positionSummaries`, badge posisi terpilih, skills via `sortSkillsByRelevance` (union keywords), projects via `filterProjectsByPositions` (tanpa cap 3), link ke `/` dan `/cv`.
- [x] **B16.** Entry point & polish: link "Share portofolio" di `CVPage.jsx` dekat selector posisi; update SETUP.md/README singkat soal format URL share.

### P4 — Career Dump Automation
- [x] **B17.** Career Dump Scanner skill: scan any folder for git repos, extract project metadata from config files, dedup against existing projects, and update `data.json`. Portable — no hardcoded paths. (`.agents/skills/career-dump-scanner/`)

## Sprint Plan (~1 minggu per sprint)

| Sprint | Fokus | Item | Status | Definition of Done |
|---|---|---|---|---|
| 1 | "CV yang bisa dikirim" | B1, B3, B4, B2 (bio + experience Qiscus) | ✅ Done | Export PDF text-based, tanpa TODO, tanpa blok AI notes, summary human-written |
| 2 | "Update tanpa sakit kepala" | B5, B6, B8 | ✅ Done | Edit di admin → live di site ≤ 2 langkah, terdokumentasi. *(B7 auth admin belum — dijadwalkan tetap di Sprint 3 sesuai plan awal; risiko token-tanpa-auth didokumentasikan di SETUP.md.)* |
| 3 | "Konten & keamanan" | B2 (sisa deskripsi proyek), B7 | ✅ Done | Seluruh konten publik lolos "human read test" |
| 4 | "Long-term health" | B9, B10, B11, B12 | ✅ Done | Config posisi single-source, test hijau, repo bersih |
| 5 | "Share portofolio multi-posisi" | B13, B14, B15, B16 | ✅ Done | `/share?positions=a,b` bisa dibuka langsung di GH Pages (query utuh), builder + Copy Link jalan, konten terfilter union keywords, test cvScoring hijau, lint & build lolos |

Status legend: 🔲 Not started · 🔶 In progress · ✅ Done

## Verifikasi (per rilis)
- Buka `/cv`, pilih tiap posisi → tidak ada TODO/boilerplate; PDF hasil export teksnya selectable (coba copy-paste dari viewer).
- Alur update: edit profil di admin → publish → cek site live berubah.
- `grep -r "TODO:" public/data.json` kosong; `cv_improvement_notes` tidak ada.
- `npm run build` sukses + test hijau.

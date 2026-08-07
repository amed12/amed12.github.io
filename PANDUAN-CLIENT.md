# Panduan Serah Terima — Portfolio & CV Site

> Untuk: **Achmad Fathullah** (pemilik site)
> Tujuan dokumen: setelah project ini diserahterimakan, dokumen ini menjadi pegangan untuk (1) memahami cara kerja sistem, (2) mengelola & mempublikasikan konten sendiri, dan (3) mematangkan CV/portofolio sampai betul-betul siap dikirim ke recruiter.
>
> Dokumen teknis pendamping: `SETUP.md` (setup & admin panel), `README.md`, `BACKLOG.md` (riwayat pekerjaan), `CLAUDE.md` (catatan arsitektur untuk maintenance berbantuan AI).

---

## 1. Gambaran Sistem

Site ini adalah aplikasi React (Vite + Tailwind) yang di-deploy otomatis ke **GitHub Pages** setiap kali ada push ke branch `master`.

| Route | Fungsi |
|---|---|
| `/` | Portofolio publik (profil, skills, experience, projects, education, certifications, testimonials) |
| `/cv` | Generator CV per posisi (pilih posisi → konten terfilter otomatis) + export PDF text-based & print |
| `/share` | Portofolio ter-kurasi multi-posisi, bisa dibagikan via URL (`/share?positions=android,flutter`) |
| `/admin` | Panel edit konten (dilindungi passphrase) + tombol **Publish to GitHub** |

**Satu-satunya sumber data adalah `public/data.json`.** Semua halaman membaca dari file ini. Mengubah file ini = mengubah seluruh site, CV, dan halaman share sekaligus.

### Konsep penting: Draft vs Publish
- **Save Changes** di admin hanya menyimpan *draft* di browser (localStorage). Site live **tidak berubah**, dan akan muncul banner kuning "unpublished changes" sebagai pengingat.
- **Publish to GitHub** (dengan GitHub Personal Access Token) meng-commit draft ke `public/data.json` di repo → GitHub Actions build & deploy otomatis (± 2–3 menit). Ini satu-satunya jalur agar perubahan tampil di site live.
- **Reset to Original** membuang draft dan kembali ke isi `data.json` yang terpublikasi.

Detail langkah membuat token & passphrase admin: lihat `SETUP.md` bagian "Saving Changes" dan "Admin Passphrase Gate".

---

## 2. Alur Kerja Harian (Cheat Sheet)

### A. Update konten (misal: tambah project baru)
1. Buka `https://<domain>/admin` → masukkan passphrase.
2. Edit di tab yang sesuai (Profile / Skills / Experience / Projects / dst).
3. Klik **Save Changes** → cek hasilnya di `/`, `/cv`, dan `/share` (masih draft lokal).
4. Puas? Klik **Publish to GitHub**, tempel token, Confirm.
5. Tunggu ± 2–3 menit, cek site live (hard-refresh: Cmd+Shift+R).

> Alternatif untuk yang nyaman dengan Git: edit `public/data.json` langsung di editor → `git commit` → `git push`. Hasilnya sama.

### B. Kirim CV untuk satu lowongan
1. Buka `/cv`, pilih posisi yang paling cocok dengan lowongan (Android / iOS / Flutter / React Native / Mobile / Web).
2. Baca ulang hasilnya — pastikan bullet & project yang muncul relevan dengan job description.
3. Export PDF (text-based, teks bisa di-copy → aman untuk ATS) atau print.

### C. Kirim link portofolio ke recruiter
1. Buka `/share` → centang posisi yang relevan → **Copy Link**.
2. Kirim link (contoh: `/share?positions=android,flutter`). Recruiter melihat bio, skills, dan project yang sudah terfilter untuk posisi itu — tanpa login.

### D. Backup rutin
Sebulan sekali (atau sebelum edit besar): admin panel → **Download JSON**, simpan filenya. Repo Git sendiri sudah menjadi backup berversi, tapi salinan lokal tidak ada ruginya.

---

## 3. Roadmap Mematangkan CV & Portofolio

Fondasi teknis sudah selesai (lihat `BACKLOG.md`, semua item B1–B16 ✅). Yang tersisa adalah **pekerjaan konten & pemakaian** — hanya Anda yang bisa mengerjakannya karena butuh data karier asli.

### Tahap 1 — Audit konten (± 1–2 jam, sekali)
- [ ] Baca `public/data.json` (atau lewat admin panel) dari atas ke bawah seperti recruiter: adakah kalimat yang terasa template/berlebihan? Tulis ulang dengan suara sendiri. Acuan tone: entri lama yang otentik (freelance/PLN, Sitamoto, Ceklok, SIBEA).
- [ ] Verifikasi semua **fakta**: tanggal kerja, nama jabatan, nomor telepon, email, link sosial media. Konten ini publik — pastikan tidak ada data yang tidak ingin Anda umumkan (mis. pertimbangkan menghapus `age` dan nomor HP dari `data.json` jika tidak mau tampil publik; cukup cantumkan email).
- [ ] Kurasi 46 project: tidak semua project menambah nilai. Pertimbangkan menandai/menghapus project latihan kecil, dan pastikan 10–15 project terbaik punya deskripsi kuat + link demo/repo/screenshot yang masih hidup.
- [ ] Cek semua link eksternal (Play Store, App Store, GitHub, live demo) masih aktif — link mati di portofolio menurunkan kredibilitas.

### Tahap 2 — Perkuat dengan metrik (berkelanjutan)
Deskripsi experience di-split per baris menjadi bullet CV, jadi setiap baris harus berdiri sendiri dan kuat. Ubah bullet "aktivitas" menjadi bullet "dampak":
- ❌ "Maintained the Android SDK"
- ✅ "Cut SDK crash rate from 1.2% to 0.3% across 40+ enterprise client apps by fixing lifecycle leaks found with LeakCanary"

Sumber angka: dashboard Firebase/Play Console/Crashlytics, jumlah user/klien, ukuran tim, persentase perbaikan performa, durasi delivery. Kumpulkan sedikit demi sedikit setiap selesai milestone di kantor — jangan menunggu mau melamar baru mencarinya.

### Tahap 3 — Kalibrasi per posisi
- [ ] Buka `/cv` untuk **setiap** posisi dan baca hasil exportnya. Filtering berbasis keyword (`src/config/positions.js`) — kalau ada project relevan yang tidak muncul, tambahkan keyword yang cocok ke deskripsi/teknologi project tersebut, atau sesuaikan daftar keyword posisi.
- [ ] Baca ulang `profile.positionSummaries` (bio per posisi). Ini paragraf pertama yang dibaca recruiter — pastikan tiap versi menonjolkan bukti terkuat untuk posisi itu.
- [ ] Tes ATS sungguhan: upload PDF hasil export ke jobscan.co / resumeworded (gratis terbatas) atau minimal copy-paste teks dari PDF viewer — semua teks harus terbaca utuh.

### Tahap 4 — Uji ke manusia
- [ ] Kirim link `/share` + PDF CV ke 2–3 teman engineer/recruiter, minta feedback jujur: "kalau kamu hiring manager, bagian mana yang membuatmu berhenti membaca?"
- [ ] Samakan cerita di LinkedIn dengan site ini (judul, tanggal, deskripsi) — recruiter selalu cross-check, dan inkonsistensi lebih merusak daripada konten yang biasa saja.

---

## 4. Saran Pengembangan Lanjutan (opsional, urut prioritas)

1. **Custom domain** (mis. `achmadfathullah.dev`) — lebih profesional di CV daripada `*.github.io`; GitHub Pages mendukung ini gratis (Settings → Pages → Custom domain) tinggal beli domainnya.
2. **SEO & preview link**: tambahkan meta description + Open Graph tags di `index.html` supaya saat link `/share` dikirim via WhatsApp/LinkedIn muncul preview yang bagus (judul, foto, deskripsi). Saat ini belum ada.
3. **Analytics ringan** (mis. GoatCounter/Plausible, gratis/murah, tanpa cookie): supaya tahu apakah recruiter benar-benar membuka link share yang Anda kirim.
4. **Foto profesional**: `avatar.jpeg` sudah dioptimasi (53 KB), tapi pastikan fotonya sendiri terkini dan sesuai dengan foto LinkedIn.
5. **Testimonial nyata**: minta 2–3 rekomendasi singkat dari rekan kerja/atasan (boleh disalin dari rekomendasi LinkedIn, dengan izin) — bagian testimonial paling meyakinkan kalau bisa diverifikasi.
6. **Rotasi token & passphrase**: token GitHub sebaiknya berumur pendek (buat baru tiap kali publish, atau maksimal 30 hari). Ganti `VITE_ADMIN_PASSPHRASE` jika pernah dipakai di komputer orang lain — ingat passphrase ini hanya penghalang kasual, bukan keamanan sungguhan (dijelaskan di `SETUP.md`).
7. **Rutinitas maintenance triwulanan**: `npm outdated` → update dependency minor, `npm run lint` + `npm test` + `npm run build` harus tetap hijau; cek link eksternal; tambah project/pencapaian baru selagi ingatannya masih segar.

---

## 5. Kalau Ada Masalah

| Gejala | Kemungkinan penyebab & solusi |
|---|---|
| Edit di admin tapi site live tidak berubah | Baru "Save Changes" (draft). Klik **Publish to GitHub**. |
| Site live tampak beda dengan yang saya lihat | Browser Anda memakai draft localStorage. Cek banner kuning; pilih publish atau **Reset to Original**. Coba juga buka di jendela incognito untuk melihat versi publik. |
| Publish gagal | Token salah/kedaluwarsa atau tidak punya izin **Contents: Read and write** pada repo ini. Buat token baru (langkahnya di `SETUP.md`). |
| Deploy tidak jalan setelah push | Cek tab **Actions** di GitHub repo — buka run yang gagal untuk melihat errornya (paling sering: `npm run lint` gagal karena warning). |
| Lupa passphrase admin | Nilai ada di file `.env` lokal dan GitHub repo secret `VITE_ADMIN_PASSPHRASE`; bisa diganti kapan saja lalu re-deploy. |
| Ingin mengubah tampilan/warna/fitur | Lihat `SETUP.md` bagian Customization, atau serahkan ke developer dengan `CLAUDE.md` sebagai konteks arsitektur. |

---

*Dokumen dibuat 2026-08-07 sebagai bagian dari serah terima project. Semua item backlog Sprint 1–5 telah selesai (lihat `BACKLOG.md`).*

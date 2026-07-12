# SISTEM PLATFORM LOWONGAN KERJA IT BERBASIS SKILL — TECHHIRE
## INTEGRATED BUSINESS REQUIREMENT DOCUMENT (BRD) & PRODUCT REQUIREMENT DOCUMENT (PRD)

---

# BAGIAN 1: BUSINESS REQUIREMENT DOCUMENT (BRD)

## 1. Overview Bisnis
TechHire adalah platform pencarian pekerjaan khusus bidang IT yang mempertemukan pelamar kerja IT dengan recruiter atau perusahaan[cite: 5, 6]. Platform ini dirancang untuk mengoptimalkan proses pencarian, pelamaran, dan screening awal kandidat secara relevan berdasarkan skill teknis, portfolio, dan spesifikasi kebutuhan lowongan[cite: 6]. Pembeda utamanya adalah pendekatan *skill-based recruitment*, yaitu sistem kalkulasi otomatis yang membantu pelamar mengetahui kecocokan skill terhadap lowongan dan membantu recruiter mengurutkan kandidat berdasarkan kecocokan tersebut[cite: 6].

Sistem ini memiliki tiga pilar bisnis utama[cite: 5, 6]:
1. **Fokus IT:** Seluruh ekosistem dikhususkan pada rumpun profesi teknologi informasi agar pencarian lowongan jauh lebih spesifik dan terarah dibanding job portal umum[cite: 6].
2. **Skill-Based Recruitment:** Evaluasi kecocokan kandidat dilakukan secara objektif melalui komparasi data skill pelamar dan requirement lowongan[cite: 6].
3. **Trust & Moderation:** Setiap akun recruiter diwajibkan melalui proses verifikasi oleh admin sebelum diberikan hak akses publikasi lowongan demi meminimalisir risiko lowongan palsu[cite: 5, 6].

## 2. Tujuan Bisnis
- Menyediakan platform pencarian kerja mandiri khusus bidang IT[cite: 5, 6].
- Mempermudah pelamar dalam memfilter lowongan berdasarkan skill, kategori, lokasi, range salary, tipe pekerjaan (*employment type*), dan level pengalaman[cite: 5, 6].
- Meningkatkan efisiensi waktu screening awal bagi recruiter melalui otomasi urutan pelamar teratas (*Candidate Ranking*)[cite: 5, 6].
- Memberikan arahan peningkatan kompetensi bagi pelamar melalui *Missing Skill Recommendation*[cite: 5, 6].
- Memastikan stabilitas ruang lingkup MVP agar realistis diselesaikan oleh satu developer dalam batas waktu pengerjaan project akademik[cite: 5, 6].

## 3. Matriks Kebutuhan Bisnis (Business Requirements)
| ID | Deskripsi Kebutuhan Bisnis | Prioritas | Target Role |
| :--- | :--- | :--- | :--- |
| **BR-001** | Sistem harus menyediakan fitur registrasi dan login manual untuk pelamar[cite: 5, 6]. | **High** | Pelamar[cite: 5, 6] |
| **BR-002** | Registrasi recruiter menghasilkan status default `pending`[cite: 5, 6]. | **High** | Recruiter[cite: 5, 6] |
| **BR-003** | Admin harus dapat memverifikasi atau menolak akun recruiter di backend[cite: 5, 6]. | **High** | Admin[cite: 5, 6] |
| **BR-004** | Recruiter non-verified dilarang mengakses fitur utama & membuat lowongan[cite: 5, 6]. | **High** | Recruiter[cite: 5, 6] |
| **BR-005** | Recruiter verified dapat melakukan operasi penuh CRUD dan status publish lowongan[cite: 5, 6]. | **High** | Recruiter[cite: 5, 6] |
| **BR-006** | Pelamar dapat mencari lowongan kerja lewat keyword dan multi-filter[cite: 5, 6]. | **High** | Pelamar[cite: 5, 6] |
| **BR-007** | Pelamar dapat apply pekerjaan menggunakan CV (PDF/DOCX) dan parameter pendukung[cite: 5, 6]. | **High** | Pelamar[cite: 5, 6] |
| **BR-008** | Sistem wajib memblokir pelamar agar tidak melakukan *double-apply* di lowongan yang sama[cite: 5, 6]. | **High** | Pelamar / Sistem[cite: 5, 6] |
| **BR-011** | Sistem mengkalkulasi persentase *Skill Match Score* secara dinamis[cite: 5, 6]. | **High** | Sistem[cite: 5, 6] |

---

# BAGIAN 2: PRODUCT REQUIREMENT DOCUMENT (PRD)

## 1. Spesifikasi Teknis & Fitur Fungsional

### 1.1 Website Publik (Frontend Pelamar)
- **Landing Page:** Menampilkan value proposition utama platform, search bar global, dan grid kategori IT populer[cite: 5].
- **Katalog Lowongan:** Menampilkan ringkasan informasi kartu lowongan[cite: 5]. Jika lowongan telah melewati batas *deadline*, sistem secara otomatis menutup form lamaran baru[cite: 5, 6].
- **Halaman Detail Lowongan:** Menampilkan seluruh deskripsi kerja, visualisasi *Skill Match Score* (untuk user terautentikasi), serta daftar komparasi *matched skills* dan *missing skills*[cite: 5].

### 1.2 Panel Administrasi Internal (Filament V3)
Menggunakan arsitektur multi-panel bawaan **Filament V3** untuk mengisolasi hak akses[cite: 6]:
- **Panel Admin:** Menyediakan dasbor statistik global, verifikasi identitas recruiter, manajemen master data (`categories` dan `skills`), serta hak moderasi/unpublish lowongan bermasalah[cite: 5, 6].
- **Panel Recruiter:** Akses khusus bagi akun berstatus `verified`[cite: 5, 6]. Menyediakan pengelolaan profil perusahaan tunggal, manajemen lowongan kerja milik sendiri, integrasi obrolan, serta peninjauan daftar pelamar kerja yang sudah terurut otomatis berdasarkan skor kecocokan tertinggi[cite: 5, 6].

## 2. Logika Formula Bisnis (Skill Matching)
Formula perhitungan persentase kecocokan skill pada platform bersifat *rule-based* menggunakan perbandingan matematis sebagai berikut[cite: 5, 6]:

$$\text{Skill Match Score} = \left( \frac{\text{Jumlah Skill Cocok}}{\text{Jumlah Skill Dibutuhkan Lowongan}} \right) \times 100\%$$

*Aturan Tambahan:* Jika entitas lowongan tidak dikonfigurasi memiliki kriteria *required skill* oleh recruiter, maka sistem akan secara otomatis mengembalikan nilai $0\%$ atau status `Not Available`[cite: 5].

## 3. Arsitektur Data & Skema Basis Data (MariaDB)

### 3.1 Tabel: `users`
| Kolom | Tipe Data | Atribut | Keterangan |
| :--- | :--- | :--- | :--- |
| `id` | BIGINT | PK, Auto Increment | Identifier unik user[cite: 5] |
| `name` | VARCHAR(255) | NOT NULL | Nama lengkap user[cite: 5] |
| `email` | VARCHAR(255) | UNIQUE, NOT NULL | Alamat email log-in[cite: 5] |
| `password` | VARCHAR(255) | NOT NULL | String password ter-hashing[cite: 5] |
| `role` | ENUM | 'admin', 'recruiter', 'pelamar' | Hak akses sistem[cite: 5] |
| `recruiter_status` | ENUM | 'pending', 'verified', 'rejected' | Status khusus akun recruiter[cite: 5] |
| `cv_path` | VARCHAR(255) | NULLABLE | Path penyimpanan dokumen CV[cite: 5] |

### 3.2 Tabel: `jobs`
| Kolom | Tipe Data | Atribut | Keterangan |
| :--- | :--- | :--- | :--- |
| `id` | BIGINT | PK, Auto Increment | Identifier unik lowongan[cite: 5] |
| `company_id` | BIGINT | FK -> `companies.id` | Asal perusahaan pembuat[cite: 5] |
| `category_id` | BIGINT | FK -> `categories.id` | Kategori rumpun IT[cite: 5] |
| `title` | VARCHAR(255) | NOT NULL | Nama posisi pekerjaan[cite: 5] |
| `employment_type` | ENUM | full_time, part_time, contract, dll | Tipe ikatan kerja[cite: 5] |
| `experience_level` | ENUM | fresh_graduate, junior, mid, senior | Kualifikasi pengalaman[cite: 5] |
| `deadline_at` | DATE | NOT NULL | Batas waktu pelamaran[cite: 5] |
| `is_published` | BOOLEAN | DEFAULT FALSE | Status aktif publikasi[cite: 5] |

---

## 4. Rencana Jadwal Pengembangan (8 Minggu)
- **Week 1:** Setup awal arsitektur project, integrasi Docker, fondasi database, dan pembuatan multi-panel auth Filament[cite: 6].
- **Week 2:** Implementasi skema migrasi MariaDB, pendefinisian relasi model Eloquent, dan pengisian data dummy seeder[cite: 6].
- **Week 3:** Penyelesaian fitur Panel Admin (Verifikasi recruiter, manajemen master skill & kategori, serta moderasi)[cite: 6].
- **Week 4 - 5:** Penyelesaian Panel Recruiter (CRUD Lowongan, Company Profile) dan perancangan Frontend Publik (Landing page, pencarian, multi-filter)[cite: 6].
- **Week 6:** Pengembangan modul workflow Pelamar (Manajemen profil portfolio, upload berkas CV, penanganan aksi apply & bookmark)[cite: 6].
- **Week 7:** Penerapan core engine (Kalkulator Skill Match, sistem Candidate Ranking, dan fitur chat real-time menggunakan Livewire polling)[cite: 6].
- **Week 8:** Siklus pengujian intensif (UAT), perbaikan bug, penyiapan berkas konfigurasi deploy VPS, dan finalisasi dokumentasi teknis[cite: 6].
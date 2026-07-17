# 🚀 TechHire-2026

**TechHire-2026** adalah platform rekrutmen Teknologi Informasi (IT) berbasis keterampilan (*skill-based recruitment*) yang menghubungkan pelamar dengan perusahaan melalui algoritma pencocokan kompetensi teknis (*Skill Match Score*). Sistem ini membantu pelamar menemukan lowongan yang paling relevan dan membantu recruiter melakukan penyaringan kandidat secara lebih cepat dan terukur.

> 🌐 **Akses Live Demo:** [https://ynugra.site](https://ynugra.site)

---

## 📌 Fitur Utama

| Modul | Fitur |
| :--- | :--- |
| **Autentikasi** | Registrasi manual, Login email/password, Google OAuth 2.0, Lupa/Reset password |
| **Manajemen Akses** | 5 Peran sistem: `super_admin`, `admin`, `recruiter`, `pelamar`, `user` (RBAC + Spatie Permission) |
| **Verifikasi Recruiter** | Status `pending` → diverifikasi/ditolak oleh admin di panel Filament |
| **Pencarian Lowongan** | Full-text search + filter multi-kriteria (kategori, lokasi, tipe kerja, level, gaji) |
| **Skill Matching** | Menampilkan *Skill Match Score*, *Matched Skills*, dan *Missing Skills* pada setiap lowongan |
| **Pelamaran** | Upload CV (PDF/DOCX, maks 5MB), surat pengantar, portfolio, pencegahan duplikasi lamaran |
| **Dashboard Pelamar** | Statistik lamaran, bookmark, rekomendasi top-5, riwayat status, undangan wawancara, notifikasi |
| **Panel Recruiter** | Profil perusahaan, CRUD lowongan, perangkingan kandidat (desc by score), screening, ubah status, kirim undangan |
| **Panel Admin** | Manajemen user, verifikasi recruiter, moderasi job/application, data master (kategori & skill) |
| **Notifikasi** | Multi-channel: Database (bell) + Email (SMTP/Mailgun) |
| **Otomatisasi** | Auto-close lowongan kedaluwarsa via cron job + command inisialisasi/pembaruan sistem |

---

## 🛠️ Tumpukan Teknologi

| Lapisan | Teknologi | Versi |
| :--- | :--- | :---: |
| **Backend** | Laravel | 12 |
| **Admin/Recruiter Panel** | Filament | V3 |
| **Frontend Reaktif** | Livewire | 3 |
| **Templating & Styling** | Blade + Tailwind CSS | 3 |
| **Database** | MariaDB | 10.11 |
| **Web Server** | Nginx + SSL | — |
| **Containerization** | Docker Compose | — |
| **RBAC** | Spatie Laravel Permission | — |
| **OAuth** | Laravel Socialite (Google) | — |

---

## 📋 Persyaratan Sistem

- PHP 8.2 atau lebih tinggi
- Composer
- Docker & Docker Compose (direkomendasikan untuk development)
- Node.js & NPM (untuk build asset)

---

## 🚀 Panduan Instalasi (Lokal dengan Docker)

1.  **Clone Repository**
    ```bash
    git clone https://github.com/dudungsss/techhire-2026.git
    cd techhire-2026

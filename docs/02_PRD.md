# 02_PRD.md
# PRODUCT REQUIREMENTS DOCUMENT (PRD)
# STOREKUIFY — Aplikasi Kasir & Manajemen Warung Kelontong

---

## 1. DOCUMENT INFORMATION

| Atribut | Keterangan |
|---|---|
| Nama Dokumen | Product Requirements Document (PRD) — StoreKuify |
| Kode Dokumen | 02_PRD.md |
| Nama Proyek | StoreKuify |
| Jenis Proyek | Web Application |
| Bahasa Dokumen | Bahasa Indonesia |
| Target Pengguna | Pemilik dan Kasir Warung Kelontong |
| Platform | Desktop First, Responsive Web |
| Teknologi Referensi | Laravel 12, Filament 4, MySQL, Tailwind CSS |
| Status Dokumen | Final Draft — Siap untuk Tahap Development |
| Pemilik Dokumen | Tim Product Management StoreKuify |
| Disusun Oleh | Senior Product Manager & Senior Software Architect |
| Tanggal Dibuat | 02 Agustus 2026 |
| Confidentiality | Internal — Hanya untuk Tim Internal & Development Team |

Dokumen ini merupakan **single source of truth** yang menjadi acuan utama untuk:

- UI/UX Design
- Database Design (ERD & Schema)
- API Design (REST/Internal API)
- Software Requirement Specification (SRS)
- Software Design Document (SDD)
- Implementasi/Development
- Quality Assurance & Testing
- User Acceptance Testing (UAT)

Seluruh tim (Product, Design, Backend, Frontend, QA) **wajib** merujuk pada dokumen ini sebagai acuan tunggal kebenaran (single source of truth). Setiap perubahan requirement harus melalui proses revisi dokumen dan dicatat pada Revision History.

---

## 2. REVISION HISTORY

| Versi | Tanggal | Deskripsi Perubahan | Disusun Oleh | Disetujui Oleh |
|---|---|---|---|---|
| 0.1 | 02 Agustus 2026 | Draft awal PRD berdasarkan hasil discovery dan requirement gathering | Senior Product Manager | - |
| 1.0 | 02 Agustus 2026 | Finalisasi PRD lengkap: Functional Requirements, Non-Functional Requirements, Security, Validation, Error Handling, Glossary | Senior Product Manager & Senior Software Architect | Product Owner |

Catatan: Setiap perubahan requirement di kemudian hari wajib menambah baris baru pada tabel di atas, tidak boleh menimpa (overwrite) versi sebelumnya.

---

## 3. TABLE OF CONTENTS

1. Document Information
2. Revision History
3. Table of Contents
4. Product Overview
5. Business Objectives
6. Product Goals
7. User Roles
8. Scope
9. Information Architecture
10. Functional Requirements
   - 10.1 Modul Authentication
   - 10.2 Modul Dashboard
   - 10.3 Modul Data Barang
   - 10.4 Modul Kasir (POS/Transaksi Penjualan)
   - 10.5 Modul Hutang Pelanggan
   - 10.6 Modul Laporan
   - 10.7 Modul Kelola Kasir
   - 10.8 Modul Pengaturan
11. Non Functional Requirements
12. Security Requirements
13. Validation Rules
14. Error Handling
15. Future Scope
16. Assumptions
17. Dependencies
18. Risks
19. Glossary

---

## 4. PRODUCT OVERVIEW

**StoreKuify** adalah aplikasi kasir dan manajemen toko yang dirancang khusus untuk kebutuhan **Warung Kelontong** — usaha retail skala kecil-menengah yang dikelola oleh individu/keluarga dengan operasional yang sederhana.

StoreKuify hadir untuk membantu **Owner** (pemilik warung) dan **Kasir** dalam mengelola:

- Data Barang dan Kategori Barang
- Stok Barang
- Transaksi Penjualan (Kasir/POS)
- Hutang Pelanggan (Piutang Toko)
- Laporan Penjualan dan Keuntungan
- Dashboard Ringkasan Bisnis
- Pengaturan Data Toko
- Pengelolaan Akun Kasir

### Filosofi Produk

StoreKuify **sengaja dibuat sederhana**. Aplikasi ini **bukan** sistem kasir modern retail besar seperti Indomaret atau Alfamart yang menggunakan barcode scanner, integrasi supplier, atau sistem multi-cabang yang kompleks.

Prinsip utama produk:

- **Simplicity First** — antarmuka dan alur kerja harus mudah dipahami oleh pengguna non-teknis (pemilik warung kelontong yang mungkin tidak terbiasa dengan aplikasi digital).
- **No Barcode Scanner** — seluruh pencarian barang menggunakan fitur pencarian nama barang (search by name), bukan pemindaian barcode.
- **Single Store Context** — StoreKuify pada versi ini dirancang untuk **satu toko** (single-tenant), bukan multi-cabang.
- **Manual & Statis untuk Pembayaran QRIS** — StoreKuify tidak terintegrasi dengan payment gateway. QRIS bersifat statis (gambar QRIS toko), dan kasir memverifikasi pembayaran secara manual berdasarkan konfirmasi pelanggan.

### Value Proposition

| Masalah Warung Kelontong | Solusi StoreKuify |
|---|---|
| Pencatatan penjualan manual, rawan human error | Pencatatan transaksi otomatis melalui sistem kasir digital |
| Tidak tahu keuntungan riil per hari/bulan | Laporan keuntungan otomatis berbasis harga modal dan harga jual |
| Hutang pelanggan sering tidak tercatat rapi | Modul Hutang Pelanggan dengan histori lengkap |
| Stok barang sering tidak akurat | Modul Data Barang dengan stok real-time |
| Pemilik tidak bisa memantau kasir | Modul Kelola Kasir dan Dashboard untuk owner |

---

## 5. BUSINESS OBJECTIVES

1. **Meningkatkan Akurasi Pencatatan Transaksi** — Menghilangkan kesalahan pencatatan manual pada buku kasir konvensional.
2. **Meningkatkan Visibilitas Keuangan Owner** — Memberikan owner data penjualan dan keuntungan secara real-time dan historis.
3. **Mempermudah Pengelolaan Stok** — Owner dapat memantau stok barang, termasuk barang yang hampir habis, agar tidak kehabisan stok penting.
4. **Mendigitalisasi Pencatatan Hutang Pelanggan** — Menggantikan pencatatan hutang manual (buku catatan) dengan sistem yang tidak mudah hilang atau rusak.
5. **Meningkatkan Kontrol Owner terhadap Operasional Kasir** — Owner dapat mengelola akun kasir dan membatasi akses sesuai peran (role-based access).
6. **Mendukung Pengambilan Keputusan Bisnis** — Laporan penjualan, keuntungan, dan barang terlaris membantu owner mengambil keputusan restock dan strategi penjualan.
7. **Menjaga Kesederhanaan Operasional** — Tidak menambah kompleksitas operasional warung kelontong dengan perangkat tambahan (seperti barcode scanner).

---

## 6. PRODUCT GOALS

### Goals Jangka Pendek (Rilis Awal)

- Menyediakan sistem autentikasi berbasis role (Owner & Kasir).
- Menyediakan modul kasir yang cepat, sederhana, dan bebas barcode.
- Menyediakan pencatatan hutang pelanggan yang akurat dan tidak dapat dihapus (audit-safe).
- Menyediakan dashboard ringkas yang informatif untuk masing-masing role.
- Menyediakan laporan penjualan dan keuntungan dengan filter periode (harian, mingguan, bulanan, tahunan).

### Goals Jangka Panjang (Roadmap Berikutnya — Referensi ke Future Scope)

- Dukungan multi-toko/multi-cabang.
- Integrasi payment gateway dinamis (QRIS dinamis).
- Aplikasi mobile companion.
- Notifikasi stok menipis via WhatsApp/Telegram.

### Success Metrics (Indikator Keberhasilan Produk)

| Metrik | Target |
|---|---|
| Waktu rata-rata transaksi kasir | < 30 detik per transaksi (untuk 1-5 item) |
| Akurasi pencatatan stok | 100% konsisten dengan transaksi tervalidasi sistem |
| Downtime histori hutang | 0% data hutang hilang/terhapus |
| Adopsi fitur laporan oleh owner | Owner mengakses laporan minimal 1x per minggu |

---

## 7. USER ROLES

StoreKuify memiliki dua peran utama pengguna: **Owner** dan **Kasir**. Tidak ada peran administrator sistem terpisah pada versi ini — Owner bertindak sebagai administrator toko.

### 7.1 Owner

Owner adalah pemilik warung kelontong yang memiliki **akses penuh (full access)** terhadap seluruh fitur aplikasi.

**Menu yang dapat diakses Owner:**

- Dashboard (versi Owner — lengkap dengan data finansial)
- Data Barang (Create, Read, Update, Delete/Nonaktifkan)
- Kasir (melakukan transaksi penjualan)
- Hutang Pelanggan (kelola penuh)
- Laporan (Harian, Mingguan, Bulanan, Tahunan — termasuk data keuntungan)
- Kelola Kasir (tambah, edit, nonaktifkan, reset password akun kasir)
- Pengaturan (Nama Toko, Alamat, Logo, QRIS, Profil Owner)

### 7.2 Kasir

Kasir adalah staf operasional yang bertugas melayani transaksi penjualan harian. Akses kasir **dibatasi** sesuai prinsip least-privilege.

**Menu yang dapat diakses Kasir:**

- Dashboard (versi Kasir — ringkasan operasional harian, tanpa data finansial sensitif)
- Data Barang (**Read Only** — hanya melihat, tidak dapat mengubah)
- Kasir (melakukan transaksi penjualan)
- Hutang Pelanggan (dapat melihat, menambah pelanggan, mencatat hutang, menerima pembayaran)

**Kasir TIDAK diperbolehkan:**

- Mengubah data Barang (nama, harga modal, harga jual, kategori, stok manual)
- Mengubah Kategori Barang
- Melihat Laporan Keuangan (Laporan Penjualan/Keuntungan)
- Mengelola akun Kasir lain
- Mengubah Pengaturan Toko

**Kasir dapat mengubah profil miliknya sendiri:**

- Username
- Password
- Foto Profil

### 7.3 Role Access Matrix

| Modul | Owner | Kasir |
|---|---|---|
| Dashboard (Full) | ✅ | ❌ (versi terbatas) |
| Data Barang — Create/Update/Delete | ✅ | ❌ |
| Data Barang — Read | ✅ | ✅ |
| Kasir (Transaksi) | ✅ | ✅ |
| Hutang Pelanggan | ✅ | ✅ |
| Laporan Penjualan & Keuntungan | ✅ | ❌ |
| Kelola Kasir | ✅ | ❌ |
| Pengaturan Toko | ✅ | ❌ |
| Ubah Profil Sendiri (username/password/foto) | ✅ | ✅ |

---

## 8. SCOPE

### 8.1 In-Scope (Termasuk dalam Ruang Lingkup)

- Sistem autentikasi berbasis session dengan role Owner dan Kasir.
- Manajemen Kategori Barang.
- Manajemen Data Barang (termasuk foto produk opsional, harga modal, harga jual, stok).
- Modul Kasir/POS dengan pencarian barang berbasis nama (tanpa barcode).
- Mekanisme keranjang belanja (cart) sebelum checkout.
- Metode pembayaran: Cash, QRIS (statis), Hutang, dan kombinasi Cash + Hutang.
- Modul Hutang Pelanggan (pencatatan piutang, histori, pembayaran cicilan/lunas).
- Modul Laporan (Harian, Mingguan, Bulanan, Tahunan) dengan grafik dan ranking barang.
- Modul Kelola Kasir (CRUD akun kasir oleh Owner).
- Modul Pengaturan Toko (identitas toko, QRIS, profil Owner).
- Dashboard berbeda untuk Owner dan Kasir.
- Aplikasi berbasis web, desktop-first, namun tetap responsif di perangkat mobile/tablet.

### 8.2 Out-of-Scope (Tidak Termasuk dalam Ruang Lingkup Versi Ini)

- Integrasi barcode scanner/hardware scanner.
- Payment gateway dinamis/otomatis terverifikasi sistem (QRIS bersifat statis, verifikasi manual oleh kasir).
- Dukungan multi-toko/multi-cabang dalam satu akun.
- Aplikasi mobile native (Android/iOS).
- Integrasi dengan supplier/purchase order otomatis.
- Sistem loyalti pelanggan (poin reward, membership tier).
- Notifikasi push/WhatsApp/SMS otomatis (dicatat sebagai Future Scope).
- Multi-bahasa (aplikasi hanya menggunakan Bahasa Indonesia).
- Integrasi akuntansi pihak ketiga (contoh: Accurate, Jurnal.id).

---

## 9. INFORMATION ARCHITECTURE

### 9.1 Struktur Navigasi Owner

```
StoreKuify (Owner)
├── Dashboard
├── Data Barang
│   ├── Kategori Barang
│   └── Barang
├── Kasir
│   ├── Pencarian Barang
│   ├── Keranjang
│   └── Checkout
├── Hutang Pelanggan
│   ├── Daftar Pelanggan
│   ├── Detail Hutang & Histori
│   └── Pembayaran Hutang
├── Laporan
│   ├── Laporan Harian
│   ├── Laporan Mingguan
│   ├── Laporan Bulanan
│   └── Laporan Tahunan
├── Kelola Kasir
│   ├── Daftar Kasir
│   ├── Tambah Kasir
│   └── Reset Password Kasir
└── Pengaturan
    ├── Profil Toko
    ├── QRIS
    └── Profil Owner
```

### 9.2 Struktur Navigasi Kasir

```
StoreKuify (Kasir)
├── Dashboard
├── Data Barang (Read Only)
├── Kasir
│   ├── Pencarian Barang
│   ├── Keranjang
│   └── Checkout
├── Hutang Pelanggan
│   ├── Daftar Pelanggan
│   ├── Detail Hutang & Histori
│   └── Pembayaran Hutang
└── Profil Saya
    ├── Ubah Username
    ├── Ubah Password
    └── Ubah Foto Profil
```

### 9.3 Entitas Data Utama (High-Level, Referensi untuk Database Design)

- `users` (Owner & Kasir, dibedakan dengan kolom role)
- `stores` (data toko: nama, alamat, logo, QRIS)
- `categories` (kategori barang)
- `products` (barang: nama, foto, harga modal, harga jual, stok, status aktif)
- `transactions` (transaksi penjualan/header)
- `transaction_items` (detail item per transaksi)
- `payments` (metode & rincian pembayaran per transaksi — cash, qris, hutang)
- `customers` (data pelanggan/pengutang)
- `debts` (hutang per transaksi)
- `debt_payments` (histori pembayaran/cicilan hutang)
- `stock_movements` (opsional/pendukung audit trail perubahan stok)


---

## 10. FUNCTIONAL REQUIREMENTS

Setiap Functional Requirement (FR) memiliki format standar berikut: **Requirement ID, Requirement Name, Description, Actor, Pre-condition, Main Flow, Alternative Flow, Post-condition, Acceptance Criteria, Priority**.

Skala prioritas: **Must Have (M)**, **Should Have (S)**, **Could Have (C)** — mengacu pada metode MoSCoW.

---

### 10.1 MODUL AUTHENTICATION

#### FR-AUTH-01 — Login Pengguna

- **Requirement Name:** Login ke Sistem
- **Description:** Sistem menyediakan mekanisme login menggunakan username dan password untuk Owner dan Kasir. Setelah login berhasil, sistem mengarahkan pengguna ke Dashboard sesuai role masing-masing.
- **Actor:** Owner, Kasir
- **Pre-condition:**
  1. Pengguna memiliki akun terdaftar di sistem (username dan password aktif).
  2. Akun pengguna berstatus aktif (tidak dinonaktifkan).
- **Main Flow:**
  1. Pengguna membuka halaman login StoreKuify.
  2. Pengguna memasukkan username dan password.
  3. Pengguna menekan tombol "Login".
  4. Sistem memvalidasi kredensial terhadap data pada database.
  5. Sistem membuat sesi login (session) untuk pengguna.
  6. Sistem mengarahkan pengguna ke halaman Dashboard sesuai role (Owner atau Kasir).
- **Alternative Flow:**
  - **A1 — Username/Password Salah:** Sistem menampilkan pesan error "Username atau password salah" dan tetap berada di halaman login.
  - **A2 — Akun Dinonaktifkan:** Sistem menampilkan pesan "Akun Anda telah dinonaktifkan, silakan hubungi Owner" dan menolak proses login.
  - **A3 — Field Kosong:** Sistem menampilkan validasi bahwa username/password wajib diisi.
- **Post-condition:** Pengguna memiliki sesi aktif dan dapat mengakses menu sesuai role-nya.
- **Acceptance Criteria:**
  1. Login berhasil hanya jika username dan password sesuai dengan data di database.
  2. Pengguna dengan role Owner diarahkan ke Dashboard Owner.
  3. Pengguna dengan role Kasir diarahkan ke Dashboard Kasir.
  4. Akun non-aktif tidak dapat login walaupun password benar.
  5. Satu akun dapat login pada lebih dari satu perangkat secara bersamaan (sesuai business rule).
- **Priority:** Must Have (M)

#### FR-AUTH-02 — Logout Pengguna

- **Requirement Name:** Logout dari Sistem
- **Description:** Pengguna dapat keluar dari sesi aplikasi secara aman melalui tombol logout.
- **Actor:** Owner, Kasir
- **Pre-condition:** Pengguna sedang dalam kondisi login (sesi aktif).
- **Main Flow:**
  1. Pengguna menekan tombol/menu "Logout".
  2. Sistem menghentikan sesi aktif pengguna pada perangkat tersebut.
  3. Sistem mengarahkan pengguna kembali ke halaman login.
- **Alternative Flow:**
  - **A1 — Sesi Sudah Kedaluwarsa:** Jika sesi telah expired sebelum pengguna menekan logout, sistem otomatis mengarahkan ke halaman login saat request berikutnya dilakukan.
- **Post-condition:** Sesi pengguna pada perangkat tersebut telah berakhir.
- **Acceptance Criteria:**
  1. Setelah logout, pengguna tidak dapat mengakses halaman internal tanpa login ulang.
  2. Sesi pada perangkat lain (jika ada) tidak terpengaruh oleh logout di satu perangkat.
- **Priority:** Must Have (M)

#### FR-AUTH-03 — Proteksi Akses Berdasarkan Role (Role-Based Access Control)

- **Requirement Name:** Pembatasan Akses Menu Berdasarkan Role
- **Description:** Sistem membatasi akses menu dan aksi tertentu berdasarkan role pengguna (Owner/Kasir) sesuai Role Access Matrix pada bagian User Roles.
- **Actor:** Owner, Kasir
- **Pre-condition:** Pengguna telah login dengan role tertentu.
- **Main Flow:**
  1. Pengguna mengakses suatu menu/aksi.
  2. Sistem memeriksa role pengguna terhadap izin akses menu/aksi tersebut.
  3. Jika diizinkan, sistem menampilkan/menjalankan aksi.
- **Alternative Flow:**
  - **A1 — Akses Ditolak:** Jika role tidak memiliki izin, sistem menampilkan halaman/pesan "403 - Anda tidak memiliki akses ke halaman ini" dan mencatat percobaan akses (opsional, untuk audit).
- **Post-condition:** Hanya aksi yang sesuai izin role yang berhasil dieksekusi.
- **Acceptance Criteria:**
  1. Kasir tidak dapat mengakses endpoint/menu untuk mengubah Barang, Kategori, Laporan Keuangan, Kelola Kasir, dan Pengaturan Toko meskipun mengetik URL secara langsung.
  2. Percobaan akses tidak sah dicatat dan/atau ditolak secara konsisten di seluruh sistem (frontend & backend validation).
- **Priority:** Must Have (M)

---

### 10.2 MODUL DASHBOARD

#### FR-DASH-01 — Dashboard Owner

- **Requirement Name:** Tampilan Dashboard untuk Owner
- **Description:** Menampilkan ringkasan performa bisnis harian dan indikator penting bagi Owner, mencakup: Penjualan Hari Ini, Keuntungan Hari Ini, Jumlah Transaksi, Barang Terjual, Grafik Penjualan, Barang Hampir Habis, dan Hutang Belum Lunas.
- **Actor:** Owner
- **Pre-condition:** Owner telah login ke sistem.
- **Main Flow:**
  1. Owner login dan diarahkan ke Dashboard.
  2. Sistem mengambil data agregat transaksi hari berjalan (total penjualan, total keuntungan, jumlah transaksi, jumlah barang terjual).
  3. Sistem menampilkan grafik penjualan (contoh: tren 7 hari terakhir).
  4. Sistem menampilkan daftar barang dengan stok di bawah ambang batas minimum (barang hampir habis).
  5. Sistem menampilkan ringkasan hutang pelanggan yang belum lunas (total nominal dan jumlah pelanggan berhutang).
- **Alternative Flow:**
  - **A1 — Belum Ada Transaksi Hari Ini:** Sistem menampilkan nilai 0/kosong dengan pesan informatif seperti "Belum ada transaksi hari ini".
  - **A2 — Tidak Ada Barang Hampir Habis:** Sistem menampilkan pesan "Semua stok barang aman".
- **Post-condition:** Owner memperoleh gambaran umum kondisi bisnis hari berjalan.
- **Acceptance Criteria:**
  1. Data Penjualan Hari Ini dan Keuntungan Hari Ini terhitung berdasarkan transaksi yang berstatus selesai (bukan draft/keranjang).
  2. Grafik penjualan menampilkan data historis minimal 7 hari terakhir.
  3. Daftar Barang Hampir Habis menampilkan barang dengan stok ≤ ambang batas minimum yang dapat dikonfigurasi (default: stok ≤ 5, dapat disesuaikan pada Pengaturan atau level Barang).
  4. Hutang Belum Lunas menampilkan total nominal outstanding dan link ke modul Hutang Pelanggan.
- **Priority:** Must Have (M)

#### FR-DASH-02 — Dashboard Kasir

- **Requirement Name:** Tampilan Dashboard untuk Kasir
- **Description:** Menampilkan ringkasan operasional harian bagi Kasir tanpa menampilkan data finansial sensitif (seperti keuntungan toko), mencakup: Ringkasan Transaksi Hari Ini, Barang Hampir Habis, dan Hutang Pelanggan.
- **Actor:** Kasir
- **Pre-condition:** Kasir telah login ke sistem.
- **Main Flow:**
  1. Kasir login dan diarahkan ke Dashboard.
  2. Sistem menampilkan ringkasan jumlah transaksi yang telah dilakukan Kasir hari ini (dan/atau seluruh transaksi toko hari ini, sesuai kebijakan tampilan yang ditentukan Owner).
  3. Sistem menampilkan daftar barang hampir habis.
  4. Sistem menampilkan ringkasan hutang pelanggan yang belum lunas.
- **Alternative Flow:**
  - **A1 — Tidak Ada Transaksi:** Sistem menampilkan pesan "Belum ada transaksi hari ini".
- **Post-condition:** Kasir mendapatkan gambaran kondisi operasional harian tanpa mengetahui data keuntungan toko.
- **Acceptance Criteria:**
  1. Dashboard Kasir **tidak menampilkan** nominal Keuntungan Hari Ini maupun data keuntungan lainnya.
  2. Dashboard Kasir menampilkan jumlah transaksi dan ringkasan barang hampir habis secara real-time.
  3. Hutang Pelanggan pada Dashboard Kasir hanya menampilkan ringkasan (jumlah pelanggan berhutang/total nominal), detail lengkap diakses melalui modul Hutang Pelanggan.
- **Priority:** Must Have (M)

---

### 10.3 MODUL DATA BARANG

#### FR-BRG-01 — Kelola Kategori Barang (Create)

- **Requirement Name:** Tambah Kategori Barang
- **Description:** Owner dapat membuat kategori barang baru sebagai wadah pengelompokan barang (contoh: Sabun, Makanan, Minuman, Bumbu).
- **Actor:** Owner
- **Pre-condition:** Owner telah login sebagai Owner.
- **Main Flow:**
  1. Owner membuka menu Data Barang → Kategori Barang.
  2. Owner menekan tombol "Tambah Kategori".
  3. Owner mengisi Nama Kategori.
  4. Owner menekan tombol "Simpan".
  5. Sistem memvalidasi keunikan nama kategori.
  6. Sistem menyimpan kategori baru dan menampilkannya pada daftar kategori.
- **Alternative Flow:**
  - **A1 — Nama Kategori Duplikat:** Sistem menampilkan pesan error "Nama kategori sudah digunakan" dan menolak penyimpanan.
  - **A2 — Field Kosong:** Sistem menampilkan validasi "Nama kategori wajib diisi".
- **Post-condition:** Kategori baru tersimpan dan dapat digunakan saat membuat Barang.
- **Acceptance Criteria:**
  1. Nama kategori bersifat unik (case-insensitive) di seluruh sistem.
  2. Kategori baru langsung tersedia sebagai pilihan saat membuat Barang.
- **Priority:** Must Have (M)

#### FR-BRG-02 — Kelola Kategori Barang (Edit & Nonaktifkan)

- **Requirement Name:** Edit dan Nonaktifkan Kategori Barang
- **Description:** Owner dapat mengubah nama kategori dan menonaktifkan kategori yang sudah tidak digunakan.
- **Actor:** Owner
- **Pre-condition:** Kategori telah dibuat sebelumnya.
- **Main Flow:**
  1. Owner membuka daftar Kategori Barang.
  2. Owner memilih kategori yang ingin diubah.
  3. Owner mengubah nama kategori dan menekan "Simpan", atau menekan "Nonaktifkan".
  4. Sistem memperbarui data kategori.
- **Alternative Flow:**
  - **A1 — Kategori Masih Memiliki Barang Aktif:** Sistem tetap mengizinkan nonaktifkan kategori namun menampilkan peringatan bahwa barang di dalamnya juga akan tidak dapat dijual, dan meminta konfirmasi Owner.
  - **A2 — Nama Baru Duplikat:** Sistem menolak dan menampilkan pesan error nama kategori sudah digunakan.
- **Post-condition:** Data kategori diperbarui sesuai perubahan Owner.
- **Acceptance Criteria:**
  1. Kategori yang dinonaktifkan tidak muncul sebagai pilihan saat menambah Barang baru.
  2. Barang yang sudah ada dalam kategori nonaktif tetap tersimpan namun mengikuti rule barang nonaktif.
- **Priority:** Should Have (S)

#### FR-BRG-03 — Tambah Barang

- **Requirement Name:** Tambah Barang Baru
- **Description:** Owner dapat menambahkan barang baru yang wajib berada di dalam sebuah kategori, dengan atribut Nama Barang, Foto Produk (opsional), Harga Modal, Harga Jual, dan Stok.
- **Actor:** Owner
- **Pre-condition:**
  1. Minimal terdapat satu kategori aktif dalam sistem.
- **Main Flow:**
  1. Owner membuka menu Data Barang.
  2. Owner menekan tombol "Tambah Barang".
  3. Owner memilih Kategori.
  4. Owner mengisi Nama Barang, Harga Modal, Harga Jual, dan Stok Awal.
  5. Owner mengunggah Foto Produk (opsional).
  6. Owner menekan tombol "Simpan".
  7. Sistem memvalidasi data (nama unik, harga jual ≥ harga modal, stok ≥ 0).
  8. Sistem menyimpan barang dan menghitung margin keuntungan per unit secara otomatis (Harga Jual − Harga Modal).
- **Alternative Flow:**
  - **A1 — Nama Barang Duplikat:** Sistem menolak dan menampilkan pesan error.
  - **A2 — Harga Jual < Harga Modal:** Sistem menolak dan menampilkan pesan "Harga jual tidak boleh lebih kecil dari harga modal".
  - **A3 — Tanpa Foto:** Sistem menggunakan foto placeholder default.
  - **A4 — Kategori Belum Ada:** Sistem menampilkan pesan "Silakan buat kategori terlebih dahulu" dan mengarahkan ke halaman Kategori.
- **Post-condition:** Barang baru tersimpan dan tersedia untuk dijual di modul Kasir.
- **Acceptance Criteria:**
  1. Barang tidak dapat dibuat tanpa memilih kategori.
  2. Sistem menolak penyimpanan jika harga jual lebih kecil dari harga modal.
  3. Barang tanpa foto otomatis menggunakan gambar placeholder.
  4. Keuntungan per unit dihitung otomatis dan tersimpan/ditampilkan konsisten dengan data harga saat itu.
- **Priority:** Must Have (M)

#### FR-BRG-04 — Edit Barang

- **Requirement Name:** Edit Data Barang
- **Description:** Owner dapat mengubah data barang (nama, kategori, harga modal, harga jual, foto). Perubahan harga tidak memengaruhi histori transaksi yang sudah terjadi.
- **Actor:** Owner
- **Pre-condition:** Barang sudah ada dalam sistem.
- **Main Flow:**
  1. Owner membuka Data Barang dan memilih barang yang ingin diubah.
  2. Owner mengubah field yang diperlukan.
  3. Owner menekan tombol "Simpan".
  4. Sistem memvalidasi ulang data (nama unik, harga jual ≥ harga modal).
  5. Sistem memperbarui data barang.
- **Alternative Flow:**
  - **A1 — Validasi Gagal:** Sistem menampilkan pesan error yang sesuai dan tidak menyimpan perubahan.
- **Post-condition:** Data barang diperbarui; histori transaksi sebelumnya tidak berubah.
- **Acceptance Criteria:**
  1. Perubahan harga barang tidak mengubah nilai harga pada transaksi yang sudah tercatat sebelumnya (sesuai Business Rule).
  2. Validasi harga jual ≥ harga modal tetap berlaku saat edit.
- **Priority:** Must Have (M)

#### FR-BRG-05 — Nonaktifkan Barang

- **Requirement Name:** Nonaktifkan/Aktifkan Kembali Barang
- **Description:** Owner dapat menonaktifkan barang yang tidak lagi dijual. Barang nonaktif tidak dapat dijual namun tetap tampil dalam daftar Data Barang.
- **Actor:** Owner
- **Pre-condition:** Barang sudah ada dalam sistem.
- **Main Flow:**
  1. Owner membuka Data Barang dan memilih barang.
  2. Owner menekan tombol "Nonaktifkan".
  3. Sistem mengubah status barang menjadi nonaktif.
- **Alternative Flow:**
  - **A1 — Aktifkan Kembali:** Owner dapat menekan tombol "Aktifkan" untuk mengembalikan status barang menjadi aktif.
- **Post-condition:** Barang berstatus nonaktif tidak dapat dimasukkan ke keranjang di modul Kasir.
- **Acceptance Criteria:**
  1. Barang nonaktif tetap muncul di daftar Data Barang namun diberi penanda visual (contoh: badge "Nonaktif").
  2. Barang nonaktif tidak muncul/tidak dapat dipilih pada pencarian barang di modul Kasir.
- **Priority:** Must Have (M)

#### FR-BRG-06 — Update Stok Manual

- **Requirement Name:** Penambahan/Penyesuaian Stok Manual
- **Description:** Owner dapat menambah atau menyesuaikan stok barang kapan saja, terlepas dari proses transaksi penjualan (contoh: restock dari supplier).
- **Actor:** Owner
- **Pre-condition:** Barang sudah terdaftar dalam sistem.
- **Main Flow:**
  1. Owner membuka detail Barang.
  2. Owner menekan aksi "Tambah Stok" atau "Sesuaikan Stok".
  3. Owner memasukkan jumlah stok yang ditambahkan/disesuaikan.
  4. Sistem memperbarui jumlah stok barang.
- **Alternative Flow:**
  - **A1 — Input Negatif Tidak Valid:** Sistem menolak input yang menyebabkan stok menjadi negatif melalui fitur ini (kecuali fitur penyesuaian eksplisit dengan alasan, jika tersedia).
- **Post-condition:** Stok barang diperbarui dan langsung terlihat di seluruh sistem (termasuk modul Kasir dan Dashboard).
- **Acceptance Criteria:**
  1. Penambahan stok tercermin secara real-time pada modul Kasir dan Dashboard.
  2. Sistem mencatat log perubahan stok manual untuk keperluan audit (opsional namun direkomendasikan).
- **Priority:** Must Have (M)

#### FR-BRG-07 — Lihat Data Barang (Read Only untuk Kasir)

- **Requirement Name:** Melihat Daftar dan Detail Barang
- **Description:** Kasir dapat melihat daftar barang beserta detail (nama, kategori, harga jual, stok, foto) namun tidak dapat mengubah data apa pun.
- **Actor:** Kasir, Owner
- **Pre-condition:** Pengguna telah login.
- **Main Flow:**
  1. Pengguna membuka menu Data Barang.
  2. Sistem menampilkan daftar barang beserta filter kategori dan pencarian nama.
  3. Pengguna dapat melihat detail masing-masing barang.
- **Alternative Flow:**
  - **A1 — Kasir Mencoba Mengakses Form Edit:** Sistem tidak menampilkan tombol Tambah/Edit/Nonaktifkan/Hapus untuk role Kasir; jika diakses langsung melalui URL, sistem menolak dengan pesan 403.
- **Post-condition:** Pengguna memperoleh informasi barang yang akurat dan terkini.
- **Acceptance Criteria:**
  1. Kasir tidak melihat tombol aksi Create/Update/Delete pada halaman Data Barang.
  2. Harga Modal dapat disembunyikan dari tampilan Kasir (opsional, sesuai kebijakan Owner) atau tetap ditampilkan sebagai info saja tanpa hak ubah — ditentukan pada tahap UI Design.
- **Priority:** Must Have (M)


---

### 10.4 MODUL KASIR (POS / TRANSAKSI PENJUALAN)

#### FR-KSR-01 — Pencarian Barang untuk Transaksi

- **Requirement Name:** Pencarian Barang Berbasis Nama
- **Description:** Kasir/Owner mencari barang yang akan dijual menggunakan fitur pencarian berbasis nama barang (tanpa barcode scanner).
- **Actor:** Owner, Kasir
- **Pre-condition:** Pengguna berada pada halaman Kasir.
- **Main Flow:**
  1. Pengguna mengetik nama barang (atau sebagian nama) pada kolom pencarian.
  2. Sistem menampilkan daftar barang yang cocok secara real-time (live search).
  3. Pengguna memilih barang dari hasil pencarian.
- **Alternative Flow:**
  - **A1 — Barang Tidak Ditemukan:** Sistem menampilkan pesan "Barang tidak ditemukan".
  - **A2 — Barang Nonaktif/Habis:** Barang nonaktif tidak muncul pada hasil pencarian; barang dengan stok habis tetap muncul namun ditandai "Stok Habis" dan tidak dapat ditambahkan ke keranjang.
- **Post-condition:** Barang yang dipilih siap ditambahkan ke keranjang.
- **Acceptance Criteria:**
  1. Pencarian bersifat case-insensitive dan mendukung pencarian sebagian kata (partial match).
  2. Hasil pencarian hanya menampilkan barang berstatus aktif.
  3. Barang dengan stok 0 tetap muncul pada pencarian namun tidak dapat ditambahkan ke keranjang.
- **Priority:** Must Have (M)

#### FR-KSR-02 — Tambah Barang ke Keranjang

- **Requirement Name:** Menambahkan Barang ke Keranjang Belanja
- **Description:** Barang yang dipilih dari hasil pencarian dimasukkan ke dalam keranjang transaksi, dengan jumlah default 1.
- **Actor:** Owner, Kasir
- **Pre-condition:** Barang tersedia (stok > 0) dan berstatus aktif.
- **Main Flow:**
  1. Pengguna memilih barang dari hasil pencarian.
  2. Sistem menambahkan barang ke dalam keranjang dengan jumlah 1.
  3. Sistem menampilkan subtotal keranjang secara otomatis (harga jual × jumlah, dijumlahkan seluruh item).
- **Alternative Flow:**
  - **A1 — Barang Sudah Ada di Keranjang:** Sistem menambahkan jumlah (+1) pada baris barang yang sama, bukan membuat baris duplikat.
  - **A2 — Stok Tidak Mencukupi:** Jika jumlah yang diminta melebihi stok tersedia, sistem menampilkan peringatan dan membatasi jumlah maksimum sesuai stok.
- **Post-condition:** Keranjang berisi barang beserta jumlah dan subtotal terkini. Stok barang **belum berkurang** pada tahap ini.
- **Acceptance Criteria:**
  1. Stok barang tidak berkurang saat barang dimasukkan ke keranjang (hanya berkurang setelah checkout berhasil).
  2. Subtotal keranjang diperbarui secara real-time setiap ada perubahan.
- **Priority:** Must Have (M)

#### FR-KSR-03 — Ubah Jumlah Barang dalam Keranjang

- **Requirement Name:** Menambah/Mengurangi Jumlah Barang di Keranjang
- **Description:** Pengguna dapat mengubah jumlah barang dalam keranjang menggunakan tombol tambah (+) dan kurang (-), atau menghapus barang dari keranjang.
- **Actor:** Owner, Kasir
- **Pre-condition:** Barang sudah berada dalam keranjang.
- **Main Flow:**
  1. Pengguna menekan tombol "+" untuk menambah jumlah, atau "-" untuk mengurangi.
  2. Sistem memvalidasi jumlah terhadap stok tersedia.
  3. Sistem memperbarui jumlah dan subtotal keranjang.
- **Alternative Flow:**
  - **A1 — Jumlah Mencapai 0:** Jika jumlah dikurangi hingga 0, sistem menghapus barang tersebut dari keranjang (dengan/atau tanpa konfirmasi, ditentukan pada UI Design).
  - **A2 — Melebihi Stok:** Sistem menolak penambahan lebih lanjut dan menampilkan pesan "Stok tidak mencukupi".
- **Post-condition:** Keranjang mencerminkan jumlah barang terbaru sesuai input pengguna.
- **Acceptance Criteria:**
  1. Tombol "+" tidak dapat menambah melebihi stok tersedia barang tersebut.
  2. Tombol "-" tidak dapat mengurangi jumlah menjadi negatif.
  3. Keranjang dapat diubah bebas sebelum checkout tanpa efek terhadap data stok aktual.
- **Priority:** Must Have (M)

#### FR-KSR-04 — Checkout Transaksi

- **Requirement Name:** Proses Checkout / Penyelesaian Transaksi
- **Description:** Pengguna menyelesaikan transaksi penjualan dengan memilih metode pembayaran: Cash, QRIS (statis), Hutang, atau kombinasi Cash + Hutang.
- **Actor:** Owner, Kasir
- **Pre-condition:**
  1. Keranjang berisi minimal satu barang.
  2. Seluruh barang dalam keranjang memiliki stok mencukupi pada saat checkout.
- **Main Flow:**
  1. Pengguna menekan tombol "Checkout" dari halaman keranjang.
  2. Sistem menampilkan ringkasan total transaksi.
  3. Pengguna memilih metode pembayaran:
     - **Cash** — pengguna memasukkan jumlah uang tunai diterima, sistem menghitung kembalian.
     - **QRIS** — sistem menampilkan gambar QRIS statis toko; kasir menunggu konfirmasi pembayaran berhasil dari pelanggan secara manual, lalu menekan "Konfirmasi Pembayaran Diterima".
     - **Hutang** — pengguna memilih/menambahkan data pelanggan, seluruh nominal transaksi tercatat sebagai hutang.
     - **Cash + Hutang** — pengguna memasukkan nominal cash yang dibayarkan, sisanya otomatis tercatat sebagai hutang atas nama pelanggan yang dipilih.
  4. Pengguna menekan tombol "Selesaikan Transaksi".
  5. Sistem memvalidasi ulang ketersediaan stok seluruh item pada keranjang.
  6. Sistem mengurangi stok barang sesuai jumlah pada transaksi.
  7. Sistem menyimpan data transaksi beserta detail item dan metode pembayaran.
  8. Sistem menghitung keuntungan transaksi (berdasarkan harga modal dan harga jual saat transaksi terjadi).
  9. Jika metode pembayaran melibatkan Hutang, sistem otomatis membuat/menambahkan catatan hutang pada modul Hutang Pelanggan.
  10. Sistem mengosongkan keranjang dan menampilkan struk/ringkasan transaksi berhasil.
- **Alternative Flow:**
  - **A1 — Metode Hutang Tanpa Pelanggan Terdaftar:** Sistem mewajibkan pengguna untuk memilih pelanggan yang sudah ada atau menambahkan pelanggan baru sebelum transaksi dengan skema Hutang dapat diselesaikan.
  - **A2 — Stok Berubah Sebelum Checkout Selesai (Race Condition):** Jika stok barang berkurang (misalnya oleh transaksi lain) sebelum checkout final disimpan, sistem menampilkan pesan "Stok tidak mencukupi untuk [Nama Barang]" dan membatalkan proses checkout tanpa mengurangi stok maupun menyimpan transaksi.
  - **A3 — Nominal Cash Kurang dari Total (tanpa memilih Hutang):** Sistem menampilkan validasi bahwa nominal cash tidak mencukupi dan meminta pengguna memilih skema Cash + Hutang atau menambah nominal.
  - **A4 — Pembatalan Checkout:** Pengguna dapat membatalkan proses checkout sebelum menekan "Selesaikan Transaksi"; keranjang tetap tersimpan/tidak hilang.
- **Post-condition:**
  1. Stok barang berkurang sesuai jumlah terjual.
  2. Transaksi tersimpan secara permanen.
  3. Keuntungan transaksi terhitung dan tersimpan.
  4. Keranjang kembali kosong.
  5. Hutang baru tercatat (jika berlaku).
- **Acceptance Criteria:**
  1. Stok hanya berkurang setelah checkout berhasil disimpan, bukan saat barang dimasukkan ke keranjang.
  2. Transaksi dengan metode Hutang atau Cash+Hutang otomatis membuat entri hutang pada modul Hutang Pelanggan.
  3. Keuntungan dihitung berdasarkan selisih harga jual dan harga modal **pada saat transaksi terjadi**, bukan harga barang saat ini (jika sudah berubah).
  4. Sistem tidak dapat menyelesaikan transaksi jika ada barang dalam keranjang yang stoknya sudah tidak mencukupi pada saat checkout final.
  5. Struk/ringkasan transaksi menampilkan rincian barang, jumlah, subtotal, metode pembayaran, dan total.
- **Priority:** Must Have (M)

#### FR-KSR-05 — Pembayaran QRIS Statis

- **Requirement Name:** Pembayaran via QRIS Statis
- **Description:** Sistem menampilkan gambar QRIS statis milik toko (diunggah Owner pada modul Pengaturan) sebagai metode pembayaran non-tunai. Verifikasi keberhasilan pembayaran dilakukan secara manual oleh kasir.
- **Actor:** Owner, Kasir
- **Pre-condition:** Owner telah mengunggah gambar QRIS pada modul Pengaturan.
- **Main Flow:**
  1. Pengguna memilih metode pembayaran QRIS pada layar checkout.
  2. Sistem menampilkan gambar QRIS statis toko beserta total tagihan.
  3. Pelanggan memindai dan membayar menggunakan aplikasi pembayaran masing-masing.
  4. Pelanggan menunjukkan bukti pembayaran berhasil kepada kasir.
  5. Kasir menekan tombol "Konfirmasi Pembayaran Diterima".
  6. Sistem melanjutkan proses penyelesaian transaksi (lihat FR-KSR-04).
- **Alternative Flow:**
  - **A1 — QRIS Belum Diatur:** Jika Owner belum mengunggah QRIS, opsi metode pembayaran QRIS tidak ditampilkan/dinonaktifkan pada layar checkout.
  - **A2 — Pelanggan Batal Membayar:** Kasir dapat membatalkan pemilihan QRIS dan kembali ke pemilihan metode pembayaran tanpa kehilangan data keranjang.
- **Post-condition:** Transaksi tercatat sebagai dibayar melalui QRIS berdasarkan konfirmasi manual kasir.
- **Acceptance Criteria:**
  1. Sistem tidak melakukan verifikasi otomatis pembayaran QRIS (bukan integrasi payment gateway).
  2. Transaksi baru dianggap selesai setelah kasir secara eksplisit menekan tombol konfirmasi.
- **Priority:** Must Have (M)

#### FR-KSR-06 — Cetak/Tampilkan Struk Transaksi

- **Requirement Name:** Struk Transaksi
- **Description:** Setelah transaksi berhasil, sistem menampilkan ringkasan struk transaksi yang dapat dilihat/dicetak/dibagikan.
- **Actor:** Owner, Kasir
- **Pre-condition:** Transaksi telah berhasil diselesaikan.
- **Main Flow:**
  1. Sistem menampilkan halaman/modal struk berisi detail transaksi.
  2. Pengguna dapat menekan tombol "Cetak" (jika printer tersedia) atau menutup struk untuk kembali ke halaman Kasir.
- **Alternative Flow:**
  - **A1 — Tidak Ada Printer:** Struk tetap ditampilkan pada layar sebagai representasi digital, cetak fisik bersifat opsional (tidak wajib pada versi awal, dapat masuk Future Scope untuk cetak thermal).
- **Post-condition:** Pengguna memperoleh bukti transaksi.
- **Acceptance Criteria:**
  1. Struk menampilkan nama toko, tanggal/waktu transaksi, daftar barang, jumlah, harga, total, metode pembayaran, dan kembalian (jika cash).
- **Priority:** Should Have (S)

---

### 10.5 MODUL HUTANG PELANGGAN

#### FR-HTG-01 — Tambah Data Pelanggan

- **Requirement Name:** Tambah Pelanggan Baru
- **Description:** Owner/Kasir dapat menambahkan data pelanggan baru untuk keperluan pencatatan hutang.
- **Actor:** Owner, Kasir
- **Pre-condition:** Pengguna telah login.
- **Main Flow:**
  1. Pengguna membuka menu Hutang Pelanggan.
  2. Pengguna menekan tombol "Tambah Pelanggan".
  3. Pengguna mengisi Nama Pelanggan dan No. Telepon (opsional, sesuai kebutuhan).
  4. Pengguna menekan "Simpan".
  5. Sistem menyimpan data pelanggan baru.
- **Alternative Flow:**
  - **A1 — Nama Kosong:** Sistem menampilkan validasi nama pelanggan wajib diisi.
- **Post-condition:** Pelanggan baru tersedia untuk dipilih pada transaksi Hutang.
- **Acceptance Criteria:**
  1. Data pelanggan yang baru ditambahkan langsung tersedia sebagai pilihan pada checkout metode Hutang.
- **Priority:** Must Have (M)

#### FR-HTG-02 — Lihat Daftar Pelanggan dan Hutang

- **Requirement Name:** Daftar Pelanggan dan Status Hutang
- **Description:** Pengguna dapat melihat daftar seluruh pelanggan beserta status hutang (lunas/belum lunas) dan total nominal hutang aktif.
- **Actor:** Owner, Kasir
- **Pre-condition:** Terdapat minimal satu data pelanggan.
- **Main Flow:**
  1. Pengguna membuka menu Hutang Pelanggan.
  2. Sistem menampilkan daftar pelanggan beserta total hutang aktif masing-masing.
  3. Pengguna dapat mencari pelanggan berdasarkan nama.
- **Alternative Flow:**
  - **A1 — Tidak Ada Hutang Aktif:** Pelanggan dengan hutang lunas ditampilkan dengan status "Lunas"/nominal Rp 0.
- **Post-condition:** Pengguna memperoleh gambaran menyeluruh status hutang seluruh pelanggan.
- **Acceptance Criteria:**
  1. Daftar dapat difilter/dicari berdasarkan nama pelanggan.
  2. Total hutang aktif dihitung secara real-time dari akumulasi transaksi hutang dikurangi pembayaran yang sudah dilakukan.
- **Priority:** Must Have (M)

#### FR-HTG-03 — Lihat Detail dan Histori Hutang Pelanggan

- **Requirement Name:** Detail dan Histori Hutang per Pelanggan
- **Description:** Pengguna dapat melihat rincian histori hutang seorang pelanggan, termasuk asal transaksi dan histori pembayaran yang pernah dilakukan.
- **Actor:** Owner, Kasir
- **Pre-condition:** Pelanggan memiliki minimal satu transaksi hutang.
- **Main Flow:**
  1. Pengguna memilih pelanggan dari daftar.
  2. Sistem menampilkan detail: daftar transaksi yang menghasilkan hutang, nominal masing-masing, tanggal, serta histori pembayaran cicilan/lunas.
- **Alternative Flow:**
  - **A1 — Belum Ada Histori:** Sistem menampilkan pesan "Belum ada histori hutang untuk pelanggan ini".
- **Post-condition:** Pengguna memahami riwayat lengkap hutang pelanggan tersebut.
- **Acceptance Criteria:**
  1. Histori hutang **tidak dapat dihapus** oleh pengguna manapun (sesuai Business Rule), termasuk oleh Owner.
  2. Data histori pelanggan tetap tersimpan meskipun seluruh hutang telah lunas.
- **Priority:** Must Have (M)

#### FR-HTG-04 — Terima Pembayaran Hutang

- **Requirement Name:** Pembayaran Cicilan/Lunas Hutang
- **Description:** Pengguna dapat mencatat pembayaran hutang dari pelanggan, baik pembayaran sebagian (cicilan) maupun pelunasan penuh.
- **Actor:** Owner, Kasir
- **Pre-condition:** Pelanggan memiliki hutang aktif (outstanding > 0).
- **Main Flow:**
  1. Pengguna membuka detail hutang pelanggan.
  2. Pengguna menekan tombol "Terima Pembayaran".
  3. Pengguna memasukkan nominal pembayaran.
  4. Sistem memvalidasi nominal (tidak melebihi total hutang outstanding).
  5. Sistem mengurangi nominal hutang outstanding sesuai jumlah yang dibayarkan.
  6. Sistem mencatat histori pembayaran (tanggal, nominal, kasir/owner yang mencatat).
- **Alternative Flow:**
  - **A1 — Nominal Melebihi Hutang Outstanding:** Sistem menolak dan menampilkan pesan "Nominal pembayaran melebihi total hutang".
  - **A2 — Pembayaran Sebagian:** Status hutang tetap "Belum Lunas" dengan sisa outstanding yang diperbarui.
  - **A3 — Pembayaran Penuh:** Status hutang berubah menjadi "Lunas".
- **Post-condition:** Saldo hutang pelanggan diperbarui; histori pembayaran tersimpan permanen.
- **Acceptance Criteria:**
  1. Pembayaran sebagian diperbolehkan dan mengurangi outstanding sesuai nominal yang dibayarkan.
  2. Histori pembayaran tidak dapat dihapus atau diedit setelah tersimpan (audit-safe).
  3. Status "Lunas" otomatis diterapkan ketika outstanding mencapai Rp 0.
- **Priority:** Must Have (M)


---

### 10.6 MODUL LAPORAN

#### FR-LAP-01 — Laporan Penjualan (Harian/Mingguan/Bulanan/Tahunan)

- **Requirement Name:** Laporan Penjualan Berdasarkan Periode
- **Description:** Owner dapat melihat laporan penjualan dengan filter periode Harian, Mingguan, Bulanan, dan Tahunan, mencakup Total Penjualan, Total Keuntungan, Jumlah Transaksi, dan Barang Terjual.
- **Actor:** Owner
- **Pre-condition:** Terdapat minimal satu transaksi tersimpan dalam sistem.
- **Main Flow:**
  1. Owner membuka menu Laporan.
  2. Owner memilih jenis periode (Harian/Mingguan/Bulanan/Tahunan) atau rentang tanggal kustom.
  3. Sistem menghitung dan menampilkan Total Penjualan, Total Keuntungan, Jumlah Transaksi, dan Total Barang Terjual pada periode tersebut.
  4. Sistem menampilkan grafik tren penjualan pada periode yang dipilih.
- **Alternative Flow:**
  - **A1 — Tidak Ada Transaksi pada Periode:** Sistem menampilkan nilai 0 dan pesan "Tidak ada data transaksi pada periode ini".
  - **A2 — Rentang Tanggal Kustom Tidak Valid:** Sistem menampilkan validasi jika tanggal awal lebih besar dari tanggal akhir.
- **Post-condition:** Owner memperoleh data agregat penjualan sesuai periode yang dipilih.
- **Acceptance Criteria:**
  1. Filter periode Harian, Mingguan, Bulanan, dan Tahunan tersedia serta dapat dikombinasikan dengan filter tanggal kustom.
  2. Total Keuntungan dihitung berdasarkan margin (harga jual − harga modal) **pada saat transaksi terjadi**, bukan harga barang saat ini.
  3. Data laporan dapat diakses hanya oleh role Owner.
- **Priority:** Must Have (M)

#### FR-LAP-02 — Barang Terlaris dan Barang Paling Menguntungkan

- **Requirement Name:** Ranking Barang Terlaris & Paling Menguntungkan
- **Description:** Sistem menampilkan daftar Top Barang Terlaris (berdasarkan jumlah unit terjual) dan Barang Paling Menguntungkan (berdasarkan total keuntungan yang dihasilkan) pada periode laporan yang dipilih.
- **Actor:** Owner
- **Pre-condition:** Terdapat data transaksi pada periode yang dipilih.
- **Main Flow:**
  1. Owner memilih periode laporan.
  2. Sistem menghitung total unit terjual per barang serta total keuntungan per barang.
  3. Sistem menampilkan daftar Top Barang Terlaris (contoh: top 10) dan Top Barang Paling Menguntungkan.
- **Alternative Flow:**
  - **A1 — Data Kosong:** Sistem menampilkan pesan "Belum ada data untuk periode ini".
- **Post-condition:** Owner mendapatkan insight barang mana yang perlu di-restock dan mana yang paling menguntungkan.
- **Acceptance Criteria:**
  1. Ranking barang terlaris diurutkan berdasarkan jumlah unit terjual (descending).
  2. Ranking barang paling menguntungkan diurutkan berdasarkan total keuntungan (descending).
- **Priority:** Should Have (S)

#### FR-LAP-03 — Filter Laporan Berdasarkan Tanggal

- **Requirement Name:** Filter Tanggal Kustom pada Laporan
- **Description:** Owner dapat memilih rentang tanggal spesifik untuk melihat laporan di luar preset Harian/Mingguan/Bulanan/Tahunan.
- **Actor:** Owner
- **Pre-condition:** Owner berada pada halaman Laporan.
- **Main Flow:**
  1. Owner memilih opsi "Rentang Kustom".
  2. Owner memasukkan Tanggal Mulai dan Tanggal Akhir.
  3. Owner menekan tombol "Terapkan Filter".
  4. Sistem menampilkan data laporan sesuai rentang yang dipilih.
- **Alternative Flow:**
  - **A1 — Tanggal Tidak Valid:** Sistem menampilkan pesan error jika Tanggal Mulai > Tanggal Akhir.
- **Post-condition:** Laporan menampilkan data sesuai rentang tanggal yang dipilih Owner.
- **Acceptance Criteria:**
  1. Rentang tanggal kustom dapat dikombinasikan dengan seluruh komponen laporan (total penjualan, keuntungan, grafik, ranking barang).
- **Priority:** Should Have (S)

#### FR-LAP-04 — Grafik Penjualan pada Laporan

- **Requirement Name:** Visualisasi Grafik Tren Penjualan
- **Description:** Sistem menampilkan grafik (line chart/bar chart) yang merepresentasikan tren penjualan sesuai periode laporan yang dipilih.
- **Actor:** Owner
- **Pre-condition:** Terdapat data transaksi pada periode yang dipilih.
- **Main Flow:**
  1. Owner memilih periode laporan.
  2. Sistem mengagregasi data penjualan per satuan waktu (per hari untuk laporan harian/mingguan, per minggu/bulan untuk laporan bulanan/tahunan).
  3. Sistem menampilkan grafik.
- **Alternative Flow:**
  - **A1 — Data Tidak Cukup untuk Grafik:** Sistem menampilkan grafik kosong dengan pesan informatif.
- **Post-condition:** Owner dapat memahami tren penjualan secara visual.
- **Acceptance Criteria:**
  1. Grafik memperbarui data sesuai filter periode/tanggal yang dipilih.
- **Priority:** Should Have (S)

---

### 10.7 MODUL KELOLA KASIR

#### FR-KKS-01 — Tambah Akun Kasir

- **Requirement Name:** Tambah Akun Kasir Baru
- **Description:** Owner dapat menambahkan akun Kasir baru dengan mengisi username, password awal, dan data profil dasar.
- **Actor:** Owner
- **Pre-condition:** Owner telah login.
- **Main Flow:**
  1. Owner membuka menu Kelola Kasir.
  2. Owner menekan tombol "Tambah Kasir".
  3. Owner mengisi Nama, Username, dan Password.
  4. Owner menekan "Simpan".
  5. Sistem memvalidasi keunikan username.
  6. Sistem membuat akun Kasir baru dengan role "Kasir" dan status aktif.
- **Alternative Flow:**
  - **A1 — Username Sudah Digunakan:** Sistem menolak dan menampilkan pesan error "Username sudah digunakan".
  - **A2 — Field Wajib Kosong:** Sistem menampilkan validasi field wajib diisi.
- **Post-condition:** Akun Kasir baru dapat digunakan untuk login.
- **Acceptance Criteria:**
  1. Username bersifat unik di seluruh sistem (lintas role Owner maupun Kasir).
  2. Akun baru langsung berstatus aktif dan dapat login setelah dibuat.
- **Priority:** Must Have (M)

#### FR-KKS-02 — Edit Data Kasir

- **Requirement Name:** Edit Data Akun Kasir
- **Description:** Owner dapat mengubah data akun Kasir seperti nama dan username.
- **Actor:** Owner
- **Pre-condition:** Akun Kasir sudah terdaftar.
- **Main Flow:**
  1. Owner membuka daftar Kelola Kasir.
  2. Owner memilih akun Kasir yang ingin diubah.
  3. Owner mengubah data yang diperlukan dan menekan "Simpan".
  4. Sistem memvalidasi dan memperbarui data.
- **Alternative Flow:**
  - **A1 — Username Baru Duplikat:** Sistem menolak dan menampilkan pesan error.
- **Post-condition:** Data akun Kasir diperbarui.
- **Acceptance Criteria:**
  1. Perubahan username tidak memengaruhi histori transaksi yang sudah tercatat atas nama akun tersebut (tetap tertaut melalui ID internal, bukan username).
- **Priority:** Must Have (M)

#### FR-KKS-03 — Nonaktifkan Akun Kasir

- **Requirement Name:** Nonaktifkan Akun Kasir
- **Description:** Owner dapat menonaktifkan akun Kasir agar tidak dapat login kembali, tanpa menghapus data historis terkait akun tersebut.
- **Actor:** Owner
- **Pre-condition:** Akun Kasir berstatus aktif.
- **Main Flow:**
  1. Owner membuka daftar Kelola Kasir.
  2. Owner memilih akun Kasir yang ingin dinonaktifkan.
  3. Owner menekan tombol "Nonaktifkan".
  4. Sistem meminta konfirmasi.
  5. Sistem mengubah status akun menjadi nonaktif.
- **Alternative Flow:**
  - **A1 — Aktifkan Kembali:** Owner dapat mengaktifkan kembali akun Kasir yang sebelumnya dinonaktifkan.
  - **A2 — Kasir Sedang Login Saat Dinonaktifkan:** Sesi aktif Kasir tersebut akan ditolak pada request berikutnya (dipaksa logout pada akses selanjutnya).
- **Post-condition:** Akun Kasir tidak dapat digunakan untuk login sampai diaktifkan kembali.
- **Acceptance Criteria:**
  1. Akun nonaktif tidak dapat login walaupun password benar.
  2. Histori transaksi yang pernah dilakukan akun tersebut tetap tersimpan dan tidak terpengaruh.
- **Priority:** Must Have (M)

#### FR-KKS-04 — Reset Password Kasir

- **Requirement Name:** Reset Password Akun Kasir oleh Owner
- **Description:** Owner dapat mereset password akun Kasir tanpa perlu mengetahui password lama, untuk kondisi Kasir lupa password.
- **Actor:** Owner
- **Pre-condition:** Akun Kasir terdaftar dalam sistem.
- **Main Flow:**
  1. Owner membuka detail akun Kasir.
  2. Owner menekan tombol "Reset Password".
  3. Owner memasukkan password baru (atau sistem membuat password sementara secara otomatis).
  4. Sistem menyimpan password baru terenkripsi.
- **Alternative Flow:**
  - **A1 — Password Baru Tidak Memenuhi Kriteria:** Sistem menampilkan validasi kriteria minimal password (lihat Validation Rules).
- **Post-condition:** Kasir dapat login menggunakan password baru.
- **Acceptance Criteria:**
  1. Password baru langsung aktif dan menggantikan password lama sepenuhnya.
  2. Password disimpan dalam bentuk hash (bukan plain text) sesuai Security Requirements.
- **Priority:** Must Have (M)

#### FR-KKS-05 — Kasir Mengubah Profil Sendiri

- **Requirement Name:** Ubah Username, Password, dan Foto Profil oleh Kasir
- **Description:** Kasir dapat mengubah data profil miliknya sendiri, meliputi Username, Password, dan Foto Profil.
- **Actor:** Kasir
- **Pre-condition:** Kasir telah login.
- **Main Flow:**
  1. Kasir membuka menu Profil Saya.
  2. Kasir mengubah Username, Password, dan/atau Foto Profil.
  3. Kasir menekan "Simpan".
  4. Sistem memvalidasi (keunikan username, kriteria password, format/ukuran foto).
  5. Sistem memperbarui data profil.
- **Alternative Flow:**
  - **A1 — Username Baru Duplikat:** Sistem menolak dan menampilkan pesan error.
  - **A2 — Password Lama Tidak Sesuai (jika diminta konfirmasi password lama):** Sistem menolak perubahan password.
- **Post-condition:** Profil Kasir diperbarui sesuai perubahan.
- **Acceptance Criteria:**
  1. Kasir hanya dapat mengubah profil miliknya sendiri, tidak dapat mengubah profil Kasir lain.
  2. Kasir tidak dapat mengubah role miliknya sendiri menjadi Owner.
- **Priority:** Must Have (M)

---

### 10.8 MODUL PENGATURAN

#### FR-SET-01 — Ubah Profil Toko

- **Requirement Name:** Pengaturan Nama Toko, Alamat, dan Logo
- **Description:** Owner dapat mengubah data identitas toko yang akan ditampilkan pada struk transaksi dan dashboard.
- **Actor:** Owner
- **Pre-condition:** Owner telah login.
- **Main Flow:**
  1. Owner membuka menu Pengaturan → Profil Toko.
  2. Owner mengubah Nama Toko, Alamat Toko, dan/atau mengunggah Logo baru.
  3. Owner menekan "Simpan".
  4. Sistem memvalidasi data dan menyimpan perubahan.
- **Alternative Flow:**
  - **A1 — Format Logo Tidak Didukung:** Sistem menolak dan menampilkan pesan format file yang didukung (contoh: JPG, PNG).
  - **A2 — Field Nama Toko Kosong:** Sistem menampilkan validasi nama toko wajib diisi.
- **Post-condition:** Data toko diperbarui dan tercermin pada struk serta tampilan aplikasi.
- **Acceptance Criteria:**
  1. Perubahan nama toko/logo langsung tercermin pada struk transaksi berikutnya.
  2. Ukuran file logo dibatasi sesuai ketentuan teknis (contoh: maksimal 2MB).
- **Priority:** Must Have (M)

#### FR-SET-02 — Kelola QRIS Statis

- **Requirement Name:** Unggah dan Kelola Gambar QRIS Toko
- **Description:** Owner dapat mengunggah, mengganti, atau menghapus gambar QRIS statis yang digunakan pada proses checkout metode QRIS.
- **Actor:** Owner
- **Pre-condition:** Owner telah login.
- **Main Flow:**
  1. Owner membuka menu Pengaturan → QRIS.
  2. Owner mengunggah gambar QRIS.
  3. Owner menekan "Simpan".
  4. Sistem menyimpan gambar QRIS dan mengaktifkan opsi pembayaran QRIS pada modul Kasir.
- **Alternative Flow:**
  - **A1 — Format Tidak Didukung:** Sistem menolak file yang bukan gambar (JPG/PNG).
  - **A2 — Owner Menghapus QRIS:** Opsi metode pembayaran QRIS otomatis disembunyikan/dinonaktifkan pada modul Kasir hingga QRIS baru diunggah.
- **Post-condition:** Gambar QRIS tersedia untuk digunakan pada transaksi.
- **Acceptance Criteria:**
  1. QRIS yang diunggah langsung tersedia sebagai metode pembayaran pada checkout tanpa perlu restart sistem.
- **Priority:** Must Have (M)

#### FR-SET-03 — Ubah Profil Owner

- **Requirement Name:** Pengaturan Profil Akun Owner
- **Description:** Owner dapat mengubah data profil pribadinya, termasuk nama, username, password, dan foto profil.
- **Actor:** Owner
- **Pre-condition:** Owner telah login.
- **Main Flow:**
  1. Owner membuka menu Pengaturan → Profil Owner.
  2. Owner mengubah data yang diinginkan.
  3. Owner menekan "Simpan".
  4. Sistem memvalidasi dan menyimpan perubahan.
- **Alternative Flow:**
  - **A1 — Username Duplikat:** Sistem menolak dan menampilkan pesan error.
- **Post-condition:** Profil Owner diperbarui.
- **Acceptance Criteria:**
  1. Perubahan password Owner mengharuskan konfirmasi password baru (re-type) untuk menghindari kesalahan input.
- **Priority:** Must Have (M)


---

## 11. NON FUNCTIONAL REQUIREMENTS

| ID | Kategori | Deskripsi |
|---|---|---|
| NFR-01 | Performance | Waktu respons pencarian barang pada modul Kasir tidak lebih dari 1 detik untuk katalog hingga 5.000 item barang. |
| NFR-02 | Performance | Proses checkout (dari klik "Selesaikan Transaksi" hingga konfirmasi berhasil) tidak lebih dari 2 detik dalam kondisi jaringan normal. |
| NFR-03 | Scalability | Sistem dirancang untuk single-store (satu toko), namun struktur database harus memungkinkan pengembangan ke multi-store di masa depan tanpa migrasi besar (lihat Future Scope). |
| NFR-04 | Usability | Antarmuka harus mudah digunakan oleh pengguna non-teknis (Owner/Kasir warung kelontong) tanpa memerlukan pelatihan formal lebih dari 15 menit. |
| NFR-05 | Usability | Aplikasi harus dapat dioperasikan sepenuhnya menggunakan mouse/keyboard pada desktop, dan sentuhan (touch) pada perangkat tablet/mobile. |
| NFR-06 | Compatibility | Aplikasi harus berjalan dengan baik pada browser modern: Google Chrome, Mozilla Firefox, Microsoft Edge (2 versi rilis terakhir). |
| NFR-07 | Responsiveness | Tampilan aplikasi bersifat desktop-first namun tetap responsif pada resolusi layar tablet (≥768px) dan mobile (≥360px), khususnya pada modul Kasir. |
| NFR-08 | Availability | Target ketersediaan sistem (uptime) minimal 99% untuk penggunaan dalam jam operasional toko. |
| NFR-09 | Maintainability | Kode aplikasi mengikuti standar Laravel best practices (PSR-12, struktur MVC/Repository, penggunaan Filament Resource) agar mudah dipelihara oleh tim developer baru. |
| NFR-10 | Data Integrity | Seluruh transaksi keuangan (penjualan, hutang, pembayaran) harus dieksekusi dalam database transaction (atomic) untuk menghindari data tidak konsisten (contoh: stok berkurang tapi transaksi gagal tersimpan). |
| NFR-11 | Backup & Recovery | Sistem harus mendukung mekanisme backup database berkala (harian) untuk mencegah kehilangan data transaksi dan hutang. |
| NFR-12 | Localization | Seluruh antarmuka, pesan sistem, dan label menggunakan Bahasa Indonesia. Format mata uang menggunakan format Rupiah (Rp) dengan pemisah ribuan titik (contoh: Rp 15.000). |
| NFR-13 | Auditability | Perubahan data sensitif (harga barang, stok manual, status akun) sebaiknya tercatat log (audit trail) minimal berupa timestamp dan aktor yang melakukan perubahan. |
| NFR-14 | Portability | Aplikasi dapat di-deploy pada hosting/VPS dengan spesifikasi umum yang mendukung PHP 8.2+ dan MySQL 8.0+. |

---

## 12. SECURITY REQUIREMENTS

| ID | Kebutuhan Keamanan | Deskripsi |
|---|---|---|
| SEC-01 | Password Hashing | Seluruh password pengguna disimpan menggunakan algoritma hashing standar industri (contoh: bcrypt/argon2), tidak pernah disimpan dalam bentuk plain text. |
| SEC-02 | Role-Based Access Control | Setiap endpoint/aksi backend wajib memvalidasi role pengguna, tidak hanya menyembunyikan tombol pada tampilan frontend (defense in depth). |
| SEC-03 | Session Management | Sesi login menggunakan mekanisme session yang aman (secure, httpOnly cookies) sesuai standar framework Laravel. |
| SEC-04 | Input Validation & Sanitization | Seluruh input pengguna (form Barang, Kategori, Pelanggan, dsb.) divalidasi dan disanitasi untuk mencegah SQL Injection dan Cross-Site Scripting (XSS). |
| SEC-05 | CSRF Protection | Seluruh form wajib dilindungi CSRF token sesuai default keamanan Laravel. |
| SEC-06 | File Upload Validation | Upload foto produk, logo toko, dan gambar QRIS divalidasi berdasarkan tipe MIME dan ukuran file maksimum untuk mencegah upload file berbahaya. |
| SEC-07 | Rate Limiting Login | Percobaan login yang gagal berulang kali (contoh: >5 kali dalam 1 menit) dibatasi sementara (throttle) untuk mencegah brute-force attack. |
| SEC-08 | Data Privacy Pelanggan | Data pelanggan (nama, nomor telepon) hanya dapat diakses oleh pengguna internal (Owner/Kasir) yang telah login, tidak dapat diakses publik. |
| SEC-09 | Audit Trail Perubahan Kritis | Perubahan harga barang, penonaktifan akun, dan penghapusan/nonaktif kategori dicatat dengan informasi aktor dan waktu perubahan. |
| SEC-10 | Protection of Historical Data | Data histori transaksi dan histori hutang bersifat immutable (tidak dapat diedit/dihapus) untuk menjaga integritas audit keuangan. |
| SEC-11 | HTTPS Enforcement | Aplikasi wajib diakses melalui koneksi HTTPS pada environment produksi. |

---

## 13. VALIDATION RULES

### 13.1 Validasi Autentikasi & Akun

| Field | Aturan Validasi |
|---|---|
| Username | Wajib diisi; unik di seluruh sistem (lintas Owner & Kasir); minimal 4 karakter; hanya huruf, angka, underscore (tanpa spasi). |
| Password | Wajib diisi; minimal 8 karakter; kombinasi huruf dan angka direkomendasikan. |
| Foto Profil | Format JPG/PNG; ukuran maksimum 2MB. |

### 13.2 Validasi Kategori Barang

| Field | Aturan Validasi |
|---|---|
| Nama Kategori | Wajib diisi; unik (case-insensitive); maksimum 100 karakter. |

### 13.3 Validasi Data Barang

| Field | Aturan Validasi |
|---|---|
| Nama Barang | Wajib diisi; unik (case-insensitive); maksimum 150 karakter. |
| Kategori | Wajib dipilih; harus kategori yang berstatus aktif. |
| Harga Modal | Wajib diisi; numerik; minimal Rp 0. |
| Harga Jual | Wajib diisi; numerik; **harus ≥ Harga Modal**. |
| Stok | Wajib diisi; numerik bulat; minimal 0 (tidak boleh negatif). |
| Foto Produk | Opsional; jika tidak diisi menggunakan placeholder default; format JPG/PNG; ukuran maksimum 2MB. |

### 13.4 Validasi Transaksi/Kasir

| Field | Aturan Validasi |
|---|---|
| Item Keranjang | Minimal 1 barang dalam keranjang sebelum checkout dapat dilakukan. |
| Jumlah Barang | Tidak boleh melebihi stok tersedia; minimal 1 (jika 0, barang dihapus dari keranjang). |
| Metode Pembayaran | Wajib dipilih salah satu: Cash, QRIS, Hutang, atau Cash + Hutang. |
| Nominal Cash | Untuk metode Cash, nominal wajib ≥ total transaksi. Untuk Cash+Hutang, nominal cash < total transaksi dan sisanya otomatis menjadi hutang. |
| Pelanggan (untuk Hutang) | Wajib dipilih pelanggan terdaftar atau menambahkan pelanggan baru sebelum transaksi Hutang/Cash+Hutang dapat diselesaikan. |

### 13.5 Validasi Hutang Pelanggan

| Field | Aturan Validasi |
|---|---|
| Nama Pelanggan | Wajib diisi; maksimum 150 karakter. |
| Nominal Pembayaran Hutang | Wajib diisi; numerik; harus > 0; tidak boleh melebihi sisa outstanding hutang pelanggan tersebut. |

### 13.6 Validasi Pengaturan Toko

| Field | Aturan Validasi |
|---|---|
| Nama Toko | Wajib diisi; maksimum 150 karakter. |
| Alamat Toko | Opsional namun direkomendasikan diisi; maksimum 255 karakter. |
| Logo Toko | Format JPG/PNG; ukuran maksimum 2MB. |
| Gambar QRIS | Format JPG/PNG; ukuran maksimum 2MB. |

---

## 14. ERROR HANDLING

Prinsip umum penanganan error pada StoreKuify:

1. Seluruh pesan error ditampilkan dalam **Bahasa Indonesia** yang jelas dan mudah dipahami pengguna non-teknis.
2. Validasi dilakukan pada dua lapisan: **frontend** (untuk responsivitas UX) dan **backend** (untuk keamanan data, tidak bergantung pada validasi client-side saja).
3. Kesalahan sistem (server error) tidak boleh menampilkan detail teknis (stack trace) kepada pengguna akhir; hanya pesan umum seperti "Terjadi kesalahan pada sistem, silakan coba lagi" beserta kode referensi error untuk keperluan debugging tim teknis (log internal).

### 14.1 Skenario Error Utama dan Penanganannya

| Skenario | Penanganan |
|---|---|
| Login gagal (kredensial salah) | Tampilkan pesan "Username atau password salah", tidak memberi tahu field mana yang salah secara spesifik (mencegah user enumeration). |
| Akun dinonaktifkan mencoba login | Tampilkan pesan "Akun Anda telah dinonaktifkan, silakan hubungi Owner". |
| Duplikasi nama kategori/barang/username | Tampilkan pesan spesifik "Nama/Username sudah digunakan, silakan gunakan yang lain". |
| Harga jual < harga modal | Tampilkan pesan "Harga jual tidak boleh lebih kecil dari harga modal". |
| Stok tidak mencukupi saat tambah ke keranjang | Tampilkan pesan "Stok [Nama Barang] tidak mencukupi, sisa stok: [jumlah]". |
| Stok berubah saat checkout final (race condition) | Batalkan proses checkout, tampilkan pesan "Stok [Nama Barang] telah berubah, silakan periksa kembali keranjang Anda", keranjang tidak hilang. |
| Nominal cash kurang dari total tanpa metode Hutang | Tampilkan pesan "Nominal pembayaran tidak mencukupi, silakan pilih metode Cash + Hutang atau tambahkan nominal". |
| Nominal pembayaran hutang melebihi outstanding | Tampilkan pesan "Nominal pembayaran melebihi total hutang yang tersisa". |
| Kasir mencoba mengakses fitur terlarang | Tampilkan halaman/pesan "403 - Anda tidak memiliki akses ke halaman ini". |
| Upload file dengan format tidak didukung | Tampilkan pesan "Format file tidak didukung, gunakan format JPG atau PNG". |
| Upload file melebihi ukuran maksimum | Tampilkan pesan "Ukuran file melebihi batas maksimum 2MB". |
| Koneksi database/server terputus | Tampilkan halaman error umum "Terjadi kesalahan pada sistem, silakan coba beberapa saat lagi" dengan opsi refresh/kembali ke Dashboard. |
| Sesi login kedaluwarsa saat transaksi berlangsung | Simpan sementara data keranjang (jika memungkinkan) dan arahkan ke halaman login dengan pesan "Sesi Anda telah berakhir, silakan login kembali". |

---

## 15. FUTURE SCOPE

Fitur-fitur berikut **tidak termasuk** dalam ruang lingkup rilis versi ini, namun dicatat sebagai kemungkinan pengembangan lanjutan:

1. **Dukungan Multi-Toko/Multi-Cabang** — satu akun Owner dapat mengelola lebih dari satu cabang warung dengan laporan konsolidasi.
2. **Integrasi Payment Gateway Dinamis** — QRIS dinamis dengan verifikasi pembayaran otomatis (contoh: integrasi Midtrans, Xendit).
3. **Aplikasi Mobile Native** — aplikasi Android/iOS pendamping untuk Owner memantau bisnis dari mana saja.
4. **Notifikasi Otomatis** — notifikasi WhatsApp/Telegram/Email untuk stok menipis dan pengingat hutang jatuh tempo.
5. **Cetak Struk Thermal** — dukungan cetak struk fisik menggunakan printer thermal 58mm/80mm.
6. **Integrasi Barcode Scanner** — opsi tambahan bagi toko yang ingin menggunakan barcode di masa depan (tanpa menghilangkan pencarian berbasis nama).
7. **Manajemen Supplier & Purchase Order** — pencatatan pembelian dari supplier secara terstruktur.
8. **Program Loyalti Pelanggan** — sistem poin/reward untuk pelanggan tetap.
9. **Laporan Ekspor PDF/Excel** — kemampuan mengekspor laporan ke format PDF/Excel untuk kebutuhan eksternal (pajak, investor, dsb.).
10. **Multi-User Permission Granular** — level akses yang lebih detail selain Owner dan Kasir (contoh: Supervisor).

---

## 16. ASSUMPTIONS

1. Setiap warung kelontong pengguna StoreKuify hanya memiliki **satu lokasi toko** (single-tenant, single-store).
2. Owner memiliki minimal satu perangkat (desktop/laptop/tablet) dengan akses internet yang memadai untuk operasional harian.
3. QRIS yang digunakan bersifat statis (gambar QR toko), bukan hasil integrasi resmi dengan penyedia payment gateway.
4. Verifikasi pembayaran QRIS dilakukan secara manual oleh kasir berdasarkan kepercayaan (trust-based), bukan verifikasi sistem otomatis.
5. Pengguna (Owner/Kasir) memiliki pemahaman dasar penggunaan aplikasi web sederhana (form input, tombol, pencarian).
6. Harga barang bersifat tunggal (tidak ada varian barang seperti ukuran/warna pada versi ini).
7. Tidak ada kebutuhan pajak otomatis (PPN) pada perhitungan transaksi di versi awal ini, kecuali dinyatakan lain oleh Owner secara manual dalam harga jual.
8. Ambang batas "barang hampir habis" dapat menggunakan nilai default yang disepakati (contoh: stok ≤ 5) dan dapat disesuaikan pada tahap pengembangan lebih lanjut.

---

## 17. DEPENDENCIES

| Dependensi | Keterangan |
|---|---|
| Laravel 12 | Framework backend utama aplikasi. |
| Filament 4 | Admin panel builder yang digunakan untuk membangun antarmuka manajemen (Data Barang, Kelola Kasir, Pengaturan, Laporan). |
| MySQL | Sistem manajemen basis data relasional utama. |
| Tailwind CSS | Framework CSS untuk styling antarmuka, khususnya pada modul Kasir yang membutuhkan desain kustom di luar Filament. |
| Web Server (Nginx/Apache) | Diperlukan untuk hosting aplikasi pada environment produksi. |
| PHP 8.2+ | Versi PHP minimum yang dibutuhkan untuk kompatibilitas Laravel 12. |
| Composer & NPM | Package manager untuk dependency backend (PHP) dan frontend (JS/CSS build). |
| Layanan Hosting/VPS | Infrastruktur server untuk deployment aplikasi produksi. |
| Browser Modern Pengguna | Chrome/Firefox/Edge versi terbaru pada perangkat Owner/Kasir untuk mengakses aplikasi. |

---

## 18. RISKS

| ID | Risiko | Dampak | Mitigasi |
|---|---|---|---|
| RISK-01 | Verifikasi QRIS manual rawan kecurangan (pelanggan mengklaim sudah bayar padahal belum) | Kerugian finansial toko | Edukasi kasir untuk selalu memastikan notifikasi/bukti pembayaran sebelum konfirmasi; pertimbangkan integrasi payment gateway pada fase berikutnya. |
| RISK-02 | Race condition stok saat dua kasir menjual barang yang sama secara bersamaan | Data stok tidak akurat/oversell | Implementasi database transaction dan row-level locking pada proses pengurangan stok saat checkout. |
| RISK-03 | Kehilangan data akibat kegagalan server tanpa backup | Kehilangan data transaksi/hutang secara permanen | Implementasi backup database otomatis harian dan penyimpanan backup di lokasi terpisah (offsite/cloud). |
| RISK-04 | Owner/Kasir tidak terbiasa dengan aplikasi digital (resistensi pengguna) | Adopsi aplikasi rendah, kembali menggunakan pencatatan manual | Desain UI sederhana, sesi onboarding singkat, serta panduan penggunaan bergambar (visual guide). |
| RISK-05 | Kredensial akun Kasir dibagikan antar staf (shared credential) | Sulit melakukan audit siapa yang benar-benar melakukan transaksi | Edukasi kebijakan penggunaan akun individu; pertimbangkan PIN tambahan per transaksi pada pengembangan lanjutan. |
| RISK-06 | Perubahan harga barang oleh Owner disalahpahami memengaruhi laporan historis | Ketidakpercayaan terhadap akurasi laporan | Pastikan seluruh histori transaksi menyimpan snapshot harga saat transaksi terjadi (sudah menjadi Business Rule wajib). |
| RISK-07 | Ukuran file foto produk/logo yang besar memperlambat performa aplikasi | Waktu loading aplikasi meningkat | Terapkan validasi ukuran file maksimum dan kompresi otomatis gambar saat upload. |

---

## 19. GLOSSARY

| Istilah | Definisi |
|---|---|
| **Owner** | Pemilik warung kelontong dengan akses penuh terhadap seluruh fitur StoreKuify. |
| **Kasir** | Staf operasional yang bertugas melayani transaksi penjualan dengan akses terbatas. |
| **Warung Kelontong** | Usaha retail skala kecil-menengah yang menjual kebutuhan sehari-hari, dikelola secara mandiri/keluarga. |
| **Kategori Barang** | Pengelompokan barang berdasarkan jenisnya (contoh: Sabun, Makanan, Minuman, Bumbu). |
| **Barang** | Item/produk yang dijual di warung, memiliki atribut nama, harga modal, harga jual, stok, dan foto (opsional). |
| **Harga Modal** | Harga pokok/biaya perolehan barang sebelum dijual. |
| **Harga Jual** | Harga yang dibebankan kepada pelanggan saat membeli barang. |
| **Keuntungan (Margin)** | Selisih antara Harga Jual dan Harga Modal, dihitung otomatis oleh sistem. |
| **Keranjang (Cart)** | Kumpulan sementara barang yang dipilih pengguna sebelum proses checkout, belum memengaruhi stok. |
| **Checkout** | Proses penyelesaian transaksi penjualan yang mengubah keranjang menjadi transaksi permanen. |
| **QRIS Statis** | Kode QR pembayaran yang bersifat tetap (gambar tunggal milik toko), tanpa integrasi otomatis dengan payment gateway. |
| **Hutang** | Kewajiban pembayaran pelanggan atas transaksi yang belum dibayar lunas. |
| **Outstanding Hutang** | Sisa nominal hutang yang belum dibayar oleh pelanggan. |
| **Cicilan** | Pembayaran hutang yang dilakukan secara bertahap/sebagian, bukan sekaligus lunas. |
| **Dashboard** | Halaman ringkasan yang menampilkan indikator penting bisnis sesuai role pengguna. |
| **Laporan** | Modul yang menyajikan data agregat penjualan dan keuntungan berdasarkan periode waktu tertentu. |
| **Role-Based Access Control (RBAC)** | Mekanisme pembatasan akses fitur/menu berdasarkan peran pengguna (Owner/Kasir). |
| **Stok Hampir Habis** | Kondisi dimana jumlah stok barang berada di bawah atau sama dengan ambang batas minimum yang ditentukan. |
| **Barang Nonaktif** | Barang yang dinonaktifkan oleh Owner sehingga tidak dapat dijual, namun tetap tampil pada Data Barang. |
| **Session/Sesi** | Status login pengguna yang aktif pada suatu perangkat setelah berhasil autentikasi. |
| **Audit Trail** | Jejak/log pencatatan perubahan data penting beserta informasi aktor dan waktu perubahan. |

---

**— AKHIR DOKUMEN 02_PRD.md —**


# 04_Information_Architecture.md
# INFORMATION ARCHITECTURE DOCUMENT
# STOREKUIFY — Web Based Grocery Store POS & Inventory Management System

---

## 1. DOCUMENT INFORMATION

| Atribut | Keterangan |
|---|---|
| Nama Dokumen | Information Architecture Document — StoreKuify |
| Kode Dokumen | 04_Information_Architecture.md |
| Nama Proyek | StoreKuify |
| Jenis Aplikasi | Web Based Grocery Store POS & Inventory Management System |
| Bahasa Dokumen | Bahasa Indonesia |
| Sumber Kebenaran (Source of Truth) | 02_PRD.md, 03_Business_Rules.md |
| Status Dokumen | Final Draft — Siap untuk Tahap UI Design (Stitch) & Frontend Development |
| Disusun Oleh | Senior UX Architect & Information Architect |
| Tanggal Dibuat | 02 Agustus 2026 |
| Confidentiality | Internal — Hanya untuk Tim Internal & Development Team |

Dokumen ini merupakan **referensi utama arsitektur informasi** yang menjadi acuan untuk:

- UI Design (Stitch)
- Navigation Design
- Layout Planning
- User Flow
- Frontend Development

Dokumen ini **BUKAN** dokumen UI Design (tidak membahas warna, tipografi, komponen visual, atau wireframe). Dokumen ini menjelaskan **bagaimana aplikasi StoreKuify diorganisasikan**: struktur navigasi, hierarki menu, hierarki halaman, hubungan antar layar (screen relationship), breadcrumb, dan hubungan parent-child antar halaman.

Seluruh isi dokumen ini **diturunkan sepenuhnya** dari 02_PRD.md (Product Requirements Document) dan 03_Business_Rules.md (Business Rules Document), tanpa menambahkan fitur baru dan tanpa bertentangan dengan kedua dokumen tersebut.

---

## 2. REVISION HISTORY

| Versi | Tanggal | Deskripsi Perubahan | Disusun Oleh | Disetujui Oleh |
|---|---|---|---|---|
| 0.1 | 02 Agustus 2026 | Draft awal Information Architecture diturunkan dari 02_PRD.md dan 03_Business_Rules.md | Senior UX Architect & Information Architect | - |
| 1.0 | 02 Agustus 2026 | Finalisasi seluruh struktur navigasi, hierarki halaman, Screen Inventory, Navigation Matrix, Page Access Matrix, Breadcrumb, dan Cross Navigation | Senior UX Architect & Information Architect | Product Owner |

Catatan: Setiap perubahan pada 02_PRD.md atau 03_Business_Rules.md yang memengaruhi struktur navigasi wajib disinkronkan ke dokumen ini dengan menambahkan baris revisi baru.

---

## 3. TABLE OF CONTENTS

1. Document Information
2. Revision History
3. Table of Contents
4. Introduction
5. Information Architecture Principles
6. Role Based Navigation
   - 6.1 Owner Navigation
   - 6.2 Kasir Navigation
7. Navigation Structure
8. Sidebar Structure
   - 8.1 Sidebar Owner
   - 8.2 Sidebar Kasir
9. Page Hierarchy
10. Parent Child Relationship
11. Screen Inventory
12. Navigation Matrix
13. Breadcrumb Structure
14. Cross Navigation
15. Page Access Matrix
16. Future Information Architecture
17. Glossary

---

## 4. INTRODUCTION

StoreKuify adalah aplikasi kasir dan manajemen toko berbasis web yang ditujukan untuk Warung Kelontong, dengan dua role pengguna: **Owner** dan **Kasir**. Dokumen Information Architecture ini disusun untuk memastikan seluruh tim (UI Design, Frontend Development, QA) memiliki pemahaman yang konsisten mengenai:

1. Bagaimana menu-menu aplikasi disusun dan dikelompokkan (grouping).
2. Bagaimana hubungan antar halaman terjadi (parent-child, sibling, cross-navigation).
3. Bagaimana navigasi berbeda antara role Owner dan role Kasir sesuai Role Access Matrix pada 02_PRD.md dan aturan BR-ROLE pada 03_Business_Rules.md.
4. Bagaimana pengguna berpindah dari satu layar ke layar lain (navigation flow) untuk menyelesaikan tugas operasional (misalnya dari Dashboard menuju Data Barang saat melihat "Barang Hampir Habis").
5. Struktur breadcrumb yang konsisten di seluruh halaman, agar pengguna selalu memahami posisinya dalam aplikasi.

Arsitektur informasi StoreKuify dirancang dengan filosofi **kesederhanaan (simplicity first)** yang sejalan dengan Product Overview pada 02_PRD.md — StoreKuify bukan aplikasi retail modern yang kompleks seperti Indomaret, sehingga struktur navigasi dijaga tetap dangkal (shallow), mudah dipelajari, dan minim langkah (minimal clicks) untuk mencapai halaman penting.

---

## 5. INFORMATION ARCHITECTURE PRINCIPLES

Prinsip-prinsip berikut menjadi acuan dalam menyusun seluruh struktur navigasi StoreKuify:

| Prinsip | Penjelasan |
|---|---|
| **Maximum 3 Klik untuk Halaman Penting** | Halaman-halaman krusial (Kasir/Checkout, Data Barang, Hutang Pelanggan, Dashboard) dapat dicapai maksimal dalam 3 klik dari halaman manapun, melalui sidebar utama. |
| **Navigasi Konsisten** | Struktur sidebar, breadcrumb, dan pola penamaan halaman konsisten di seluruh modul, tidak berubah-ubah antar role. |
| **Responsive Layout** | Struktur navigasi (sidebar, breadcrumb) tetap dapat diakses pada layar desktop, tablet, dan mobile, mengikuti prinsip Desktop First pada 02_PRD.md. |
| **Desktop First** | Struktur navigasi utama dirancang mengutamakan pengalaman desktop, dengan sidebar tetap (persistent sidebar), dan beradaptasi menjadi collapsible/hamburger menu pada layar sempit. |
| **Role Based Visibility** | Sidebar dan menu navigasi hanya menampilkan item yang sesuai dengan hak akses role (Owner/Kasir), sesuai BR-ROLE-001 s.d. BR-ROLE-007 pada 03_Business_Rules.md. |
| **Minimal Cognitive Load** | Jumlah item menu utama dibatasi (maksimal 7±2 item pada level pertama) agar mudah diingat dan tidak membingungkan pengguna non-teknis. |
| **Clear Grouping** | Halaman dikelompokkan berdasarkan domain fungsional (Data Barang mengelompokkan Kategori dan Barang; Pengaturan mengelompokkan Profil Toko, QRIS, dan Profil Owner). |
| **No Duplicated Navigation** | Setiap halaman hanya memiliki satu jalur utama (primary path) dalam sidebar; jalur tambahan (cross-navigation) bersifat kontekstual dan tidak menduplikasi struktur menu utama. |
| **Shallow Hierarchy** | Kedalaman hierarki dijaga agar tidak lebih dari 4 tingkat (contoh terdalam: Data Barang → Kategori → Detail Kategori → Barang → Detail Barang), untuk menghindari navigasi yang membingungkan. |
| **Predictable Parent-Child Relationship** | Setiap halaman anak (child screen) selalu dapat kembali secara jelas ke halaman induknya (parent screen) melalui breadcrumb maupun tombol kembali. |


---

## 6. ROLE BASED NAVIGATION

Sesuai dengan Role Access Matrix pada 02_PRD.md (Bagian 7.3) dan aturan BR-ROLE pada 03_Business_Rules.md, StoreKuify menyediakan dua struktur navigasi berbeda: **Owner Navigation** dan **Kasir Navigation**.

### 6.1 Owner Navigation

Owner memiliki akses penuh terhadap seluruh modul aplikasi. Struktur navigasi Owner adalah sebagai berikut:

```
Dashboard
Data Barang
  └── Kategori
        └── Detail Kategori
              └── Barang
                    └── Detail Barang
Kasir
  └── Checkout
Hutang Pelanggan
Laporan
Kelola Kasir
Pengaturan
```

**Penjelasan hierarki Data Barang (Owner):**

1. **Data Barang** — halaman induk (landing page), menampilkan daftar seluruh **Kategori** barang.
2. **Kategori** — daftar kategori (Sabun, Makanan, Minuman, Bumbu, dll.), dapat ditambah/diubah oleh Owner.
3. **Detail Kategori** — halaman detail satu kategori tertentu, menampilkan informasi kategori beserta daftar **Barang** yang berada di dalamnya.
4. **Barang** — daftar barang yang tergabung dalam kategori tersebut (ditampilkan di dalam halaman Detail Kategori).
5. **Detail Barang** — halaman detail satu barang tertentu (nama, foto, harga modal, harga jual, stok), tempat Owner dapat mengedit atau menonaktifkan barang.

### 6.2 Kasir Navigation

Kasir memiliki akses terbatas sesuai Role Access Matrix. Struktur navigasi Kasir adalah sebagai berikut:

```
Dashboard
Data Barang (Read Only)
Kasir
  └── Checkout
Hutang Pelanggan
Profil Saya
```

**Catatan Perbedaan Navigasi Kasir:**

- **Data Barang** pada navigasi Kasir bersifat **Read Only** — Kasir tetap dapat menavigasi ke Kategori → Detail Kategori → Barang → Detail Barang, namun tanpa tombol aksi Create/Update/Delete (sesuai BR-BRG-013, BR-ROLE-003).
- **Laporan**, **Kelola Kasir**, dan **Pengaturan** **tidak muncul** pada sidebar Kasir (sesuai BR-ROLE-004, BR-ROLE-005, BR-ROLE-006).
- **Profil Saya** hanya muncul pada navigasi Kasir (untuk mengubah username, password, foto profil miliknya sendiri, sesuai BR-KKS-006). Pada navigasi Owner, fungsi setara tersedia melalui **Pengaturan → Profil Owner**.

---

## 7. NAVIGATION STRUCTURE

Struktur navigasi StoreKuify menggunakan pola **Persistent Sidebar Navigation** (sidebar tetap di sisi kiri layar) dikombinasikan dengan **Breadcrumb** pada bagian atas konten utama, sesuai prinsip Desktop First dan Responsive Web pada 02_PRD.md.

### 7.1 Elemen Navigasi Utama

| Elemen | Fungsi |
|---|---|
| **Sidebar (Menu Utama)** | Menampilkan seluruh modul utama sesuai role pengguna (lihat Bagian 8 — Sidebar Structure). Bersifat persistent pada desktop, collapsible pada tablet/mobile. |
| **Topbar** | Menampilkan nama toko/logo, notifikasi ringkas (opsional), dan menu profil pengguna (foto profil, nama, tombol logout). |
| **Breadcrumb** | Menampilkan posisi pengguna dalam hierarki halaman saat ini, memungkinkan navigasi cepat ke halaman induk (lihat Bagian 13 — Breadcrumb Structure). |
| **Contextual Action Button** | Tombol aksi kontekstual pada tiap halaman (contoh: "Tambah Barang", "Checkout", "Terima Pembayaran"), muncul sesuai hak akses role. |
| **Modal/Dialog** | Digunakan untuk aksi cepat yang tidak memerlukan perpindahan halaman penuh (contoh: Tambah Kategori, Tambah Pelanggan, Konfirmasi Pembayaran QRIS, Reset Password Kasir). |

### 7.2 Pola Navigasi Antar Modul

Navigasi StoreKuify mengikuti tiga pola utama:

1. **Primary Navigation (Sidebar → Halaman Utama Modul)** — pengguna berpindah antar modul utama (Dashboard, Data Barang, Kasir, Hutang Pelanggan, Laporan, Kelola Kasir, Pengaturan) melalui klik item sidebar.
2. **Drill-Down Navigation (Halaman Induk → Halaman Anak)** — pengguna masuk lebih dalam ke suatu hierarki (contoh: Data Barang → Kategori → Detail Kategori → Barang → Detail Barang) dengan mengklik item pada daftar.
3. **Cross Navigation (Kontekstual)** — pengguna berpindah dari satu modul ke modul lain melalui elemen kontekstual (contoh: dari Dashboard mengklik kartu "Barang Hampir Habis" menuju Data Barang; lihat Bagian 14 — Cross Navigation).


---

## 8. SIDEBAR STRUCTURE

### 8.1 Sidebar Owner

```
StoreKuify (Owner)
├── Dashboard
├── Data Barang
│   └── Kategori
│         └── Detail Kategori
│               └── Barang
│                     └── Detail Barang
├── Kasir
│   └── Checkout
├── Hutang Pelanggan
│   └── Detail Hutang Pelanggan
├── Laporan
│   ├── Laporan Harian
│   ├── Laporan Mingguan
│   ├── Laporan Bulanan
│   └── Laporan Tahunan
├── Kelola Kasir
│   └── Detail/Form Kasir
└── Pengaturan
    ├── Profil Toko
    ├── QRIS
    └── Profil Owner
```

### 8.2 Sidebar Kasir

```
StoreKuify (Kasir)
├── Dashboard
├── Data Barang (Read Only)
│   └── Kategori
│         └── Detail Kategori
│               └── Barang
│                     └── Detail Barang
├── Kasir
│   └── Checkout
├── Hutang Pelanggan
│   └── Detail Hutang Pelanggan
└── Profil Saya
```

**Catatan Sidebar:**

- Item sidebar level pertama dibatasi maksimal 7 item (Owner) dan 5 item (Kasir), sesuai prinsip *Minimal Cognitive Load*.
- Sub-item (Kategori, Detail Kategori, Barang, Detail Barang, Laporan Harian/Mingguan/Bulanan/Tahunan) **tidak ditampilkan sebagai item sidebar permanen**, melainkan muncul secara kontekstual sebagai tab/link di dalam halaman induknya masing-masing (contoh: filter periode pada halaman Laporan; drill-down link pada halaman Data Barang).
- Sidebar bersifat **collapsible** pada resolusi tablet/mobile (sesuai NFR-07 pada 02_PRD.md), berubah menjadi hamburger menu yang dapat dibuka/tutup.

---

## 9. PAGE HIERARCHY

Berikut adalah hierarki halaman lengkap StoreKuify, mencakup seluruh modul sesuai 02_PRD.md.

```
StoreKuify
│
├── 1. Login
│
├── 2. Dashboard
│     ├── 2.1 Dashboard Owner
│     └── 2.2 Dashboard Kasir
│
├── 3. Data Barang
│     └── 3.1 Kategori (Daftar Kategori)
│           └── 3.1.1 Detail Kategori
│                 └── 3.1.1.1 Barang (Daftar Barang dalam Kategori)
│                       └── 3.1.1.1.1 Detail Barang
│                             ├── Form Edit Barang (Owner)
│                             └── Aksi Nonaktifkan/Aktifkan Barang (Owner)
│           └── Form Tambah/Edit Kategori (Owner, modal)
│     └── Form Tambah Barang (Owner, modal/halaman)
│
├── 4. Kasir
│     ├── 4.1 Pencarian & Keranjang Barang
│     └── 4.2 Checkout
│           ├── 4.2.1 Pemilihan Metode Pembayaran
│           ├── 4.2.2 Konfirmasi QRIS (jika metode QRIS)
│           ├── 4.2.3 Form Tambah Pelanggan (jika metode Hutang/Cash+Hutang dan pelanggan belum ada)
│           └── 4.2.4 Struk Transaksi
│
├── 5. Hutang Pelanggan
│     └── 5.1 Daftar Pelanggan
│           └── 5.1.1 Detail Hutang & Histori Pelanggan
│                 └── Form Terima Pembayaran Hutang (modal)
│           └── Form Tambah Pelanggan (modal)
│
├── 6. Laporan (Owner Only)
│     ├── 6.1 Laporan Harian
│     ├── 6.2 Laporan Mingguan
│     ├── 6.3 Laporan Bulanan
│     ├── 6.4 Laporan Tahunan
│     └── 6.5 Filter Rentang Kustom
│
├── 7. Kelola Kasir (Owner Only)
│     └── 7.1 Daftar Kasir
│           └── 7.1.1 Detail/Form Edit Kasir
│                 └── Form Reset Password (modal)
│           └── Form Tambah Kasir (modal/halaman)
│
├── 8. Pengaturan (Owner Only)
│     ├── 8.1 Profil Toko
│     ├── 8.2 QRIS
│     └── 8.3 Profil Owner
│
└── 9. Profil Saya (Kasir Only)
      ├── 9.1 Ubah Username
      ├── 9.2 Ubah Password
      └── 9.3 Ubah Foto Profil
```

**Catatan Kedalaman Hierarki:**

Hierarki terdalam pada StoreKuify terdapat pada modul Data Barang, dengan 4 tingkat kedalaman: **Data Barang → Kategori → Detail Kategori → Barang → Detail Barang**, sesuai spesifikasi eksplisit pada requirement dokumen ini. Seluruh modul lain memiliki kedalaman maksimal 2–3 tingkat, sejalan dengan prinsip *Shallow Hierarchy* pada Bagian 5.


---

## 10. PARENT CHILD RELATIONSHIP

Tabel berikut menjelaskan hubungan parent-child antar seluruh halaman pada StoreKuify.

| Parent Screen | Child Screen | Relationship Type | Keterangan |
|---|---|---|---|
| Login | Dashboard Owner | Redirect setelah autentikasi | Role Owner |
| Login | Dashboard Kasir | Redirect setelah autentikasi | Role Kasir |
| Dashboard Owner | Data Barang | Cross Navigation | Melalui klik kartu "Barang Hampir Habis" |
| Dashboard Owner | Hutang Pelanggan | Cross Navigation | Melalui klik kartu "Hutang Belum Lunas" |
| Dashboard Kasir | Data Barang | Cross Navigation | Melalui klik kartu "Barang Hampir Habis" |
| Dashboard Kasir | Hutang Pelanggan | Cross Navigation | Melalui klik kartu "Hutang Pelanggan" |
| Data Barang | Kategori (Daftar Kategori) | Drill-Down (Landing Page) | Data Barang = tampilan Daftar Kategori |
| Kategori (Daftar Kategori) | Detail Kategori | Drill-Down | Klik salah satu kategori |
| Kategori (Daftar Kategori) | Form Tambah/Edit Kategori | Modal Navigation | Owner only |
| Detail Kategori | Barang (Daftar Barang dalam Kategori) | Embedded/Drill-Down | Daftar barang ditampilkan dalam Detail Kategori |
| Barang (Daftar Barang) | Detail Barang | Drill-Down | Klik salah satu barang |
| Barang (Daftar Barang) | Form Tambah Barang | Modal/Page Navigation | Owner only |
| Detail Barang | Form Edit Barang | Modal Navigation | Owner only |
| Kasir | Pencarian & Keranjang Barang | Embedded | Bagian dari halaman Kasir |
| Pencarian & Keranjang Barang | Checkout | Drill-Down (Action) | Klik tombol "Checkout" |
| Checkout | Pemilihan Metode Pembayaran | Embedded | Bagian dari alur Checkout |
| Checkout | Konfirmasi QRIS | Conditional Drill-Down | Jika metode QRIS dipilih |
| Checkout | Form Tambah Pelanggan | Modal Navigation | Jika metode Hutang/Cash+Hutang dan pelanggan belum terdaftar |
| Checkout | Struk Transaksi | Redirect (Post-Success) | Setelah checkout berhasil |
| Struk Transaksi | Kasir (Pencarian & Keranjang) | Redirect (Return) | Keranjang kosong, siap transaksi baru |
| Hutang Pelanggan | Daftar Pelanggan | Landing Page | Halaman utama modul Hutang Pelanggan |
| Daftar Pelanggan | Detail Hutang & Histori Pelanggan | Drill-Down | Klik salah satu pelanggan |
| Daftar Pelanggan | Form Tambah Pelanggan | Modal Navigation | Owner & Kasir |
| Detail Hutang & Histori Pelanggan | Form Terima Pembayaran Hutang | Modal Navigation | Owner & Kasir |
| Laporan | Laporan Harian | Tab Navigation | Owner only, default tab |
| Laporan | Laporan Mingguan | Tab Navigation | Owner only |
| Laporan | Laporan Bulanan | Tab Navigation | Owner only |
| Laporan | Laporan Tahunan | Tab Navigation | Owner only |
| Laporan | Filter Rentang Kustom | Embedded Control | Owner only |
| Kelola Kasir | Daftar Kasir | Landing Page | Owner only |
| Daftar Kasir | Detail/Form Edit Kasir | Drill-Down | Klik salah satu akun Kasir |
| Daftar Kasir | Form Tambah Kasir | Modal/Page Navigation | Owner only |
| Detail/Form Edit Kasir | Form Reset Password | Modal Navigation | Owner only |
| Pengaturan | Profil Toko | Tab Navigation | Owner only, default tab |
| Pengaturan | QRIS | Tab Navigation | Owner only |
| Pengaturan | Profil Owner | Tab Navigation | Owner only |
| Profil Saya | Ubah Username | Embedded Form Section | Kasir only |
| Profil Saya | Ubah Password | Embedded Form Section | Kasir only |
| Profil Saya | Ubah Foto Profil | Embedded Form Section | Kasir only |


---

## 11. SCREEN INVENTORY

Tabel berikut mendaftarkan seluruh layar (screen) yang ada pada StoreKuify, lengkap dengan Screen ID, Purpose, User Role, Parent Screen, Child Screen, Accessible From, dan Navigation Type.

| Screen ID | Screen Name | Purpose | User Role | Parent Screen | Child Screen | Accessible From | Navigation Type |
|---|---|---|---|---|---|---|---|
| SCR-001 | Login | Autentikasi pengguna ke dalam sistem | Owner, Kasir | - | Dashboard Owner, Dashboard Kasir | URL langsung / Redirect saat sesi berakhir | Redirect |
| SCR-002 | Dashboard Owner | Menampilkan ringkasan bisnis harian: penjualan, keuntungan, transaksi, grafik, stok menipis, hutang | Owner | Login | Data Barang (via card), Hutang Pelanggan (via card) | Sidebar, Redirect setelah login | Primary Navigation |
| SCR-003 | Dashboard Kasir | Menampilkan ringkasan operasional harian tanpa data keuntungan | Kasir | Login | Data Barang (via card), Hutang Pelanggan (via card) | Sidebar, Redirect setelah login | Primary Navigation |
| SCR-004 | Data Barang (Daftar Kategori) | Menampilkan daftar kategori barang sebagai halaman induk Data Barang | Owner (full), Kasir (read only) | Dashboard | Detail Kategori, Form Tambah/Edit Kategori | Sidebar, Cross Navigation dari Dashboard | Primary Navigation |
| SCR-005 | Detail Kategori | Menampilkan informasi kategori beserta daftar barang di dalamnya | Owner (full), Kasir (read only) | Data Barang (Daftar Kategori) | Daftar Barang (embedded), Detail Barang | Data Barang (Daftar Kategori) | Drill-Down |
| SCR-006 | Form Tambah/Edit Kategori | Form untuk menambah kategori baru atau mengubah nama kategori | Owner | Data Barang (Daftar Kategori) | - | Tombol "Tambah Kategori" / "Edit" pada Daftar Kategori | Modal Navigation |
| SCR-007 | Daftar Barang dalam Kategori | Menampilkan daftar barang yang tergabung dalam suatu kategori (embedded dalam Detail Kategori) | Owner (full), Kasir (read only) | Detail Kategori | Detail Barang, Form Tambah Barang | Detail Kategori | Embedded/Drill-Down |
| SCR-008 | Detail Barang | Menampilkan detail lengkap satu barang: nama, foto, harga modal, harga jual, stok, status | Owner (full), Kasir (read only) | Daftar Barang dalam Kategori | Form Edit Barang | Daftar Barang dalam Kategori | Drill-Down |
| SCR-009 | Form Tambah Barang | Form untuk menambah barang baru ke dalam kategori tertentu | Owner | Daftar Barang dalam Kategori | - | Tombol "Tambah Barang" pada Daftar Barang | Modal/Page Navigation |
| SCR-010 | Form Edit Barang | Form untuk mengubah data barang (nama, kategori, harga, foto) atau menonaktifkan barang | Owner | Detail Barang | - | Tombol "Edit"/"Nonaktifkan" pada Detail Barang | Modal Navigation |
| SCR-011 | Kasir (Pencarian & Keranjang) | Halaman utama transaksi penjualan: pencarian barang berbasis nama dan pengelolaan keranjang | Owner, Kasir | Dashboard | Checkout | Sidebar | Primary Navigation |
| SCR-012 | Checkout (Pemilihan Metode Pembayaran) | Menyelesaikan transaksi dengan memilih metode pembayaran: Cash, QRIS, Hutang, Cash+Hutang | Owner, Kasir | Kasir (Pencarian & Keranjang) | Konfirmasi QRIS, Form Tambah Pelanggan, Struk Transaksi | Tombol "Checkout" pada halaman Kasir | Drill-Down (Action) |
| SCR-013 | Konfirmasi Pembayaran QRIS | Menampilkan gambar QRIS statis toko dan tombol konfirmasi pembayaran diterima | Owner, Kasir | Checkout | Struk Transaksi | Checkout, saat metode QRIS dipilih | Conditional Drill-Down |
| SCR-014 | Form Tambah Pelanggan | Form untuk menambahkan data pelanggan baru (nama, no. telepon) | Owner, Kasir | Checkout, Daftar Pelanggan (Hutang Pelanggan) | - | Checkout (metode Hutang/Cash+Hutang tanpa pelanggan), Daftar Pelanggan | Modal Navigation |
| SCR-015 | Struk Transaksi | Menampilkan ringkasan struk setelah transaksi berhasil diselesaikan | Owner, Kasir | Checkout / Konfirmasi QRIS | Kasir (Pencarian & Keranjang, redirect kembali) | Checkout berhasil | Redirect (Post-Success) |
| SCR-016 | Hutang Pelanggan (Daftar Pelanggan) | Menampilkan daftar seluruh pelanggan beserta status dan total hutang aktif | Owner, Kasir | Dashboard | Detail Hutang & Histori Pelanggan, Form Tambah Pelanggan | Sidebar, Cross Navigation dari Dashboard | Primary Navigation |
| SCR-017 | Detail Hutang & Histori Pelanggan | Menampilkan rincian hutang, transaksi sumber hutang, dan histori pembayaran pelanggan tertentu | Owner, Kasir | Daftar Pelanggan | Form Terima Pembayaran Hutang | Daftar Pelanggan | Drill-Down |
| SCR-018 | Form Terima Pembayaran Hutang | Form untuk mencatat pembayaran hutang (sebagian/lunas) | Owner, Kasir | Detail Hutang & Histori Pelanggan | - | Tombol "Terima Pembayaran" pada Detail Hutang | Modal Navigation |
| SCR-019 | Laporan | Menampilkan laporan penjualan dan keuntungan dengan filter periode Harian/Mingguan/Bulanan/Tahunan/Kustom, grafik, dan ranking barang | Owner | Dashboard | - | Sidebar | Primary Navigation |
| SCR-020 | Kelola Kasir (Daftar Kasir) | Menampilkan daftar akun Kasir beserta status aktif/nonaktif | Owner | Dashboard | Detail/Form Edit Kasir, Form Tambah Kasir | Sidebar | Primary Navigation |
| SCR-021 | Detail/Form Edit Kasir | Menampilkan dan mengubah data akun Kasir (nama, username), serta aksi nonaktifkan/aktifkan | Owner | Daftar Kasir | Form Reset Password | Daftar Kasir | Drill-Down |
| SCR-022 | Form Tambah Kasir | Form untuk membuat akun Kasir baru | Owner | Daftar Kasir | - | Tombol "Tambah Kasir" pada Daftar Kasir | Modal/Page Navigation |
| SCR-023 | Form Reset Password Kasir | Form untuk mereset password akun Kasir tanpa password lama | Owner | Detail/Form Edit Kasir | - | Tombol "Reset Password" pada Detail Kasir | Modal Navigation |
| SCR-024 | Pengaturan — Profil Toko | Mengubah Nama Toko, Alamat Toko, dan Logo | Owner | Dashboard | - | Sidebar (tab default Pengaturan) | Primary Navigation / Tab |
| SCR-025 | Pengaturan — QRIS | Mengunggah/mengganti/menghapus gambar QRIS statis toko | Owner | Pengaturan — Profil Toko | - | Tab "QRIS" pada halaman Pengaturan | Tab Navigation |
| SCR-026 | Pengaturan — Profil Owner | Mengubah nama, username, password, dan foto profil Owner | Owner | Pengaturan — Profil Toko | - | Tab "Profil Owner" pada halaman Pengaturan | Tab Navigation |
| SCR-027 | Profil Saya (Kasir) | Mengubah username, password, dan foto profil milik akun Kasir yang sedang login | Kasir | Dashboard | - | Sidebar / Menu Profil pada Topbar | Primary Navigation |

**Catatan:** Total 27 layar utama teridentifikasi pada StoreKuify, mencakup seluruh modul pada 02_PRD.md (Authentication, Dashboard, Data Barang, Kasir, Hutang Pelanggan, Laporan, Kelola Kasir, Pengaturan).


---

## 12. NAVIGATION MATRIX

Tabel berikut menjelaskan seluruh jalur navigasi (navigation path) antar layar pada StoreKuify.

| Source Screen | Destination Screen | Navigation Method | Role |
|---|---|---|---|
| Login (SCR-001) | Dashboard Owner (SCR-002) | Redirect otomatis setelah login berhasil | Owner |
| Login (SCR-001) | Dashboard Kasir (SCR-003) | Redirect otomatis setelah login berhasil | Kasir |
| Dashboard Owner (SCR-002) | Data Barang (SCR-004) | Klik sidebar "Data Barang" | Owner |
| Dashboard Owner (SCR-002) | Data Barang (SCR-004) | Klik kartu "Barang Hampir Habis" | Owner |
| Dashboard Owner (SCR-002) | Kasir (SCR-011) | Klik sidebar "Kasir" | Owner |
| Dashboard Owner (SCR-002) | Hutang Pelanggan (SCR-016) | Klik sidebar "Hutang Pelanggan" | Owner |
| Dashboard Owner (SCR-002) | Hutang Pelanggan (SCR-016) | Klik kartu "Hutang Belum Lunas" | Owner |
| Dashboard Owner (SCR-002) | Laporan (SCR-019) | Klik sidebar "Laporan" | Owner |
| Dashboard Owner (SCR-002) | Kelola Kasir (SCR-020) | Klik sidebar "Kelola Kasir" | Owner |
| Dashboard Owner (SCR-002) | Pengaturan (SCR-024) | Klik sidebar "Pengaturan" | Owner |
| Dashboard Kasir (SCR-003) | Data Barang (SCR-004) | Klik sidebar "Data Barang" | Kasir |
| Dashboard Kasir (SCR-003) | Data Barang (SCR-004) | Klik kartu "Barang Hampir Habis" | Kasir |
| Dashboard Kasir (SCR-003) | Kasir (SCR-011) | Klik sidebar "Kasir" | Kasir |
| Dashboard Kasir (SCR-003) | Hutang Pelanggan (SCR-016) | Klik sidebar "Hutang Pelanggan" | Kasir |
| Dashboard Kasir (SCR-003) | Hutang Pelanggan (SCR-016) | Klik kartu "Hutang Pelanggan" | Kasir |
| Dashboard Kasir (SCR-003) | Profil Saya (SCR-027) | Klik sidebar/topbar "Profil Saya" | Kasir |
| Data Barang (SCR-004) | Detail Kategori (SCR-005) | Klik salah satu baris kategori | Owner, Kasir |
| Data Barang (SCR-004) | Form Tambah/Edit Kategori (SCR-006) | Klik tombol "Tambah Kategori" / ikon "Edit" | Owner |
| Detail Kategori (SCR-005) | Daftar Barang dalam Kategori (SCR-007) | Otomatis ditampilkan (embedded) | Owner, Kasir |
| Daftar Barang dalam Kategori (SCR-007) | Detail Barang (SCR-008) | Klik salah satu baris barang | Owner, Kasir |
| Daftar Barang dalam Kategori (SCR-007) | Form Tambah Barang (SCR-009) | Klik tombol "Tambah Barang" | Owner |
| Detail Barang (SCR-008) | Form Edit Barang (SCR-010) | Klik tombol "Edit" | Owner |
| Kasir (SCR-011) | Checkout (SCR-012) | Klik tombol "Checkout" | Owner, Kasir |
| Checkout (SCR-012) | Konfirmasi QRIS (SCR-013) | Klik/pilih metode pembayaran "QRIS" | Owner, Kasir |
| Checkout (SCR-012) | Form Tambah Pelanggan (SCR-014) | Klik "Tambah Pelanggan Baru" saat memilih metode Hutang/Cash+Hutang | Owner, Kasir |
| Checkout (SCR-012) | Struk Transaksi (SCR-015) | Klik "Selesaikan Transaksi" (metode Cash/Hutang) | Owner, Kasir |
| Konfirmasi QRIS (SCR-013) | Struk Transaksi (SCR-015) | Klik "Konfirmasi Pembayaran Diterima" | Owner, Kasir |
| Struk Transaksi (SCR-015) | Kasir (SCR-011) | Klik "Transaksi Baru"/"Tutup" | Owner, Kasir |
| Hutang Pelanggan (SCR-016) | Detail Hutang & Histori Pelanggan (SCR-017) | Klik salah satu baris pelanggan | Owner, Kasir |
| Hutang Pelanggan (SCR-016) | Form Tambah Pelanggan (SCR-014) | Klik tombol "Tambah Pelanggan" | Owner, Kasir |
| Detail Hutang & Histori Pelanggan (SCR-017) | Form Terima Pembayaran Hutang (SCR-018) | Klik tombol "Terima Pembayaran" | Owner, Kasir |
| Laporan (SCR-019) | Laporan (SCR-019) | Klik tab "Harian" / "Mingguan" / "Bulanan" / "Tahunan" / "Rentang Kustom" | Owner |
| Kelola Kasir (SCR-020) | Detail/Form Edit Kasir (SCR-021) | Klik salah satu baris akun Kasir | Owner |
| Kelola Kasir (SCR-020) | Form Tambah Kasir (SCR-022) | Klik tombol "Tambah Kasir" | Owner |
| Detail/Form Edit Kasir (SCR-021) | Form Reset Password Kasir (SCR-023) | Klik tombol "Reset Password" | Owner |
| Pengaturan — Profil Toko (SCR-024) | Pengaturan — QRIS (SCR-025) | Klik tab "QRIS" | Owner |
| Pengaturan — Profil Toko (SCR-024) | Pengaturan — Profil Owner (SCR-026) | Klik tab "Profil Owner" | Owner |
| Manapun (Semua Halaman) | Login (SCR-001) | Klik "Logout" pada Topbar | Owner, Kasir |
| Manapun (Semua Halaman) | Halaman Sebelumnya | Klik breadcrumb / tombol kembali | Owner, Kasir |

---

## 13. BREADCRUMB STRUCTURE

Setiap halaman pada StoreKuify menampilkan breadcrumb yang mencerminkan posisinya dalam hierarki halaman. Format breadcrumb: `Dashboard > [Modul] > [Sub-Halaman] > ...`.

| Screen | Breadcrumb |
|---|---|
| Dashboard Owner / Dashboard Kasir | `Dashboard` |
| Data Barang (Daftar Kategori) | `Dashboard > Data Barang` |
| Detail Kategori | `Dashboard > Data Barang > [Nama Kategori]` |
| Daftar Barang dalam Kategori | `Dashboard > Data Barang > [Nama Kategori] > Barang` |
| Detail Barang | `Dashboard > Data Barang > [Nama Kategori] > Barang > [Nama Barang]` |
| Form Tambah/Edit Kategori | `Dashboard > Data Barang > Tambah Kategori` atau `Dashboard > Data Barang > Edit Kategori` |
| Form Tambah Barang | `Dashboard > Data Barang > [Nama Kategori] > Barang > Tambah Barang` |
| Form Edit Barang | `Dashboard > Data Barang > [Nama Kategori] > Barang > [Nama Barang] > Edit` |
| Kasir | `Dashboard > Kasir` |
| Checkout | `Dashboard > Kasir > Checkout` |
| Konfirmasi QRIS | `Dashboard > Kasir > Checkout > QRIS` |
| Struk Transaksi | `Dashboard > Kasir > Checkout > Struk` |
| Hutang Pelanggan (Daftar Pelanggan) | `Dashboard > Hutang Pelanggan` |
| Detail Hutang & Histori Pelanggan | `Dashboard > Hutang Pelanggan > [Nama Pelanggan]` |
| Form Terima Pembayaran Hutang | `Dashboard > Hutang Pelanggan > [Nama Pelanggan] > Terima Pembayaran` |
| Form Tambah Pelanggan | `Dashboard > Hutang Pelanggan > Tambah Pelanggan` |
| Laporan (Harian) | `Dashboard > Laporan > Harian` |
| Laporan (Mingguan) | `Dashboard > Laporan > Mingguan` |
| Laporan (Bulanan) | `Dashboard > Laporan > Bulanan` |
| Laporan (Tahunan) | `Dashboard > Laporan > Tahunan` |
| Kelola Kasir (Daftar Kasir) | `Dashboard > Kelola Kasir` |
| Detail/Form Edit Kasir | `Dashboard > Kelola Kasir > [Nama Kasir]` |
| Form Tambah Kasir | `Dashboard > Kelola Kasir > Tambah Kasir` |
| Form Reset Password Kasir | `Dashboard > Kelola Kasir > [Nama Kasir] > Reset Password` |
| Pengaturan — Profil Toko | `Dashboard > Pengaturan > Profil Toko` |
| Pengaturan — QRIS | `Dashboard > Pengaturan > QRIS` |
| Pengaturan — Profil Owner | `Dashboard > Pengaturan > Profil Owner` |
| Profil Saya (Kasir) | `Dashboard > Profil Saya` |

**Aturan Breadcrumb:**

1. Breadcrumb selalu dimulai dari `Dashboard` sebagai root, kecuali pada halaman Login (tidak memiliki breadcrumb).
2. Setiap segmen breadcrumb (kecuali segmen terakhir/halaman aktif) bersifat clickable dan mengarahkan pengguna kembali ke halaman induk terkait.
3. Segmen breadcrumb yang menampilkan nama entitas dinamis (`[Nama Kategori]`, `[Nama Barang]`, `[Nama Pelanggan]`, `[Nama Kasir]`) diambil langsung dari data entitas yang sedang ditampilkan.
4. Modal/Dialog (contoh: Form Tambah Kategori, Form Reset Password) tidak menghasilkan breadcrumb baru karena tidak berpindah halaman penuh; breadcrumb tetap mengikuti halaman induk tempat modal dibuka.

---

## 14. CROSS NAVIGATION

Cross Navigation menjelaskan jalur perpindahan kontekstual antar modul yang berbeda, di luar jalur sidebar utama.

### 14.1 Dashboard → Data Barang (via Barang Hampir Habis)

```
Dashboard (Owner/Kasir)
   ↓ (klik kartu "Barang Hampir Habis")
Data Barang (Daftar Kategori)
   ↓ (klik kategori terkait barang yang hampir habis)
Detail Kategori
   ↓ (klik barang yang hampir habis pada daftar barang)
Detail Barang
```

### 14.2 Dashboard → Hutang Pelanggan (via Hutang Belum Lunas)

```
Dashboard (Owner/Kasir)
   ↓ (klik kartu "Hutang Belum Lunas" / "Hutang Pelanggan")
Hutang Pelanggan (Daftar Pelanggan)
   ↓ (klik salah satu pelanggan dengan hutang aktif)
Detail Hutang & Histori Pelanggan
```

### 14.3 Kasir → Checkout → Hutang Pelanggan (Pembuatan Hutang Otomatis)

```
Kasir (Pencarian & Keranjang)
   ↓ (klik "Checkout")
Checkout (Pilih metode Hutang / Cash + Hutang)
   ↓ (pilih/tambah data pelanggan)
Struk Transaksi (transaksi tersimpan, hutang otomatis tercatat)
   ↓ (pengguna dapat menavigasi manual)
Hutang Pelanggan → Detail Hutang & Histori Pelanggan (untuk memverifikasi hutang baru)
```

### 14.4 Data Barang → Kasir (Referensi Ketersediaan Barang)

```
Detail Barang (Data Barang)
   ↓ (barang berstatus aktif dan stok tersedia)
Kasir (Pencarian & Keranjang)
   ↓ (barang yang sama muncul pada hasil pencarian dan dapat ditambahkan ke keranjang)
```

Catatan: Ini bukan navigasi klik langsung, melainkan hubungan data (data relationship) — status dan stok barang yang diubah pada Data Barang langsung memengaruhi ketersediaan barang pada modul Kasir secara real-time.

### 14.5 Laporan → Data Barang (Referensi Barang Terlaris/Paling Menguntungkan)

```
Laporan
   ↓ (melihat daftar "Top Barang Terlaris" / "Barang Paling Menguntungkan")
   ↓ (klik nama barang pada daftar ranking, opsional)
Detail Barang
```

### 14.6 Kelola Kasir → Session (Efek Nonaktifkan Akun)

```
Kelola Kasir (Daftar Kasir)
   ↓ (Owner menonaktifkan akun Kasir yang sedang login)
Sesi Kasir tersebut ditolak pada request berikutnya
   ↓
Login (Kasir dipaksa keluar/tidak dapat mengakses halaman manapun)
```


---

## 15. PAGE ACCESS MATRIX

Tabel berikut menjelaskan hak akses (permission) dan operasi CRUD yang diizinkan untuk setiap layar, per role.

| Screen | Owner | Kasir | Permission | CRUD |
|---|---|---|---|---|
| Login | ✅ | ✅ | Akses publik (belum autentikasi) | - |
| Dashboard Owner | ✅ | ❌ | Full Access | Read |
| Dashboard Kasir | ❌ | ✅ | Full Access | Read |
| Data Barang (Daftar Kategori) | ✅ | ✅ (Read Only) | Owner: Full; Kasir: Read Only | Owner: C, R, U, D (nonaktifkan); Kasir: R |
| Detail Kategori | ✅ | ✅ (Read Only) | Owner: Full; Kasir: Read Only | Owner: R, U; Kasir: R |
| Form Tambah/Edit Kategori | ✅ | ❌ | Owner Only | C, U |
| Daftar Barang dalam Kategori | ✅ | ✅ (Read Only) | Owner: Full; Kasir: Read Only | Owner: C, R, U, D (nonaktifkan); Kasir: R |
| Detail Barang | ✅ | ✅ (Read Only) | Owner: Full; Kasir: Read Only | Owner: R, U, D (nonaktifkan); Kasir: R |
| Form Tambah Barang | ✅ | ❌ | Owner Only | C |
| Form Edit Barang | ✅ | ❌ | Owner Only | U |
| Kasir (Pencarian & Keranjang) | ✅ | ✅ | Full Access | C (keranjang sementara), R |
| Checkout | ✅ | ✅ | Full Access | C (transaksi baru) |
| Konfirmasi QRIS | ✅ | ✅ | Full Access | U (status pembayaran) |
| Form Tambah Pelanggan | ✅ | ✅ | Full Access | C |
| Struk Transaksi | ✅ | ✅ | Full Access | R |
| Hutang Pelanggan (Daftar Pelanggan) | ✅ | ✅ | Full Access | C, R |
| Detail Hutang & Histori Pelanggan | ✅ | ✅ | Full Access | R (histori tidak dapat diubah/dihapus) |
| Form Terima Pembayaran Hutang | ✅ | ✅ | Full Access | C (entri pembayaran baru) |
| Laporan | ✅ | ❌ | Owner Only | R |
| Kelola Kasir (Daftar Kasir) | ✅ | ❌ | Owner Only | C, R, U, D (nonaktifkan) |
| Detail/Form Edit Kasir | ✅ | ❌ | Owner Only | R, U, D (nonaktifkan) |
| Form Tambah Kasir | ✅ | ❌ | Owner Only | C |
| Form Reset Password Kasir | ✅ | ❌ | Owner Only | U |
| Pengaturan — Profil Toko | ✅ | ❌ | Owner Only | R, U |
| Pengaturan — QRIS | ✅ | ❌ | Owner Only | C, R, U, D |
| Pengaturan — Profil Owner | ✅ | ❌ | Owner Only | R, U |
| Profil Saya (Kasir) | ❌ | ✅ | Kasir Only (data milik sendiri) | R, U |

**Legenda:** ✅ = Dapat diakses, ❌ = Tidak dapat diakses, C = Create, R = Read, U = Update, D = Delete/Nonaktifkan.

**Catatan Kepatuhan terhadap Business Rules:**

- Pembatasan akses pada matriks ini konsisten dengan BR-ROLE-001 s.d. BR-ROLE-007 pada 03_Business_Rules.md.
- Operasi "D" (Delete) pada modul Data Barang dan Kelola Kasir selalu berarti **nonaktifkan**, bukan penghapusan permanen, sesuai BR-BRG-008 dan BR-KKS-003 (histori tidak boleh hilang).
- Modul Hutang Pelanggan tidak memiliki operasi "Delete" sama sekali pada histori hutang maupun pembayaran, sesuai BR-HTG-005 (riwayat hutang tidak boleh dihapus).

---

## 16. FUTURE INFORMATION ARCHITECTURE

Struktur navigasi berikut **belum berlaku** pada versi StoreKuify saat ini, namun dicatat sebagai referensi awal untuk pengembangan lanjutan, konsisten dengan Bagian 15 (Future Scope) pada 02_PRD.md dan Bagian 8 (Future Business Rules) pada 03_Business_Rules.md:

1. **Navigasi Multi-Toko** — jika StoreKuify mendukung multi-cabang di masa depan, diperlukan tambahan level navigasi "Pemilihan Toko/Cabang" sebelum Dashboard, serta penyesuaian pada seluruh breadcrumb menjadi `[Nama Cabang] > Dashboard > ...`.
2. **Menu Notifikasi** — kemungkinan penambahan ikon notifikasi pada Topbar untuk pemberitahuan stok menipis atau hutang jatuh tempo, dengan drill-down langsung ke Detail Barang atau Detail Hutang Pelanggan.
3. **Halaman Ekspor Laporan** — jika fitur ekspor PDF/Excel ditambahkan, diperlukan penambahan sub-halaman/modal "Ekspor Laporan" sebagai child screen dari Laporan (SCR-019).
4. **Role Supervisor** — jika role tambahan ditambahkan di antara Owner dan Kasir, diperlukan struktur navigasi ketiga (Supervisor Navigation) dengan kombinasi akses yang berbeda dari matriks saat ini.
5. **Pencarian Barcode** — jika barcode scanner ditambahkan sebagai opsi, halaman Kasir (SCR-011) akan mendapat metode input tambahan (scan barcode) yang berjalan berdampingan dengan pencarian nama, tanpa mengubah struktur navigasi utama.
6. **Halaman Program Loyalti** — jika program loyalti pelanggan ditambahkan, diperlukan child screen baru di bawah Detail Hutang & Histori Pelanggan (SCR-017) untuk menampilkan poin/reward pelanggan.

---

## 17. GLOSSARY

| Istilah | Definisi |
|---|---|
| **Information Architecture (IA)** | Struktur pengorganisasian informasi dan navigasi dalam sebuah aplikasi, mencakup hierarki halaman, menu, dan hubungan antar layar. |
| **Sidebar** | Panel navigasi utama yang persisten di sisi kiri layar, menampilkan seluruh modul utama aplikasi sesuai role pengguna. |
| **Breadcrumb** | Elemen navigasi yang menampilkan jejak posisi pengguna dalam hierarki halaman, memungkinkan navigasi cepat ke halaman induk. |
| **Screen/Layar** | Satu unit tampilan halaman atau modal yang dapat diakses pengguna dalam aplikasi. |
| **Parent Screen** | Halaman induk yang menjadi titik asal navigasi menuju suatu halaman anak (child screen). |
| **Child Screen** | Halaman anak yang diakses melalui drill-down dari halaman induknya. |
| **Drill-Down Navigation** | Pola navigasi berjenjang di mana pengguna masuk lebih dalam ke suatu hierarki data (contoh: dari daftar kategori menuju detail kategori). |
| **Cross Navigation** | Perpindahan kontekstual antar modul yang berbeda, di luar jalur sidebar utama (contoh: dari Dashboard menuju Data Barang melalui kartu "Barang Hampir Habis"). |
| **Primary Navigation** | Navigasi utama melalui sidebar untuk berpindah antar modul tingkat atas. |
| **Modal/Dialog Navigation** | Perpindahan yang menampilkan formulir/konten pada lapisan di atas halaman aktif tanpa berpindah halaman penuh. |
| **Tab Navigation** | Perpindahan antar sub-bagian dalam satu halaman yang sama menggunakan komponen tab (contoh: tab Harian/Mingguan/Bulanan/Tahunan pada Laporan). |
| **Landing Page** | Halaman pertama yang ditampilkan saat pengguna mengakses suatu modul dari sidebar (contoh: Data Barang menampilkan Daftar Kategori sebagai landing page). |
| **Role Based Visibility** | Prinsip di mana elemen navigasi hanya ditampilkan jika sesuai dengan hak akses role pengguna yang sedang login. |
| **Shallow Hierarchy** | Prinsip menjaga kedalaman hierarki halaman tetap minim (idealnya tidak lebih dari 3-4 tingkat) untuk memudahkan navigasi. |
| **Page Access Matrix** | Tabel yang memetakan hak akses (permission) dan operasi CRUD yang diizinkan untuk setiap halaman, per role pengguna. |
| **Navigation Matrix** | Tabel yang memetakan seluruh jalur perpindahan (source, destination, method) antar halaman dalam aplikasi. |
| **CRUD** | Singkatan dari Create, Read, Update, Delete — empat operasi dasar terhadap data. |

---

**— AKHIR DOKUMEN 04_Information_Architecture.md —**

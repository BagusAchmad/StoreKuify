# 05_Sitemap.md
# SITEMAP DOCUMENT
# STOREKUIFY — Web Based Grocery Store POS & Inventory Management System

---

## 1. DOCUMENT INFORMATION

| Atribut | Keterangan |
|---|---|
| Nama Dokumen | Sitemap Document — StoreKuify |
| Kode Dokumen | 05_Sitemap.md |
| Nama Proyek | StoreKuify |
| Jenis Aplikasi | Web Based Grocery Store POS & Inventory Management System |
| Bahasa Dokumen | Bahasa Indonesia |
| Sumber Kebenaran (Source of Truth) | 02_PRD.md, 03_Business_Rules.md, 04_Information_Architecture.md |
| Status Dokumen | Final Draft — Siap untuk Tahap UI Design (Stitch), Wireframe Planning, dan Frontend Development |
| Disusun Oleh | Senior Information Architect & UX Architect |
| Tanggal Dibuat | 02 Agustus 2026 |
| Confidentiality | Internal — Hanya untuk Tim Internal & Development Team |

Dokumen ini merupakan **referensi utama struktur halaman (page structure)** StoreKuify secara menyeluruh, yang menjadi acuan untuk:

- UI Design (Stitch)
- Navigation Mapping
- Wireframe Planning
- Frontend Development

Dokumen ini **BUKAN** dokumen User Flow (tidak menjelaskan alur langkah demi langkah pengguna menyelesaikan tugas) dan **BUKAN** dokumen UI Design (tidak membahas tata letak visual). Dokumen ini secara khusus menjelaskan **struktur lengkap seluruh halaman** di dalam StoreKuify: setiap halaman, setiap layar, hubungan parent-child, hierarki navigasi, visibilitas per role, halaman publik, halaman terproteksi, halaman tersembunyi, halaman modal/dialog, empty state, error page, dan loading state.

Seluruh isi dokumen ini diturunkan **sepenuhnya** dari 02_PRD.md, 03_Business_Rules.md, dan 04_Information_Architecture.md, tanpa menambahkan fitur baru, tanpa mengubah logika bisnis yang sudah ditetapkan, dan tanpa bertentangan dengan ketiga dokumen tersebut.

---

## 2. REVISION HISTORY

| Versi | Tanggal | Deskripsi Perubahan | Disusun Oleh | Disetujui Oleh |
|---|---|---|---|---|
| 0.1 | 02 Agustus 2026 | Draft awal Sitemap Document diturunkan dari 02_PRD.md, 03_Business_Rules.md, dan 04_Information_Architecture.md | Senior Information Architect & UX Architect | - |
| 1.0 | 02 Agustus 2026 | Finalisasi seluruh sitemap: Public/Owner/Kasir Sitemap, Screen Hierarchy, Modal Hierarchy, Hidden Pages, Error Pages, Empty States, Loading States, Page Inventory, Navigation Rules | Senior Information Architect & UX Architect | Product Owner |

Catatan: Setiap perubahan pada dokumen sumber (02, 03, 04) yang memengaruhi struktur halaman wajib disinkronkan ke dokumen ini dengan menambahkan baris revisi baru.

---

## 3. TABLE OF CONTENTS

1. Document Information
2. Revision History
3. Table of Contents
4. Introduction
5. Sitemap Principles
6. Public Sitemap
7. Owner Sitemap
8. Kasir Sitemap
9. Screen Hierarchy
10. Modal Hierarchy
11. Hidden Pages
12. Error Pages
13. Empty States
14. Loading States
15. Page Inventory
16. Navigation Rules
17. Future Sitemap
18. Glossary

---

## 4. INTRODUCTION

Dokumen Sitemap ini menjabarkan **struktur lengkap seluruh halaman** yang ada pada StoreKuify — aplikasi kasir dan manajemen toko untuk Warung Kelontong dengan dua role pengguna: **Owner** dan **Kasir**.

Berbeda dengan 04_Information_Architecture.md yang berfokus pada navigasi, hierarki menu, dan hubungan antar layar tingkat tinggi, dokumen ini memperluas cakupan tersebut hingga mencakup **seluruh jenis halaman** yang mungkin ditemui pengguna, termasuk:

- Halaman publik (Login) dan halaman terproteksi (memerlukan autentikasi).
- Halaman yang disembunyikan dari navigasi (hidden pages) namun tetap dapat diakses melalui rute tertentu.
- Halaman modal/dialog yang muncul di atas halaman aktif.
- Kondisi tampilan halaman ketika data kosong (empty states).
- Kondisi tampilan halaman ketika sedang memuat data (loading states).
- Halaman kesalahan sistem (error pages) seperti 401, 403, 404, 419, 500, Network Error, Maintenance, dan Session Expired.

Dokumen ini menjadi acuan tunggal bagi tim UI Design dan Frontend Development untuk memastikan **tidak ada halaman yang terlewat** saat proses desain maupun implementasi, dan bahwa setiap kondisi tampilan (normal, kosong, memuat, error) telah terdefinisi dengan jelas.

---

## 5. SITEMAP PRINCIPLES

| Prinsip | Penjelasan |
|---|---|
| **Single Source of Truth** | Seluruh halaman pada sitemap ini harus dapat ditelusuri kembali ke modul yang didefinisikan pada 02_PRD.md dan 03_Business_Rules.md. |
| **Role Visibility Explicit** | Setiap halaman secara eksplisit menyatakan visibilitasnya terhadap role Owner dan/atau Kasir. |
| **Public vs Protected** | Sitemap membedakan dengan jelas halaman yang dapat diakses tanpa login (Public) dan halaman yang memerlukan sesi aktif (Protected). |
| **No Orphan Page** | Setiap halaman (kecuali Login dan Error Pages) harus memiliki minimal satu Parent Page yang jelas, tidak ada halaman yang berdiri sendiri tanpa jalur masuk. |
| **State Completeness** | Setiap halaman yang menampilkan data harus memiliki definisi Loading State dan Empty State, selain tampilan normal (data tersedia). |
| **Error Resilience** | Sitemap mendefinisikan seluruh kemungkinan halaman error (401, 403, 404, 419, 500, Network Error, Maintenance, Session Expired) agar aplikasi memiliki penanganan yang konsisten terhadap kegagalan. |
| **Modal Isolation** | Halaman modal/dialog tidak mengubah URL/breadcrumb halaman induk; modal dianggap sebagai lapisan tambahan di atas halaman aktif, bukan halaman baru dalam hierarki navigasi utama. |
| **Consistent Hierarchy dengan IA** | Hierarki pada dokumen ini selaras sepenuhnya dengan Page Hierarchy dan Sidebar Structure pada 04_Information_Architecture.md, tanpa penambahan atau pengurangan struktur. |


---

## 6. PUBLIC SITEMAP

Halaman publik adalah halaman yang dapat diakses **tanpa autentikasi (belum login)**. Pada StoreKuify, hanya terdapat satu halaman publik utama beserta halaman error yang dapat muncul sebelum autentikasi.

```
PUBLIC SITEMAP
│
├── Login
│     └── (Redirect setelah sukses) → Dashboard (Owner/Kasir, sesuai role)
│
├── 404 - Halaman Tidak Ditemukan (dapat diakses tanpa login, contoh: salah ketik URL)
├── 500 - Kesalahan Server
├── Network Error - Kesalahan Koneksi
└── Maintenance - Halaman Pemeliharaan Sistem
```

**Karakteristik Halaman Publik:**

| Halaman | Autentikasi Diperlukan | Keterangan |
|---|---|---|
| Login | Tidak | Titik masuk satu-satunya ke seluruh sistem StoreKuify. |
| 404 - Halaman Tidak Ditemukan | Tidak | Dapat muncul kapan pun, baik sebelum maupun sesudah login. |
| 500 - Kesalahan Server | Tidak | Dapat muncul kapan pun akibat kegagalan sistem di backend. |
| Network Error | Tidak | Dapat muncul kapan pun akibat kegagalan koneksi internet perangkat pengguna. |
| Maintenance | Tidak | Ditampilkan ketika sistem sedang dalam masa pemeliharaan terjadwal. |

Tidak ada halaman lain di StoreKuify yang dapat diakses tanpa login; seluruh modul fungsional (Dashboard, Data Barang, Kasir, Hutang Pelanggan, Laporan, Kelola Kasir, Pengaturan, Profil Saya) bersifat **Protected Pages** dan memerlukan sesi login aktif, sesuai BR-SEC-006 dan BR-ROLE pada 03_Business_Rules.md.

---

## 7. OWNER SITEMAP

Berikut adalah hierarki lengkap halaman yang dapat diakses oleh role **Owner**, sesuai Owner Navigation pada 04_Information_Architecture.md.

```
OWNER SITEMAP
│
├── Dashboard (Owner)
│
├── Data Barang
│     └── Kategori (Daftar Kategori)
│           └── Detail Kategori
│                 └── Barang (Daftar Barang dalam Kategori)
│                       └── Detail Barang
│                             ├── Edit Barang (Modal)
│                             └── Nonaktifkan Barang (Modal Konfirmasi)
│                       └── Tambah Barang (Modal)
│           └── Tambah Kategori (Modal)
│           └── Edit Kategori (Modal)
│
├── Kasir
│     └── Keranjang (Embedded)
│           └── Checkout
│                 └── QRIS (Konfirmasi Pembayaran, kondisional)
│                 └── Tambah Pelanggan (Modal, kondisional untuk Hutang/Cash+Hutang)
│                 └── Struk (Halaman Hasil Transaksi)
│
├── Hutang
│     └── Daftar Pelanggan
│           └── Detail Hutang
│                 └── Pembayaran Hutang (Modal)
│           └── Tambah Pelanggan (Modal)
│
├── Laporan
│     ├── Harian
│     ├── Mingguan
│     ├── Bulanan
│     ├── Tahunan
│     └── Custom Range
│
├── Kelola Kasir
│     └── Daftar Kasir
│           └── Tambah Kasir (Modal/Halaman)
│           └── Edit Kasir
│                 └── Reset Password (Modal)
│                 └── Nonaktifkan Kasir (Modal Konfirmasi)
│
└── Pengaturan
      ├── Profil Toko
      ├── QRIS
      └── Profil Owner
```

**Catatan Owner Sitemap:**

- Owner memiliki akses ke **seluruh 8 modul utama**: Dashboard, Data Barang, Kasir, Hutang, Laporan, Kelola Kasir, dan Pengaturan (sesuai Role Access Matrix pada 02_PRD.md Bagian 7.3).
- Modul **Laporan**, **Kelola Kasir**, dan **Pengaturan** hanya muncul pada Owner Sitemap, tidak muncul sama sekali pada Kasir Sitemap (BR-ROLE-004, BR-ROLE-005, BR-ROLE-006).
- Owner tidak memiliki halaman "Profil Saya" tersendiri; fungsi setara tersedia melalui **Pengaturan → Profil Owner**.

---

## 8. KASIR SITEMAP

Berikut adalah hierarki lengkap halaman yang dapat diakses oleh role **Kasir**, sesuai Kasir Navigation pada 04_Information_Architecture.md.

```
KASIR SITEMAP
│
├── Dashboard (Kasir)
│
├── Data Barang (Read Only)
│     └── Kategori (Daftar Kategori) — Read Only
│           └── Detail Kategori — Read Only
│                 └── Barang (Daftar Barang dalam Kategori) — Read Only
│                       └── Detail Barang — Read Only
│
├── Kasir
│     └── Keranjang (Embedded)
│           └── Checkout
│                 └── QRIS (Konfirmasi Pembayaran, kondisional)
│                 └── Tambah Pelanggan (Modal, kondisional untuk Hutang/Cash+Hutang)
│                 └── Struk (Halaman Hasil Transaksi)
│
├── Hutang
│     └── Daftar Pelanggan
│           └── Detail Hutang
│                 └── Pembayaran Hutang (Modal)
│           └── Tambah Pelanggan (Modal)
│
└── Profil Saya
      ├── Ubah Username
      ├── Ubah Password
      └── Ubah Foto Profil
```

**Catatan Kasir Sitemap:**

- Modul **Data Barang** pada Kasir Sitemap bersifat sepenuhnya **Read Only** — seluruh tombol aksi Tambah/Edit/Nonaktifkan **tidak ditampilkan** (BR-ROLE-003, BR-BRG-013).
- Modul **Laporan**, **Kelola Kasir**, dan **Pengaturan** **tidak muncul** pada Kasir Sitemap, baik sebagai item navigasi maupun sebagai rute yang dapat diakses langsung (percobaan akses langsung menghasilkan 403 - lihat Bagian 12).
- Halaman **Profil Saya** hanya muncul pada Kasir Sitemap, digunakan untuk mengubah data akun milik Kasir sendiri (BR-KKS-006).


---

## 9. SCREEN HIERARCHY

Hierarki lengkap seluruh layar StoreKuify (gabungan Owner dan Kasir, dengan penanda role pada setiap cabang), disusun sebagai diagram alur turunan (top-down hierarchy):

```
Login
  ↓
Dashboard
  ↓
Data Barang
  ↓
Kategori
  ↓
Detail Kategori
  ↓
Barang
  ↓
Detail Barang
  ↓
Tambah Barang [Modal — Owner Only]
  ↓
Edit Barang [Modal — Owner Only]
```

```
Kasir
  ↓
Keranjang
  ↓
Checkout
  ↓
QRIS
  ↓
Struk
```

```
Hutang
  ↓
Daftar Pelanggan
  ↓
Detail Hutang
  ↓
Pembayaran Hutang [Modal]
```

```
Laporan [Owner Only]
  ↓
Harian
  ↓
Mingguan
  ↓
Bulanan
  ↓
Tahunan
  ↓
Custom Range
```

```
Kelola Kasir [Owner Only]
  ↓
Daftar Kasir
  ↓
Tambah Kasir [Modal]
  ↓
Edit Kasir
  ↓
Reset Password [Modal]
```

```
Pengaturan [Owner Only]
  ↓
Profil Toko
  ↓
QRIS
  ↓
Profil Owner
```

```
Profil Saya [Kasir Only]
  ↓
Ubah Username
  ↓
Ubah Password
  ↓
Ubah Foto Profil
```

### 9.1 Diagram Hierarki Gabungan (Full Tree)

```
StoreKuify
│
├── Login  [Public]
│
├── Dashboard  [Protected — Owner/Kasir, tampilan berbeda per role]
│
├── Data Barang  [Protected — Owner: Full Access, Kasir: Read Only]
│     └── Kategori
│           └── Detail Kategori
│                 └── Barang
│                       └── Detail Barang
│                             ├── Tambah Barang  [Modal — Owner Only]
│                             └── Edit Barang  [Modal — Owner Only]
│                                   └── Nonaktifkan Barang  [Modal Konfirmasi — Owner Only]
│           ├── Tambah Kategori  [Modal — Owner Only]
│           └── Edit Kategori  [Modal — Owner Only]
│
├── Kasir  [Protected — Owner & Kasir]
│     └── Keranjang  [Embedded dalam halaman Kasir]
│           └── Checkout
│                 ├── QRIS  [Kondisional — jika metode QRIS dipilih]
│                 ├── Tambah Pelanggan  [Modal — kondisional untuk Hutang/Cash+Hutang]
│                 └── Struk  [Halaman hasil transaksi]
│
├── Hutang  [Protected — Owner & Kasir]
│     └── Daftar Pelanggan
│           └── Detail Hutang
│                 └── Pembayaran Hutang  [Modal]
│           └── Tambah Pelanggan  [Modal]
│
├── Laporan  [Protected — Owner Only]
│     ├── Harian
│     ├── Mingguan
│     ├── Bulanan
│     ├── Tahunan
│     └── Custom Range
│
├── Kelola Kasir  [Protected — Owner Only]
│     └── Daftar Kasir
│           ├── Tambah Kasir  [Modal/Halaman]
│           └── Edit Kasir
│                 ├── Reset Password  [Modal]
│                 └── Nonaktifkan Kasir  [Modal Konfirmasi]
│
├── Pengaturan  [Protected — Owner Only]
│     ├── Profil Toko
│     ├── QRIS
│     └── Profil Owner
│
├── Profil Saya  [Protected — Kasir Only]
│     ├── Ubah Username
│     ├── Ubah Password
│     └── Ubah Foto Profil
│
└── Error Pages  [Public/Protected — muncul kondisional]
      ├── 401 - Unauthorized
      ├── 403 - Forbidden
      ├── 404 - Not Found
      ├── 419 - Session Expired (Page Expired)
      ├── 500 - Internal Server Error
      ├── Network Error
      ├── Maintenance
      └── Session Expired (redirect ke Login)
```

---

## 10. MODAL HIERARCHY

Modal/Dialog pada StoreKuify tidak menghasilkan perubahan URL/breadcrumb; modal selalu muncul di atas halaman induknya (parent page). Berikut hierarki lengkap seluruh modal pada StoreKuify.

```
MODAL HIERARCHY
│
├── Data Barang
│     ├── Tambah Kategori  (Parent: Kategori/Data Barang)
│     ├── Edit Kategori  (Parent: Detail Kategori)
│     ├── Tambah Barang  (Parent: Barang/Daftar Barang dalam Kategori)
│     ├── Edit Barang  (Parent: Detail Barang)
│     └── Nonaktifkan Barang  (Parent: Detail Barang — Modal Konfirmasi)
│
├── Kasir
│     ├── Konfirmasi QRIS  (Parent: Checkout)
│     ├── Tambah Pelanggan  (Parent: Checkout — kondisional)
│     └── Cancel Checkout Confirmation  (Parent: Checkout — Modal Konfirmasi)
│
├── Hutang
│     ├── Tambah Pelanggan  (Parent: Daftar Pelanggan)
│     └── Pembayaran Hutang  (Parent: Detail Hutang)
│
├── Kelola Kasir
│     ├── Tambah Kasir  (Parent: Daftar Kasir)
│     ├── Reset Password  (Parent: Edit Kasir)
│     └── Nonaktifkan Kasir  (Parent: Edit Kasir — Modal Konfirmasi)
│
├── Pengaturan
│     └── Ganti QRIS Confirmation  (Parent: Pengaturan — QRIS — Modal Konfirmasi, opsional)
│
└── Global (Muncul di Halaman Manapun)
      ├── Logout Confirmation  (Parent: Halaman Manapun, dipicu dari Topbar)
      ├── Delete Confirmation  (Parent: Halaman Manapun yang memiliki aksi hapus/nonaktifkan)
      └── Unsaved Changes Confirmation  (Parent: Halaman Manapun yang memiliki form belum tersimpan)
```

### 10.1 Tabel Ringkasan Modal

| Modal | Parent Page | Trigger | Role |
|---|---|---|---|
| Tambah Kategori | Data Barang (Kategori) | Klik tombol "Tambah Kategori" | Owner |
| Edit Kategori | Detail Kategori | Klik tombol "Edit" pada Detail Kategori | Owner |
| Tambah Barang | Daftar Barang dalam Kategori | Klik tombol "Tambah Barang" | Owner |
| Edit Barang | Detail Barang | Klik tombol "Edit" pada Detail Barang | Owner |
| Nonaktifkan Barang | Detail Barang | Klik tombol "Nonaktifkan" | Owner |
| Konfirmasi QRIS | Checkout | Memilih metode pembayaran "QRIS" | Owner, Kasir |
| Tambah Pelanggan (dari Kasir) | Checkout | Klik "Tambah Pelanggan Baru" saat metode Hutang/Cash+Hutang | Owner, Kasir |
| Tambah Pelanggan (dari Hutang) | Daftar Pelanggan | Klik tombol "Tambah Pelanggan" | Owner, Kasir |
| Pembayaran Hutang | Detail Hutang | Klik tombol "Terima Pembayaran" | Owner, Kasir |
| Tambah Kasir | Daftar Kasir | Klik tombol "Tambah Kasir" | Owner |
| Reset Password | Edit Kasir | Klik tombol "Reset Password" | Owner |
| Nonaktifkan Kasir | Edit Kasir | Klik tombol "Nonaktifkan" | Owner |
| Logout Confirmation | Halaman manapun | Klik "Logout" pada Topbar | Owner, Kasir |
| Delete Confirmation | Halaman manapun dengan aksi hapus/nonaktifkan | Klik tombol hapus/nonaktifkan | Owner |
| Unsaved Changes Confirmation | Halaman manapun dengan form aktif | Menutup/berpindah halaman dengan form belum disimpan | Owner, Kasir |


---

## 11. HIDDEN PAGES

Hidden Pages adalah halaman yang **tidak muncul pada sidebar/menu navigasi**, namun tetap dapat diakses melalui rute tertentu (drill-down, cross-navigation, atau URL langsung bagi pengguna yang berwenang).

| Halaman Tersembunyi | Alasan Disembunyikan dari Menu | Cara Mengakses | Role |
|---|---|---|---|
| Detail Kategori | Bukan item menu utama, hanya dapat diakses melalui drill-down dari Data Barang | Klik salah satu kategori pada Daftar Kategori | Owner, Kasir |
| Detail Barang | Bukan item menu utama, hanya dapat diakses melalui drill-down dari Daftar Barang | Klik salah satu barang pada Daftar Barang dalam Kategori | Owner, Kasir |
| Checkout | Bukan item menu utama, merupakan kelanjutan dari halaman Kasir | Klik tombol "Checkout" pada halaman Kasir | Owner, Kasir |
| Struk | Bukan item menu utama, hanya muncul sebagai hasil transaksi berhasil | Otomatis muncul setelah checkout berhasil | Owner, Kasir |
| Detail Hutang & Histori Pelanggan | Bukan item menu utama, hanya dapat diakses melalui drill-down dari Daftar Pelanggan | Klik salah satu pelanggan pada Daftar Pelanggan | Owner, Kasir |
| Detail/Edit Kasir | Bukan item menu utama, hanya dapat diakses melalui drill-down dari Daftar Kasir | Klik salah satu akun Kasir pada Daftar Kasir | Owner |
| Laporan — Harian/Mingguan/Bulanan/Tahunan/Custom Range | Merupakan tab di dalam satu halaman Laporan, bukan item sidebar terpisah | Klik tab periode pada halaman Laporan | Owner |
| Pengaturan — QRIS, Pengaturan — Profil Owner | Merupakan tab di dalam halaman Pengaturan, bukan item sidebar terpisah | Klik tab terkait pada halaman Pengaturan | Owner |

**Aturan Hidden Pages:**

1. Hidden Pages **tetap dilindungi** oleh Page Access Matrix yang sama seperti halaman biasa (sesuai Bagian 15 pada 04_Information_Architecture.md); tersembunyi dari menu tidak berarti dapat diakses bebas oleh role yang tidak berwenang.
2. Jika pengguna dengan role yang tidak berwenang mencoba mengakses Hidden Page secara langsung melalui URL, sistem menampilkan halaman **403 - Forbidden** (lihat Bagian 12).
3. Hidden Pages tetap memiliki breadcrumb lengkap sesuai Bagian 13 pada 04_Information_Architecture.md, meskipun tidak muncul di sidebar.

---

## 12. ERROR PAGES

Berikut adalah seluruh halaman error yang didefinisikan pada StoreKuify, lengkap dengan kondisi pemicu dan perilaku sistem.

| Kode/Nama Error | Nama Halaman | Kondisi Pemicu | Isi Halaman | Aksi yang Tersedia |
|---|---|---|---|---|
| **401** | Unauthorized | Pengguna mengakses halaman/endpoint terproteksi tanpa sesi login aktif sama sekali | Pesan "Anda perlu login untuk mengakses halaman ini" | Tombol "Login" mengarah ke halaman Login |
| **403** | Forbidden | Pengguna login namun mencoba mengakses halaman/aksi di luar hak akses role-nya (contoh: Kasir mencoba mengakses Laporan) | Pesan "403 - Anda tidak memiliki akses ke halaman ini" (sesuai BR-ROLE-003 s.d. BR-ROLE-007) | Tombol "Kembali ke Dashboard" |
| **404** | Not Found | Pengguna mengakses URL/rute yang tidak terdaftar dalam sistem | Pesan "Halaman yang Anda cari tidak ditemukan" | Tombol "Kembali ke Dashboard" atau "Kembali ke Login" (jika belum login) |
| **419** | Page Expired / Session Expired (Form Token) | Token keamanan form (CSRF token) kedaluwarsa saat submit form (sesuai SEC-05 pada 02_PRD.md) | Pesan "Sesi form telah kedaluwarsa, silakan muat ulang halaman" | Tombol "Muat Ulang Halaman" |
| **500** | Internal Server Error | Terjadi kesalahan tak terduga pada sisi server/backend | Pesan umum "Terjadi kesalahan pada sistem, silakan coba lagi" beserta kode referensi (sesuai BR-ERR-002) | Tombol "Coba Lagi" atau "Kembali ke Dashboard" |
| **Network Error** | Kesalahan Koneksi | Koneksi internet pengguna terputus saat berinteraksi dengan sistem | Pesan "Koneksi internet Anda terputus, silakan periksa jaringan Anda" | Tombol "Coba Lagi" |
| **Maintenance** | Halaman Pemeliharaan | Sistem sedang dalam masa pemeliharaan terjadwal | Pesan "StoreKuify sedang dalam pemeliharaan, silakan coba beberapa saat lagi" | Tidak ada aksi lain selain menunggu; halaman menampilkan estimasi waktu jika tersedia |
| **Session Expired** | Sesi Berakhir | Sesi login pengguna kedaluwarsa saat sedang menggunakan aplikasi (termasuk saat transaksi berlangsung, sesuai BR-ERR-005) | Pesan "Sesi Anda telah berakhir, silakan login kembali" | Redirect otomatis ke halaman Login; data keranjang disimpan sementara jika memungkinkan secara teknis |

**Catatan Konsistensi dengan Business Rules:**

- Halaman 403 konsisten dengan BR-ROLE-003, BR-ROLE-004, BR-ROLE-005, BR-ROLE-006, dan BR-ROLE-007 pada 03_Business_Rules.md.
- Halaman Session Expired konsisten dengan BR-ERR-005 pada 03_Business_Rules.md.
- Halaman 500 mengikuti prinsip tidak menampilkan detail teknis (stack trace) kepada pengguna akhir, sesuai NFR terkait Error Handling pada 02_PRD.md.

---

## 13. EMPTY STATES

Empty State adalah tampilan yang muncul ketika suatu halaman belum memiliki data untuk ditampilkan. Berikut definisi Empty State untuk setiap modul StoreKuify.

| Halaman | Kondisi Empty State | Pesan yang Ditampilkan | Aksi yang Ditawarkan |
|---|---|---|---|
| Dashboard (Owner) | Belum ada transaksi hari ini | "Belum ada transaksi hari ini" | Tombol "Mulai Transaksi" mengarah ke halaman Kasir |
| Dashboard (Kasir) | Belum ada transaksi hari ini | "Belum ada transaksi hari ini" | Tombol "Mulai Transaksi" mengarah ke halaman Kasir |
| Dashboard — Barang Hampir Habis | Tidak ada barang dengan stok di bawah ambang batas | "Semua stok barang aman" | Tidak ada aksi (informasional) |
| Dashboard — Hutang Belum Lunas | Tidak ada hutang pelanggan yang belum lunas | "Tidak ada hutang yang belum lunas" | Tidak ada aksi (informasional) |
| Data Barang — Daftar Kategori | Belum ada kategori yang dibuat | "Belum ada kategori. Silakan buat kategori terlebih dahulu" | Tombol "Tambah Kategori" (Owner only) |
| Data Barang — Daftar Barang dalam Kategori | Belum ada barang di dalam kategori tersebut | "Belum ada barang di kategori ini" | Tombol "Tambah Barang" (Owner only) |
| Kasir — Hasil Pencarian | Barang yang dicari tidak ditemukan | "Barang tidak ditemukan" | Saran untuk mencoba kata kunci lain |
| Kasir — Keranjang | Keranjang belum berisi barang apa pun | "Keranjang masih kosong, silakan cari dan tambahkan barang" | Fokus otomatis ke kolom pencarian |
| Hutang Pelanggan — Daftar Pelanggan | Belum ada data pelanggan | "Belum ada pelanggan. Silakan tambah pelanggan terlebih dahulu" | Tombol "Tambah Pelanggan" |
| Hutang Pelanggan — Detail Hutang | Pelanggan belum memiliki histori hutang | "Belum ada histori hutang untuk pelanggan ini" | Tidak ada aksi (informasional) |
| Laporan (seluruh periode) | Tidak ada transaksi pada periode yang dipilih | "Tidak ada data transaksi pada periode ini" | Saran untuk mengganti periode/rentang tanggal |
| Laporan — Ranking Barang | Tidak ada data penjualan barang pada periode tersebut | "Belum ada data untuk periode ini" | Tidak ada aksi (informasional) |
| Kelola Kasir — Daftar Kasir | Belum ada akun Kasir yang dibuat oleh Owner | "Belum ada akun Kasir. Silakan tambah akun Kasir" | Tombol "Tambah Kasir" |

**Catatan Empty State:**

Seluruh Empty State pada tabel di atas ditulis dalam Bahasa Indonesia yang jelas, sejalan dengan BR-ERR-001 pada 03_Business_Rules.md, dan tidak menggunakan istilah teknis yang membingungkan pengguna non-teknis.

---

## 14. LOADING STATES

Loading State adalah tampilan sementara yang muncul saat sistem sedang memuat data dari server. Berikut definisi Loading State untuk setiap modul utama StoreKuify.

| Halaman | Elemen yang Menampilkan Loading | Perilaku Sistem |
|---|---|---|
| Dashboard | Kartu ringkasan (Penjualan, Keuntungan, Transaksi, Barang Terjual), Grafik Penjualan, Daftar Barang Hampir Habis, Ringkasan Hutang | Menampilkan skeleton/placeholder pada masing-masing kartu dan grafik selama data diambil dari server; tidak memblokir seluruh halaman |
| Data Barang | Daftar Kategori, Detail Kategori, Daftar Barang, Detail Barang | Menampilkan skeleton list/table saat memuat daftar; spinner pada tombol saat submit form Tambah/Edit |
| Kasir | Hasil Pencarian Barang | Menampilkan indikator loading kecil di bawah kolom pencarian saat live search sedang memproses permintaan |
| Checkout | Proses "Selesaikan Transaksi" | Tombol berubah menjadi status loading (disabled + spinner) untuk mencegah submit ganda selama validasi stok dan penyimpanan transaksi berlangsung |
| Laporan | Data agregat, Grafik, Ranking Barang | Menampilkan skeleton pada kartu ringkasan dan grafik saat filter periode/tanggal diterapkan |
| Hutang | Daftar Pelanggan, Detail Hutang & Histori | Menampilkan skeleton list saat memuat daftar pelanggan; spinner pada tombol saat submit Pembayaran Hutang |
| Kelola Kasir | Daftar Kasir, Detail/Edit Kasir | Menampilkan skeleton list saat memuat daftar akun; spinner pada tombol saat submit Tambah Kasir/Reset Password |
| Pengaturan | Profil Toko, QRIS, Profil Owner | Menampilkan skeleton form saat memuat data pengaturan; spinner pada tombol "Simpan" saat submit perubahan |

**Aturan Umum Loading State:**

1. Loading State tidak boleh memblokir elemen navigasi (sidebar, breadcrumb, topbar) tetap dapat digunakan pengguna selama data dimuat, kecuali pada proses submit transaksi (Checkout) yang wajib mengunci tombol aksi untuk mencegah duplikasi data.
2. Loading State pada tabel/daftar menggunakan pola skeleton (bentuk placeholder menyerupai konten asli), bukan spinner penuh layar, untuk menjaga kesan responsif sesuai NFR-01 dan NFR-02 pada 02_PRD.md.


---

## 15. PAGE INVENTORY

Tabel berikut mendaftarkan **seluruh halaman** StoreKuify (halaman utama, halaman tersembunyi, modal, dan halaman error) lengkap dengan Page ID, Role, Parent Page, Child Page, Purpose, Access, dan Navigation.

| Page ID | Page Name | Role | Parent Page | Child Page | Purpose | Access | Navigation |
|---|---|---|---|---|---|---|---|
| PG-001 | Login | Owner, Kasir | - | Dashboard | Autentikasi pengguna ke sistem | Public | Redirect |
| PG-002 | Dashboard (Owner) | Owner | Login | Data Barang, Hutang | Ringkasan bisnis harian: penjualan, keuntungan, transaksi, grafik, stok, hutang | Protected | Primary Navigation |
| PG-003 | Dashboard (Kasir) | Kasir | Login | Data Barang, Hutang | Ringkasan operasional harian tanpa data keuntungan | Protected | Primary Navigation |
| PG-004 | Data Barang (Kategori) | Owner, Kasir (Read Only) | Dashboard | Detail Kategori, Tambah Kategori | Menampilkan daftar kategori sebagai halaman induk Data Barang | Protected | Primary Navigation |
| PG-005 | Detail Kategori | Owner, Kasir (Read Only) | Data Barang (Kategori) | Barang, Edit Kategori | Menampilkan informasi kategori dan daftar barang di dalamnya | Protected (Hidden dari sidebar) | Drill-Down |
| PG-006 | Barang (Daftar Barang dalam Kategori) | Owner, Kasir (Read Only) | Detail Kategori | Detail Barang, Tambah Barang | Menampilkan daftar barang dalam kategori tertentu | Protected (Embedded) | Drill-Down |
| PG-007 | Detail Barang | Owner, Kasir (Read Only) | Barang | Edit Barang, Nonaktifkan Barang | Menampilkan detail lengkap satu barang | Protected (Hidden dari sidebar) | Drill-Down |
| PG-008 | Tambah Barang | Owner | Barang | - | Form menambah barang baru ke kategori | Protected | Modal |
| PG-009 | Edit Barang | Owner | Detail Barang | - | Form mengubah data barang | Protected | Modal |
| PG-010 | Tambah Kategori | Owner | Data Barang (Kategori) | - | Form menambah kategori baru | Protected | Modal |
| PG-011 | Edit Kategori | Owner | Detail Kategori | - | Form mengubah nama kategori | Protected | Modal |
| PG-012 | Kasir | Owner, Kasir | Dashboard | Keranjang, Checkout | Halaman pencarian barang dan pengelolaan keranjang transaksi | Protected | Primary Navigation |
| PG-013 | Keranjang | Owner, Kasir | Kasir | Checkout | Menampilkan daftar barang yang akan dibeli beserta subtotal | Protected (Embedded) | Embedded |
| PG-014 | Checkout | Owner, Kasir | Keranjang | QRIS, Tambah Pelanggan, Struk | Menyelesaikan transaksi dengan memilih metode pembayaran | Protected (Hidden dari sidebar) | Drill-Down (Action) |
| PG-015 | QRIS (Konfirmasi Pembayaran) | Owner, Kasir | Checkout | Struk | Menampilkan gambar QRIS statis dan konfirmasi pembayaran manual | Protected | Modal/Conditional |
| PG-016 | Struk | Owner, Kasir | Checkout / QRIS | Kasir (kembali) | Menampilkan ringkasan transaksi setelah checkout berhasil | Protected (Hidden dari sidebar) | Redirect (Post-Success) |
| PG-017 | Hutang (Daftar Pelanggan) | Owner, Kasir | Dashboard | Detail Hutang, Tambah Pelanggan | Menampilkan daftar pelanggan dan status hutang | Protected | Primary Navigation |
| PG-018 | Detail Hutang | Owner, Kasir | Daftar Pelanggan | Pembayaran Hutang | Menampilkan histori hutang dan pembayaran pelanggan | Protected (Hidden dari sidebar) | Drill-Down |
| PG-019 | Pembayaran Hutang | Owner, Kasir | Detail Hutang | - | Form mencatat pembayaran hutang (sebagian/lunas) | Protected | Modal |
| PG-020 | Tambah Pelanggan | Owner, Kasir | Daftar Pelanggan / Checkout | - | Form menambah data pelanggan baru | Protected | Modal |
| PG-021 | Laporan | Owner | Dashboard | Harian, Mingguan, Bulanan, Tahunan, Custom Range | Menampilkan laporan penjualan dan keuntungan | Protected | Primary Navigation |
| PG-022 | Laporan — Harian | Owner | Laporan | - | Menampilkan laporan periode harian | Protected (Hidden, berupa tab) | Tab Navigation |
| PG-023 | Laporan — Mingguan | Owner | Laporan | - | Menampilkan laporan periode mingguan | Protected (Hidden, berupa tab) | Tab Navigation |
| PG-024 | Laporan — Bulanan | Owner | Laporan | - | Menampilkan laporan periode bulanan | Protected (Hidden, berupa tab) | Tab Navigation |
| PG-025 | Laporan — Tahunan | Owner | Laporan | - | Menampilkan laporan periode tahunan | Protected (Hidden, berupa tab) | Tab Navigation |
| PG-026 | Laporan — Custom Range | Owner | Laporan | - | Menampilkan laporan berdasarkan rentang tanggal kustom | Protected (Hidden, berupa tab) | Tab Navigation |
| PG-027 | Kelola Kasir (Daftar Kasir) | Owner | Dashboard | Tambah Kasir, Edit Kasir | Menampilkan daftar akun Kasir | Protected | Primary Navigation |
| PG-028 | Tambah Kasir | Owner | Daftar Kasir | - | Form membuat akun Kasir baru | Protected | Modal/Halaman |
| PG-029 | Edit Kasir | Owner | Daftar Kasir | Reset Password, Nonaktifkan Kasir | Mengubah data akun Kasir (nama, username) | Protected (Hidden dari sidebar) | Drill-Down |
| PG-030 | Reset Password | Owner | Edit Kasir | - | Form mereset password akun Kasir tanpa password lama | Protected | Modal |
| PG-031 | Nonaktifkan Kasir | Owner | Edit Kasir | - | Modal konfirmasi menonaktifkan akun Kasir | Protected | Modal Konfirmasi |
| PG-032 | Pengaturan — Profil Toko | Owner | Dashboard | QRIS, Profil Owner | Mengubah Nama Toko, Alamat Toko, Logo | Protected | Primary Navigation / Tab |
| PG-033 | Pengaturan — QRIS | Owner | Profil Toko | - | Mengunggah/mengganti/menghapus gambar QRIS statis | Protected (Hidden, berupa tab) | Tab Navigation |
| PG-034 | Pengaturan — Profil Owner | Owner | Profil Toko | - | Mengubah nama, username, password, foto profil Owner | Protected (Hidden, berupa tab) | Tab Navigation |
| PG-035 | Profil Saya | Kasir | Dashboard | Ubah Username, Ubah Password, Ubah Foto Profil | Halaman induk pengaturan profil milik Kasir sendiri | Protected | Primary Navigation |
| PG-036 | Ubah Username | Kasir | Profil Saya | - | Form mengubah username akun Kasir sendiri | Protected (Embedded) | Embedded Form Section |
| PG-037 | Ubah Password | Kasir | Profil Saya | - | Form mengubah password akun Kasir sendiri | Protected (Embedded) | Embedded Form Section |
| PG-038 | Ubah Foto Profil | Kasir | Profil Saya | - | Form mengubah foto profil akun Kasir sendiri | Protected (Embedded) | Embedded Form Section |
| PG-039 | Nonaktifkan Barang | Owner | Detail Barang | - | Modal konfirmasi menonaktifkan barang | Protected | Modal Konfirmasi |
| PG-040 | Logout Confirmation | Owner, Kasir | Halaman manapun | Login | Modal konfirmasi sebelum logout | Protected | Modal Konfirmasi |
| PG-041 | Delete Confirmation | Owner | Halaman manapun dengan aksi hapus/nonaktifkan | - | Modal konfirmasi generik untuk aksi nonaktifkan/hapus | Protected | Modal Konfirmasi |
| PG-042 | 401 - Unauthorized | Owner, Kasir (belum login) | - | Login | Menampilkan pesan bahwa pengguna perlu login | Public | Error Page |
| PG-043 | 403 - Forbidden | Owner, Kasir | Halaman manapun yang diakses tanpa hak | Dashboard | Menampilkan pesan akses ditolak sesuai role | Protected | Error Page |
| PG-044 | 404 - Not Found | Owner, Kasir, Publik | - | Dashboard/Login | Menampilkan pesan halaman tidak ditemukan | Public/Protected | Error Page |
| PG-045 | 419 - Page Expired | Owner, Kasir | Halaman dengan form aktif | Halaman yang sama (reload) | Menampilkan pesan token form kedaluwarsa | Protected | Error Page |
| PG-046 | 500 - Internal Server Error | Owner, Kasir, Publik | - | Dashboard/Login | Menampilkan pesan kesalahan sistem umum | Public/Protected | Error Page |
| PG-047 | Network Error | Owner, Kasir, Publik | - | - | Menampilkan pesan koneksi internet terputus | Public/Protected | Error Page |
| PG-048 | Maintenance | Owner, Kasir, Publik | - | - | Menampilkan pesan sistem sedang pemeliharaan | Public | Error Page |
| PG-049 | Session Expired | Owner, Kasir | Halaman manapun saat sesi aktif | Login | Menampilkan pesan sesi berakhir dan redirect ke Login | Protected | Error Page / Redirect |

**Total Halaman Teridentifikasi:** 49 halaman, mencakup Public Pages, Protected Pages, Hidden Pages, Modal Pages, dan Error Pages.


---

## 16. NAVIGATION RULES

Aturan navigasi berikut berlaku secara konsisten di seluruh halaman StoreKuify.

| ID | Aturan Navigasi | Penjelasan |
|---|---|---|
| NAV-001 | Setiap Halaman Wajib Memiliki Breadcrumb | Seluruh halaman (kecuali Login dan Error Pages) menampilkan breadcrumb sesuai posisinya dalam hierarki, mengikuti struktur pada Bagian 13 04_Information_Architecture.md. |
| NAV-002 | Maksimal 3 Klik untuk Halaman Penting | Halaman krusial (Kasir, Data Barang, Hutang, Dashboard) dapat dicapai maksimal dalam 3 klik dari sidebar manapun. |
| NAV-003 | Perilaku Tombol Kembali (Back Button) | Tombol kembali/breadcrumb selalu mengarahkan pengguna ke Parent Page terakhir yang valid, bukan ke halaman sebelumnya secara acak (browser back tetap didukung namun UI menyediakan tombol kembali eksplisit pada halaman drill-down). |
| NAV-004 | Perilaku Tombol Batal (Cancel Button) | Tombol "Batal" pada form/modal menutup form tanpa menyimpan perubahan dan mengembalikan pengguna ke halaman/state sebelum form dibuka; jika terdapat perubahan yang belum disimpan, sistem menampilkan Unsaved Changes Confirmation (lihat NAV-007). |
| NAV-005 | Perilaku Tombol Simpan (Save Button) | Tombol "Simpan" memvalidasi data terlebih dahulu (frontend & backend sesuai BR-VAL-001); jika valid, data disimpan dan pengguna diarahkan kembali ke halaman induk dengan pesan sukses; jika tidak valid, form tetap terbuka dengan pesan error pada field terkait. |
| NAV-006 | Perilaku Menutup Modal (Close Modal) | Modal dapat ditutup melalui tombol "X", tombol "Batal", atau klik di luar area modal (overlay), kecuali modal konfirmasi kritis (contoh: Konfirmasi QRIS saat proses checkout) yang hanya dapat ditutup melalui aksi eksplisit untuk mencegah kehilangan data transaksi secara tidak sengaja. |
| NAV-007 | Perilaku Perubahan Belum Tersimpan (Unsaved Changes) | Jika pengguna mencoba menutup modal/berpindah halaman saat form memiliki perubahan yang belum disimpan, sistem menampilkan Unsaved Changes Confirmation, menawarkan opsi "Simpan", "Buang Perubahan", atau "Batal Menutup". |
| NAV-008 | Perilaku Refresh Halaman | Me-refresh halaman tidak menghapus data yang sudah tersimpan di database (contoh: transaksi yang sudah berhasil checkout); namun data yang belum disimpan pada form (termasuk keranjang belanja yang belum di-checkout, tergantung implementasi state management) berpotensi hilang kecuali disimpan sementara pada sisi client. |
| NAV-009 | Perilaku Session Timeout | Jika sesi login kedaluwarsa saat pengguna sedang berinteraksi (termasuk saat transaksi berlangsung), sistem menampilkan halaman/pesan Session Expired dan mengarahkan ke Login, sesuai BR-ERR-005. |
| NAV-010 | Konsistensi Navigasi Sidebar | Struktur dan urutan item sidebar tidak berubah antar halaman dalam satu sesi role yang sama, untuk mendukung prinsip *Consistent Navigation* (sesuai Bagian 5 pada 04_Information_Architecture.md). |
| NAV-011 | Modal Tidak Mengubah URL | Navigasi menuju modal/dialog tidak menghasilkan perubahan alamat/URL halaman maupun breadcrumb; breadcrumb tetap mengikuti halaman induk tempat modal dibuka. |
| NAV-012 | Tab Navigation Tidak Mengubah Parent Breadcrumb | Berpindah antar tab (contoh: Laporan Harian ke Mingguan, atau Pengaturan Profil Toko ke QRIS) hanya mengubah segmen terakhir breadcrumb, tanpa mengubah segmen induk. |
| NAV-013 | Role Visibility Diberlakukan di Setiap Level Navigasi | Baik sidebar, breadcrumb, tombol aksi kontekstual, maupun akses URL langsung seluruhnya tunduk pada Page Access Matrix yang sama (Bagian 15 pada 04_Information_Architecture.md); tidak ada jalur navigasi yang mem-bypass pembatasan role. |
| NAV-014 | Redirect Otomatis Setelah Login | Setelah login berhasil, sistem secara otomatis mengarahkan pengguna ke Dashboard sesuai role (Owner → Dashboard Owner, Kasir → Dashboard Kasir), tanpa memerlukan aksi tambahan dari pengguna. |
| NAV-015 | Konfirmasi Wajib untuk Aksi Destruktif/Sensitif | Aksi yang bersifat destruktif atau sensitif (Nonaktifkan Barang, Nonaktifkan Kasir, Logout) selalu memerlukan modal konfirmasi eksplisit sebelum dieksekusi, untuk mencegah kesalahan tidak disengaja. |

---

## 17. FUTURE SITEMAP

Struktur halaman berikut **belum berlaku** pada versi StoreKuify saat ini, namun dicatat sebagai referensi awal untuk pengembangan lanjutan, konsisten dengan Future Scope pada 02_PRD.md, Future Business Rules pada 03_Business_Rules.md, dan Future Information Architecture pada 04_Information_Architecture.md:

1. **Halaman Pemilihan Toko/Cabang** — jika dukungan multi-toko ditambahkan, diperlukan halaman baru "Pilih Toko" sebagai parent page baru sebelum Dashboard.
2. **Halaman Notifikasi** — kemungkinan penambahan halaman/panel "Notifikasi" yang menampilkan daftar peringatan stok menipis dan hutang jatuh tempo, dengan drill-down ke Detail Barang atau Detail Hutang.
3. **Halaman Ekspor Laporan** — kemungkinan penambahan modal/halaman "Ekspor Laporan (PDF/Excel)" sebagai child page dari Laporan.
4. **Halaman Manajemen Supplier & Purchase Order** — jika ditambahkan, memerlukan modul baru dengan hierarki halaman tersendiri (Daftar Supplier, Detail Supplier, Purchase Order).
5. **Halaman Program Loyalti Pelanggan** — jika ditambahkan, memerlukan child page baru di bawah Detail Hutang untuk menampilkan poin/reward pelanggan.
6. **Halaman Konfigurasi Barcode Scanner** — jika barcode scanner ditambahkan sebagai opsi, diperlukan halaman pengaturan tambahan di bawah Pengaturan untuk mengaktifkan/menonaktifkan mode barcode.
7. **Halaman Role Supervisor** — jika role tambahan ditambahkan, diperlukan sitemap ketiga (Supervisor Sitemap) dengan kombinasi visibilitas halaman yang berbeda dari Owner dan Kasir Sitemap saat ini.

---

## 18. GLOSSARY

| Istilah | Definisi |
|---|---|
| **Sitemap** | Dokumen yang memetakan seluruh halaman dalam aplikasi beserta hubungan parent-child, visibilitas role, dan jenis halamannya (publik, terproteksi, tersembunyi, modal, error). |
| **Public Page** | Halaman yang dapat diakses tanpa memerlukan autentikasi/login. |
| **Protected Page** | Halaman yang hanya dapat diakses oleh pengguna dengan sesi login aktif. |
| **Hidden Page** | Halaman yang tidak ditampilkan pada menu/sidebar navigasi utama, namun tetap dapat diakses melalui drill-down atau rute tertentu. |
| **Modal/Dialog Page** | Halaman yang muncul sebagai lapisan tambahan di atas halaman aktif, tanpa mengubah URL/breadcrumb halaman induk. |
| **Empty State** | Kondisi tampilan suatu halaman ketika belum ada data untuk ditampilkan. |
| **Loading State** | Kondisi tampilan sementara suatu halaman ketika sistem sedang memuat data dari server. |
| **Error Page** | Halaman yang ditampilkan ketika terjadi kondisi kesalahan tertentu (401, 403, 404, 419, 500, Network Error, Maintenance, Session Expired). |
| **Parent Page** | Halaman induk yang menjadi titik asal navigasi menuju suatu halaman anak. |
| **Child Page** | Halaman anak yang diakses melalui drill-down dari halaman induknya. |
| **Breadcrumb** | Elemen navigasi yang menampilkan jejak posisi pengguna dalam hierarki halaman. |
| **Skeleton Loading** | Pola tampilan loading berupa placeholder yang menyerupai bentuk konten asli, digunakan untuk daftar/tabel data. |
| **Unsaved Changes** | Kondisi ketika pengguna memiliki perubahan pada form yang belum disimpan ke sistem. |
| **Session Timeout** | Kondisi ketika sesi login pengguna berakhir secara otomatis akibat batas waktu tidak aktif atau kedaluwarsa. |
| **CSRF Token / Page Expired (419)** | Token keamanan form yang digunakan untuk mencegah serangan Cross-Site Request Forgery; kedaluwarsanya token ini memicu error 419. |
| **Role Visibility** | Prinsip di mana suatu halaman/elemen navigasi hanya terlihat/dapat diakses oleh role pengguna tertentu. |

---

**— AKHIR DOKUMEN 05_Sitemap.md —**

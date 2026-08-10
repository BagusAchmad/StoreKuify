# 03_Business_Rules.md
# BUSINESS RULES DOCUMENT
# STOREKUIFY — Web Based Grocery Store POS & Inventory Management System

---

## 1. DOCUMENT INFORMATION

| Atribut | Keterangan |
|---|---|
| Nama Dokumen | Business Rules Document — StoreKuify |
| Kode Dokumen | 03_Business_Rules.md |
| Nama Proyek | StoreKuify |
| Jenis Aplikasi | Web Based Grocery Store POS & Inventory Management System |
| Bahasa Dokumen | Bahasa Indonesia |
| Sumber Kebenaran (Source of Truth) | 02_PRD.md (Product Requirements Document — StoreKuify) |
| Status Dokumen | Final Draft — Siap untuk Tahap Development |
| Disusun Oleh | Senior Business Analyst |
| Tanggal Dibuat | 02 Agustus 2026 |
| Confidentiality | Internal — Hanya untuk Tim Internal & Development Team |

Dokumen ini merupakan **referensi utama logika bisnis (business logic reference)** yang digunakan sebagai acuan untuk:

- UI Design
- Database Design (ERD & Schema)
- API Design
- Software Development (Backend & Frontend)
- Quality Assurance & Testing

Seluruh aturan bisnis (business rules) pada dokumen ini **diekstrak sepenuhnya dari 02_PRD.md** dan tidak boleh bertentangan dengan dokumen tersebut. Dokumen ini bukan merupakan daftar fitur (feature list), melainkan penjelasan **bagaimana sistem berperilaku (how the system behaves)** dalam setiap kondisi operasional.

---

## 2. REVISION HISTORY

| Versi | Tanggal | Deskripsi Perubahan | Disusun Oleh | Disetujui Oleh |
|---|---|---|---|---|
| 0.1 | 02 Agustus 2026 | Draft awal Business Rules Document diekstrak dari 02_PRD.md | Senior Business Analyst | - |
| 1.0 | 02 Agustus 2026 | Finalisasi seluruh kategori business rules (21 kategori), termasuk Assumptions, Future Business Rules, dan Glossary | Senior Business Analyst | Product Owner |

Catatan: Setiap perubahan pada 02_PRD.md yang memengaruhi logika bisnis wajib disinkronkan ke dokumen ini dengan menambahkan baris revisi baru.

---

## 3. TABLE OF CONTENTS

1. Document Information
2. Revision History
3. Table of Contents
4. Introduction
5. Business Rule Categories
6. Complete Business Rules
   - 6.1 Authentication
   - 6.2 User Role
   - 6.3 Dashboard
   - 6.4 Kategori Barang
   - 6.5 Data Barang
   - 6.6 Stok Barang
   - 6.7 Kasir
   - 6.8 Keranjang
   - 6.9 Checkout
   - 6.10 Pembayaran
   - 6.11 QRIS
   - 6.12 Hutang
   - 6.13 Laporan
   - 6.14 Kelola Kasir
   - 6.15 Pengaturan
   - 6.16 Security
   - 6.17 Audit Log
   - 6.18 Validation
   - 6.19 Error Handling
   - 6.20 Session
   - 6.21 General Rules
7. Assumptions
8. Future Business Rules
9. Glossary

---

## 4. INTRODUCTION

StoreKuify adalah aplikasi kasir dan manajemen toko berbasis web yang dirancang khusus untuk kebutuhan Warung Kelontong. Dokumen ini menjabarkan **seluruh aturan bisnis (business rules)** yang mengatur perilaku sistem StoreKuify, diekstrak sepenuhnya dari Product Requirements Document (02_PRD.md).

Tujuan dokumen ini adalah:

1. Menjadi referensi tunggal logika bisnis bagi tim Database Design, API Design, dan Software Development.
2. Menjamin konsistensi perilaku sistem di seluruh modul (Authentication, Data Barang, Kasir, Hutang, Laporan, dsb.).
3. Memastikan setiap kondisi (condition) memiliki respon sistem (system response) yang jelas dan terdefinisi.
4. Mendokumentasikan pengecualian (exception) yang berlaku pada setiap aturan, agar tidak terjadi ambiguitas saat implementasi.

Setiap Business Rule bersifat **atomic** (mengatur satu perilaku spesifik) dan **independent** (tidak bergantung pada penjelasan aturan lain untuk dipahami), namun tetap konsisten satu sama lain dan dengan 02_PRD.md sebagai sumber kebenaran tunggal.

Business Rule yang tidak dinyatakan secara eksplisit di 02_PRD.md namun secara jelas tersirat (implied) dari deskripsi, alur (flow), atau acceptance criteria pada PRD, diturunkan secara logis pada dokumen ini tanpa menambahkan fitur baru atau mengubah keputusan bisnis yang sudah ditetapkan.

---

## 5. BUSINESS RULE CATEGORIES

Business Rules pada StoreKuify dikelompokkan ke dalam 21 kategori berikut:

| No | Kategori | Prefix ID | Ringkasan Cakupan |
|---|---|---|---|
| 1 | Authentication | BR-AUTH | Login, logout, validasi kredensial, status akun |
| 2 | User Role | BR-ROLE | Hak akses Owner dan Kasir, pembatasan menu/aksi |
| 3 | Dashboard | BR-DASH | Perbedaan tampilan Dashboard Owner dan Kasir |
| 4 | Kategori Barang | BR-KAT | Pembuatan, keunikan, dan status kategori |
| 5 | Data Barang | BR-BRG | Atribut barang, validasi harga, foto, status aktif/nonaktif |
| 6 | Stok Barang | BR-STK | Perubahan stok, ambang batas stok hampir habis |
| 7 | Kasir | BR-KSR | Pencarian barang, interaksi transaksi di titik penjualan |
| 8 | Keranjang | BR-CART | Penambahan, perubahan, dan pengosongan keranjang |
| 9 | Checkout | BR-CHK | Proses penyelesaian transaksi dan efek sistemiknya |
| 10 | Pembayaran | BR-PAY | Metode pembayaran Cash, QRIS, Hutang, Cash+Hutang |
| 11 | QRIS | BR-QRIS | Aturan spesifik pembayaran QRIS statis |
| 12 | Hutang | BR-HTG | Pencatatan, pembayaran, dan histori hutang pelanggan |
| 13 | Laporan | BR-LAP | Akses dan perhitungan data laporan |
| 14 | Kelola Kasir | BR-KKS | Pengelolaan akun Kasir oleh Owner |
| 15 | Pengaturan | BR-SET | Pengaturan identitas toko, QRIS, dan profil Owner |
| 16 | Security | BR-SEC | Enkripsi, proteksi akses, dan keamanan data |
| 17 | Audit Log | BR-AUD | Pencatatan jejak perubahan data sensitif |
| 18 | Validation | BR-VAL | Aturan validasi input di seluruh modul |
| 19 | Error Handling | BR-ERR | Perilaku sistem terhadap kondisi galat |
| 20 | Session | BR-SESS | Aturan sesi login dan multi-perangkat |
| 21 | General Rules | BR-GEN | Prinsip lintas modul yang berlaku secara umum |


---

## 6. COMPLETE BUSINESS RULES

### 6.1 Authentication

#### BR-AUTH-001

**Nama Rule:** Login Menggunakan Username dan Password

**Deskripsi:** Pengguna (Owner/Kasir) hanya dapat masuk ke sistem menggunakan kombinasi username dan password yang valid.

**Kondisi:** Pengguna mengisi username dan password pada halaman login dan menekan tombol "Login".

**Respon Sistem:** Sistem memvalidasi kredensial terhadap data pengguna di database; jika sesuai, sistem membuat sesi login dan mengarahkan pengguna ke Dashboard sesuai role.

**Exception:** Jika username/password tidak sesuai, sistem menolak login dan menampilkan pesan "Username atau password salah" tanpa menyebutkan field mana yang salah.

**Modul Terkait:** Authentication

**Prioritas:** Critical

---

#### BR-AUTH-002

**Nama Rule:** Username Harus Unik

**Deskripsi:** Setiap username pada sistem harus bersifat unik di seluruh sistem, berlaku lintas role Owner dan Kasir.

**Kondisi:** Pengguna baru dibuat, atau username diubah pada profil.

**Respon Sistem:** Sistem menolak penyimpanan jika username yang dimasukkan sudah digunakan oleh akun lain.

**Exception:** Tidak ada pengecualian; keunikan username berlaku mutlak di seluruh sistem, termasuk saat mengubah username akun sendiri.

**Modul Terkait:** Authentication, Kelola Kasir, Pengaturan

**Prioritas:** Critical

---

#### BR-AUTH-003

**Nama Rule:** Password Wajib Terenkripsi

**Deskripsi:** Password pengguna tidak pernah disimpan dalam bentuk teks biasa (plain text); seluruh password disimpan menggunakan algoritma hashing standar industri.

**Kondisi:** Password dibuat, diubah, atau direset oleh Owner maupun pengguna itu sendiri.

**Respon Sistem:** Sistem melakukan hashing terhadap password sebelum disimpan ke database.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Authentication, Security

**Prioritas:** Critical

---

#### BR-AUTH-004

**Nama Rule:** Akun Nonaktif Tidak Dapat Login

**Deskripsi:** Akun pengguna yang berstatus nonaktif tidak dapat digunakan untuk login meskipun kredensial yang dimasukkan benar.

**Kondisi:** Pengguna dengan status akun nonaktif mencoba login.

**Respon Sistem:** Sistem menolak proses login dan menampilkan pesan "Akun Anda telah dinonaktifkan, silakan hubungi Owner".

**Exception:** Owner dapat mengaktifkan kembali akun tersebut, setelah itu login kembali diizinkan.

**Modul Terkait:** Authentication, Kelola Kasir

**Prioritas:** Critical

---

#### BR-AUTH-005

**Nama Rule:** Field Login Wajib Diisi

**Deskripsi:** Username dan password wajib diisi sebelum proses login dapat dilakukan.

**Kondisi:** Salah satu atau kedua field (username/password) dikosongkan saat submit login.

**Respon Sistem:** Sistem menampilkan validasi bahwa field terkait wajib diisi dan tidak melanjutkan proses autentikasi.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Authentication, Validation

**Prioritas:** High

---

#### BR-AUTH-006

**Nama Rule:** Logout Mengakhiri Sesi pada Perangkat Terkait

**Deskripsi:** Ketika pengguna melakukan logout, sesi login pada perangkat tersebut diakhiri, namun tidak memengaruhi sesi aktif pengguna yang sama pada perangkat lain.

**Kondisi:** Pengguna menekan tombol logout.

**Respon Sistem:** Sistem menghentikan sesi pada perangkat tersebut dan mengarahkan pengguna ke halaman login.

**Exception:** Jika sesi sudah kedaluwarsa sebelum logout ditekan, sistem otomatis mengarahkan ke halaman login pada request berikutnya.

**Modul Terkait:** Authentication, Session

**Prioritas:** High

---

### 6.2 User Role

#### BR-ROLE-001

**Nama Rule:** Owner Memiliki Akses Penuh

**Deskripsi:** Role Owner memiliki akses penuh terhadap seluruh modul: Dashboard, Data Barang, Kasir, Hutang Pelanggan, Laporan, Kelola Kasir, dan Pengaturan.

**Kondisi:** Pengguna login dengan role Owner.

**Respon Sistem:** Sistem menampilkan seluruh menu navigasi dan mengizinkan seluruh aksi Create, Read, Update, dan Delete/Nonaktifkan pada modul yang menjadi kewenangan Owner.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** User Role

**Prioritas:** Critical

---

#### BR-ROLE-002

**Nama Rule:** Kasir Memiliki Akses Terbatas

**Deskripsi:** Role Kasir hanya memiliki akses ke Dashboard (versi terbatas), Data Barang (Read Only), Kasir (transaksi), dan Hutang Pelanggan.

**Kondisi:** Pengguna login dengan role Kasir.

**Respon Sistem:** Sistem hanya menampilkan menu yang diizinkan untuk role Kasir dan menyembunyikan menu Laporan, Kelola Kasir, dan Pengaturan.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** User Role

**Prioritas:** Critical

---

#### BR-ROLE-003

**Nama Rule:** Kasir Tidak Dapat Mengubah Data Barang

**Deskripsi:** Kasir hanya dapat melihat (Read Only) Data Barang, tidak dapat menambah, mengubah harga, mengubah kategori, atau menonaktifkan barang.

**Kondisi:** Kasir mengakses modul Data Barang.

**Respon Sistem:** Sistem tidak menampilkan tombol Tambah/Edit/Nonaktifkan pada tampilan Kasir; jika Kasir mengakses endpoint aksi tersebut secara langsung, sistem menolak dengan pesan 403.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** User Role, Data Barang

**Prioritas:** Critical

---

#### BR-ROLE-004

**Nama Rule:** Kasir Tidak Dapat Melihat Laporan Keuangan

**Deskripsi:** Kasir tidak memiliki akses ke modul Laporan yang menampilkan data penjualan dan keuntungan toko.

**Kondisi:** Kasir mencoba mengakses menu/endpoint Laporan.

**Respon Sistem:** Sistem menyembunyikan menu Laporan dari navigasi Kasir dan menolak akses langsung ke endpoint terkait dengan pesan 403.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** User Role, Laporan

**Prioritas:** Critical

---

#### BR-ROLE-005

**Nama Rule:** Kasir Tidak Dapat Mengelola Akun Kasir Lain

**Deskripsi:** Kasir tidak memiliki akses ke modul Kelola Kasir; hanya Owner yang dapat menambah, mengedit, menonaktifkan, atau mereset password akun Kasir.

**Kondisi:** Kasir mencoba mengakses menu/endpoint Kelola Kasir.

**Respon Sistem:** Sistem menyembunyikan menu Kelola Kasir dari navigasi Kasir dan menolak akses langsung dengan pesan 403.

**Exception:** Kasir tetap dapat mengubah profil miliknya sendiri (username, password, foto profil) melalui menu Profil Saya, bukan melalui Kelola Kasir.

**Modul Terkait:** User Role, Kelola Kasir

**Prioritas:** Critical

---

#### BR-ROLE-006

**Nama Rule:** Kasir Tidak Dapat Mengubah Pengaturan Toko

**Deskripsi:** Kasir tidak memiliki akses untuk mengubah Nama Toko, Alamat Toko, Logo, QRIS, maupun Profil Owner.

**Kondisi:** Kasir mencoba mengakses menu/endpoint Pengaturan.

**Respon Sistem:** Sistem menyembunyikan menu Pengaturan dari navigasi Kasir dan menolak akses langsung dengan pesan 403.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** User Role, Pengaturan

**Prioritas:** Critical

---

#### BR-ROLE-007

**Nama Rule:** Validasi Role Dilakukan di Backend, Bukan Hanya Frontend

**Deskripsi:** Pembatasan akses berdasarkan role wajib divalidasi pada sisi backend (server-side), tidak cukup hanya menyembunyikan elemen UI pada frontend.

**Kondisi:** Setiap request yang menyentuh endpoint aksi Create/Update/Delete pada modul yang dibatasi role.

**Respon Sistem:** Sistem memeriksa role pengguna pada setiap request backend dan menolak aksi jika role tidak sesuai, terlepas dari tampilan frontend yang diakses.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** User Role, Security

**Prioritas:** Critical

---

### 6.3 Dashboard

#### BR-DASH-001

**Nama Rule:** Dashboard Owner Berbeda dengan Dashboard Kasir

**Deskripsi:** Sistem menampilkan versi Dashboard yang berbeda tergantung pada role pengguna yang login.

**Kondisi:** Pengguna login dan diarahkan ke halaman Dashboard.

**Respon Sistem:** Sistem menampilkan Dashboard Owner (lengkap dengan data finansial) untuk role Owner, dan Dashboard Kasir (ringkasan operasional tanpa data finansial) untuk role Kasir.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Dashboard, User Role

**Prioritas:** Critical

---

#### BR-DASH-002

**Nama Rule:** Dashboard Owner Menampilkan Data Finansial Harian

**Deskripsi:** Dashboard Owner menampilkan Penjualan Hari Ini, Keuntungan Hari Ini, Jumlah Transaksi, Barang Terjual, Grafik Penjualan, Barang Hampir Habis, dan Hutang Belum Lunas.

**Kondisi:** Owner mengakses halaman Dashboard.

**Respon Sistem:** Sistem menghitung dan menampilkan seluruh indikator berdasarkan data transaksi hari berjalan yang berstatus selesai.

**Exception:** Jika belum ada transaksi pada hari berjalan, sistem menampilkan nilai 0 dengan pesan informatif.

**Modul Terkait:** Dashboard

**Prioritas:** Must Have

---

#### BR-DASH-003

**Nama Rule:** Dashboard Kasir Tidak Menampilkan Data Keuntungan

**Deskripsi:** Dashboard Kasir tidak menampilkan nominal Keuntungan Hari Ini maupun data keuntungan lainnya, hanya menampilkan Ringkasan Transaksi Hari Ini, Barang Hampir Habis, dan Hutang Pelanggan.

**Kondisi:** Kasir mengakses halaman Dashboard.

**Respon Sistem:** Sistem menyembunyikan seluruh komponen keuntungan dari tampilan Dashboard Kasir.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Dashboard, User Role

**Prioritas:** Critical

---

#### BR-DASH-004

**Nama Rule:** Barang Hampir Habis Ditentukan oleh Ambang Batas Stok

**Deskripsi:** Barang yang ditampilkan pada bagian "Barang Hampir Habis" adalah barang dengan stok kurang dari atau sama dengan ambang batas minimum yang ditentukan.

**Kondisi:** Sistem menghitung daftar barang untuk ditampilkan pada Dashboard.

**Respon Sistem:** Sistem menampilkan barang dengan stok ≤ ambang batas minimum (default disepakati, dapat disesuaikan).

**Exception:** Jika tidak ada barang yang memenuhi kondisi tersebut, sistem menampilkan pesan "Semua stok barang aman".

**Modul Terkait:** Dashboard, Stok Barang

**Prioritas:** Must Have

---

### 6.4 Kategori Barang

#### BR-KAT-001

**Nama Rule:** Nama Kategori Harus Unik

**Deskripsi:** Nama kategori barang harus bersifat unik (case-insensitive) di seluruh sistem.

**Kondisi:** Owner membuat atau mengubah nama kategori.

**Respon Sistem:** Sistem menolak penyimpanan dan menampilkan pesan "Nama kategori sudah digunakan" jika nama sudah ada.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Kategori Barang

**Prioritas:** Critical

---

#### BR-KAT-002

**Nama Rule:** Hanya Owner yang Dapat Mengelola Kategori

**Deskripsi:** Pembuatan, pengubahan, dan penonaktifan kategori barang hanya dapat dilakukan oleh role Owner.

**Kondisi:** Pengguna mengakses fitur Create/Update/Nonaktifkan Kategori.

**Respon Sistem:** Sistem hanya mengizinkan aksi tersebut untuk role Owner; role Kasir hanya dapat melihat daftar kategori.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Kategori Barang, User Role

**Prioritas:** Critical

---

#### BR-KAT-003

**Nama Rule:** Kategori Nonaktif Tidak Tersedia untuk Barang Baru

**Deskripsi:** Kategori yang dinonaktifkan tidak muncul sebagai pilihan saat membuat Barang baru.

**Kondisi:** Owner menonaktifkan sebuah kategori.

**Respon Sistem:** Sistem menghapus kategori tersebut dari daftar pilihan kategori pada form Tambah Barang.

**Exception:** Barang yang sudah ada di dalam kategori nonaktif tetap tersimpan dan tetap menampilkan kategori tersebut sebagai atributnya, namun mengikuti aturan barang nonaktif (lihat BR-BRG-008) jika kategori memengaruhi status jual barang.

**Modul Terkait:** Kategori Barang, Data Barang

**Prioritas:** Should Have

---

### 6.5 Data Barang

#### BR-BRG-001

**Nama Rule:** Barang Wajib Berada dalam Kategori

**Deskripsi:** Setiap barang harus dibuat di dalam sebuah kategori; barang tidak dapat dibuat tanpa memilih kategori terlebih dahulu.

**Kondisi:** Owner menambahkan barang baru tanpa memilih kategori, atau belum ada kategori yang dibuat.

**Respon Sistem:** Sistem menolak penyimpanan barang; jika belum ada kategori sama sekali, sistem menampilkan pesan "Silakan buat kategori terlebih dahulu" dan mengarahkan ke halaman Kategori.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Data Barang, Kategori Barang

**Prioritas:** Critical

---

#### BR-BRG-002

**Nama Rule:** Nama Barang Tidak Boleh Sama

**Deskripsi:** Nama barang harus bersifat unik (case-insensitive) di seluruh sistem.

**Kondisi:** Owner membuat atau mengubah nama barang.

**Respon Sistem:** Sistem menolak penyimpanan dan menampilkan pesan error jika nama barang sudah digunakan oleh barang lain.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Data Barang

**Prioritas:** Critical

---

#### BR-BRG-003

**Nama Rule:** Harga Jual Tidak Boleh Lebih Kecil dari Harga Modal

**Deskripsi:** Sistem mewajibkan nilai Harga Jual selalu lebih besar atau sama dengan Harga Modal pada setiap barang.

**Kondisi:** Owner menyimpan atau mengubah data barang dengan Harga Jual < Harga Modal.

**Respon Sistem:** Sistem menolak penyimpanan dan menampilkan pesan "Harga jual tidak boleh lebih kecil dari harga modal".

**Exception:** Tidak ada pengecualian; aturan ini berlaku baik saat pembuatan maupun pengeditan barang.

**Modul Terkait:** Data Barang, Validation

**Prioritas:** Critical

---

#### BR-BRG-004

**Nama Rule:** Foto Barang Bersifat Opsional

**Deskripsi:** Pengunggahan foto produk tidak wajib dilakukan saat membuat atau mengubah data barang.

**Kondisi:** Owner menyimpan barang tanpa mengunggah foto.

**Respon Sistem:** Sistem tetap menyimpan data barang tanpa memerlukan foto.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Data Barang

**Prioritas:** Must Have

---

#### BR-BRG-005

**Nama Rule:** Foto Placeholder Digunakan Jika Foto Kosong

**Deskripsi:** Jika Owner tidak mengunggah foto produk, sistem secara otomatis menggunakan gambar placeholder default untuk barang tersebut.

**Kondisi:** Barang disimpan tanpa foto produk.

**Respon Sistem:** Sistem menampilkan gambar placeholder default pada seluruh tampilan yang menampilkan barang tersebut (Data Barang, Kasir, dsb.).

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Data Barang

**Prioritas:** Must Have

---

#### BR-BRG-006

**Nama Rule:** Barang Habis Tetap Tampil

**Deskripsi:** Barang dengan stok 0 tetap ditampilkan pada daftar Data Barang dan pada hasil pencarian di modul Kasir.

**Kondisi:** Stok barang mencapai 0.

**Respon Sistem:** Sistem tetap menampilkan barang tersebut, namun diberi penanda visual "Stok Habis".

**Exception:** Tidak berlaku untuk barang yang dinonaktifkan Owner (barang nonaktif tidak muncul pada pencarian Kasir, lihat BR-BRG-009).

**Modul Terkait:** Data Barang, Stok Barang, Kasir

**Prioritas:** Must Have

---

#### BR-BRG-007

**Nama Rule:** Barang Habis Tidak Dapat Dimasukkan ke Keranjang

**Deskripsi:** Barang dengan stok 0 tidak dapat ditambahkan ke keranjang transaksi meskipun tetap tampil pada pencarian.

**Kondisi:** Pengguna mencoba menambahkan barang dengan stok 0 ke keranjang.

**Respon Sistem:** Sistem menolak penambahan barang tersebut ke keranjang.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Data Barang, Keranjang

**Prioritas:** Critical

---

#### BR-BRG-008

**Nama Rule:** Barang Dapat Dinonaktifkan oleh Owner

**Deskripsi:** Owner dapat menonaktifkan barang yang tidak lagi dijual, dan dapat mengaktifkannya kembali kapan pun diperlukan.

**Kondisi:** Owner menekan aksi "Nonaktifkan" atau "Aktifkan" pada suatu barang.

**Respon Sistem:** Sistem mengubah status barang menjadi nonaktif/aktif sesuai aksi Owner.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Data Barang

**Prioritas:** Must Have

---

#### BR-BRG-009

**Nama Rule:** Barang Nonaktif Tidak Dapat Dijual

**Deskripsi:** Barang yang berstatus nonaktif tidak muncul/tidak dapat dipilih pada pencarian barang di modul Kasir, sehingga tidak dapat dimasukkan ke transaksi.

**Kondisi:** Barang memiliki status nonaktif.

**Respon Sistem:** Sistem mengecualikan barang tersebut dari hasil pencarian pada modul Kasir.

**Exception:** Barang nonaktif tetap tampil pada daftar Data Barang (dengan penanda "Nonaktif") untuk keperluan pengelolaan oleh Owner.

**Modul Terkait:** Data Barang, Kasir

**Prioritas:** Critical

---

#### BR-BRG-010

**Nama Rule:** Owner Dapat Menambah Stok Kapan Saja

**Deskripsi:** Owner dapat menambah atau menyesuaikan stok barang kapan pun diperlukan, terlepas dari proses transaksi penjualan.

**Kondisi:** Owner mengakses fitur Tambah Stok/Sesuaikan Stok pada detail barang.

**Respon Sistem:** Sistem memperbarui jumlah stok barang secara langsung dan mencerminkannya secara real-time di seluruh sistem.

**Exception:** Sistem menolak input yang menyebabkan stok menjadi negatif.

**Modul Terkait:** Data Barang, Stok Barang

**Prioritas:** Must Have

---

#### BR-BRG-011

**Nama Rule:** Perubahan Harga Tidak Mengubah Histori Transaksi

**Deskripsi:** Perubahan Harga Modal atau Harga Jual pada suatu barang tidak memengaruhi nilai harga yang tercatat pada transaksi yang sudah terjadi sebelumnya.

**Kondisi:** Owner mengubah harga barang setelah barang tersebut sudah pernah terjual dalam suatu transaksi.

**Respon Sistem:** Sistem menyimpan snapshot harga pada level transaksi (transaction_items), sehingga histori transaksi tetap menampilkan harga saat transaksi terjadi, bukan harga barang saat ini.

**Exception:** Tidak ada pengecualian; ini adalah aturan wajib untuk menjaga integritas laporan historis.

**Modul Terkait:** Data Barang, Checkout, Laporan

**Prioritas:** Critical

---

#### BR-BRG-012

**Nama Rule:** Keuntungan Dihitung Berdasarkan Harga Saat Transaksi

**Deskripsi:** Keuntungan (margin) suatu transaksi dihitung menggunakan Harga Modal dan Harga Jual yang berlaku pada saat transaksi terjadi, bukan harga barang yang berlaku saat ini.

**Kondisi:** Sistem menghitung keuntungan pada saat checkout maupun saat menampilkan Laporan.

**Respon Sistem:** Sistem mengambil nilai harga dari snapshot transaksi (bukan dari master data Barang saat ini) untuk perhitungan keuntungan.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Data Barang, Checkout, Laporan

**Prioritas:** Critical

---

#### BR-BRG-013

**Nama Rule:** Kasir Hanya Dapat Melihat Data Barang (Read Only)

**Deskripsi:** Kasir dapat melihat daftar dan detail barang, namun tidak memiliki tombol atau akses untuk menambah, mengubah, atau menonaktifkan barang.

**Kondisi:** Kasir mengakses modul Data Barang.

**Respon Sistem:** Sistem menampilkan data barang dalam mode tampilan saja (read only) untuk role Kasir.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Data Barang, User Role

**Prioritas:** Critical

---

### 6.6 Stok Barang

#### BR-STK-001

**Nama Rule:** Stok Tidak Boleh Bernilai Negatif

**Deskripsi:** Nilai stok barang harus selalu ≥ 0 pada seluruh kondisi (pembuatan barang, penyesuaian manual, maupun setelah transaksi).

**Kondisi:** Suatu aksi (input stok manual, checkout) berpotensi menghasilkan nilai stok < 0.

**Respon Sistem:** Sistem menolak aksi tersebut dan mempertahankan nilai stok pada batas minimum 0.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Stok Barang, Data Barang, Checkout

**Prioritas:** Critical

---

#### BR-STK-002

**Nama Rule:** Stok Berkurang Hanya Setelah Checkout Berhasil

**Deskripsi:** Pengurangan stok barang hanya terjadi setelah transaksi checkout berhasil diselesaikan, bukan saat barang dimasukkan ke keranjang.

**Kondisi:** Barang berada di dalam keranjang namun transaksi belum diselesaikan (checkout belum ditekan/belum berhasil).

**Respon Sistem:** Sistem tidak mengubah nilai stok barang selama proses ini; stok baru dikurangi saat checkout berhasil disimpan ke database.

**Exception:** Jika transaksi dibatalkan sebelum checkout selesai, stok tidak berubah sama sekali.

**Modul Terkait:** Stok Barang, Keranjang, Checkout

**Prioritas:** Critical

---

#### BR-STK-003

**Nama Rule:** Validasi Stok Dilakukan Ulang Sebelum Checkout Final

**Deskripsi:** Sistem memvalidasi ulang ketersediaan stok seluruh item dalam keranjang tepat sebelum transaksi disimpan sebagai antisipasi perubahan stok akibat transaksi bersamaan (race condition).

**Kondisi:** Pengguna menekan tombol "Selesaikan Transaksi" pada proses checkout.

**Respon Sistem:** Sistem memeriksa ulang stok setiap item; jika stok mencukupi, transaksi dilanjutkan dan disimpan.

**Exception:** Jika stok salah satu item tidak lagi mencukupi pada saat validasi ulang ini, sistem membatalkan proses checkout, menampilkan pesan kesalahan, dan tidak mengurangi stok maupun menyimpan transaksi.

**Modul Terkait:** Stok Barang, Checkout

**Prioritas:** Critical

---

#### BR-STK-004

**Nama Rule:** Ambang Batas Barang Hampir Habis Dapat Dikonfigurasi

**Deskripsi:** Sistem menentukan status "hampir habis" suatu barang berdasarkan ambang batas minimum stok yang dapat disesuaikan.

**Kondisi:** Sistem menghitung daftar barang untuk Dashboard dan/atau notifikasi terkait stok.

**Respon Sistem:** Sistem menandai barang dengan stok ≤ ambang batas minimum (default disepakati, contoh: 5) sebagai "Barang Hampir Habis".

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Stok Barang, Dashboard

**Prioritas:** Should Have

---

### 6.7 Kasir

#### BR-KSR-001

**Nama Rule:** Pencarian Barang Menggunakan Nama, Bukan Barcode

**Deskripsi:** Seluruh pencarian barang pada modul Kasir dilakukan melalui pencarian berbasis nama barang; sistem tidak menggunakan atau mendukung barcode scanner.

**Kondisi:** Pengguna mencari barang pada halaman Kasir.

**Respon Sistem:** Sistem menampilkan hasil pencarian secara real-time (live search) berdasarkan kecocokan nama barang (partial match, case-insensitive).

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Kasir

**Prioritas:** Critical

---

#### BR-KSR-002

**Nama Rule:** Hasil Pencarian Hanya Menampilkan Barang Aktif

**Deskripsi:** Pencarian barang pada modul Kasir hanya menampilkan barang dengan status aktif; barang nonaktif dikecualikan dari hasil pencarian.

**Kondisi:** Pengguna melakukan pencarian barang di modul Kasir.

**Respon Sistem:** Sistem menyaring hasil pencarian agar hanya menampilkan barang berstatus aktif.

**Exception:** Barang aktif dengan stok 0 tetap ditampilkan (lihat BR-BRG-006), namun tidak dapat ditambahkan ke keranjang.

**Modul Terkait:** Kasir, Data Barang

**Prioritas:** Critical

---

#### BR-KSR-003

**Nama Rule:** Owner dan Kasir Sama-Sama Dapat Melakukan Transaksi

**Deskripsi:** Modul Kasir (POS) dapat diakses dan digunakan baik oleh Owner maupun Kasir untuk melakukan transaksi penjualan.

**Kondisi:** Pengguna dengan role Owner atau Kasir mengakses modul Kasir.

**Respon Sistem:** Sistem mengizinkan kedua role tersebut melakukan seluruh alur transaksi (pencarian, keranjang, checkout).

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Kasir, User Role

**Prioritas:** Must Have

---

### 6.8 Keranjang

#### BR-CART-001

**Nama Rule:** Barang Baru Masuk Keranjang dengan Jumlah Default 1

**Deskripsi:** Ketika barang pertama kali dipilih dari hasil pencarian, sistem menambahkannya ke keranjang dengan jumlah default 1.

**Kondisi:** Pengguna memilih barang dari hasil pencarian yang belum ada di keranjang.

**Respon Sistem:** Sistem menambahkan baris baru pada keranjang dengan jumlah 1 dan menghitung subtotal.

**Exception:** Jika barang tersebut sudah ada di keranjang, sistem menambah jumlah (+1) pada baris yang sama, bukan membuat baris duplikat (lihat BR-CART-002).

**Modul Terkait:** Keranjang

**Prioritas:** Must Have

---

#### BR-CART-002

**Nama Rule:** Barang Duplikat di Keranjang Digabungkan

**Deskripsi:** Jika barang yang sama dipilih kembali saat sudah ada di keranjang, sistem menambah jumlah pada baris yang sudah ada, bukan membuat entri baru.

**Kondisi:** Pengguna memilih barang yang sudah berada di keranjang.

**Respon Sistem:** Sistem menambah jumlah (+1) pada baris barang yang sama di keranjang.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Keranjang

**Prioritas:** Must Have

---

#### BR-CART-003

**Nama Rule:** Jumlah Barang di Keranjang Tidak Boleh Melebihi Stok

**Deskripsi:** Jumlah suatu barang dalam keranjang tidak boleh melebihi stok yang tersedia untuk barang tersebut.

**Kondisi:** Pengguna menekan tombol "+" untuk menambah jumlah barang di keranjang hingga melebihi stok tersedia.

**Respon Sistem:** Sistem menolak penambahan lebih lanjut dan menampilkan pesan "Stok tidak mencukupi".

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Keranjang, Stok Barang

**Prioritas:** Critical

---

#### BR-CART-004

**Nama Rule:** Jumlah Barang di Keranjang Tidak Boleh Negatif

**Deskripsi:** Jumlah barang pada keranjang tidak dapat dikurangi hingga bernilai negatif menggunakan tombol "-".

**Kondisi:** Pengguna menekan tombol "-" saat jumlah barang sudah bernilai 1.

**Respon Sistem:** Jika jumlah mencapai 0, sistem menghapus barang tersebut dari keranjang.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Keranjang

**Prioritas:** Must Have

---

#### BR-CART-005

**Nama Rule:** Keranjang Dapat Diubah Bebas Sebelum Checkout

**Deskripsi:** Pengguna dapat menambah, mengurangi, atau menghapus barang dari keranjang kapan saja sebelum proses checkout diselesaikan, tanpa memengaruhi data stok aktual.

**Kondisi:** Pengguna mengubah isi keranjang sebelum menekan "Selesaikan Transaksi".

**Respon Sistem:** Sistem memperbarui isi dan subtotal keranjang secara real-time tanpa mengubah stok barang di database.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Keranjang, Stok Barang

**Prioritas:** Critical

---

#### BR-CART-006

**Nama Rule:** Stok Tidak Berubah Sebelum Checkout

**Deskripsi:** Selama barang berada di keranjang (belum checkout), nilai stok barang di database tidak mengalami perubahan apa pun.

**Kondisi:** Barang berada dalam keranjang transaksi apa pun yang belum diselesaikan.

**Respon Sistem:** Sistem mempertahankan nilai stok barang tetap sama seperti sebelum barang dimasukkan ke keranjang.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Keranjang, Stok Barang

**Prioritas:** Critical

---

#### BR-CART-007

**Nama Rule:** Keranjang Dikosongkan Setelah Transaksi Berhasil

**Deskripsi:** Setelah checkout berhasil diselesaikan, sistem secara otomatis mengosongkan keranjang untuk transaksi berikutnya.

**Kondisi:** Transaksi checkout berhasil disimpan.

**Respon Sistem:** Sistem menghapus seluruh isi keranjang dan menampilkan struk/ringkasan transaksi.

**Exception:** Jika checkout gagal atau dibatalkan, isi keranjang tetap dipertahankan (lihat BR-CHK-004).

**Modul Terkait:** Keranjang, Checkout

**Prioritas:** Must Have

---

### 6.9 Checkout

#### BR-CHK-001

**Nama Rule:** Checkout Menghasilkan Transaksi Baru

**Deskripsi:** Setiap proses checkout yang berhasil diselesaikan menghasilkan satu record transaksi baru yang tersimpan permanen dalam sistem.

**Kondisi:** Pengguna menekan tombol "Selesaikan Transaksi" dan seluruh validasi (stok, metode pembayaran) terpenuhi.

**Respon Sistem:** Sistem membuat dan menyimpan transaksi baru beserta seluruh detail item, metode pembayaran, dan total nominal.

**Exception:** Jika transaksi dibatalkan sebelum tahap ini, tidak ada record transaksi yang dibuat.

**Modul Terkait:** Checkout, Kasir

**Prioritas:** Critical

---

#### BR-CHK-002

**Nama Rule:** Checkout Mengurangi Stok

**Deskripsi:** Ketika checkout berhasil, sistem mengurangi stok setiap barang sesuai jumlah yang terjual pada transaksi tersebut.

**Kondisi:** Transaksi checkout berhasil diselesaikan.

**Respon Sistem:** Sistem mengurangi nilai stok masing-masing barang sesuai jumlah pada transaksi.

**Exception:** Jika transaksi dibatalkan, stok tidak berubah.

**Modul Terkait:** Checkout, Stok Barang

**Prioritas:** Critical

---

#### BR-CHK-003

**Nama Rule:** Checkout Menghitung Keuntungan

**Deskripsi:** Setiap transaksi checkout yang berhasil menghitung total keuntungan berdasarkan selisih Harga Jual dan Harga Modal pada saat transaksi terjadi.

**Kondisi:** Transaksi checkout berhasil diselesaikan.

**Respon Sistem:** Sistem menghitung dan menyimpan nilai keuntungan per item dan total keuntungan transaksi.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Checkout, Data Barang, Laporan

**Prioritas:** Critical

---

#### BR-CHK-004

**Nama Rule:** Checkout yang Gagal Tidak Mengubah Data

**Deskripsi:** Jika checkout gagal (misalnya karena stok tidak mencukupi saat validasi ulang) atau dibatalkan oleh pengguna, sistem tidak mengubah stok, tidak menyimpan transaksi, dan tidak mengosongkan keranjang.

**Kondisi:** Proses checkout dibatalkan atau gagal pada tahap validasi akhir.

**Respon Sistem:** Sistem mempertahankan isi keranjang dan tidak melakukan perubahan apa pun pada data stok maupun transaksi.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Checkout, Keranjang, Stok Barang

**Prioritas:** Critical

---

#### BR-CHK-005

**Nama Rule:** Checkout Membuat Hutang Jika Pembayaran Belum Lunas

**Deskripsi:** Jika metode pembayaran yang dipilih adalah Hutang atau Cash + Hutang, sistem secara otomatis membuat entri hutang pada modul Hutang Pelanggan untuk nominal yang belum dibayar.

**Kondisi:** Transaksi checkout diselesaikan dengan metode Hutang atau Cash + Hutang.

**Respon Sistem:** Sistem membuat catatan hutang baru terkait pelanggan yang dipilih, dengan nominal sesuai sisa yang belum dibayar.

**Exception:** Jika metode pembayaran adalah Cash penuh atau QRIS penuh (lunas), tidak ada entri hutang yang dibuat.

**Modul Terkait:** Checkout, Hutang, Pembayaran

**Prioritas:** Critical

---

#### BR-CHK-006

**Nama Rule:** Checkout Wajib Memiliki Minimal Satu Item

**Deskripsi:** Proses checkout hanya dapat dilakukan jika keranjang berisi minimal satu barang.

**Kondisi:** Pengguna menekan tombol "Checkout" dengan keranjang kosong.

**Respon Sistem:** Sistem menolak proses checkout dan tidak menampilkan opsi untuk melanjutkan.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Checkout, Keranjang

**Prioritas:** Must Have

---

#### BR-CHK-007

**Nama Rule:** Struk Ditampilkan Setelah Checkout Berhasil

**Deskripsi:** Setelah transaksi berhasil disimpan, sistem menampilkan ringkasan struk transaksi kepada pengguna.

**Kondisi:** Checkout berhasil diselesaikan.

**Respon Sistem:** Sistem menampilkan halaman/modal struk berisi rincian barang, jumlah, harga, total, metode pembayaran, dan kembalian (jika berlaku).

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Checkout, Kasir

**Prioritas:** Should Have

---

### 6.10 Pembayaran

#### BR-PAY-001

**Nama Rule:** Sistem Mendukung Empat Metode Pembayaran

**Deskripsi:** StoreKuify mendukung empat metode pembayaran pada proses checkout: Cash, QRIS, Hutang, dan Cash + Hutang.

**Kondisi:** Pengguna berada pada tahap pemilihan metode pembayaran saat checkout.

**Respon Sistem:** Sistem menampilkan keempat opsi metode pembayaran tersebut untuk dipilih pengguna (QRIS hanya muncul jika sudah dikonfigurasi, lihat BR-QRIS-003).

**Exception:** Tidak ada metode pembayaran lain di luar keempat opsi tersebut yang didukung pada versi ini.

**Modul Terkait:** Pembayaran, Checkout

**Prioritas:** Critical

---

#### BR-PAY-002

**Nama Rule:** Metode Cash Menghitung Kembalian

**Deskripsi:** Untuk metode pembayaran Cash, sistem menghitung nilai kembalian berdasarkan selisih antara nominal yang dibayarkan dan total transaksi.

**Kondisi:** Pengguna memilih metode Cash dan memasukkan nominal uang tunai yang diterima.

**Respon Sistem:** Sistem menghitung kembalian = nominal diterima − total transaksi, dan menampilkannya pada layar checkout dan struk.

**Exception:** Jika nominal yang dimasukkan kurang dari total transaksi, sistem menolak penyelesaian transaksi dengan metode Cash penuh (lihat BR-PAY-003).

**Modul Terkait:** Pembayaran, Checkout

**Prioritas:** Must Have

---

#### BR-PAY-003

**Nama Rule:** Nominal Cash Kurang Mewajibkan Skema Cash + Hutang

**Deskripsi:** Jika nominal cash yang dimasukkan kurang dari total transaksi dan pengguna tidak memilih skema Cash + Hutang, sistem menolak penyelesaian transaksi.

**Kondisi:** Pengguna memasukkan nominal cash < total transaksi tanpa memilih metode Cash + Hutang.

**Respon Sistem:** Sistem menampilkan pesan "Nominal pembayaran tidak mencukupi, silakan pilih metode Cash + Hutang atau tambahkan nominal".

**Exception:** Tidak berlaku jika pengguna secara eksplisit memilih metode Cash + Hutang, di mana sisa nominal otomatis tercatat sebagai hutang.

**Modul Terkait:** Pembayaran, Checkout, Hutang

**Prioritas:** Critical

---

#### BR-PAY-004

**Nama Rule:** Metode Hutang Mewajibkan Data Pelanggan

**Deskripsi:** Transaksi dengan metode Hutang atau Cash + Hutang mewajibkan pengguna memilih pelanggan terdaftar atau menambahkan pelanggan baru sebelum transaksi dapat diselesaikan.

**Kondisi:** Pengguna memilih metode Hutang atau Cash + Hutang tanpa memilih/menambahkan pelanggan.

**Respon Sistem:** Sistem menahan proses checkout dan mewajibkan pemilihan/penambahan data pelanggan sebelum melanjutkan.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Pembayaran, Hutang, Checkout

**Prioritas:** Critical

---

#### BR-PAY-005

**Nama Rule:** Cash + Hutang Membagi Nominal Transaksi

**Deskripsi:** Pada metode Cash + Hutang, nominal cash yang dibayarkan mengurangi total tagihan, dan sisanya tercatat penuh sebagai hutang atas nama pelanggan yang dipilih.

**Kondisi:** Pengguna memilih metode Cash + Hutang dan memasukkan nominal cash parsial.

**Respon Sistem:** Sistem menghitung sisa = total transaksi − nominal cash, dan mencatat sisa tersebut sebagai hutang baru.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Pembayaran, Hutang, Checkout

**Prioritas:** Critical

---

### 6.11 QRIS

#### BR-QRIS-001

**Nama Rule:** QRIS Bersifat Statis

**Deskripsi:** Metode pembayaran QRIS pada StoreKuify menggunakan gambar QRIS statis milik toko, bukan QRIS dinamis yang terhubung dengan payment gateway.

**Kondisi:** Pengguna memilih metode pembayaran QRIS.

**Respon Sistem:** Sistem menampilkan gambar QRIS statis yang telah diunggah Owner beserta total tagihan transaksi.

**Exception:** Tidak ada pengecualian pada versi ini.

**Modul Terkait:** QRIS, Pembayaran

**Prioritas:** Critical

---

#### BR-QRIS-002

**Nama Rule:** Verifikasi Pembayaran QRIS Dilakukan Secara Manual

**Deskripsi:** Sistem tidak melakukan verifikasi otomatis terhadap keberhasilan pembayaran QRIS; kasir memverifikasi secara manual berdasarkan konfirmasi/bukti dari pelanggan.

**Kondisi:** Pelanggan menunjukkan bukti pembayaran QRIS berhasil kepada kasir.

**Respon Sistem:** Kasir menekan tombol "Konfirmasi Pembayaran Diterima" untuk melanjutkan proses checkout; sistem tidak memvalidasi pembayaran melalui integrasi eksternal apa pun.

**Exception:** Tidak ada pengecualian; ini adalah karakteristik utama QRIS statis pada StoreKuify.

**Modul Terkait:** QRIS, Kasir, Checkout

**Prioritas:** Critical

---

#### BR-QRIS-003

**Nama Rule:** Opsi QRIS Hanya Tampil Jika Sudah Dikonfigurasi

**Deskripsi:** Opsi metode pembayaran QRIS hanya ditampilkan pada layar checkout jika Owner telah mengunggah gambar QRIS pada modul Pengaturan.

**Kondisi:** Owner belum mengunggah gambar QRIS toko.

**Respon Sistem:** Sistem menyembunyikan/menonaktifkan opsi metode pembayaran QRIS pada layar checkout.

**Exception:** Setelah Owner mengunggah QRIS, opsi ini otomatis tersedia tanpa perlu restart sistem.

**Modul Terkait:** QRIS, Pengaturan, Checkout

**Prioritas:** Must Have

---

#### BR-QRIS-004

**Nama Rule:** Transaksi QRIS Selesai Hanya Setelah Konfirmasi Eksplisit Kasir

**Deskripsi:** Transaksi dengan metode QRIS baru dianggap selesai (dan stok baru dikurangi) setelah kasir secara eksplisit menekan tombol konfirmasi pembayaran diterima.

**Kondisi:** Pengguna memilih metode QRIS pada checkout.

**Respon Sistem:** Sistem menahan penyelesaian transaksi hingga kasir menekan tombol konfirmasi.

**Exception:** Jika kasir membatalkan sebelum konfirmasi, transaksi tidak tersimpan dan keranjang tetap ada.

**Modul Terkait:** QRIS, Checkout

**Prioritas:** Critical

---

### 6.12 Hutang

#### BR-HTG-001

**Nama Rule:** Hutang Berasal dari Transaksi

**Deskripsi:** Setiap entri hutang pada sistem berasal dari sebuah transaksi penjualan dengan metode Hutang atau Cash + Hutang; hutang tidak dapat dibuat secara manual tanpa transaksi terkait.

**Kondisi:** Sistem membuat entri hutang baru.

**Respon Sistem:** Sistem menautkan entri hutang dengan transaksi yang menjadi sumbernya.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Hutang, Checkout

**Prioritas:** Critical

---

#### BR-HTG-002

**Nama Rule:** Hutang Dapat Dibayar Sebagian (Cicilan)

**Deskripsi:** Pembayaran hutang pelanggan tidak harus dilakukan sekaligus; sistem mengizinkan pembayaran sebagian (cicilan) yang mengurangi nilai outstanding hutang.

**Kondisi:** Owner/Kasir mencatat pembayaran dengan nominal lebih kecil dari total outstanding hutang pelanggan.

**Respon Sistem:** Sistem mengurangi nilai outstanding sesuai nominal yang dibayarkan dan status hutang tetap "Belum Lunas".

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Hutang

**Prioritas:** Critical

---

#### BR-HTG-003

**Nama Rule:** Hutang Dapat Dilunasi

**Deskripsi:** Ketika nominal pembayaran (baik sekaligus maupun akumulasi cicilan) mencapai total outstanding, status hutang otomatis berubah menjadi "Lunas".

**Kondisi:** Total pembayaran yang tercatat sama dengan total nominal hutang.

**Respon Sistem:** Sistem mengubah status hutang menjadi "Lunas" dan outstanding menjadi Rp 0.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Hutang

**Prioritas:** Critical

---

#### BR-HTG-004

**Nama Rule:** Nominal Pembayaran Tidak Boleh Melebihi Outstanding

**Deskripsi:** Sistem menolak pencatatan pembayaran hutang jika nominal yang dimasukkan melebihi sisa outstanding hutang pelanggan.

**Kondisi:** Pengguna memasukkan nominal pembayaran hutang > outstanding.

**Respon Sistem:** Sistem menampilkan pesan "Nominal pembayaran melebihi total hutang yang tersisa" dan menolak penyimpanan.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Hutang, Validation

**Prioritas:** Critical

---

#### BR-HTG-005

**Nama Rule:** Riwayat Hutang Tidak Boleh Dihapus

**Deskripsi:** Data histori hutang (baik entri hutang maupun histori pembayaran) bersifat permanen dan tidak dapat dihapus oleh pengguna manapun, termasuk Owner.

**Kondisi:** Pengguna mencoba menghapus entri hutang atau histori pembayaran.

**Respon Sistem:** Sistem tidak menyediakan aksi hapus untuk data hutang; data tetap tersimpan selamanya dalam sistem.

**Exception:** Tidak ada pengecualian, termasuk untuk hutang yang berstatus "Lunas".

**Modul Terkait:** Hutang, Audit Log

**Prioritas:** Critical

---

#### BR-HTG-006

**Nama Rule:** Histori Pelanggan Tetap Disimpan

**Deskripsi:** Data pelanggan dan seluruh histori transaksi/hutang terkait tetap tersimpan dalam sistem meskipun seluruh hutang pelanggan tersebut telah lunas.

**Kondisi:** Pelanggan melunasi seluruh hutangnya.

**Respon Sistem:** Sistem tetap menyimpan data pelanggan dan histori transaksinya untuk keperluan audit dan referensi di masa depan.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Hutang

**Prioritas:** Must Have

---

#### BR-HTG-007

**Nama Rule:** Owner dan Kasir Dapat Mengelola Hutang

**Deskripsi:** Baik Owner maupun Kasir dapat melihat daftar pelanggan, menambah pelanggan, mencatat hutang baru (melalui transaksi), dan menerima pembayaran hutang.

**Kondisi:** Pengguna dengan role Owner atau Kasir mengakses modul Hutang Pelanggan.

**Respon Sistem:** Sistem mengizinkan kedua role tersebut melakukan seluruh aksi pada modul Hutang Pelanggan.

**Exception:** Tidak ada pengecualian; modul Hutang Pelanggan tidak dibatasi seperti modul Laporan atau Pengaturan.

**Modul Terkait:** Hutang, User Role

**Prioritas:** Must Have

---

### 6.13 Laporan

#### BR-LAP-001

**Nama Rule:** Hanya Owner yang Dapat Melihat Laporan

**Deskripsi:** Modul Laporan (penjualan dan keuntungan) hanya dapat diakses oleh role Owner; Kasir tidak memiliki akses ke modul ini.

**Kondisi:** Pengguna mengakses menu/endpoint Laporan.

**Respon Sistem:** Sistem mengizinkan akses hanya untuk role Owner dan menolak akses Kasir dengan pesan 403.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Laporan, User Role

**Prioritas:** Critical

---

#### BR-LAP-002

**Nama Rule:** Laporan Mendukung Empat Periode Standar

**Deskripsi:** Owner dapat melihat laporan berdasarkan empat periode: Harian, Mingguan, Bulanan, dan Tahunan, serta rentang tanggal kustom.

**Kondisi:** Owner memilih jenis periode pada halaman Laporan.

**Respon Sistem:** Sistem menampilkan data agregat (Total Penjualan, Total Keuntungan, Jumlah Transaksi, Barang Terjual) sesuai periode yang dipilih.

**Exception:** Jika tidak ada transaksi pada periode tersebut, sistem menampilkan nilai 0 dengan pesan informatif.

**Modul Terkait:** Laporan

**Prioritas:** Critical

---

#### BR-LAP-003

**Nama Rule:** Keuntungan pada Laporan Menggunakan Harga Historis

**Deskripsi:** Perhitungan Total Keuntungan pada laporan menggunakan nilai harga (modal dan jual) yang tercatat pada saat transaksi terjadi, bukan harga barang saat laporan diakses.

**Kondisi:** Sistem menghitung Total Keuntungan untuk suatu periode laporan.

**Respon Sistem:** Sistem mengagregasi nilai keuntungan dari snapshot harga masing-masing transaksi pada periode tersebut.

**Exception:** Tidak ada pengecualian (konsisten dengan BR-BRG-012).

**Modul Terkait:** Laporan, Data Barang, Checkout

**Prioritas:** Critical

---

#### BR-LAP-004

**Nama Rule:** Laporan Menampilkan Ranking Barang Terlaris dan Paling Menguntungkan

**Deskripsi:** Laporan menyediakan daftar Top Barang Terlaris (berdasarkan unit terjual) dan Barang Paling Menguntungkan (berdasarkan total keuntungan) pada periode yang dipilih.

**Kondisi:** Owner mengakses bagian ranking barang pada halaman Laporan.

**Respon Sistem:** Sistem mengurutkan barang berdasarkan unit terjual (descending) untuk Barang Terlaris, dan berdasarkan total keuntungan (descending) untuk Barang Paling Menguntungkan.

**Exception:** Jika tidak ada data pada periode tersebut, sistem menampilkan pesan "Belum ada data untuk periode ini".

**Modul Terkait:** Laporan

**Prioritas:** Should Have

---

#### BR-LAP-005

**Nama Rule:** Laporan Dapat Difilter Berdasarkan Rentang Tanggal Kustom

**Deskripsi:** Selain preset periode standar, Owner dapat memilih rentang tanggal spesifik (Tanggal Mulai dan Tanggal Akhir) untuk melihat laporan.

**Kondisi:** Owner memilih opsi "Rentang Kustom" dan memasukkan rentang tanggal.

**Respon Sistem:** Sistem menampilkan data laporan sesuai rentang tanggal yang dimasukkan.

**Exception:** Jika Tanggal Mulai > Tanggal Akhir, sistem menolak dan menampilkan pesan validasi.

**Modul Terkait:** Laporan, Validation

**Prioritas:** Should Have

---

### 6.14 Kelola Kasir

#### BR-KKS-001

**Nama Rule:** Hanya Owner yang Dapat Mengelola Akun Kasir

**Deskripsi:** Penambahan, pengeditan, penonaktifan, dan reset password akun Kasir hanya dapat dilakukan oleh Owner.

**Kondisi:** Pengguna mengakses menu/endpoint Kelola Kasir.

**Respon Sistem:** Sistem mengizinkan akses hanya untuk role Owner.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Kelola Kasir, User Role

**Prioritas:** Critical

---

#### BR-KKS-002

**Nama Rule:** Akun Kasir Baru Berstatus Aktif Secara Default

**Deskripsi:** Akun Kasir yang baru dibuat oleh Owner otomatis berstatus aktif dan dapat langsung digunakan untuk login.

**Kondisi:** Owner menyimpan data akun Kasir baru.

**Respon Sistem:** Sistem membuat akun dengan status aktif tanpa memerlukan aktivasi tambahan.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Kelola Kasir, Authentication

**Prioritas:** Must Have

---

#### BR-KKS-003

**Nama Rule:** Nonaktifkan Akun Kasir Tidak Menghapus Histori

**Deskripsi:** Menonaktifkan akun Kasir tidak menghapus atau memengaruhi histori transaksi yang pernah dilakukan oleh akun tersebut.

**Kondisi:** Owner menonaktifkan akun Kasir yang memiliki histori transaksi.

**Respon Sistem:** Sistem mengubah status akun menjadi nonaktif namun tetap mempertahankan seluruh data transaksi historis yang tertaut ke akun tersebut.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Kelola Kasir, Audit Log

**Prioritas:** Must Have

---

#### BR-KKS-004

**Nama Rule:** Akun Kasir yang Sedang Login Dipaksa Logout Saat Dinonaktifkan

**Deskripsi:** Jika akun Kasir sedang memiliki sesi aktif ketika dinonaktifkan Owner, sesi tersebut akan ditolak pada request/akses berikutnya.

**Kondisi:** Owner menonaktifkan akun Kasir yang sedang login.

**Respon Sistem:** Sistem menolak permintaan berikutnya dari sesi tersebut dan mengarahkan ke halaman login dengan status akun nonaktif.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Kelola Kasir, Session

**Prioritas:** Should Have

---

#### BR-KKS-005

**Nama Rule:** Reset Password oleh Owner Tidak Memerlukan Password Lama

**Deskripsi:** Owner dapat mereset password akun Kasir tanpa perlu mengetahui atau memasukkan password lama akun tersebut.

**Kondisi:** Owner menekan tombol "Reset Password" pada detail akun Kasir.

**Respon Sistem:** Sistem mengizinkan Owner memasukkan password baru langsung tanpa validasi password lama.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Kelola Kasir, Authentication

**Prioritas:** Must Have

---

#### BR-KKS-006

**Nama Rule:** Kasir Dapat Mengubah Profil Miliknya Sendiri

**Deskripsi:** Kasir dapat mengubah Username, Password, dan Foto Profil miliknya sendiri, namun tidak dapat mengubah profil Kasir lain atau mengubah role-nya sendiri.

**Kondisi:** Kasir mengakses menu Profil Saya.

**Respon Sistem:** Sistem mengizinkan perubahan data profil milik akun yang sedang login saja.

**Exception:** Perubahan username tetap tunduk pada aturan keunikan username (BR-AUTH-002); Kasir tidak dapat mengubah field role.

**Modul Terkait:** Kelola Kasir, Authentication

**Prioritas:** Must Have

---

### 6.15 Pengaturan

#### BR-SET-001

**Nama Rule:** Hanya Owner yang Dapat Mengubah Pengaturan Toko

**Deskripsi:** Perubahan Nama Toko, Alamat Toko, Logo, QRIS, dan Profil Owner hanya dapat dilakukan oleh role Owner.

**Kondisi:** Pengguna mengakses menu/endpoint Pengaturan.

**Respon Sistem:** Sistem mengizinkan akses hanya untuk role Owner.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Pengaturan, User Role

**Prioritas:** Critical

---

#### BR-SET-002

**Nama Rule:** Perubahan Identitas Toko Langsung Tercermin pada Struk

**Deskripsi:** Perubahan Nama Toko dan Logo yang dilakukan Owner langsung tercermin pada struk transaksi berikutnya tanpa memerlukan restart sistem.

**Kondisi:** Owner menyimpan perubahan Nama Toko atau Logo.

**Respon Sistem:** Sistem menerapkan data toko terbaru pada seluruh transaksi yang dibuat setelah perubahan tersebut.

**Exception:** Struk transaksi yang sudah dibuat sebelum perubahan tidak diubah secara retroaktif.

**Modul Terkait:** Pengaturan, Checkout

**Prioritas:** Must Have

---

#### BR-SET-003

**Nama Rule:** Menghapus QRIS Menonaktifkan Opsi Pembayaran QRIS

**Deskripsi:** Jika Owner menghapus gambar QRIS yang telah diunggah, opsi metode pembayaran QRIS otomatis disembunyikan pada modul Kasir hingga QRIS baru diunggah.

**Kondisi:** Owner menghapus gambar QRIS pada menu Pengaturan.

**Respon Sistem:** Sistem menonaktifkan opsi QRIS pada layar checkout.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Pengaturan, QRIS, Checkout

**Prioritas:** Must Have

---


### 6.16 Security

#### BR-SEC-001

**Nama Rule:** Password Disimpan dalam Bentuk Hash

**Deskripsi:** Seluruh password pengguna disimpan menggunakan algoritma hashing standar industri (contoh: bcrypt/argon2), tidak pernah dalam bentuk plain text.

**Kondisi:** Sistem menyimpan atau memperbarui password pengguna.

**Respon Sistem:** Sistem melakukan hashing sebelum data password disimpan ke database.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Security, Authentication

**Prioritas:** Critical

---

#### BR-SEC-002

**Nama Rule:** Validasi Role Dilakukan pada Setiap Endpoint Backend

**Deskripsi:** Setiap endpoint aksi (Create/Update/Delete) wajib memvalidasi role pengguna di sisi backend, tidak cukup hanya menyembunyikan elemen pada frontend.

**Kondisi:** Permintaan (request) dikirim ke endpoint yang dibatasi role tertentu.

**Respon Sistem:** Sistem memeriksa role pengguna sebelum memproses permintaan; menolak dengan kode 403 jika tidak sesuai.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Security, User Role

**Prioritas:** Critical

---

#### BR-SEC-003

**Nama Rule:** Input Pengguna Divalidasi dan Disanitasi

**Deskripsi:** Seluruh input dari form (Barang, Kategori, Pelanggan, dll.) divalidasi dan disanitasi untuk mencegah SQL Injection dan Cross-Site Scripting (XSS).

**Kondisi:** Pengguna mengirimkan data melalui form apa pun dalam sistem.

**Respon Sistem:** Sistem menyaring dan memvalidasi input sebelum diproses atau disimpan ke database.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Security, Validation

**Prioritas:** Critical

---

#### BR-SEC-004

**Nama Rule:** Upload File Divalidasi Berdasarkan Tipe dan Ukuran

**Deskripsi:** Setiap file yang diunggah (foto produk, logo toko, gambar QRIS) divalidasi tipe MIME dan ukuran maksimumnya sebelum diterima sistem.

**Kondisi:** Pengguna mengunggah file gambar pada form Barang, Pengaturan, atau Profil.

**Respon Sistem:** Sistem menerima file hanya jika sesuai format (JPG/PNG) dan ukuran maksimum (2MB); jika tidak, sistem menolak dan menampilkan pesan error.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Security, Validation

**Prioritas:** Critical

---

#### BR-SEC-005

**Nama Rule:** Percobaan Login Gagal Berulang Dibatasi

**Deskripsi:** Sistem membatasi (throttle) percobaan login yang gagal berulang kali dalam rentang waktu singkat untuk mencegah serangan brute-force.

**Kondisi:** Pengguna gagal login lebih dari ambang batas yang ditentukan (contoh: 5 kali dalam 1 menit).

**Respon Sistem:** Sistem menahan sementara percobaan login berikutnya dari sumber tersebut selama periode cooldown.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Security, Authentication

**Prioritas:** High

---

#### BR-SEC-006

**Nama Rule:** Data Pelanggan Hanya Dapat Diakses Pengguna Internal

**Deskripsi:** Data pelanggan (nama, nomor telepon, hutang) hanya dapat diakses oleh pengguna internal (Owner/Kasir) yang telah login, tidak dapat diakses publik.

**Kondisi:** Permintaan mengakses data pelanggan.

**Respon Sistem:** Sistem mewajibkan sesi login aktif sebelum data pelanggan dapat ditampilkan.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Security, Hutang

**Prioritas:** Critical

---

#### BR-SEC-007

**Nama Rule:** Aplikasi Wajib Diakses via HTTPS pada Produksi

**Deskripsi:** Pada environment produksi, seluruh akses ke aplikasi StoreKuify wajib menggunakan koneksi HTTPS.

**Kondisi:** Aplikasi berjalan pada environment produksi.

**Respon Sistem:** Sistem/infrastruktur mengarahkan (redirect) seluruh akses HTTP ke HTTPS.

**Exception:** Tidak berlaku pada environment development/staging lokal.

**Modul Terkait:** Security

**Prioritas:** High

---

### 6.17 Audit Log

#### BR-AUD-001

**Nama Rule:** Perubahan Data Kritis Dicatat dengan Aktor dan Waktu

**Deskripsi:** Perubahan pada data sensitif (harga barang, stok manual, status akun, penonaktifan kategori) dicatat dengan informasi aktor yang melakukan perubahan dan timestamp kejadian.

**Kondisi:** Terjadi perubahan pada data kritis yang disebutkan.

**Respon Sistem:** Sistem mencatat log berisi aktor, waktu, dan jenis perubahan yang dilakukan.

**Exception:** Tidak ada pengecualian; log bersifat direkomendasikan kuat (strongly recommended) untuk seluruh perubahan data kritis.

**Modul Terkait:** Audit Log, Security

**Prioritas:** Should Have

---

#### BR-AUD-002

**Nama Rule:** Histori Transaksi dan Hutang Bersifat Immutable

**Deskripsi:** Data histori transaksi dan histori hutang tidak dapat diubah atau dihapus oleh pengguna manapun setelah tersimpan, untuk menjaga integritas audit keuangan.

**Kondisi:** Pengguna mencoba mengubah atau menghapus data transaksi/hutang yang sudah tersimpan.

**Respon Sistem:** Sistem tidak menyediakan fitur/endpoint untuk mengubah atau menghapus data tersebut.

**Exception:** Tidak ada pengecualian, termasuk untuk role Owner.

**Modul Terkait:** Audit Log, Hutang, Checkout

**Prioritas:** Critical

---

#### BR-AUD-003

**Nama Rule:** Penambahan Stok Manual Dicatat sebagai Log

**Deskripsi:** Setiap penambahan atau penyesuaian stok secara manual oleh Owner dicatat sebagai log perubahan stok untuk keperluan audit.

**Kondisi:** Owner menambah atau menyesuaikan stok barang secara manual.

**Respon Sistem:** Sistem mencatat log berisi barang, jumlah perubahan, aktor, dan waktu perubahan.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Audit Log, Stok Barang

**Prioritas:** Should Have

---

### 6.18 Validation

#### BR-VAL-001

**Nama Rule:** Validasi Dilakukan pada Frontend dan Backend

**Deskripsi:** Seluruh aturan validasi diterapkan pada dua lapisan: frontend (untuk responsivitas pengalaman pengguna) dan backend (untuk keamanan dan integritas data).

**Kondisi:** Pengguna mengirimkan data melalui form apa pun dalam sistem.

**Respon Sistem:** Sistem memvalidasi data pada sisi client (frontend) untuk umpan balik cepat, dan memvalidasi ulang pada sisi server (backend) sebelum data disimpan.

**Exception:** Tidak ada pengecualian; validasi backend wajib dilakukan meskipun validasi frontend sudah lolos.

**Modul Terkait:** Validation, Security

**Prioritas:** Critical

---

#### BR-VAL-002

**Nama Rule:** Field Wajib Tidak Boleh Kosong

**Deskripsi:** Seluruh field yang ditandai wajib (Nama Kategori, Nama Barang, Harga Modal, Harga Jual, Stok, Username, Password, Nama Pelanggan, Nama Toko, dll.) tidak boleh dikosongkan saat submit form.

**Kondisi:** Pengguna mengirimkan form dengan field wajib kosong.

**Respon Sistem:** Sistem menampilkan pesan validasi spesifik per field dan menolak penyimpanan.

**Exception:** Field yang secara eksplisit ditandai opsional (Foto Produk, Alamat Toko) dikecualikan dari aturan ini.

**Modul Terkait:** Validation

**Prioritas:** Critical

---

#### BR-VAL-003

**Nama Rule:** Nilai Numerik Tidak Boleh Negatif pada Field Terkait

**Deskripsi:** Field numerik seperti Harga Modal, Harga Jual, dan Stok tidak boleh bernilai negatif.

**Kondisi:** Pengguna memasukkan nilai negatif pada field tersebut.

**Respon Sistem:** Sistem menolak penyimpanan dan menampilkan pesan validasi nilai minimum.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Validation, Data Barang, Stok Barang

**Prioritas:** Critical

---

#### BR-VAL-004

**Nama Rule:** Format dan Ukuran File Divalidasi Sebelum Diunggah

**Deskripsi:** Seluruh file gambar yang diunggah (foto barang, foto profil, logo toko, gambar QRIS) harus berformat JPG/PNG dan berukuran maksimum 2MB.

**Kondisi:** Pengguna mengunggah file dengan format atau ukuran yang tidak memenuhi ketentuan.

**Respon Sistem:** Sistem menolak upload dan menampilkan pesan error sesuai jenis kegagalan (format atau ukuran).

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Validation, Security

**Prioritas:** High

---

### 6.19 Error Handling

#### BR-ERR-001

**Nama Rule:** Pesan Error Ditampilkan dalam Bahasa Indonesia

**Deskripsi:** Seluruh pesan error/validasi yang ditampilkan kepada pengguna menggunakan Bahasa Indonesia yang jelas dan mudah dipahami pengguna non-teknis.

**Kondisi:** Sistem menampilkan pesan kesalahan apa pun kepada pengguna.

**Respon Sistem:** Sistem menampilkan teks pesan dalam Bahasa Indonesia, tanpa istilah teknis yang membingungkan.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Error Handling

**Prioritas:** Must Have

---

#### BR-ERR-002

**Nama Rule:** Detail Teknis Error Tidak Ditampilkan ke Pengguna Akhir

**Deskripsi:** Kesalahan sistem (server error) tidak menampilkan detail teknis (stack trace) kepada pengguna akhir; hanya pesan umum yang ditampilkan.

**Kondisi:** Terjadi kesalahan pada sisi server (contoh: koneksi database terputus).

**Respon Sistem:** Sistem menampilkan pesan umum seperti "Terjadi kesalahan pada sistem, silakan coba lagi" beserta kode referensi error untuk log internal tim teknis.

**Exception:** Tidak ada pengecualian pada environment produksi.

**Modul Terkait:** Error Handling, Security

**Prioritas:** High

---

#### BR-ERR-003

**Nama Rule:** Login Gagal Tidak Mengungkap Field yang Salah

**Deskripsi:** Saat login gagal, sistem tidak memberi tahu secara spesifik apakah username atau password yang salah, untuk mencegah user enumeration.

**Kondisi:** Kombinasi username/password yang dimasukkan tidak valid.

**Respon Sistem:** Sistem menampilkan pesan generik "Username atau password salah".

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Error Handling, Authentication, Security

**Prioritas:** High

---

#### BR-ERR-004

**Nama Rule:** Kegagalan Stok Saat Checkout Tidak Menghilangkan Keranjang

**Deskripsi:** Jika checkout gagal akibat perubahan stok (race condition), sistem membatalkan proses checkout namun tetap mempertahankan isi keranjang pengguna.

**Kondisi:** Validasi ulang stok saat checkout final menemukan stok tidak mencukupi.

**Respon Sistem:** Sistem menampilkan pesan "Stok [Nama Barang] telah berubah, silakan periksa kembali keranjang Anda" dan tidak mengosongkan keranjang.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Error Handling, Checkout, Stok Barang

**Prioritas:** Critical

---

#### BR-ERR-005

**Nama Rule:** Sesi Kedaluwarsa Saat Transaksi Mengarahkan ke Login

**Deskripsi:** Jika sesi login pengguna berakhir saat proses transaksi sedang berlangsung, sistem mengarahkan pengguna ke halaman login dengan pesan yang jelas.

**Kondisi:** Sesi pengguna kedaluwarsa saat pengguna sedang berada di tengah transaksi (checkout).

**Respon Sistem:** Sistem menampilkan pesan "Sesi Anda telah berakhir, silakan login kembali" dan mengarahkan ke halaman login; data keranjang disimpan sementara jika memungkinkan secara teknis.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Error Handling, Session, Checkout

**Prioritas:** High

---

### 6.20 Session

#### BR-SESS-001

**Nama Rule:** Satu Akun Dapat Login pada Lebih dari Satu Perangkat

**Deskripsi:** Sistem mengizinkan satu akun pengguna (Owner/Kasir) untuk login secara bersamaan pada lebih dari satu perangkat.

**Kondisi:** Pengguna login menggunakan akun yang sama pada perangkat berbeda.

**Respon Sistem:** Sistem membuat sesi terpisah untuk masing-masing perangkat tanpa menghentikan sesi lain.

**Exception:** Tidak ada pengecualian, kecuali jika akun dinonaktifkan Owner (lihat BR-KKS-004), yang akan memutus seluruh sesi pada request berikutnya.

**Modul Terkait:** Session, Authentication

**Prioritas:** Must Have

---

#### BR-SESS-002

**Nama Rule:** Logout Hanya Memengaruhi Sesi pada Perangkat Tersebut

**Deskripsi:** Tindakan logout pada satu perangkat tidak menghentikan sesi aktif yang sama pada perangkat lain.

**Kondisi:** Pengguna logout dari salah satu perangkat tempat ia login.

**Respon Sistem:** Sistem hanya menghentikan sesi pada perangkat tempat aksi logout dilakukan.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** Session, Authentication

**Prioritas:** Must Have

---

### 6.21 General Rules

#### BR-GEN-001

**Nama Rule:** Aplikasi Tidak Menggunakan Barcode Scanner

**Deskripsi:** Seluruh proses identifikasi barang dalam sistem StoreKuify menggunakan pencarian berbasis nama, dan tidak melibatkan perangkat atau fitur barcode scanner dalam bentuk apa pun.

**Kondisi:** Berlaku secara umum di seluruh modul yang melibatkan pemilihan barang.

**Respon Sistem:** Sistem hanya menyediakan mekanisme pencarian nama pada seluruh titik interaksi dengan data Barang.

**Exception:** Tidak ada pengecualian pada versi ini (lihat Future Business Rules untuk kemungkinan pengembangan mendatang).

**Modul Terkait:** General Rules, Kasir, Data Barang

**Prioritas:** Critical

---

#### BR-GEN-002

**Nama Rule:** Aplikasi Beroperasi dalam Konteks Single-Store

**Deskripsi:** StoreKuify dirancang untuk mengelola satu toko (single-tenant) dalam satu instalasi/akun, tidak mendukung multi-cabang pada versi ini.

**Kondisi:** Berlaku secara umum di seluruh modul (Data Barang, Kasir, Laporan, Pengaturan, dll.).

**Respon Sistem:** Seluruh data (Barang, Transaksi, Hutang, Laporan) terikat pada satu entitas toko tunggal.

**Exception:** Tidak ada pengecualian pada versi ini (lihat Future Business Rules).

**Modul Terkait:** General Rules

**Prioritas:** Critical

---

#### BR-GEN-003

**Nama Rule:** Seluruh Antarmuka Menggunakan Bahasa Indonesia

**Deskripsi:** Seluruh label, menu, pesan sistem, dan konten antarmuka StoreKuify disajikan dalam Bahasa Indonesia.

**Kondisi:** Berlaku secara umum di seluruh halaman dan komponen aplikasi.

**Respon Sistem:** Sistem menampilkan seluruh teks antarmuka dalam Bahasa Indonesia, termasuk format mata uang Rupiah dengan pemisah ribuan titik (contoh: Rp 15.000).

**Exception:** Tidak ada pengecualian; aplikasi tidak mendukung multi-bahasa pada versi ini.

**Modul Terkait:** General Rules

**Prioritas:** Must Have

---

#### BR-GEN-004

**Nama Rule:** Transaksi Keuangan Dieksekusi Secara Atomic

**Deskripsi:** Seluruh operasi yang melibatkan perubahan data keuangan (checkout, pembayaran hutang) harus dieksekusi dalam satu database transaction (atomic), untuk menghindari data tidak konsisten.

**Kondisi:** Proses checkout atau pencatatan pembayaran hutang sedang berlangsung.

**Respon Sistem:** Sistem memastikan seluruh langkah (pengurangan stok, penyimpanan transaksi, pembuatan hutang) berhasil bersamaan, atau seluruhnya dibatalkan (rollback) jika salah satu langkah gagal.

**Exception:** Tidak ada pengecualian.

**Modul Terkait:** General Rules, Checkout, Hutang

**Prioritas:** Critical

---

## 7. ASSUMPTIONS

Asumsi berikut mendasari penyusunan business rules pada dokumen ini, diturunkan langsung dari 02_PRD.md:

1. Setiap instalasi/akun StoreKuify hanya melayani **satu toko** (single-tenant, single-store); tidak ada kebutuhan pemisahan data antar cabang pada versi ini.
2. Owner dan Kasir memiliki perangkat dengan akses internet yang memadai untuk mengoperasikan aplikasi berbasis web secara real-time.
3. QRIS yang digunakan bersifat **statis** (gambar QR toko), sehingga seluruh aturan terkait QRIS mengasumsikan tidak adanya integrasi payment gateway otomatis.
4. Verifikasi pembayaran QRIS bersifat **trust-based**, mengandalkan kejujuran dan ketelitian kasir dalam mengonfirmasi bukti pembayaran dari pelanggan.
5. Barang tidak memiliki varian (ukuran, warna, rasa); satu nama barang merepresentasikan satu entitas produk tunggal dengan satu harga modal dan satu harga jual.
6. Tidak ada perhitungan pajak otomatis (PPN) yang terpisah dari Harga Jual; jika Owner ingin memasukkan komponen pajak, hal tersebut diasumsikan sudah termasuk dalam Harga Jual yang diinput secara manual.
7. Ambang batas "stok hampir habis" menggunakan nilai default yang disepakati dan dapat disesuaikan pada tahap pengembangan lebih lanjut; business rules terkait (BR-DASH-004, BR-STK-004) mengasumsikan nilai ini dapat dikonfigurasi meskipun default awal ditentukan tim development.
8. Role pengguna terbatas pada dua jenis (Owner dan Kasir); tidak ada asumsi mengenai role tambahan seperti "Supervisor" atau "Admin Sistem" pada versi ini.

---

## 8. FUTURE BUSINESS RULES

Aturan bisnis berikut **belum berlaku** pada versi StoreKuify saat ini, namun berpotensi ditambahkan pada pengembangan lanjutan sesuai Future Scope pada 02_PRD.md. Aturan ini dicatat sebagai referensi awal, bukan bagian dari cakupan implementasi versi ini:

1. **Hutang Jatuh Tempo** — kemungkinan penambahan aturan tanggal jatuh tempo hutang dengan notifikasi otomatis kepada Owner/Kasir menjelang atau setelah tanggal jatuh tempo.
2. **Verifikasi QRIS Otomatis** — jika terjadi integrasi payment gateway dinamis (contoh: Midtrans/Xendit), aturan verifikasi manual (BR-QRIS-002) akan digantikan oleh aturan verifikasi otomatis berbasis callback/webhook.
3. **Multi-Toko/Multi-Cabang** — kemungkinan penambahan aturan pemisahan data (data scoping) antar cabang, termasuk laporan konsolidasi lintas cabang untuk Owner.
4. **Barcode Scanner Opsional** — jika ditambahkan di masa depan, aturan pencarian barang (BR-KSR-001, BR-GEN-001) perlu diperluas untuk mendukung pencarian ganda (nama dan barcode) tanpa menghilangkan pencarian berbasis nama yang sudah ada.
5. **Notifikasi Otomatis Stok Menipis** — kemungkinan penambahan aturan pengiriman notifikasi WhatsApp/Telegram/Email otomatis ketika stok barang mencapai ambang batas hampir habis.
6. **Ekspor Laporan ke PDF/Excel** — kemungkinan penambahan aturan validasi dan pembatasan akses untuk fitur ekspor data laporan ke format eksternal.
7. **Role Tambahan (Supervisor)** — jika ditambahkan, memerlukan perluasan Role Access Matrix dan aturan-aturan pada kategori User Role secara menyeluruh.
8. **Program Loyalti Pelanggan** — kemungkinan penambahan aturan akumulasi poin dan penukaran reward yang terkait dengan modul Hutang/Pelanggan dan Checkout.

---

## 9. GLOSSARY

| Istilah | Definisi |
|---|---|
| **Owner** | Pemilik warung kelontong dengan akses penuh terhadap seluruh fitur StoreKuify. |
| **Kasir** | Staf operasional yang bertugas melayani transaksi penjualan dengan akses terbatas. |
| **Business Rule** | Aturan yang mendefinisikan bagaimana sistem harus berperilaku dalam kondisi tertentu, bersifat atomic dan independent. |
| **Kategori Barang** | Pengelompokan barang berdasarkan jenisnya (contoh: Sabun, Makanan, Minuman, Bumbu). |
| **Barang** | Item/produk yang dijual di warung, memiliki atribut nama, harga modal, harga jual, stok, dan foto (opsional). |
| **Harga Modal** | Harga pokok/biaya perolehan barang sebelum dijual. |
| **Harga Jual** | Harga yang dibebankan kepada pelanggan saat membeli barang. |
| **Keuntungan (Margin)** | Selisih antara Harga Jual dan Harga Modal, dihitung otomatis oleh sistem berdasarkan harga saat transaksi terjadi. |
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
| **Audit Trail / Audit Log** | Jejak/log pencatatan perubahan data penting beserta informasi aktor dan waktu perubahan. |
| **Race Condition** | Kondisi ketika dua atau lebih proses (contoh: dua kasir menjual barang yang sama secara bersamaan) berpotensi menghasilkan data yang tidak konsisten jika tidak ditangani dengan benar. |
| **Snapshot Harga** | Nilai Harga Modal dan Harga Jual yang disimpan pada level transaksi saat transaksi terjadi, terpisah dari nilai harga terkini pada master data Barang. |
| **Atomic (Business Rule)** | Sifat suatu aturan bisnis yang mengatur satu perilaku spesifik dan tidak dapat dipecah lagi menjadi aturan yang lebih kecil. |
| **MoSCoW Priority** | Metode penentuan prioritas: Must Have, Should Have, Could Have, Won't Have (digunakan untuk klasifikasi Prioritas pada dokumen ini, disederhanakan menjadi Critical/High/Must Have/Should Have). |

---

**— AKHIR DOKUMEN 03_Business_Rules.md —**

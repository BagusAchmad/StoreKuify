# 08_AI_Design_Brief.md
# AI DESIGN BRIEF
# STOREKUIFY — Web Based Grocery Store POS & Inventory Management System

---

## 1. DOCUMENT INFORMATION

| Atribut | Keterangan |
|---|---|
| Nama Dokumen | AI Design Brief — StoreKuify |
| Kode Dokumen | 08_AI_Design_Brief.md |
| Nama Proyek | StoreKuify |
| Jenis Aplikasi | Web Based Grocery Store POS & Inventory Management System |
| Bahasa Dokumen | Bahasa Indonesia |
| Sumber Kebenaran (Source of Truth) | 02_PRD.md, 03_Business_Rules.md, 04_Information_Architecture.md, 05_Sitemap.md, 06_User_Flow.md, 07_Design_System.md |
| Status Dokumen | Final Draft — Siap Digunakan sebagai Prompt/Referensi Utama untuk AI UI Design Tools |
| Disusun Oleh | Principal Product Designer, AI UX Architect & Design Director |
| Tanggal Dibuat | 02 Agustus 2026 |
| Confidentiality | Internal — Hanya untuk Tim Internal & Development Team |

Dokumen ini merupakan **referensi desain utama untuk AI UI Designer** (Stitch, Figma AI, Lovable, v0, Bolt, Galileo AI, Uizard, dan AI UI generator lainnya) dalam menghasilkan antarmuka StoreKuify.

Dokumen ini **BUKAN** Product Requirement Document, **BUKAN** Design System (referensi token/komponen teknis sudah dijabarkan lengkap pada 07_Design_System.md), dan **BUKAN** User Flow (logika interaksi langkah-demi-langkah sudah dijabarkan lengkap pada 06_User_Flow.md). Dokumen ini menjelaskan **BAGAIMANA AI HARUS BERPIKIR DAN MENDESAIN** — arah visual, filosofi tiap modul, prioritas desain, dan instruksi desain per layar — agar output AI mendekati kualitas final tanpa perlu banyak iterasi manual.

Seluruh isi dokumen ini **diturunkan sepenuhnya** dari 02_PRD.md, 03_Business_Rules.md, 04_Information_Architecture.md, 05_Sitemap.md, 06_User_Flow.md, dan 07_Design_System.md, tanpa menambahkan fitur baru, tanpa mengubah business rules, tanpa mengubah navigasi, dan tanpa mengubah user flow yang telah ditetapkan.

---

## 2. REVISION HISTORY

| Versi | Tanggal | Deskripsi Perubahan | Disusun Oleh | Disetujui Oleh |
|---|---|---|---|---|
| 0.1 | 02 Agustus 2026 | Draft awal AI Design Brief diturunkan dari 02_PRD.md, 03_Business_Rules.md, 04_Information_Architecture.md, 05_Sitemap.md, 06_User_Flow.md, dan 07_Design_System.md | Principal Product Designer & AI UX Architect | - |
| 1.0 | 02 Agustus 2026 | Finalisasi seluruh Design Brief: Visual Direction, Philosophy per Modul, Screen-by-Screen Instructions, AI Instructions, UI Quality Checklist | Principal Product Designer & AI UX Architect | Product Owner |

Catatan: Setiap perubahan pada dokumen sumber (02, 03, 04, 05, 06, 07) yang memengaruhi arah desain wajib disinkronkan ke dokumen ini dengan menambahkan baris revisi baru.

---

## 3. TABLE OF CONTENTS

1. Document Information
2. Revision History
3. Table of Contents
4. Project Overview
5. Product Personality
6. Target Users
7. UX Goals
8. Design Goals
9. Visual Direction
10. Brand Personality
11. Layout Philosophy
12. Navigation Philosophy
13. Dashboard Philosophy
14. POS Screen Philosophy
15. Data Management Philosophy
16. Reporting Philosophy
17. Interaction Philosophy
18. Component Usage Guidelines
19. Form Design Guidelines
20. Table Design Guidelines
21. Empty State Guidelines
22. Loading State Guidelines
23. Error State Guidelines
24. Confirmation Dialog Guidelines
25. Notification Guidelines
26. Responsive Strategy
27. Accessibility Guidelines
28. Motion Guidelines
29. Micro Interaction Guidelines
30. Screen Priority
31. Screen-by-Screen Design Instructions
32. What AI Should Prioritize
33. What AI Must Avoid
34. UI Quality Checklist
35. Final AI Design Instructions
36. Glossary

---

## 4. PROJECT OVERVIEW

**StoreKuify** adalah aplikasi kasir dan manajemen toko berbasis web yang dirancang khusus untuk **Warung Kelontong** — usaha retail skala kecil-menengah yang dikelola secara mandiri/keluarga, sesuai 02_PRD.md Bagian 4.

Dua role pengguna: **Owner** (akses penuh ke 7 modul: Dashboard, Data Barang, Kasir, Hutang Pelanggan, Laporan, Kelola Kasir, Pengaturan) dan **Kasir** (akses terbatas ke Dashboard, Kasir, Hutang Pelanggan, Profil Saya).

StoreKuify **sengaja dibuat sederhana** — bukan sistem retail modern kompleks seperti Indomaret/Alfamart. Tidak menggunakan barcode scanner (pencarian barang berbasis nama), single-store/single-tenant, dan QRIS bersifat statis dengan verifikasi manual oleh kasir (bukan integrasi payment gateway).

**Teknologi Referensi:** Laravel 12, Filament 4 (modul manajemen), Tailwind CSS (khususnya modul Kasir yang membutuhkan desain kustom di luar pola admin panel standar), MySQL.

AI UI Designer harus memahami: StoreKuify melayani **dua konteks penggunaan yang sangat berbeda** dalam satu aplikasi — (1) konteks manajemen/administratif yang tenang dan terstruktur (Dashboard, Data Barang, Laporan, Pengaturan), dan (2) konteks operasional cepat dan bertekanan waktu (modul Kasir/POS, digunakan berulang puluhan kali sehari sambil melayani pelanggan yang menunggu). Kedua konteks ini harus terasa **satu keluarga visual yang sama**, namun dengan penekanan desain yang berbeda sesuai kebutuhan masing-masing.

---

## 5. PRODUCT PERSONALITY

Jika StoreKuify adalah seseorang, ia adalah **asisten toko yang tenang, cekatan, dan dapat diandalkan** — bukan sistem korporat yang rumit, dan bukan aplikasi konsumen yang playful berlebihan.

| Sifat | Bukan |
|---|---|
| Tenang dan rapi | Ramai dan penuh ornamen |
| Cepat tanggap | Lambat/berat secara visual |
| Jujur dan transparan soal angka | Menyembunyikan/mengaburkan data finansial |
| Ramah bagi pengguna awam digital | Teknis dan mengintimidasi |
| Percaya diri tanpa berlebihan | Flashy, penuh gradient/animasi mencolok |

AI harus mendesain StoreKuify seolah sedang membangun **partner kerja harian pemilik warung** — sesuatu yang dipercaya untuk mencatat uang dan hutang pelanggan mereka, sehingga tampilan harus terasa **stabil, jujur, dan tidak neko-neko**.

---

## 6. TARGET USERS

| Aspek | Owner | Kasir |
|---|---|---|
| Profil | Pemilik warung kelontong, sering berusia dewasa-lanjut, tingkat literasi digital bervariasi (mungkin baru pertama kali pakai aplikasi bisnis digital) | Staf operasional, melayani transaksi harian, sering bekerja di bawah tekanan waktu (pelanggan menunggu di depan kasir) |
| Perangkat Utama | Desktop/laptop di ruang belakang toko, sesekali tablet | Tablet/desktop di meja kasir, kondisi pencahayaan dan kebisingan toko fisik |
| Kebutuhan Emosional | Rasa aman dan percaya terhadap akurasi data finansial; tidak ingin merasa "bodoh" saat memakai aplikasi | Kecepatan dan minim kesalahan klik; tidak ingin membuat pelanggan menunggu lama |
| Implikasi Desain | Hierarki visual sangat jelas, label eksplisit (bukan ikon abstrak), copy Bahasa Indonesia yang sopan dan tidak kaku | Target sentuh besar, kontras tinggi, alur checkout sesingkat mungkin, minim langkah yang tidak perlu |

AI harus selalu mendesain dengan asumsi **pengguna non-teknis** sebagai baseline — bukan power user SaaS berpengalaman.

---

## 7. UX GOALS

| Goal | Penjelasan |
|---|---|
| **Transaksi Kasir < 30 Detik** | Alur Kasir → Keranjang → Checkout → Struk harus dapat diselesaikan dalam waktu sesingkat mungkin (selaras NFR-01/NFR-02 pada 02_PRD.md), didukung oleh layout, ukuran tombol, dan minim langkah tambahan. |
| **Maksimal 3 Klik untuk Halaman Penting** | Dashboard, Kasir, Data Barang, Hutang Pelanggan dapat dicapai maksimal 3 klik dari sidebar manapun (NAV-002). |
| **Zero Ambiguity pada Data Finansial** | Nominal, status hutang, status stok tidak pernah ambigu — selalu jelas maknanya dalam satu pandangan. |
| **Error Recovery Tanpa Kehilangan Data** | Setiap kegagalan (validasi, stok, jaringan) tidak boleh menghilangkan data yang sudah diinput pengguna (BR-ERR-004). |
| **Konsistensi Navigasi Penuh** | Sidebar, breadcrumb, dan pola interaksi tidak berubah antar halaman dalam satu sesi role (NAV-010). |
| **Low Cognitive Load** | Jumlah elemen visual per layar dijaga minimal; informasi disajikan bertahap (progressive disclosure) bukan sekaligus. |

---

## 8. DESIGN GOALS

| Goal | Penjelasan |
|---|---|
| Tampilan setara kualitas dashboard enterprise modern (Stripe Dashboard, Linear, Notion, Tailwind UI, Shadcn UI) **tanpa meniru identitas visual mereka** | Gunakan prinsip clean layout, whitespace, tipografi tegas — bukan mengkloning warna/komponen produk tersebut. |
| Satu bahasa visual dari Login hingga Error Page | Tidak ada halaman yang terasa "berbeda produk". |
| Desain harus scalable untuk data kosong maupun data penuh | Setiap layar harus tetap terlihat baik dalam kondisi Empty State maupun ratusan baris data. |
| Desain mendukung kepercayaan finansial | Nominal Rupiah, status hutang, dan status transaksi harus selalu menjadi elemen paling jelas terbaca di setiap layar yang menampilkannya. |
| Desain siap pakai untuk implementasi Filament 4 + Tailwind CSS | Struktur komponen tidak boleh memerlukan pola custom yang sulit direplikasi di Filament 4 untuk modul manajemen. |

---

## 9. VISUAL DIRECTION

| Aspek | Arahan |
|---|---|
| Gaya | Modern, Minimalist, Clean, Professional, Friendly, Fast, Simple, Elegant |
| Layout | Desktop First, Responsive penuh ke Tablet dan Mobile |
| Warna | Satu warna primer tegas (`primary-600` #2563EB — lihat 07_Design_System.md Bagian 7), palet netral luas, warna semantik jelas untuk status finansial dan stok |
| Tipografi | Sans-serif modern (Inter), hierarki tegas, angka menggunakan tabular numerals agar sejajar di tabel |
| Densitas | Rendah pada halaman non-tabel (Dashboard, Form), sedang-padat pada tabel data (Data Barang, Laporan) — tetap terstruktur, tidak sesak |
| Ornamen | Minimal — shadow lembut, radius konsisten, tanpa gradient mencolok, tanpa ilustrasi berlebihan di luar Empty State/Error Page |
| Referensi Kualitas | Kualitas visual setara dashboard enterprise modern; **JANGAN meniru** produk manapun secara langsung (warna, layout persis, ikon custom brand tertentu) |
| Fotografi/Gambar Produk | Foto barang bersifat opsional (sesuai PRD) — desain harus tetap elegan meski banyak barang tanpa foto (gunakan placeholder ikon box konsisten, bukan gambar kosong yang janggal) |

---

## 10. BRAND PERSONALITY

Mengikuti 07_Design_System.md Bagian 6 — StoreKuify: **Modern, Bersih, Minimalis, Profesional, Ramah, Cepat.**

**Nada Komunikasi (Voice) yang harus tercermin dalam desain UI copy:**

| Konteks | Nada |
|---|---|
| Label/Instruksi | Netral, jelas, langsung — "Nama Barang", "Harga Jual" |
| Pesan Sukses | Positif, ringkas — "Barang berhasil disimpan" |
| Pesan Error | Informatif, tidak menyalahkan pengguna — "Stok Beras 5kg tidak mencukupi, sisa stok: 3" |
| Konfirmasi Destruktif | Tegas namun sopan — "Barang ini akan dinonaktifkan dan tidak dapat dijual. Lanjutkan?" |
| Empty State | Ramah, mengarahkan aksi — "Belum ada barang di kategori ini. Tambahkan barang pertama Anda." |

AI harus menulis seluruh microcopy dalam **Bahasa Indonesia yang jelas**, tidak menggunakan istilah teknis/Inggris yang tidak perlu (contoh: gunakan "Simpan" bukan "Submit", "Batal" bukan "Cancel").

---

## 11. LAYOUT PHILOSOPHY

StoreKuify menggunakan **dua pola layout berbeda** sesuai konteks penggunaan, keduanya harus tetap terasa satu keluarga visual (warna, tipografi, spacing sama).

### 11.1 Layout Administratif (Dashboard, Data Barang, Hutang, Laporan, Kelola Kasir, Pengaturan)

Pola **Persistent Sidebar + Topbar + Content Area** — struktur admin panel modern, tenang, terorganisir, dengan whitespace cukup agar tidak terasa padat meski menampilkan banyak data tabel/statistik.

### 11.2 Layout Operasional (Kasir/POS)

Pola **Split-View Dua Panel** — panel kiri untuk pencarian & daftar barang (area kerja utama), panel kanan untuk keranjang & ringkasan checkout (selalu terlihat, sticky). Layout ini secara sengaja **berbeda** dari layout admin standar karena tujuannya berbeda: kecepatan transaksi, bukan eksplorasi data.

### 11.3 Prinsip Universal Layout

| Prinsip | Penjelasan |
|---|---|
| Grid 12-kolom (desktop) | Basis penyusunan seluruh halaman administratif, lihat 07_Design_System.md Bagian 15 |
| Whitespace sebagai alat hierarki | Jarak antar elemen digunakan untuk mengelompokkan informasi terkait, bukan sekadar estetika |
| Satu Primary Action per Halaman | Setiap halaman memiliki maksimal satu tombol aksi utama yang paling menonjol (contoh: "Tambah Barang" di Data Barang) |
| Konten Terpusat pada Konteks | Layout tidak boleh membuat pengguna mencari-cari elemen penting — data paling relevan dengan tugas saat ini selalu di area pandang utama (above the fold) |

---

## 12. NAVIGATION PHILOSOPHY

Navigasi StoreKuify **dangkal (shallow)** dan **dapat diprediksi**, sesuai 04_Information_Architecture.md.

| Prinsip | Penjelasan untuk AI |
|---|---|
| Sidebar sebagai peta mental utama | Item sidebar harus selalu terlihat sama persis (urutan, label, ikon) di seluruh halaman dalam satu role — ini adalah "jangkar" orientasi pengguna non-teknis |
| Role-based visibility eksplisit | Sidebar Owner menampilkan 7 item; Sidebar Kasir menampilkan 4 item (Dashboard, Kasir, Hutang Pelanggan, Profil Saya) — AI tidak boleh mencampur/menambah item di luar struktur ini |
| Breadcrumb selalu ada (kecuali Login & Error Page) | Breadcrumb menjadi penunjuk posisi, terutama penting untuk drill-down (Data Barang → Kategori → Detail Kategori → Barang → Detail Barang) |
| Modal tidak mengubah URL/breadcrumb | Modal/dialog adalah lapisan sementara, bukan halaman baru — desain harus mencerminkan ini secara visual (overlay, bukan transisi halaman penuh) |
| Tab tidak mengubah breadcrumb induk | Contoh: tab Laporan Harian/Mingguan/Bulanan/Tahunan hanya mengubah konten, bukan posisi hierarki |

---

## 13. DASHBOARD PHILOSOPHY

Dashboard adalah **halaman pertama yang dilihat setiap hari** — harus memberi gambaran kondisi toko dalam hitungan detik (at-a-glance), bukan halaman yang perlu dianalisis lama.

| Prinsip | Penjelasan |
|---|---|
| **F-Pattern Scanning** | Statistic Card paling penting (Penjualan/Keuntungan) diletakkan di baris teratas, kiri-ke-kanan sesuai urutan prioritas bisnis |
| **Angka Besar, Konteks Kecil** | Nominal utama pada Statistic Card menggunakan tipografi besar (`dashboard-metric`, 30px bold), label deskriptif kecil di atasnya |
| **Role-Aware Content, Bukan Sekadar Role-Aware Access** | Dashboard Kasir secara desain **tidak boleh menyisakan ruang kosong mencurigakan** di tempat widget Keuntungan biasanya berada pada Dashboard Owner — layout Kasir harus dirancang ulang secara proporsional (bukan Dashboard Owner dikurangi satu card), sesuai BR-DASH-003 |
| **Actionable Widgets** | Widget "Barang Hampir Habis" dan "Hutang Belum Lunas" bukan sekadar informasi pasif — harus terasa clickable/actionable menuju halaman detail terkait (cross-navigation sesuai 04_Information_Architecture.md Bagian 14) |
| **Grafik sebagai Cerita, Bukan Dekorasi** | Grafik Penjualan harus langsung menjawab "apakah tren naik atau turun?" tanpa perlu membaca angka detail terlebih dahulu |
| **Graceful Zero State** | Jika belum ada transaksi hari berjalan, tampilkan nilai "Rp 0" dengan pesan informatif — bukan card kosong atau skeleton yang tidak pernah selesai (BR-DASH-002 Exception) |

---

## 14. POS SCREEN PHILOSOPHY

Modul Kasir adalah **jantung operasional harian** StoreKuify dan layar dengan frekuensi penggunaan tertinggi. Filosofi desainnya berbeda signifikan dari halaman lain.

| Prinsip | Penjelasan |
|---|---|
| **Speed Over Aesthetics Refinement** | Jika ada trade-off antara tampilan yang "cantik" dan kecepatan interaksi, kecepatan selalu menang. Tombol besar, area klik luas, minim langkah. |
| **Search-First Interaction** | Search bar barang adalah elemen pertama yang harus diperhatikan pengguna saat membuka Kasir — auto-focus, ukuran besar (52px height), posisi paling atas panel kiri. Ini menggantikan barcode scanner. |
| **Keranjang Selalu Terlihat** | Panel kanan (keranjang + ringkasan) bersifat sticky/fixed — pengguna tidak pernah perlu scroll untuk melihat total transaksi berjalan atau menekan tombol Checkout. |
| **Zero Ambiguity pada Stok** | Barang dengan stok habis tetap muncul di hasil pencarian namun secara visual jelas tidak dapat diklik (opacity turun, badge "Stok Habis", cursor not-allowed) — bukan disembunyikan, agar kasir tidak bingung kenapa barang "hilang". |
| **Real-Time Feedback** | Setiap perubahan jumlah di keranjang (+/-) langsung memperbarui subtotal tanpa delay/loading terlihat. |
| **Payment Method sebagai Pilihan Visual Besar** | Empat metode pembayaran (Cash, QRIS, Hutang, Cash+Hutang) ditampilkan sebagai pilihan besar/card selectable, bukan dropdown kecil — mengurangi risiko salah pilih saat terburu-buru. |
| **Loading yang Mencegah Double-Submit** | Tombol "Selesaikan Transaksi" wajib menunjukkan state loading yang sangat jelas (disabled + spinner + opsional overlay ringan) karena risiko transaksi ganda sangat kritis pada konteks kasir yang cepat menekan tombol. |
| **Struk sebagai Penutup yang Jelas** | Setelah checkout berhasil, Struk Transaksi harus terasa sebagai "titik selesai" yang jelas — desain harus memberi sinyal visual kuat (checkmark, warna sukses) sebelum kasir kembali ke pencarian barang untuk transaksi berikutnya. |
| **QRIS: Kejujuran Visual tentang Proses Manual** | Karena verifikasi QRIS bersifat manual/trust-based (bukan otomatis), desain harus membuat tombol "Konfirmasi Pembayaran Diterima" terasa sebagai **keputusan sadar kasir**, bukan tombol pasif — beri sedikit penekanan visual (bukan warna alarm, cukup kontras tegas) agar kasir tidak asal klik. |

---

## 15. DATA MANAGEMENT PHILOSOPHY

Modul Data Barang, Hutang Pelanggan, dan Kelola Kasir adalah tentang **kepercayaan terhadap keakuratan data dari waktu ke waktu**.

| Prinsip | Penjelasan |
|---|---|
| **Drill-Down yang Dapat Diprediksi** | Hierarki Kategori → Detail Kategori → Barang → Detail Barang harus terasa seperti membuka folder, bukan berpindah aplikasi — transisi visual konsisten di setiap level. |
| **Status Selalu Terlihat, Tidak Pernah Tersembunyi** | Barang nonaktif tetap tampil di daftar (opacity turun, bukan dihilangkan) sesuai BR-BRG-008 — desain harus secara eksplisit membedakan "nonaktif" dari "terhapus". |
| **Nonaktifkan ≠ Menghapus (Visual Language)** | Ikon dan copy untuk aksi nonaktifkan harus terasa berbeda dari "hapus permanen" — hindari ikon tempat sampah merah tegas yang menyiratkan penghapusan destruktif; gunakan bahasa visual yang lebih netral (toggle/slash-circle). |
| **Snapshot Harga sebagai Konsep Tersembunyi namun Konsisten** | Perubahan harga barang tidak memengaruhi transaksi historis — meskipun ini adalah logika data, UI Laporan/Detail Transaksi harus tetap menampilkan harga **saat transaksi terjadi**, bukan harga terkini, agar tidak membingungkan Owner. |
| **Hutang: Transparansi Total** | Detail Hutang & Histori Pelanggan harus menampilkan seluruh riwayat transaksi dan pembayaran secara kronologis dan tidak dapat dihapus (BR-HTG-005) — desain tabel histori harus terasa seperti "buku catatan digital yang dapat dipercaya". |
| **Form Sebagai Pencegah Kesalahan, Bukan Sekadar Input** | Validasi harga jual < harga modal, duplikasi nama, dan format file harus terasa sebagai bantuan, bukan hambatan — pesan error harus muncul tepat di dekat field yang salah, dengan bahasa yang membantu bukan menyalahkan. |

---

## 16. REPORTING PHILOSOPHY

Laporan adalah modul **khusus Owner** yang mendukung pengambilan keputusan bisnis — harus mengutamakan **keterbacaan data dalam jumlah besar** di atas estetika dekoratif.

| Prinsip | Penjelasan |
|---|---|
| **Scannability di Atas Segalanya** | Tabel dan chart pada Laporan harus dapat "dipindai" cepat oleh mata — angka rata kanan, tabular nums, header kolom jelas dan sticky saat scroll panjang. |
| **Perbandingan Periode sebagai Kebutuhan Inti** | Tab Harian/Mingguan/Bulanan/Tahunan harus terasa sebagai satu kontinuum data, bukan empat halaman terpisah — transisi antar tab instan tanpa reload penuh. |
| **Highlight yang Bermakna** | Barang Terlaris/Paling Menguntungkan ditampilkan sebagai ranking visual (nomor urut + bar horizontal proporsional), bukan sekadar daftar teks datar. |
| **Angka Keuntungan sebagai Fokus Utama Owner** | Karena ini adalah data yang hanya Owner lihat, desain boleh memberi penekanan visual lebih kuat pada Keuntungan dibanding Penjualan Kotor (ukuran font, posisi) — ini adalah informasi paling bernilai bagi Owner. |
| **Filter Tanpa Friksi** | Filter rentang tanggal kustom harus terasa cepat digunakan (date range picker yang jelas), tidak memerlukan banyak klik untuk kombinasi umum (Hari Ini, Minggu Ini, Bulan Ini). |
| **Data Kosong = Insight, Bukan Kegagalan** | Jika tidak ada data pada periode tertentu, tampilkan pesan yang membantu Owner memahami ("Belum ada transaksi pada periode ini"), bukan chart/tabel kosong tanpa konteks. |

---

## 17. INTERACTION PHILOSOPHY

| Prinsip | Penjelasan |
|---|---|
| **Setiap Aksi Punya Feedback** | Tidak ada aksi (klik, submit, hapus) yang "diam saja" — selalu ada perubahan visual (loading, toast, redirect, error inline). |
| **Prevent Double Submission** | Tombol aksi kritis (Simpan, Selesaikan Transaksi) selalu dikunci selama proses berlangsung. |
| **Unsaved Changes Terlindungi** | Menutup form/modal dengan perubahan belum tersimpan selalu memicu konfirmasi, tidak pernah kehilangan data diam-diam. |
| **Confirmation Sebelum Aksi Kritis** | Nonaktifkan, Hapus, Logout selalu melalui Dialog konfirmasi eksplisit — tidak ada aksi destruktif satu-klik. |
| **Realtime di Mana Berarti** | Live search, kalkulasi subtotal keranjang, kembalian cash — seluruhnya real-time tanpa perlu tombol "Hitung" terpisah. |
| **Kegagalan Tidak Menghapus Usaha Pengguna** | Form yang gagal validasi tetap mempertahankan seluruh input yang sudah diisi pengguna; keranjang yang gagal checkout (stok berubah) tetap utuh. |

---

## 18. COMPONENT USAGE GUIDELINES

AI harus menggunakan **komponen yang telah didefinisikan pada 07_Design_System.md** secara konsisten — dokumen ini memberi konteks kapan menggunakan komponen tersebut.

| Komponen | Kapan Digunakan | Kapan TIDAK Digunakan |
|---|---|---|
| **Button Primary** | Satu per halaman/section untuk aksi paling penting (Simpan, Checkout, Tambah Barang) | Jangan gunakan lebih dari satu Button Primary yang bersaing dalam satu area pandang |
| **Button Danger** | Aksi destruktif eksplisit (Nonaktifkan, Hapus) — selalu dipicu dari dalam Dialog konfirmasi | Jangan gunakan sebagai warna default tombol biasa |
| **Badge** | Representasi status data (Aktif, Hampir Habis, Lunas, dll — lihat 07_Design_System.md Bagian 24) | Jangan gunakan Badge untuk label yang bukan status (gunakan teks biasa) |
| **Modal** | Form ringkas yang tidak memerlukan konteks halaman penuh (Tambah Kategori, Reset Password) | Jangan gunakan Modal untuk form kompleks dengan banyak section (gunakan halaman penuh) |
| **Dialog** | Konfirmasi aksi sensitif/destruktif SAJA | Jangan gunakan Dialog untuk form input data |
| **Toast** | Feedback sementara non-blocking (berhasil/gagal simpan) | Jangan gunakan Toast untuk pesan yang harus dibaca lengkap dan disimpan konteksnya (gunakan Alert inline) |
| **Alert** | Peringatan kontekstual yang menempel di halaman (banner stok, validasi form) | Jangan gunakan Alert untuk notifikasi sesaat (gunakan Toast) |
| **Skeleton Loading** | Pemuatan awal halaman/data tabel/dashboard | Jangan gunakan spinner penuh layar yang memblokir seluruh konten |
| **Statistic Card** | Ringkasan angka kunci pada Dashboard | Jangan gunakan untuk data yang memerlukan detail/breakdown (gunakan Table) |

**Reusability Rule:** Setiap komponen yang muncul lebih dari satu kali di seluruh aplikasi (Button, Card, Badge, Input, Table Row, dll.) harus didesain sebagai **satu definisi visual tunggal** yang dipakai ulang — AI tidak boleh menghasilkan variasi kecil yang tidak konsisten (contoh: radius button berbeda-beda di halaman berbeda).

---

## 19. FORM DESIGN GUIDELINES

| Prinsip | Penjelasan |
|---|---|
| **Minimize Mistakes by Design** | Field Harga Jual dan Harga Modal diletakkan berdampingan (agar mudah dibandingkan visual), dengan validasi real-time yang mencegah harga jual lebih kecil dari harga modal sebelum submit. |
| **Single Column pada Form Pendek** | Modal seperti Tambah Kategori, Reset Password — satu kolom, fokus penuh. |
| **Grouped Two-Column pada Form Panjang** | Form Tambah/Edit Barang, Pengaturan Profil Toko — dikelompokkan per topik (Informasi Dasar, Informasi Harga, Foto) dengan judul grup jelas. |
| **Label di Atas Input** | Selalu top-aligned, bukan inline kiri — mendukung scan-reading cepat dan responsif ke mobile. |
| **Required Indicator Eksplisit** | Asterisk merah pada seluruh field wajib, tidak mengandalkan asumsi pengguna. |
| **Upload Foto yang Ramah** | Dropzone dengan preview langsung, batas ukuran/format ditampilkan jelas sebelum error terjadi (proaktif, bukan reaktif). |
| **Validasi Sedini Mungkin** | Validasi on-blur untuk field kritis (duplikasi nama/username) — pengguna tahu masalah sebelum menekan Simpan, bukan setelah. |
| **Tombol Aksi Selalu Predictable** | "Batal" di kiri, tombol aksi utama (Simpan/dsb.) di kanan — posisi ini konsisten di SELURUH form aplikasi tanpa pengecualian. |

---

## 20. TABLE DESIGN GUIDELINES

| Prinsip | Penjelasan |
|---|---|
| **Kolom Prioritas Tinggi di Kiri** | Nama Barang/Pelanggan/Kasir (identitas utama) selalu kolom pertama, kolom Aksi selalu kolom terakhir. |
| **Angka Selalu Rata Kanan** | Harga, Stok, Nominal — rata kanan dengan tabular nums, memudahkan perbandingan vertikal. |
| **Status via Badge, Bukan Teks Polos** | Kolom Status selalu menggunakan Badge berwarna, tidak pernah teks hitam polos "Aktif"/"Nonaktif". |
| **Toolbar Konsisten di Atas Tabel** | Search (kiri) + Filter (tengah) + Primary Action (kanan) — pola ini identik di Data Barang, Hutang Pelanggan, Kelola Kasir. |
| **Row Sebagai Pintu Masuk Detail** | Klik baris (di luar kolom Aksi) langsung membuka halaman Detail — mengurangi kebutuhan tombol "Lihat" terpisah di setiap baris. |
| **Nonaktif Tetap Terlihat, Bukan Hilang** | Baris data nonaktif tetap ada dengan opacity diturunkan, memvalidasi kepercayaan bahwa data tidak pernah hilang diam-diam. |
| **Pagination Informatif** | Selalu tampilkan "Menampilkan X–Y dari Z data" — bukan hanya nomor halaman, agar Owner memahami skala data tokonya. |

---

## 21. EMPTY STATE GUIDELINES

| Konteks | Pendekatan Desain |
|---|---|
| Data Barang/Kategori Kosong (pertama kali pakai) | Ilustrasi/icon ramah + judul jelas + deskripsi singkat + tombol aksi utama ("Tambah Barang Pertama Anda") — mendorong onboarding aktif |
| Hasil Pencarian Kosong | Pesan ringan tanpa ilustrasi besar ("Barang tidak ditemukan"), tanpa Primary Action Button — ini kondisi sementara, bukan kondisi awal aplikasi |
| Widget Dashboard Kosong (Barang Hampir Habis/Hutang) | Pesan inline positif dengan icon check ("Semua stok barang aman") — Empty State di sini adalah **kabar baik**, desain harus mencerminkan nada positif, bukan nada "kosong/kurang" |
| Laporan Tanpa Data pada Periode | Pesan kontekstual di tengah area chart/tabel ("Belum ada transaksi pada periode ini"), dengan saran mengubah filter periode |
| Prinsip Umum | Empty State tidak boleh terasa seperti "error" atau kegagalan sistem — selalu bernada membantu dan mengarahkan langkah berikutnya |

---

## 22. LOADING STATE GUIDELINES

| Konteks | Pendekatan Desain |
|---|---|
| Pemuatan Halaman Awal | Skeleton Loading yang meniru struktur konten asli (bukan spinner generik) |
| Submit Form/Transaksi | Spinner inline dalam tombol, tombol terkunci, tanpa mengubah layout sekitar |
| Refresh Data Tabel | Overlay semi-transparan, data lama tetap terlihat samar hingga data baru siap — menghindari "flash of empty content" |
| Live Search | Skeleton super singkat (2-3 baris) — hampir tidak terlihat karena respons harus instan |
| Prinsip Kritis untuk Kasir | Loading pada modul Kasir/Checkout HARUS terasa sangat singkat dan jelas — hindari loading state yang membuat kasir ragu apakah tombol sudah tertekan atau belum |

---

## 23. ERROR STATE GUIDELINES

| Konteks | Pendekatan Desain |
|---|---|
| Validasi Form (field-level) | Border merah pada input + pesan error tepat di bawah field, bahasa spesifik dan actionable |
| Error Bisnis (contoh: stok tidak cukup) | Toast/Alert dengan pesan spesifik menyebutkan nama barang dan sisa stok, bukan pesan generik |
| Race Condition Checkout | Alert tegas namun tenang di halaman Checkout: "Stok [Nama Barang] telah berubah, silakan periksa kembali keranjang Anda" — keranjang tetap utuh secara visual, tidak reset ke kosong |
| Error Sistem (500, Network Error) | Halaman/ilustrasi ramah bernada tenang, tombol "Coba Lagi" atau "Kembali ke Dashboard" jelas — hindari pesan teknis (stack trace) yang menakutkan pengguna non-teknis |
| Session Expired | Redirect halus ke Login dengan pesan singkat "Sesi Anda telah berakhir, silakan login kembali" — nada netral, bukan menyalahkan pengguna |
| 403 Forbidden | Pesan jelas sesuai role: pengguna paham bahwa ini bukan bug, melainkan pembatasan akses yang disengaja |
| Prinsip Umum | Error harus selalu terasa seperti "sistem sedang membantu Anda memperbaiki sesuatu", bukan "sistem menyalahkan Anda" |

---

## 24. CONFIRMATION DIALOG GUIDELINES

| Aksi | Pendekatan |
|---|---|
| Nonaktifkan Barang/Kasir | Dialog dengan icon netral (bukan tanda bahaya ekstrem), judul jelas, deskripsi menjelaskan konsekuensi ("data historis tetap tersimpan") untuk mengurangi kecemasan pengguna |
| Logout | Dialog ringan, nada netral — bukan seolah aksi berbahaya |
| Delete/Nonaktifkan Generik | Selalu tombol "Batal" di kiri (default/aman) dan tombol aksi (Danger) di kanan — posisi tombol Batal harus konsisten agar pengguna terburu-buru tidak salah klik |
| Konfirmasi QRIS saat Checkout | Modal non-dismissible (tidak bisa ditutup via klik overlay) karena berkaitan langsung dengan integritas transaksi — desain harus memberi sinyal bahwa ini adalah langkah wajib, bukan opsional |
| Prinsip Umum | Dialog konfirmasi tidak boleh terasa berlebihan/menakutkan untuk aksi yang sebenarnya reversible (nonaktifkan bukan hapus permanen) — nada visual harus proporsional dengan tingkat risiko aksi |

---

## 25. NOTIFICATION GUIDELINES

| Jenis | Kapan | Nada Visual |
|---|---|---|
| Toast Sukses | Simpan/Update berhasil, Transaksi selesai | Hijau, ringkas, auto-dismiss cepat (4 detik) |
| Toast Error | Gagal simpan, kesalahan sistem non-kritis | Merah, tetap terlihat lebih lama (6 detik) agar sempat dibaca |
| Toast Warning | Peringatan ringan (stok mulai menipis setelah transaksi) | Kuning/oranye, tidak mengganggu alur kerja |
| Alert Inline | Informasi kontekstual yang relevan sepanjang pengguna berada di halaman tersebut | Menempel di halaman, tidak hilang otomatis |
| Prinsip Umum | Notifikasi tidak boleh menumpuk berlebihan atau memblokir interaksi berikutnya — maksimal 3 toast terlihat bersamaan, notifikasi baru tidak boleh menutupi tombol aksi penting |

---

## 26. RESPONSIVE STRATEGY

Desktop First namun **wajib** berfungsi baik di Tablet (perangkat umum di meja kasir) dan Mobile.

| Breakpoint | Prioritas Desain |
|---|---|
| Desktop (≥1280px) | Pengalaman penuh — sidebar expanded, split-view Kasir, tabel lengkap |
| Tablet (768–1023px) | **Prioritas tinggi** karena tablet adalah perangkat umum di meja kasir fisik — sidebar collapse ke icon-only, split-view Kasir dipertahankan jika ruang cukup |
| Mobile (<768px) | Sidebar menjadi drawer, tabel menjadi card list, modul Kasir: panel kiri full-screen + keranjang sebagai bottom sheet floating |

AI harus mendesain modul Kasir dengan asumsi **tablet adalah perangkat setara-penting dengan desktop**, bukan sekadar breakpoint sekunder — karena ini adalah kenyataan penggunaan warung kelontong sehari-hari.

---

## 27. ACCESSIBILITY GUIDELINES

| Prinsip | Penjelasan |
|---|---|
| Kontras Warna Minimum | 4.5:1 untuk teks body, 3:1 untuk teks besar/elemen UI non-teks (WCAG AA) |
| Status Tidak Hanya via Warna | Setiap status (error, sukses, peringatan) disertai icon dan/atau teks eksplisit, tidak hanya warna |
| Target Sentuh Besar | Minimum 40x40px, krusial pada modul Kasir yang digunakan di tablet |
| Keyboard Navigable | Seluruh elemen interaktif dapat diakses via keyboard, fokus terlihat jelas (focus ring) |
| Label Bahasa Indonesia yang Jelas | Mendukung pengguna dengan tingkat literasi digital rendah — hindari jargon teknis |
| Required Field Jelas | Asterisk visual + atribut aria-required |

Detail teknis lengkap (rasio kontras per token warna, aria attributes) mengacu pada 07_Design_System.md Bagian 38.

---

## 28. MOTION GUIDELINES

| Prinsip | Penjelasan |
|---|---|
| Fungsional, Bukan Dekoratif | Setiap animasi harus punya tujuan (memberi feedback, menunjukkan hubungan spasial) — bukan sekadar "terlihat modern" |
| Durasi Singkat | 120–250ms untuk sebagian besar transisi UI (hover, modal, toast) — lihat 07_Design_System.md Bagian 39 |
| Tidak Ada Transisi Halaman Penuh | Perpindahan antar halaman bersifat instan, mendukung kecepatan kerja kasir |
| Reduced Motion Dihormati | Animasi non-esensial dinonaktifkan saat preferensi sistem `prefers-reduced-motion` aktif |

---

## 29. MICRO INTERACTION GUIDELINES

| Interaksi | Detail |
|---|---|
| Tambah ke Keranjang | Feedback visual instan (highlight singkat pada baris keranjang, subtotal update tanpa delay) |
| Checkout Berhasil | Micro-animation checkmark ringan (400ms) sebagai penutup psikologis transaksi sebelum kembali ke pencarian |
| Toggle +/- Jumlah Keranjang | Perubahan angka terasa responsif (tanpa loading), dengan sedikit transisi angka jika teknis memungkinkan |
| Hover pada Card/Row Clickable | Perubahan shadow/background halus (120ms) menandakan elemen dapat diklik |
| Validasi Real-Time (Password/Username tersedia) | Icon check muncul halus saat validasi berhasil, tanpa animasi berlebihan |
| Prinsip Umum | Micro-interaction memperkuat rasa "sistem merespons saya", tidak pernah memperlambat alur kerja aktual |

---

## 30. SCREEN PRIORITY

Urutan prioritas desain — AI harus mengalokasikan perhatian desain paling detail sesuai urutan berikut, karena ini mencerminkan frekuensi dan kekritisan penggunaan:

| Prioritas | Halaman | Alasan |
|---|---|---|
| **P0 — Kritis** | Kasir (Pencarian & Keranjang), Checkout, QRIS, Struk Transaksi | Digunakan puluhan kali sehari, sensitif waktu, langsung berdampak pada uang toko |
| **P0 — Kritis** | Login | Titik masuk tunggal seluruh pengguna |
| **P1 — Sangat Penting** | Dashboard Owner, Dashboard Kasir | Halaman pertama dilihat setiap sesi |
| **P1 — Sangat Penting** | Data Barang (Kategori, Detail Kategori, Barang, Detail Barang), Tambah/Edit Barang | Fondasi data yang digunakan modul Kasir |
| **P1 — Sangat Penting** | Hutang Pelanggan (Daftar & Detail), Pembayaran Hutang | Menyangkut kepercayaan finansial pelanggan |
| **P2 — Penting** | Laporan | Digunakan berkala (harian/mingguan) oleh Owner, bukan real-time sepanjang hari |
| **P2 — Penting** | Kelola Kasir, Pengaturan, Profil Saya | Digunakan jarang, namun harus tetap rapi dan tidak membingungkan saat diakses |
| **P3 — Standar** | Modal/Dialog Konfirmasi, Empty State, Loading State, Error Pages | Elemen pendukung — harus konsisten mengikuti Design System, tidak memerlukan eksplorasi visual baru per halaman |

---

## 31. SCREEN-BY-SCREEN DESIGN INSTRUCTIONS

### 31.1 Login (PG-001)

| Aspek | Instruksi |
|---|---|
| Layout | Single centered card, max-width 400px, vertikal & horizontal center, background `bg-page` polos atau aksen bentuk geometris minimal `primary-50` |
| Konten | Logo StoreKuify di atas form, field Username + Password, tombol "Masuk" (Primary, full-width), tanpa elemen dekoratif berlebihan |
| Nada | Tenang, meyakinkan — ini titik masuk pertama kali bagi pengguna yang mungkin baru pertama pakai aplikasi digital |
| Error | Pesan error login digabung ("Username atau password salah") tepat di atas tombol submit, tidak menyebut field spesifik (mencegah user enumeration, sesuai BR-ERR) |

### 31.2 Dashboard Owner (SCR-002 / PG-002)

| Aspek | Instruksi |
|---|---|
| Struktur | Baris 1: 4 Statistic Card (Penjualan Hari Ini, Keuntungan Hari Ini, Jumlah Transaksi, Barang Terjual). Baris 2: Grafik Penjualan full-width. Baris 3: dua List Widget berdampingan (Barang Hampir Habis, Hutang Belum Lunas) |
| Fokus Visual | Keuntungan Hari Ini boleh mendapat sedikit penekanan (warna `success-600` pada value) karena ini metrik paling bernilai bagi Owner |
| Interaksi | Setiap List Widget item clickable menuju Detail Barang/Detail Hutang; Grafik memiliki tooltip hover |
| Zero State | Jika belum ada transaksi hari ini, seluruh Statistic Card menampilkan "Rp 0" / "0" dengan tetap terlihat lengkap (bukan disembunyikan) |

### 31.3 Dashboard Kasir (SCR-003 / PG-003)

| Aspek | Instruksi |
|---|---|
| Struktur | Baris 1: 1 Statistic Card "Ringkasan Transaksi Hari Ini" (jumlah transaksi, bukan nominal keuntungan). Baris 2: dua List Widget (Barang Hampir Habis, Hutang Pelanggan) |
| Fokus Visual | Layout dirancang ulang secara proporsional — TIDAK menyisakan ruang kosong di posisi widget Keuntungan pada Dashboard Owner. Card lebih besar/lega karena jumlah widget lebih sedikit |
| Larangan Tegas | Tidak boleh ada elemen apa pun yang menyiratkan nominal Keuntungan atau margin, sesuai BR-DASH-003 |

### 31.4 Kategori (Daftar Kategori — Landing Page Data Barang)

| Aspek | Instruksi |
|---|---|
| Layout | Grid card kategori (icon/warna representatif per kategori + nama + jumlah barang di dalamnya) ATAU table view sederhana — pilih grid card untuk kesan lebih ramah non-teknis |
| Toolbar | Search + Button Primary "Tambah Kategori" (Owner only) |
| Kasir View | Read-only — tanpa tombol Tambah/Edit, card tetap clickable untuk drill-down |
| Empty State | "Belum Ada Kategori" + Button "Tambah Kategori Pertama" |

### 31.5 Data Barang — Detail Kategori & Daftar Barang

| Aspek | Instruksi |
|---|---|
| Layout | Breadcrumb jelas (Data Barang > [Nama Kategori]), Header menampilkan nama kategori + tombol Edit (Owner), diikuti Table daftar barang dalam kategori tersebut |
| Table Columns | Foto (jika ada, thumbnail kecil), Nama Barang, Harga Modal (Owner only view — pertimbangkan apakah Kasir perlu lihat, sesuai Page Access Matrix Kasir Read Only mencakup seluruh kolom), Harga Jual, Stok (dengan Badge status), Status Aktif/Nonaktif, Aksi |
| Toolbar | Search barang dalam kategori + Button Primary "Tambah Barang" (Owner only) |

### 31.6 Tambah Barang / Edit Barang

| Aspek | Instruksi |
|---|---|
| Layout | Form dua kolom (desktop): Kolom kiri — Upload Foto (dropzone besar, opsional). Kolom kanan — Nama Barang, Kategori (select), Harga Modal, Harga Jual (berdampingan agar mudah dibandingkan), Stok Awal |
| Validasi Visual | Field Harga Jual mendapat highlight error real-time jika nilainya lebih kecil dari Harga Modal saat kedua field terisi |
| Aksi | "Batal" (kiri) + "Simpan" (kanan, Primary), sticky di bawah jika form panjang |

### 31.7 Detail Barang

| Aspek | Instruksi |
|---|---|
| Layout | Header besar dengan foto (jika ada) + nama + Badge status, diikuti grid info (Harga Modal, Harga Jual, Margin terhitung, Stok, Kategori) dalam bentuk Card ringkas |
| Aksi Owner | Edit (Primary/Secondary), Nonaktifkan (Danger Ghost, di dalam Dialog konfirmasi) |
| Aksi Kasir | Read only — tidak ada tombol edit/nonaktifkan sama sekali |

### 31.8 Kasir (Pencarian & Keranjang) — SCR-011

| Aspek | Instruksi |
|---|---|
| Layout | Split-view: Panel kiri 65% (Search bar besar auto-focus di atas, grid/list hasil pencarian barang dengan foto/placeholder + nama + harga + badge stok di bawahnya). Panel kanan 35% (sticky): daftar item keranjang (nama, qty dengan stepper +/-, subtotal per baris), Total besar di bawah, tombol "Checkout" (Primary, size `lg`, full-width panel kanan) |
| Item Keranjang | Setiap baris jelas: Nama barang, stepper qty (tombol - dan + besar, mudah ditekan di tablet), subtotal rata kanan, icon hapus kecil di ujung |
| Grid Hasil Pencarian | Card kompak per barang — foto/placeholder, nama (max 2 baris), harga, Badge stok jika hampir habis/habis. Barang stok habis: opacity turun, tidak clickable |
| Interaksi Kunci | Klik/tap barang langsung menambah ke keranjang (tanpa modal konfirmasi tambahan) — kecepatan adalah prioritas |
| Keranjang Kosong | Ilustrasi ringan + teks "Keranjang masih kosong, cari barang untuk memulai transaksi" pada Panel Kanan; tombol Checkout disabled |

### 31.9 Checkout (SCR-012)

| Aspek | Instruksi |
|---|---|
| Layout | Ringkasan total transaksi di atas (besar, jelas), diikuti pilihan metode pembayaran sebagai 4 card besar selectable (Cash, QRIS, Hutang, Cash+Hutang) — bukan dropdown |
| Cash | Setelah dipilih, tampilkan input nominal besar (font besar, prefix "Rp") + kalkulasi kembalian real-time di bawahnya dengan warna `success-600` jika mencukupi |
| Hutang / Cash+Hutang | Setelah dipilih, tampilkan pemilihan/tambah pelanggan (searchable select atau tombol "Tambah Pelanggan Baru") |
| Tombol Aksi | "Selesaikan Transaksi" (Primary, `lg`, full-width area aksi) — state loading sangat jelas (spinner + teks "Memproses...") |
| Validasi Cash Kurang | Alert merah muncul tepat di bawah input nominal: "Nominal pembayaran tidak mencukupi, silakan pilih metode Cash + Hutang atau tambahkan nominal" |

### 31.10 QRIS (SCR-013 / PG dalam Checkout)

| Aspek | Instruksi |
|---|---|
| Layout | Modal/panel menampilkan gambar QRIS statis toko (besar, jelas, center) + Total Tagihan di atasnya (font besar) |
| Aksi | Tombol besar "Konfirmasi Pembayaran Diterima" (Primary, `lg`) sebagai aksi utama; tombol "Batal" kecil untuk kembali memilih metode lain |
| Nada Visual | Netral-positif, bukan alarm — namun tombol konfirmasi harus terasa sebagai keputusan sadar (padding besar, tidak accidental-clickable) |

### 31.11 Hutang Pelanggan (Daftar & Detail)

| Aspek | Instruksi |
|---|---|
| Daftar Pelanggan | Table: Nama Pelanggan, Total Outstanding (rata kanan, Badge Warning jika > 0), Terakhir Transaksi, Aksi (Lihat Detail) |
| Detail Hutang & Histori | Header: Nama pelanggan + Total Outstanding besar. Di bawahnya: Table histori kronologis (tanggal, jenis — transaksi baru/pembayaran, nominal, sisa outstanding setelah entri tersebut) + tombol "Terima Pembayaran" (Primary) |
| Histori | Desain harus terasa seperti buku catatan tepercaya — setiap baris jelas menunjukkan penambahan (warna netral/warning) vs pembayaran (warna success) |

### 31.12 Pembayaran Hutang (Form Terima Pembayaran)

| Aspek | Instruksi |
|---|---|
| Layout | Modal ringkas: menampilkan Outstanding saat ini (besar, jelas), input nominal pembayaran, kalkulasi sisa outstanding setelah pembayaran (real-time) |
| Validasi | Jika nominal melebihi outstanding, error inline: "Nominal pembayaran melebihi total hutang yang tersisa" |
| Pelunasan Penuh | Jika nominal = outstanding penuh, tampilkan indikasi visual positif sebelum submit (contoh: preview Badge berubah menjadi "Lunas") |

### 31.13 Laporan (SCR-019)

| Aspek | Instruksi |
|---|---|
| Layout | Tab navigasi atas (Harian/Mingguan/Bulanan/Tahunan) + filter rentang tanggal kustom di kanan. Di bawahnya: Statistic Card ringkasan periode, Grafik Penjualan/Keuntungan, Table/ranking Barang Terlaris & Paling Menguntungkan |
| Ranking Barang | Horizontal bar chart atau list bernomor dengan bar proporsional, nama barang clickable ke Detail Barang |
| Filter Kustom | Date range picker sederhana dengan preset cepat (Hari Ini, Minggu Ini, Bulan Ini) |

### 31.14 Kelola Kasir (Daftar & Form)

| Aspek | Instruksi |
|---|---|
| Daftar | Table: Nama, Username, Status (Badge), Aksi (Edit, Reset Password, Nonaktifkan) |
| Tambah/Edit Kasir | Modal ringkas: Nama, Username, Password (hanya saat tambah) |
| Reset Password | Modal terpisah, sangat ringkas — satu field password baru + konfirmasi, tanpa perlu password lama (sesuai fitur PRD) |
| Nonaktifkan | Dialog konfirmasi dengan penjelasan dampak ("Kasir tidak akan bisa login lagi, namun histori transaksinya tetap tersimpan") |

### 31.15 Pengaturan (Profil Toko, QRIS, Profil Owner)

| Aspek | Instruksi |
|---|---|
| Layout | Tab navigasi (Profil Toko / QRIS / Profil Owner) di bawah Page Title, breadcrumb induk tidak berubah antar tab |
| Profil Toko | Form: Logo Toko (upload dropzone), Nama Toko, Alamat Toko |
| QRIS | Upload dropzone khusus gambar QRIS + preview besar setelah upload + opsi hapus/ganti |
| Profil Owner | Form: Nama, Username, Password (opsional ubah), Foto Profil |

### 31.16 Profil Saya (Kasir)

| Aspek | Instruksi |
|---|---|
| Layout | Single halaman dengan section embedded: Ubah Username, Ubah Password, Ubah Foto Profil — masing-masing sebagai sub-card ringkas dalam satu halaman (bukan tab terpisah, sesuai Sitemap "Embedded Form Section") |

### 31.17 Modal & Dialog (Umum)

Mengikuti spesifikasi lengkap pada 07_Design_System.md Bagian 26–27. Instruksi tambahan untuk AI: setiap Modal/Dialog harus terasa sebagai "lapisan sementara" — overlay gelap tegas di belakangnya, shadow kuat, dan konten utama halaman tetap sedikit terlihat (tidak benar-benar hilang) untuk menjaga orientasi spasial pengguna.

### 31.18 Error Pages (401, 403, 404, 419, 500, Network Error, Maintenance, Session Expired)

| Aspek | Instruksi |
|---|---|
| Layout | Centered, full-screen minimal — icon/ilustrasi ramah (`icon-xl` dalam lingkaran tint warna) + judul jelas + deskripsi singkat + tombol aksi ("Kembali ke Dashboard" / "Coba Lagi" / "Login") |
| Nada | Tenang, tidak menakutkan — hindari warna merah pekat dominan pada seluruh layar; gunakan warna semantik hanya pada icon |
| 403 Forbidden | Nada netral-informatif: pengguna paham ini pembatasan role, bukan kesalahan mereka |
| Maintenance | Nada paling ramah dari semua error page — toko sedang "istirahat sebentar", bukan "rusak" |

### 31.19 Loading Pages / Empty Pages

Mengikuti spesifikasi lengkap pada 07_Design_System.md Bagian 30–32. Instruksi tambahan: skeleton harus proporsional terhadap konten asli halaman tersebut — skeleton Dashboard harus terlihat seperti "Dashboard yang belum termuat", bukan skeleton generik yang sama di semua halaman.

---

## 32. WHAT AI SHOULD PRIORITIZE

1. **Kecepatan dan kejelasan pada modul Kasir** di atas segalanya — ini adalah fitur yang paling sering digunakan dan paling berdampak langsung pada operasional harian.
2. **Konsistensi lintas halaman** — komponen yang sama harus terlihat identik di setiap halaman, tidak ada variasi "kreatif" per konteks.
3. **Kejelasan status data finansial** (stok, hutang, keuntungan) — ini adalah inti kepercayaan pengguna terhadap aplikasi.
4. **Kesederhanaan untuk pengguna non-teknis** — setiap keputusan desain harus diuji dengan pertanyaan "apakah pemilik warung yang baru pertama kali pakai aplikasi bisa memahami ini tanpa penjelasan?"
5. **Role-awareness yang proporsional** — Dashboard dan navigasi Kasir bukan versi "dikurangi" dari Owner, melainkan versi yang dirancang ulang secara utuh sesuai kebutuhannya.
6. **Kesiapan implementasi teknis** — struktur visual harus realistis dibangun dengan Filament 4 (modul admin) dan Tailwind CSS custom (modul Kasir).
7. **Kepatuhan penuh terhadap Design System** (07_Design_System.md) — token warna, tipografi, spacing, dan komponen yang sudah didefinisikan tidak boleh diciptakan ulang atau disimpangi.

---

## 33. WHAT AI MUST AVOID

1. **Jangan menambahkan fitur, halaman, atau elemen yang tidak ada** pada 02_PRD.md, 03_Business_Rules.md, 04_Information_Architecture.md, 05_Sitemap.md, atau 06_User_Flow.md — termasuk elemen "umum" seperti notifikasi bell icon, barcode scanner UI, atau multi-toko switcher (seluruhnya adalah Future Scope, belum berlaku).
2. **Jangan mengubah struktur navigasi atau hierarki halaman** yang telah ditetapkan pada 04_Information_Architecture.md dan 05_Sitemap.md.
3. **Jangan menampilkan data Keuntungan/Margin di halaman manapun yang diakses Kasir**, sesuai BR-DASH-003.
4. **Jangan meniru identitas visual produk lain** (Stripe, Linear, Notion, Shadcn UI, dsb.) secara langsung — gunakan sebagai referensi kualitas, bukan referensi tampilan untuk disalin.
5. **Jangan menyembunyikan data nonaktif** — barang/kasir nonaktif harus tetap terlihat (opacity turun), tidak pernah dihapus dari tampilan daftar.
6. **Jangan membuat aksi destruktif (nonaktifkan/hapus) dapat dieksekusi dalam satu klik** — wajib melalui Dialog konfirmasi.
7. **Jangan menggunakan bahasa Inggris atau istilah teknis** pada UI copy yang seharusnya berbahasa Indonesia jelas.
8. **Jangan membuat modul Kasir terasa seperti admin panel biasa** — layout split-view dan penekanan kecepatan harus terasa jelas berbeda dari halaman manajemen.
9. **Jangan gunakan animasi/transisi berlebihan** yang memperlambat persepsi kecepatan, terutama pada alur Checkout.
10. **Jangan berasumsi ada integrasi otomatis** untuk QRIS (payment gateway) — desain harus mencerminkan proses verifikasi manual oleh kasir.
11. **Jangan membuat variasi baru dari komponen yang sudah didefinisikan** pada 07_Design_System.md (contoh: radius button berbeda, warna badge baru di luar mapping yang ada).
12. **Jangan mendesain dengan asumsi pengguna power-user/teknis** — selalu asumsikan pengguna awam digital sebagai baseline.

---

## 34. UI QUALITY CHECKLIST

Sebelum output AI dianggap final, verifikasi terhadap checklist berikut:

| # | Checklist | Terpenuhi? |
|---|---|---|
| 1 | Seluruh warna yang digunakan berasal dari token pada 07_Design_System.md Bagian 7 | ☐ |
| 2 | Seluruh tipografi mengikuti scale pada 07_Design_System.md Bagian 8 | ☐ |
| 3 | Sidebar menampilkan item yang tepat sesuai role (Owner: 7 item; Kasir: 4 item) | ☐ |
| 4 | Breadcrumb muncul di seluruh halaman kecuali Login dan Error Page | ☐ |
| 5 | Setiap halaman memiliki maksimal satu Button Primary yang dominan | ☐ |
| 6 | Status data (stok, hutang, aktif/nonaktif) menggunakan Badge dengan warna semantik yang benar | ☐ |
| 7 | Dashboard Kasir tidak menampilkan elemen apa pun terkait Keuntungan/Margin | ☐ |
| 8 | Modul Kasir menggunakan layout split-view, bukan layout admin standar | ☐ |
| 9 | Search bar pada Kasir berukuran besar dan menonjol (auto-focus) | ☐ |
| 10 | Tombol Checkout selalu terlihat tanpa perlu scroll (sticky) | ☐ |
| 11 | Setiap Empty State memiliki pesan yang jelas dan (jika relevan) aksi lanjutan | ☐ |
| 12 | Setiap aksi destruktif memerlukan Dialog konfirmasi eksplisit | ☐ |
| 13 | Nominal Rupiah diformat dengan pemisah ribuan titik dan tabular nums | ☐ |
| 14 | Data nonaktif tetap terlihat (opacity turun), tidak disembunyikan | ☐ |
| 15 | Seluruh UI copy menggunakan Bahasa Indonesia yang jelas dan konsisten | ☐ |
| 16 | Kontras warna teks memenuhi standar aksesibilitas minimum (4.5:1) | ☐ |
| 17 | Layout responsif berfungsi baik pada breakpoint Tablet (kritis untuk Kasir) | ☐ |
| 18 | Tidak ada fitur/elemen yang tidak tercantum pada dokumen sumber | ☐ |
| 19 | Komponen yang sama (Button, Card, Input, dsb.) terlihat identik di seluruh halaman | ☐ |
| 20 | Loading state menggunakan Skeleton, bukan spinner penuh layar | ☐ |

---

## 35. FINAL AI DESIGN INSTRUCTIONS

Ringkasan mental model yang harus dipegang AI UI Designer saat menghasilkan setiap layar StoreKuify:

1. **Mulai dari pertanyaan "siapa yang memakai layar ini, dan dalam kondisi apa?"** — pemilik warung yang tenang meninjau laporan di ruang belakang, atau kasir yang terburu-buru melayani pelanggan? Jawaban ini menentukan densitas, ukuran elemen, dan kecepatan interaksi yang tepat.
2. **Selalu rujuk 07_Design_System.md untuk detail token/komponen teknis** — dokumen ini (08_AI_Design_Brief.md) memberi *arah dan alasan*, sementara Design System memberi *spesifikasi pasti* (hex value, ukuran px, radius). Keduanya harus digunakan bersamaan.
3. **Konsistensi mengalahkan kreativitas per halaman** — StoreKuify harus terasa dibangun oleh satu tim desain yang sama, bukan kumpulan halaman yang didesain terpisah-pisah.
4. **Setiap keputusan visual harus dapat dijelaskan alasannya** merujuk ke Business Rules, User Flow, atau prinsip pada dokumen ini — hindari dekorasi/keputusan desain yang murni estetika tanpa dasar fungsional.
5. **Uji setiap layar terhadap UI Quality Checklist (Bagian 34)** sebelum dianggap selesai.
6. **Ketika ragu antara dua pilihan desain, pilih yang lebih sederhana dan lebih cepat dipahami** — ini adalah prinsip tertinggi StoreKuify (Simplicity First, sesuai 02_PRD.md).
7. **Jangan pernah berimprovisasi fitur baru** — jika suatu kebutuhan tidak tercakup di dokumen sumber, desain halaman/komponen yang paling dekat dengan cakupan yang ADA, dan catat sebagai potensi Future Design System jika benar-benar diperlukan, bukan langsung ditambahkan ke desain final.

---

## 36. GLOSSARY

| Istilah | Definisi |
|---|---|
| **AI Design Brief** | Dokumen yang menjelaskan arah, filosofi, dan instruksi desain kepada AI UI Designer, sebagai jembatan antara dokumen requirement/business logic dengan proses generasi UI otomatis. |
| **Design System** | Kumpulan token dan komponen visual teknis (warna, tipografi, spacing) — lihat 07_Design_System.md. |
| **User Flow** | Dokumentasi logika interaksi langkah-demi-langkah pengguna — lihat 06_User_Flow.md. |
| **Owner** | Pemilik warung kelontong dengan akses penuh terhadap seluruh fitur StoreKuify. |
| **Kasir** | Staf operasional yang bertugas melayani transaksi penjualan dengan akses terbatas. |
| **Split-View Layout** | Pola layout dua panel berdampingan, digunakan pada modul Kasir. |
| **Statistic Card** | Komponen Card yang menampilkan satu metrik angka kunci beserta labelnya pada Dashboard. |
| **Empty State** | Tampilan yang ditunjukkan ketika suatu halaman/komponen belum memiliki data. |
| **Snapshot Harga** | Nilai Harga Modal dan Harga Jual yang disimpan pada level transaksi saat transaksi terjadi, terpisah dari harga terkini pada master data Barang. |
| **QRIS Statis** | Kode QR pembayaran yang bersifat tetap (gambar tunggal milik toko), tanpa integrasi otomatis dengan payment gateway. |
| **Trust-Based Verification** | Proses verifikasi pembayaran (khususnya QRIS) yang dilakukan secara manual oleh kasir berdasarkan bukti yang ditunjukkan pelanggan, bukan verifikasi sistem otomatis. |
| **Role-Aware Design** | Pendekatan desain di mana tampilan/komponen menyesuaikan diri secara utuh terhadap role pengguna (Owner/Kasir), bukan sekadar menyembunyikan/menampilkan elemen dari satu layout dasar yang sama. |
| **F-Pattern Scanning** | Pola umum mata manusia membaca layar dari kiri-atas ke kanan, lalu turun — digunakan sebagai dasar penempatan elemen prioritas tinggi pada Dashboard. |
| **Progressive Disclosure** | Prinsip menampilkan informasi secara bertahap sesuai kebutuhan, bukan menampilkan seluruh detail sekaligus, untuk mengurangi cognitive load. |
| **Cognitive Load** | Beban mental yang dibutuhkan pengguna untuk memahami dan berinteraksi dengan suatu antarmuka. |
| **Above the Fold** | Area tampilan yang langsung terlihat tanpa perlu scroll. |

---

**— AKHIR DOKUMEN 08_AI_Design_Brief.md —**

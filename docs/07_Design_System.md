# 07_Design_System.md
# DESIGN SYSTEM DOCUMENT
# STOREKUIFY — Web Based Grocery Store POS & Inventory Management System

---

## 1. DOCUMENT INFORMATION

| Atribut | Keterangan |
|---|---|
| Nama Dokumen | Design System Document — StoreKuify |
| Kode Dokumen | 07_Design_System.md |
| Nama Proyek | StoreKuify |
| Jenis Aplikasi | Web Based Grocery Store POS & Inventory Management System |
| Bahasa Dokumen | Bahasa Indonesia |
| Sumber Kebenaran (Source of Truth) | 02_PRD.md, 03_Business_Rules.md, 04_Information_Architecture.md, 05_Sitemap.md, 06_User_Flow.md |
| Status Dokumen | Final Draft — Siap untuk Tahap UI Design (Stitch AI), UI Development, dan Frontend Implementation |
| Disusun Oleh | Senior Product Designer, Design System Architect & UX Lead |
| Tanggal Dibuat | 02 Agustus 2026 |
| Confidentiality | Internal — Hanya untuk Tim Internal & Development Team |

Dokumen ini merupakan **referensi visual dan komponen tunggal (single source of truth for UI)** StoreKuify, yang menjadi acuan utama untuk:

- Stitch AI (UI Generation)
- UI/UX Design (Wireframe → High-Fidelity)
- Frontend Development (Tailwind CSS, Filament 4)
- Konsistensi visual di seluruh halaman dan komponen
- Design QA dan Review

Dokumen ini **BUKAN** dokumen fitur (PRD), **BUKAN** dokumen logika bisnis (Business Rules), dan **BUKAN** dokumen struktur navigasi (Information Architecture/Sitemap). Dokumen ini murni membahas **bahasa visual (visual language)**: warna, tipografi, spacing, komponen UI, dan aturan tampilan yang menerapkan fitur dan navigasi yang telah didefinisikan pada dokumen-dokumen sebelumnya.

Seluruh isi dokumen ini **diturunkan sepenuhnya** dari 02_PRD.md, 03_Business_Rules.md, 04_Information_Architecture.md, 05_Sitemap.md, dan 06_User_Flow.md, tanpa menambahkan fitur baru, tanpa mengubah business rules, dan tanpa mengubah struktur navigasi yang sudah ditetapkan.

---

## 2. REVISION HISTORY

| Versi | Tanggal | Deskripsi Perubahan | Disusun Oleh | Disetujui Oleh |
|---|---|---|---|---|
| 0.1 | 02 Agustus 2026 | Draft awal Design System diturunkan dari 02_PRD.md, 03_Business_Rules.md, 04_Information_Architecture.md, 05_Sitemap.md, dan 06_User_Flow.md | Senior Product Designer & Design System Architect | - |
| 1.0 | 02 Agustus 2026 | Finalisasi seluruh spesifikasi visual: Color System, Typography, Spacing, Component Library, Responsive Rules, Accessibility Guidelines | Senior Product Designer & Design System Architect | Product Owner |

Catatan: Setiap perubahan pada dokumen sumber (02, 03, 04, 05, 06) yang memengaruhi kebutuhan tampilan wajib disinkronkan ke dokumen ini dengan menambahkan baris revisi baru. Perubahan pada dokumen ini tidak boleh menghasilkan penambahan fitur, perubahan business rules, atau perubahan struktur navigasi.

---

## 3. TABLE OF CONTENTS

1. Document Information
2. Revision History
3. Table of Contents
4. Introduction
5. Design Principles
6. Brand Personality
7. Color System
8. Typography
9. Spacing System
10. Border Radius
11. Shadow System
12. Iconography
13. Illustration Style
14. Logo Usage
15. Grid System
16. Layout Rules
17. Sidebar Rules
18. Topbar Rules
19. Card Component
20. Button Component
21. Input Component
22. Select Component
23. Search Component
24. Badge Component
25. Table Component
26. Modal Component
27. Dialog Component
28. Toast Notification
29. Alert Component
30. Empty State
31. Loading State
32. Skeleton Loading
33. Charts
34. Dashboard Widgets
35. Form Guidelines
36. Data Table Guidelines
37. Responsive Rules
38. Accessibility
39. Animation Guidelines
40. UI Do's and Don'ts
41. Future Design System
42. Glossary

---

## 4. INTRODUCTION

StoreKuify adalah aplikasi kasir dan manajemen toko berbasis web yang dirancang khusus untuk kebutuhan **Warung Kelontong** — usaha retail skala kecil-menengah yang dikelola secara mandiri/keluarga, dengan dua role pengguna: **Owner** dan **Kasir**.

Dokumen Design System ini disusun agar seluruh halaman StoreKuify — mulai dari Dashboard, Data Barang, Kasir (POS), Hutang Pelanggan, Laporan, Kelola Kasir, hingga Pengaturan — memiliki **satu bahasa visual yang konsisten**, terlepas dari siapa yang mendesain atau membangun halaman tersebut.

Sesuai dengan Filosofi Produk pada 02_PRD.md, StoreKuify **sengaja dibuat sederhana**: antarmuka harus mudah dipahami oleh pengguna non-teknis (pemilik warung kelontong yang mungkin belum terbiasa dengan aplikasi digital), dengan alur kerja yang cepat terutama pada modul Kasir yang digunakan berulang kali setiap hari dalam kondisi kerja yang sering terburu-buru (melayani pelanggan yang menunggu di depan kasir).

Design System ini menjadi acuan tunggal bagi:

- **Stitch AI** — dalam menghasilkan desain UI otomatis yang konsisten dengan brand StoreKuify.
- **UI Designer** — dalam membuat wireframe dan high-fidelity design.
- **Frontend Developer** — dalam mengimplementasikan komponen menggunakan Tailwind CSS dan Filament 4.
- **QA Team** — dalam memvalidasi konsistensi visual pada setiap halaman yang telah diimplementasikan.

Referensi teknologi sesuai 02_PRD.md: **Laravel 12, Filament 4, MySQL, Tailwind CSS**. Modul manajemen (Data Barang, Kelola Kasir, Pengaturan, Laporan) dibangun di atas Filament 4, sementara modul Kasir (POS) menggunakan desain kustom berbasis Tailwind CSS karena membutuhkan alur kerja interaktif dan cepat yang berada di luar pola standar admin panel.

---

## 5. DESIGN PRINCIPLES

| Prinsip | Penjelasan |
|---|---|
| **Simplicity First** | Setiap elemen visual harus mendukung kemudahan pemahaman bagi pengguna non-teknis. Hindari dekorasi yang tidak fungsional. Sejalan dengan filosofi produk pada 02_PRD.md Bagian 4. |
| **Clarity Over Cleverness** | Label, ikon, dan status harus jelas maknanya tanpa memerlukan penjelasan tambahan. Tidak ada ikon abstrak tanpa label pada aksi penting. |
| **Speed at the Counter** | Modul Kasir (POS) adalah halaman dengan frekuensi penggunaan tertinggi dan tekanan waktu tertinggi (pelanggan menunggu). Layout, ukuran tombol, dan kontras pada modul ini dioptimalkan untuk kecepatan aksi dan minim kesalahan klik. |
| **Consistent Navigation** | Struktur sidebar, topbar, dan breadcrumb tidak berubah antar halaman dalam satu sesi role, sesuai NAV-010 pada 05_Sitemap.md. |
| **Role-Aware Interface** | Elemen visual (menu, aksi, data finansial) menyesuaikan role yang login (Owner/Kasir) sesuai Page Access Matrix pada 04_Information_Architecture.md Bagian 15. Kasir tidak pernah melihat elemen UI yang menyiratkan data Keuntungan (BR-DASH-003). |
| **Trustworthy & Transparent** | Karena aplikasi menangani uang dan hutang pelanggan secara langsung, seluruh nominal, status pembayaran, dan status hutang harus ditampilkan dengan jelas, konsisten, dan tidak ambigu. |
| **Feedback for Every Action** | Setiap aksi pengguna (simpan, hapus, checkout, error validasi) selalu memiliki umpan balik visual yang jelas (toast, alert, atau perubahan state), sesuai prinsip error handling pada 02_PRD.md Bagian 14. |
| **Accessible by Default** | Kontras warna, ukuran target sentuh, dan struktur form dirancang agar dapat digunakan oleh pengguna dengan tingkat literasi digital berbeda-beda, termasuk pada perangkat tablet di meja kasir. |
| **Desktop First, Responsive Ready** | Sesuai 02_PRD.md dan 04_Information_Architecture.md, layout diprioritaskan untuk desktop namun tetap adaptif ke tablet dan mobile. |
| **Bahasa Indonesia Konsisten** | Seluruh label UI, pesan error, dan pesan sistem menggunakan Bahasa Indonesia yang jelas, sesuai BR-ERR-001 dan Bagian 14 pada 02_PRD.md. |

---

## 6. BRAND PERSONALITY

StoreKuify memiliki kepribadian visual: **Modern, Bersih, Minimalis, Profesional, Ramah, dan Cepat.**

| Sifat | Diwujudkan Melalui |
|---|---|
| **Modern** | Tipografi sans-serif kontemporer, layout berbasis grid, whitespace yang cukup, tanpa elemen skeuomorphic. |
| **Bersih (Clean)** | Palet warna terbatas dan konsisten, satu aksen warna primer, hierarki visual yang jelas. |
| **Minimalis** | Komponen tanpa ornamen berlebihan; ikon linier tipis, shadow lembut, border tipis. |
| **Profesional** | Struktur tabel dan form yang rapi, konsisten dengan pola dashboard SaaS modern (Stripe Dashboard, Linear, Notion, Tailwind UI, Shadcn UI) tanpa meniru identitas visual mereka secara langsung. |
| **Ramah (Friendly)** | Warna aksen hangat pada elemen positif (sukses, keuntungan), microcopy Bahasa Indonesia yang sopan dan tidak kaku, ilustrasi empty state yang bersahabat. |
| **Cepat (Fast)** | Interaksi ringan (light interaction cost), animasi singkat, prioritas pada modul Kasir untuk transaksi bernilai tinggi-frekuensi. |

**Brand Voice pada UI Copy:**

| Konteks | Nada | Contoh |
|---|---|---|
| Instruksi/Label | Netral, jelas, langsung | "Nama Barang", "Harga Jual" |
| Pesan Sukses | Positif, ringkas | "Barang berhasil disimpan" |
| Pesan Error | Informatif, tidak menyalahkan pengguna | "Stok Beras 5kg tidak mencukupi, sisa stok: 3" |
| Konfirmasi Destruktif | Tegas namun sopan | "Barang ini akan dinonaktifkan dan tidak dapat dijual. Lanjutkan?" |
| Empty State | Ramah, mengarahkan aksi | "Belum ada barang di kategori ini. Tambahkan barang pertama Anda." |

---

## 7. COLOR SYSTEM

Palet warna StoreKuify dirancang dengan satu warna primer yang tegas, warna status yang jelas untuk kebutuhan finansial (penjualan, keuntungan, hutang, stok), dan skala neutral yang luas untuk mendukung hierarki informasi pada dashboard dan tabel data.

### 7.1 Primary Color

| Token | Hex | Penggunaan |
|---|---|---|
| `primary-50` | #EFF6FF | Background hover halus, highlight ringan |
| `primary-100` | #DBEAFE | Background badge/chip primer |
| `primary-200` | #BFDBFE | Border elemen aktif ringan |
| `primary-300` | #93C5FD | Disabled state pada elemen primary |
| `primary-400` | #60A5FA | Icon aktif sekunder |
| `primary-500` | #3B82F6 | Aksen ringan, link |
| `primary-600` | **#2563EB** | **Primary Base** — tombol utama, aktif sidebar, fokus elemen |
| `primary-700` | #1D4ED8 | Hover state tombol primary |
| `primary-800` | #1E40AF | Active/pressed state tombol primary |
| `primary-900` | #1E3A8A | Teks pada background primary terang |

### 7.2 Secondary Color

| Token | Hex | Penggunaan |
|---|---|---|
| `secondary-100` | #F1F5F9 | Background tombol secondary |
| `secondary-300` | #CBD5E1 | Border tombol secondary |
| `secondary-600` | **#475569** | **Secondary Base** — tombol sekunder, ikon non-aktif |
| `secondary-700` | #334155 | Hover tombol secondary |
| `secondary-900` | #0F172A | Teks judul kontras tinggi |

### 7.3 Semantic Colors

| Kategori | Token | Hex | Penggunaan |
|---|---|---|---|
| **Success** | `success-50` | #ECFDF5 | Background alert/badge sukses |
| | `success-500` | #10B981 | Ikon, border sukses |
| | `success-600` | **#059669** | **Base** — teks/tombol sukses, status "Lunas", "Aktif", Keuntungan positif |
| | `success-700` | #047857 | Hover state |
| **Danger** | `danger-50` | #FEF2F2 | Background alert/badge bahaya |
| | `danger-500` | #EF4444 | Ikon, border bahaya |
| | `danger-600` | **#DC2626** | **Base** — teks/tombol hapus-nonaktifkan, pesan error, "Stok Habis" |
| | `danger-700` | #B91C1C | Hover state |
| **Warning** | `warning-50` | #FFFBEB | Background alert/badge peringatan |
| | `warning-500` | #F59E0B | Ikon, border peringatan |
| | `warning-600` | **#D97706** | **Base** — "Barang Hampir Habis", "Hutang Belum Lunas", peringatan non-kritis |
| | `warning-700` | #B45309 | Hover state |
| **Info** | `info-50` | #EFF6FF | Background alert/badge informasi |
| | `info-500` | #3B82F6 | Ikon informasi |
| | `info-600` | **#2563EB** | **Base** — pesan informatif netral (identik dengan Primary) |
| | `info-700` | #1D4ED8 | Hover state |

### 7.4 Neutral Scale

| Token | Hex | Penggunaan |
|---|---|---|
| `neutral-0` | #FFFFFF | Surface/Card background (light mode) |
| `neutral-50` | #F8FAFC | Page background (light mode) |
| `neutral-100` | #F1F5F9 | Hover row tabel, background input disabled |
| `neutral-200` | #E2E8F0 | Border default, divider |
| `neutral-300` | #CBD5E1 | Border input, border card |
| `neutral-400` | #94A3B8 | Placeholder text, icon non-aktif |
| `neutral-500` | #64748B | Teks sekunder (caption, label kecil) |
| `neutral-600` | #475569 | Teks body sekunder |
| `neutral-700` | #334155 | Teks body utama |
| `neutral-800` | #1E293B | Teks judul (heading) |
| `neutral-900` | #0F172A | Teks judul terkuat, teks pada dark surface |

### 7.5 Background, Surface, Border, Text (Light Mode)

| Token | Hex | Penggunaan |
|---|---|---|
| `bg-page` | #F8FAFC | Latar belakang utama seluruh halaman |
| `bg-sidebar` | #FFFFFF | Latar belakang sidebar |
| `bg-topbar` | #FFFFFF | Latar belakang topbar |
| `surface-card` | #FFFFFF | Latar belakang card, modal, dialog, tabel |
| `surface-elevated` | #FFFFFF | Latar belakang popover, dropdown |
| `border-default` | #E2E8F0 | Border card, tabel, input |
| `border-strong` | #CBD5E1 | Border elemen fokus non-aktif, divider tegas |
| `text-primary` | #0F172A | Teks judul dan konten utama |
| `text-secondary` | #64748B | Teks label, caption, deskripsi |
| `text-disabled` | #94A3B8 | Teks pada elemen disabled |
| `text-inverse` | #FFFFFF | Teks di atas background berwarna gelap/primary |

### 7.6 Interaction States

| Token | Hex | Penggunaan |
|---|---|---|
| `hover-primary` | #1D4ED8 (primary-700) | Hover tombol/elemen primary |
| `hover-neutral` | #F1F5F9 (neutral-100) | Hover row tabel, hover menu sidebar |
| `active-primary` | #1E40AF (primary-800) | Pressed state tombol primary |
| `active-neutral` | #E2E8F0 (neutral-200) | Pressed state elemen netral |
| `disabled-bg` | #F1F5F9 (neutral-100) | Background elemen disabled |
| `disabled-text` | #94A3B8 (neutral-400) | Teks elemen disabled |
| `disabled-border` | #E2E8F0 (neutral-200) | Border elemen disabled |
| `focus-ring` | #93C5FD (primary-300), opacity 60% | Ring fokus keyboard/klik pada input dan tombol |

### 7.7 Dark Mode Ready

Dark mode **tidak wajib diimplementasikan pada rilis versi ini** (tidak disebutkan sebagai requirement pada 02_PRD.md), namun token warna disiapkan agar sistem **siap dikembangkan ke dark mode** tanpa restrukturisasi.

| Token | Light Mode | Dark Mode (disiapkan) |
|---|---|---|
| `bg-page` | #F8FAFC | #0F172A |
| `bg-sidebar` / `bg-topbar` | #FFFFFF | #111827 |
| `surface-card` | #FFFFFF | #1E293B |
| `border-default` | #E2E8F0 | #334155 |
| `text-primary` | #0F172A | #F1F5F9 |
| `text-secondary` | #64748B | #94A3B8 |
| `primary-600` | #2563EB | #3B82F6 (dinaikkan 1 step agar tetap kontras) |
| `success-600` | #059669 | #10B981 |
| `danger-600` | #DC2626 | #EF4444 |
| `warning-600` | #D97706 | #F59E0B |

Catatan: Implementasi dark mode dicatat pada Bagian 41 (Future Design System) dan bukan bagian dari scope rilis versi ini.

### 7.8 Status Color Mapping (Business Rule Alignment)

Pemetaan warna terhadap status data wajib konsisten di seluruh aplikasi, sesuai istilah pada 03_Business_Rules.md dan 02_PRD.md.

| Status | Warna | Konteks Business Rule |
|---|---|---|
| Aktif (Barang/Kasir) | `success-600` | BR-BRG, BR-KKS |
| Nonaktif (Barang/Kasir) | `neutral-500` (badge abu-abu, bukan merah — nonaktif ≠ error) | BR-BRG-008, BR-KKS-003 |
| Stok Aman | `success-600` | BR-STK |
| Barang Hampir Habis | `warning-600` | BR-DASH-004, BR-STK-004 |
| Stok Habis (0) | `danger-600` | BR-STK |
| Hutang Belum Lunas / Outstanding | `warning-600` | BR-HTG |
| Hutang Lunas | `success-600` | BR-HTG |
| Transaksi Berhasil | `success-600` | BR-CHK |
| Transaksi Gagal/Dibatalkan | `danger-600` | BR-ERR |
| Keuntungan (nominal positif) | `success-600` | BR-DASH-002 |
| Pesan Error Validasi | `danger-600` | BR-VAL |
| Pesan Informasi Netral | `info-600` | Umum |

---

## 8. TYPOGRAPHY

**Font Family:** `Inter` sebagai typeface utama (sans-serif modern, keterbacaan tinggi pada angka — krusial untuk data finansial dan tabel). Fallback: `-apple-system, "Segoe UI", Roboto, Helvetica, Arial, sans-serif`.

**Font untuk Angka/Nominal:** Gunakan `font-variant-numeric: tabular-nums` pada seluruh nominal Rupiah dan angka tabel agar digit sejajar secara vertikal, penting untuk keterbacaan tabel Laporan dan Kasir.

### 8.1 Typography Scale

| Token | Ukuran (px/rem) | Line Height | Weight | Penggunaan |
|---|---|---|---|---|
| `display` | 32px / 2rem | 40px | 700 (Bold) | Nominal besar pada Dashboard (contoh: Penjualan Hari Ini) |
| `heading-1` | 28px / 1.75rem | 36px | 700 (Bold) | Judul halaman utama (Page Title) |
| `heading-2` | 24px / 1.5rem | 32px | 600 (Semibold) | Judul section dalam halaman |
| `heading-3` | 20px / 1.25rem | 28px | 600 (Semibold) | Judul card, judul modal |
| `subtitle` | 16px / 1rem | 24px | 600 (Semibold) | Sub-judul, label grup form |
| `body-lg` | 16px / 1rem | 24px | 400 (Regular) | Body text utama, deskripsi |
| `body` | 14px / 0.875rem | 20px | 400 (Regular) | Body text default (form, teks umum) |
| `body-sm` | 13px / 0.8125rem | 18px | 400 (Regular) | Teks sekunder, deskripsi field |
| `caption` | 12px / 0.75rem | 16px | 400 (Regular) | Helper text, metadata, timestamp |
| `caption-bold` | 12px / 0.75rem | 16px | 600 (Semibold) | Label kolom tabel (uppercase), tag kecil |
| `button` | 14px / 0.875rem | 20px | 600 (Semibold) | Label tombol |
| `table-header` | 12px / 0.75rem | 16px | 600 (Semibold), uppercase, letter-spacing 0.04em | Header kolom tabel |
| `table-body` | 14px / 0.875rem | 20px | 400 (Regular) | Isi sel tabel |
| `table-body-numeric` | 14px / 0.875rem | 20px | 500 (Medium), tabular-nums | Sel angka/nominal pada tabel |
| `dashboard-metric` | 30px / 1.875rem | 36px | 700 (Bold), tabular-nums | Angka utama pada Statistic Card Dashboard |
| `dashboard-label` | 13px / 0.8125rem | 18px | 500 (Medium) | Label di atas angka Statistic Card |

### 8.2 Typography Color Application

| Elemen | Token Warna |
|---|---|
| Heading (h1–h3) | `text-primary` (#0F172A) |
| Body text | `text-primary` atau `text-secondary` tergantung hierarki |
| Caption/metadata | `text-secondary` (#64748B) |
| Placeholder | `text-disabled` (#94A3B8) |
| Link | `primary-600`, underline saat hover |
| Teks pada tombol primary | `text-inverse` (#FFFFFF) |

---

## 9. SPACING SYSTEM

Menggunakan skala **4px base unit**, konsisten dengan konvensi utility-first Tailwind CSS.

| Token | Nilai | Penggunaan |
|---|---|---|
| `space-1` | 4px | Jarak antar ikon dan label inline |
| `space-2` | 8px | Padding kecil (badge, chip), gap antar elemen inline |
| `space-3` | 12px | Padding input/button vertikal, gap antar form field pendek |
| `space-4` | 16px | Padding card default, gap antar elemen dalam section |
| `space-5` | 20px | Gap antar card dalam grid |
| `space-6` | 24px | Padding container halaman (mobile), gap antar section |
| `space-8` | 32px | Padding container halaman (desktop), margin antar blok besar |
| `space-10` | 40px | Margin atas judul halaman dari topbar |
| `space-12` | 48px | Jarak antar section besar pada halaman panjang (Laporan) |
| `space-16` | 64px | Padding vertikal Empty State, halaman error |

**Aturan Umum:**
- Padding internal Card: `space-4` (mobile) hingga `space-6` (desktop).
- Gap antar Statistic Card pada grid Dashboard: `space-5`.
- Padding sel tabel: horizontal `space-4`, vertikal `space-3`.
- Gap antar tombol dalam grup aksi (contoh: "Batal" & "Simpan"): `space-3`.

---

## 10. BORDER RADIUS

| Token | Nilai | Penggunaan |
|---|---|---|
| `radius-sm` | 6px | Badge, chip, tag kecil |
| `radius-md` | 8px | Input, Select, Button, Search Bar |
| `radius-lg` | 12px | Card, Table Container, Alert |
| `radius-xl` | 16px | Modal, Dialog, Dashboard Widget Card |
| `radius-full` | 9999px | Avatar, Profile Image, Status Dot, Pill Badge |

---

## 11. SHADOW SYSTEM

Shadow digunakan secara minimal dan lembut, sesuai gaya Stripe Dashboard/Linear — untuk memberi elevasi tanpa terkesan berat.

| Token | CSS Value | Penggunaan |
|---|---|---|
| `shadow-xs` | `0 1px 2px rgba(15, 23, 42, 0.04)` | Card default, input pada state resting |
| `shadow-sm` | `0 1px 3px rgba(15, 23, 42, 0.06), 0 1px 2px rgba(15, 23, 42, 0.04)` | Card hover, dropdown kecil |
| `shadow-md` | `0 4px 6px rgba(15, 23, 42, 0.05), 0 2px 4px rgba(15, 23, 42, 0.04)` | Popover, dropdown menu, tooltip |
| `shadow-lg` | `0 10px 15px rgba(15, 23, 42, 0.08), 0 4px 6px rgba(15, 23, 42, 0.05)` | Modal, Dialog |
| `shadow-xl` | `0 20px 25px rgba(15, 23, 42, 0.10), 0 8px 10px rgba(15, 23, 42, 0.04)` | Modal kritis (Konfirmasi QRIS saat checkout) |
| `shadow-focus` | `0 0 0 3px rgba(59, 130, 246, 0.35)` | Focus ring pada input/button saat aktif keyboard |

---

## 12. ICONOGRAPHY

**Icon Set:** Menggunakan gaya **line icon (outline)**, stroke width konsisten 1.5–2px, sudut membulat (rounded joint), grid dasar 24x24px. Direkomendasikan pustaka setara **Lucide Icons** (open-source, konsisten dengan gaya Shadcn UI) sebagai referensi visual tanpa menyalin identitas brand pihak ketiga.

### 12.1 Icon Sizing

| Token | Ukuran | Penggunaan |
|---|---|---|
| `icon-xs` | 14px | Icon inline dalam teks kecil/caption |
| `icon-sm` | 16px | Icon dalam Badge, icon dalam Input (search, calendar) |
| `icon-md` | 20px | Icon default pada Button, icon menu Sidebar |
| `icon-lg` | 24px | Icon pada Statistic Card, Empty State icon container |
| `icon-xl` | 32px | Icon utama pada Alert besar, Error Page |

### 12.2 Icon Mapping per Modul

| Modul/Aksi | Icon Konsep |
|---|---|
| Dashboard | Grid/Layout dashboard |
| Data Barang | Box/Package |
| Kasir (POS) | Shopping cart / Cash register |
| Hutang Pelanggan | Wallet / Receipt with clock |
| Laporan | Bar chart |
| Kelola Kasir | Users/People |
| Pengaturan | Gear/Settings |
| Tambah | Plus (+) |
| Edit | Pencil |
| Nonaktifkan/Hapus | Trash / Slash-circle (bukan silang merah tegas, agar tidak disalahartikan sebagai delete permanen) |
| Cari | Magnifying glass |
| Notifikasi Stok Menipis | Alert triangle |
| Status Lunas | Check-circle |
| Status Belum Lunas | Clock |
| Logout | Log-out arrow |
| QRIS | QR code |
| Cash | Banknote |

**Aturan Warna Icon:** Icon mengikuti warna teks/status di sekitarnya (`currentColor`), kecuali icon status semantik (sukses/bahaya/peringatan) yang mengikuti token warna semantik terkait.

---

## 13. ILLUSTRATION STYLE

Ilustrasi digunakan terbatas pada **Empty State** dan **Error Page**, dengan gaya:

| Aspek | Aturan |
|---|---|
| Gaya Visual | Flat, minimalis, dua-warna (primary tint + neutral outline), tanpa gradient kompleks atau detail berlebihan |
| Ukuran | 120–200px pada Empty State dalam card/tabel; 240–320px pada Error Page full-screen |
| Nada | Ramah, tidak menakutkan — terutama pada Error Page (403, 404, 500) agar tidak membuat pengguna non-teknis panik |
| Warna Dominan | `primary-100`/`primary-200` sebagai warna isi utama ilustrasi, `neutral-300` untuk outline/detail |
| Alternatif | Jika ilustrasi kustom tidak tersedia saat development, gunakan kombinasi Icon besar (`icon-xl`, 48–64px) dalam lingkaran `primary-50` sebagai fallback minimalis yang tetap konsisten dengan brand |

---

## 14. LOGO USAGE

| Aturan | Ketentuan |
|---|---|
| Placement Sidebar | Logo StoreKuify diletakkan di area header Sidebar, tinggi 32–40px, rata kiri dengan padding `space-4` hingga `space-6` |
| Placement Login | Logo ditampilkan di atas form Login, ukuran 40–48px, rata tengah |
| Logo Toko (custom upload) | Logo Toko milik pengguna (hasil upload pada Pengaturan Profil Toko) **tidak** menggantikan logo StoreKuify pada Sidebar — logo toko hanya tampil pada konteks Struk Transaksi dan halaman Pengaturan, sesuai cakupan fitur pada 02_PRD.md Bagian 13 (Logo Toko: JPG/PNG, maksimum 2MB) |
| Format Fallback | Jika logo StoreKuify tidak tersedia, gunakan wordmark teks "StoreKuify" dengan `heading-3`, weight 700, warna `primary-600` |
| Clear Space | Minimum clear space di sekeliling logo = tinggi logo itu sendiri |
| Larangan | Jangan mengubah rasio, warna, atau menambahkan efek (shadow/gradient) pada logo StoreKuify |

---

## 15. GRID SYSTEM

**Basis Grid:** 12-column grid pada layar desktop, dengan container max-width dan gutter konsisten.

| Breakpoint | Container Max-Width | Columns | Gutter | Margin Halaman |
|---|---|---|---|---|
| Desktop (≥1280px) | 1280px (fluid dalam area konten setelah sidebar) | 12 | 24px | 32px |
| Laptop (1024–1279px) | Fluid | 12 | 20px | 24px |
| Tablet (768–1023px) | Fluid | 8 | 16px | 20px |
| Mobile (<768px) | Fluid | 4 | 16px | 16px |

**Grid untuk Statistic Card Dashboard:**

| Breakpoint | Kolom Card |
|---|---|
| Desktop | 4 kolom per baris |
| Laptop | 3 kolom per baris |
| Tablet | 2 kolom per baris |
| Mobile | 1 kolom (stacked) |

---

## 16. LAYOUT RULES

Layout utama StoreKuify menggunakan pola **Persistent Sidebar + Topbar + Content Area**, konsisten di seluruh halaman Protected sesuai 04_Information_Architecture.md, dengan pengecualian pada halaman Login (layout terpisah, centered) dan halaman Kasir/Checkout (layout khusus, lihat 16.2).

### 16.1 Layout Standar (Dashboard, Data Barang, Hutang, Laporan, Kelola Kasir, Pengaturan)

```
┌───────────────────────────────────────────────┐
│ Sidebar │ Topbar (Breadcrumb + User Menu)      │
│ (fixed) ├───────────────────────────────────────┤
│         │ Page Title + Primary Action           │
│         │                                       │
│         │ Content Area (Cards / Table / Form)   │
│         │                                       │
└───────────────────────────────────────────────┘
```

| Elemen | Ketentuan |
|---|---|
| Sidebar width | 260px (expanded), 72px (collapsed icon-only) |
| Topbar height | 64px |
| Content padding | `space-8` (desktop), `space-6` (tablet), `space-4` (mobile) |
| Max content width | 1280px, di-center jika layar lebih lebar |

### 16.2 Layout Kasir (POS)

Modul Kasir menggunakan layout **dua panel (split-view)** yang berbeda dari layout admin standar, untuk mendukung prinsip **Speed at the Counter**:

```
┌───────────────┬───────────────────┐
│ Panel Kiri     │ Panel Kanan        │
│ Pencarian &    │ Keranjang &        │
│ Daftar Barang  │ Ringkasan Checkout │
│ (scrollable)   │ (fixed/sticky)     │
└───────────────┴───────────────────┘
```

| Elemen | Ketentuan |
|---|---|
| Rasio Panel | 65% (kiri) : 35% (kanan) pada desktop; stacked full-width pada mobile dengan panel keranjang sebagai bottom sheet/tab |
| Sidebar pada halaman Kasir | Tetap ditampilkan namun dapat di-collapse otomatis ke mode icon-only untuk memaksimalkan ruang kerja |
| Tombol Checkout | Selalu terlihat (sticky) di bagian bawah Panel Kanan, tidak boleh memerlukan scroll untuk diakses |

### 16.3 Layout Login

| Elemen | Ketentuan |
|---|---|
| Struktur | Single centered card, max-width 400px, vertically & horizontally centered |
| Background | `bg-page` polos atau dengan aksen bentuk geometris minimal warna `primary-50` |

---

## 17. SIDEBAR RULES

| Aturan | Ketentuan |
|---|---|
| Posisi | Fixed, sisi kiri, tinggi penuh viewport |
| Background | `bg-sidebar` (#FFFFFF), border kanan `border-default` |
| Item Menu | Icon (`icon-md`) + Label (`body`, 14px), padding vertikal `space-3`, padding horizontal `space-4`, radius `radius-md` pada state hover/aktif |
| Item Aktif | Background `primary-50`, teks & icon `primary-600`, indikator bar kiri 3px warna `primary-600` |
| Item Hover (non-aktif) | Background `hover-neutral` (#F1F5F9) |
| Grouping | Item sidebar mengikuti struktur Owner Navigation / Kasir Navigation persis sesuai 04_Information_Architecture.md Bagian 6 — tidak ada penambahan/pengurangan item |
| Role Visibility | Sidebar Owner menampilkan: Dashboard, Data Barang, Kasir, Hutang Pelanggan, Laporan, Kelola Kasir, Pengaturan. Sidebar Kasir menampilkan: Dashboard, Kasir, Hutang Pelanggan, Profil Saya — sesuai Page Access Matrix |
| Collapse Behavior | Pada layar sempit (tablet ke bawah) atau mode collapsed manual, sidebar menyusut ke 72px menampilkan icon saja dengan tooltip label saat hover |
| Footer Sidebar | Menampilkan info user ringkas (avatar + nama + role) di bagian bawah sidebar, dengan akses cepat ke Logout |
| Konsistensi | Struktur dan urutan item sidebar **tidak berubah** antar halaman dalam satu sesi role yang sama, sesuai NAV-010 |

---

## 18. TOPBAR RULES

| Aturan | Ketentuan |
|---|---|
| Posisi | Fixed top, tinggi 64px, lebar mengikuti content area (setelah sidebar) |
| Background | `bg-topbar` (#FFFFFF), border bawah `border-default` |
| Isi Kiri | Breadcrumb (sesuai struktur breadcrumb pada 04_Information_Architecture.md Bagian 13), kecuali di halaman Login dan Error Page (NAV-001) |
| Isi Kanan | User menu (avatar + nama + dropdown: Profil, Logout) |
| Breadcrumb Style | `caption` (12px), separator `/` warna `text-disabled`, segmen aktif terakhir warna `text-primary` dan bold, segmen lain `text-secondary` dan clickable |
| Tab Navigation | Untuk halaman dengan tab (Laporan: Harian/Mingguan/Bulanan/Tahunan; Pengaturan: Profil Toko/QRIS/Profil Owner), tab diletakkan di bawah Topbar/Page Title, tidak mengubah breadcrumb induk (NAV-012) |
| Mobile Behavior | Pada mobile, breadcrumb dapat disingkat menjadi tombol "← Kembali" + judul halaman saat ini |

---

## 19. CARD COMPONENT

| Property | Value |
|---|---|
| Background | `surface-card` (#FFFFFF) |
| Border | 1px solid `border-default` |
| Border Radius | `radius-lg` (12px) |
| Shadow | `shadow-xs`, berubah ke `shadow-sm` saat hover (jika card clickable) |
| Padding | `space-6` (24px) desktop, `space-4` (16px) mobile |
| Header Card | Judul `heading-3` + opsional aksi kanan (button/link), margin bawah `space-4` |

### 19.1 Statistic Card (Dashboard Widget)

| Element | Spesifikasi |
|---|---|
| Label | `dashboard-label`, warna `text-secondary`, contoh: "Penjualan Hari Ini" |
| Value | `dashboard-metric`, warna `text-primary`, format Rupiah dengan pemisah titik (contoh: "Rp 1.250.000") sesuai BR-GEN terkait format mata uang |
| Icon Container | Lingkaran 40x40px, background tint warna semantik (contoh `success-50` untuk Keuntungan), icon `icon-lg` warna semantik (`success-600`) |
| Trend Indicator (opsional) | Panah + persentase, warna `success-600` (naik) atau `danger-600` (turun), `caption` |
| Empty/Zero State | Jika belum ada transaksi hari berjalan, tampilkan value "Rp 0" dengan caption informatif, bukan card kosong (sesuai BR-DASH-002 Exception) |

### 19.2 Product Card (Data Barang Grid, jika digunakan pada Kasir)

| Element | Spesifikasi |
|---|---|
| Image | Rasio 1:1, radius `radius-md`, object-fit cover, placeholder icon Box jika foto tidak tersedia (foto barang bersifat opsional per PRD) |
| Nama Barang | `body`, weight 600, max 2 baris (truncate dengan ellipsis) |
| Harga Jual | `body`, weight 700, warna `text-primary`, format Rupiah |
| Status Stok | Badge kecil di pojok/bawah card (lihat Bagian 24 Badge Component) |
| Disabled State (stok habis/nonaktif) | Opacity card 60%, badge "Stok Habis" `danger`, card tidak clickable untuk ditambahkan ke keranjang |

---

## 20. BUTTON COMPONENT

### 20.1 Variants

| Variant | Background | Text Color | Border | Penggunaan |
|---|---|---|---|---|
| **Primary** | `primary-600` | `text-inverse` (#FFFFFF) | none | Aksi utama per halaman (Simpan, Checkout, Tambah Barang) |
| **Secondary** | `surface-card` (#FFFFFF) | `text-primary` | 1px `border-strong` | Aksi sekunder (Batal, Filter, Edit) |
| **Ghost** | transparent | `primary-600` | none | Aksi tersier, aksi dalam tabel (Lihat Detail) |
| **Danger** | `danger-600` | `text-inverse` | none | Aksi destruktif (Nonaktifkan, Hapus) |
| **Danger Ghost** | transparent | `danger-600` | none | Aksi destruktif ringan dalam konteks tabel/list |
| **Link** | transparent | `primary-600` | none, underline on hover | Aksi inline dalam teks/tabel |

### 20.2 Sizes

| Size | Height | Padding Horizontal | Font | Penggunaan |
|---|---|---|---|---|
| `sm` | 32px | 12px | `body-sm` (13px) | Aksi dalam tabel/card kecil |
| `md` | 40px | 16px | `button` (14px) | Default — mayoritas form dan halaman |
| `lg` | 48px | 20px | `button` (14px), padding lebih besar | Tombol utama pada Kasir (contoh: "Checkout"), area sentuh besar untuk kecepatan input |

### 20.3 States

| State | Ketentuan |
|---|---|
| Default | Sesuai variant |
| Hover | Primary → `primary-700`; Secondary → background `hover-neutral`; Danger → `danger-700` |
| Active/Pressed | Primary → `primary-800`; scale visual 98% opsional |
| Focus | Tambahkan `shadow-focus` ring |
| Disabled | Background `disabled-bg`, teks `disabled-text`, cursor not-allowed, tanpa hover effect |
| Loading | Teks digantikan/didampingi spinner 16px, tombol non-interaktif, tetap mempertahankan lebar tombol |

### 20.4 Icon Button

| Ketentuan | Spesifikasi |
|---|---|
| Ukuran | 36x36px (sm) / 40x40px (md), radius `radius-md` |
| Penggunaan | Aksi ikon-saja dalam toolbar tabel (contoh: icon edit/nonaktifkan pada baris tabel) — **wajib** disertai `aria-label` dan tooltip teks untuk aksesibilitas, sesuai prinsip Clarity Over Cleverness |

---

## 21. INPUT COMPONENT

| Property | Value |
|---|---|
| Height | 40px (default), 48px (untuk input krusial pada Kasir, contoh: input nominal cash) |
| Padding | Horizontal `space-3` (12px) |
| Border | 1px solid `border-default`, radius `radius-md` |
| Background | `surface-card` (#FFFFFF), `disabled-bg` jika disabled |
| Font | `body` (14px), warna `text-primary` |
| Placeholder | `text-disabled` |
| Label | `body-sm`, weight 600, warna `text-primary`, margin bawah `space-2` |
| Helper Text | `caption`, warna `text-secondary`, margin atas `space-1` |

### 21.1 States

| State | Border | Tambahan |
|---|---|---|
| Default | `border-default` | — |
| Hover | `border-strong` | — |
| Focus | `primary-600` | `shadow-focus` ring |
| Error | `danger-600` | Helper text berubah warna `danger-600`, icon alert kecil di kanan input |
| Disabled | `disabled-border` | Background `disabled-bg`, teks `disabled-text` |
| Success (opsional, contoh: validasi real-time username tersedia) | `success-600` | Icon check kecil di kanan input |

### 21.2 Input Types Khusus

| Tipe | Ketentuan |
|---|---|
| Input Rupiah | Prefix "Rp" statis di kiri input, format otomatis pemisah ribuan saat mengetik, `tabular-nums` |
| Input Password | Icon toggle show/hide (mata) di kanan input |
| Input Upload (Foto Barang, Logo, QRIS) | Dropzone dengan border dashed `border-strong`, radius `radius-lg`, preview thumbnail setelah upload, helper text menampilkan batas format & ukuran (contoh: "JPG/PNG, maksimum 2MB" sesuai 02_PRD.md Bagian 13) |
| Textarea | Min-height 80px, resize vertikal saja |
| Required Field Indicator | Asterisk merah (`danger-600`) setelah label, contoh: "Nama Barang *" |

---

## 22. SELECT COMPONENT

| Property | Value |
|---|---|
| Struktur Visual | Identik dengan Input (height, border, radius) + icon chevron-down di kanan (`icon-sm`, `text-secondary`) |
| Dropdown Panel | Background `surface-elevated`, `shadow-md`, radius `radius-md`, max-height 280px dengan scroll |
| Option Item | Padding `space-3` horizontal, `space-2` vertikal, hover background `hover-neutral` |
| Option Terpilih | Background `primary-50`, teks `primary-600`, icon check di kanan |
| Searchable Select | Untuk daftar panjang (contoh: pilih Kategori saat Tambah Barang), sertakan input pencarian di atas daftar option |
| Multi-Select (jika diperlukan) | Option terpilih ditampilkan sebagai chip/tag di dalam field, dapat dihapus dengan icon "x" pada chip |
| Disabled | Sama seperti Input disabled state |

---

## 23. SEARCH COMPONENT

Search adalah komponen **kritis** pada StoreKuify karena menggantikan barcode scanner sesuai filosofi produk (No Barcode Scanner — pencarian barang berbasis nama).

| Property | Value |
|---|---|
| Height | 44px (umum), 52px (khusus pada modul Kasir untuk kecepatan interaksi) |
| Icon | Magnifying glass (`icon-sm`) di kiri, warna `text-secondary` |
| Border & Radius | Sama seperti Input, radius `radius-md` |
| Placeholder | Kontekstual, contoh: "Cari nama barang..." |
| Clear Button | Icon "x" muncul di kanan saat ada input, untuk mengosongkan pencarian dengan cepat |
| Behavior | Live search/instant filter (tanpa perlu klik tombol cari) direkomendasikan untuk mendukung prinsip Speed at the Counter pada modul Kasir |
| Hasil Kosong | Tampilkan Empty State kontekstual: "Barang '[kata kunci]' tidak ditemukan" |
| Fokus pada Kasir | Search bar Kasir sebaiknya auto-focus saat halaman dimuat, agar kasir dapat langsung mengetik tanpa klik |

---

## 24. BADGE COMPONENT

Badge digunakan luas untuk menampilkan status data (stok, hutang, transaksi, akun) secara konsisten di seluruh aplikasi.

| Property | Value |
|---|---|
| Height | 22–24px |
| Padding | Horizontal `space-2` (8px) |
| Border Radius | `radius-sm` (6px) untuk badge persegi, `radius-full` untuk badge pill |
| Font | `caption-bold` (12px, semibold) |
| Struktur | Opsional dot indicator (6px, `radius-full`) di kiri teks untuk penekanan status |

### 24.1 Badge Variants

| Variant | Background | Text | Contoh Penggunaan |
|---|---|---|---|
| Success | `success-50` | `success-700` | "Aktif", "Lunas", "Stok Aman", "Berhasil" |
| Warning | `warning-50` | `warning-700` | "Hampir Habis", "Belum Lunas" |
| Danger | `danger-50` | `danger-700` | "Stok Habis", "Nonaktif Sementara/Error" |
| Neutral | `neutral-100` | `neutral-600` | "Nonaktif" (status netral, bukan error — sesuai catatan Bagian 7.8) |
| Info | `info-50` | `info-700` | "Baru", "Cash + Hutang" |
| Primary | `primary-50` | `primary-700` | Kategori/tag umum |

### 24.2 Badge Mapping Wajib

| Data | Badge |
|---|---|
| Barang Aktif | Success — "Aktif" |
| Barang Nonaktif | Neutral — "Nonaktif" |
| Stok ≤ ambang batas minimum | Warning — "Hampir Habis" (BR-DASH-004, BR-STK-004) |
| Stok = 0 | Danger — "Habis" |
| Hutang Outstanding > 0 | Warning — "Belum Lunas" |
| Hutang Outstanding = 0 | Success — "Lunas" |
| Metode Pembayaran Cash | Neutral/Info — "Cash" |
| Metode Pembayaran QRIS | Info — "QRIS" |
| Metode Pembayaran Hutang | Warning — "Hutang" |
| Metode Pembayaran Cash + Hutang | Info — "Cash + Hutang" |
| Akun Kasir Aktif | Success — "Aktif" |
| Akun Kasir Dinonaktifkan | Neutral — "Nonaktif" |

---

## 25. TABLE COMPONENT

Table adalah komponen inti pada modul Data Barang, Hutang Pelanggan, Laporan, dan Kelola Kasir (Filament 4-based).

| Property | Value |
|---|---|
| Container | `surface-card`, border `border-default`, radius `radius-lg`, overflow-x auto untuk responsive |
| Header Row | Background `neutral-50`, teks `table-header` (uppercase, `text-secondary`), height 44px, sticky saat scroll vertikal panjang |
| Body Row | Height 52–56px, border-bottom 1px `border-default` (kecuali baris terakhir), teks `table-body` |
| Row Hover | Background `hover-neutral` |
| Row Zebra Stripe | Tidak digunakan secara default (mengutamakan clean look ala Linear/Notion); border antar baris sudah cukup memisahkan data |
| Kolom Numerik/Rupiah | Rata kanan (right-aligned), `table-body-numeric` |
| Kolom Status | Menggunakan Badge Component, rata kiri atau center |
| Kolom Aksi | Rata kanan, berisi Icon Button (Edit, Nonaktifkan) atau Button Ghost "Detail" |
| Pagination | Diletakkan di footer table, menampilkan info "Menampilkan 1–10 dari 42 data" (kiri) + kontrol halaman (kanan) |
| Sorting | Header kolom yang dapat diurutkan menampilkan icon chevron kecil, aktif saat kolom diklik |
| Checkbox Selection (jika diperlukan bulk action) | Checkbox di kolom pertama, header checkbox untuk select-all |
| Sticky Column (opsional) | Kolom nama/identitas utama dapat sticky di kiri saat scroll horizontal pada tabel lebar (contoh: tabel Laporan dengan banyak kolom) |

---

## 26. MODAL COMPONENT

Modal digunakan untuk form ringkas (Tambah Kategori, Tambah Kasir, Reset Password) dan konfirmasi, sesuai Modal/Dialog Pages pada 05_Sitemap.md.

| Property | Value |
|---|---|
| Overlay | `rgba(15, 23, 42, 0.5)`, klik di luar menutup modal (kecuali modal kritis, lihat 26.1) |
| Container | `surface-card`, radius `radius-xl`, `shadow-lg`, max-width 480px (form kecil) / 640px (form kompleks) |
| Header | Judul `heading-3` + tombol close "X" (`icon-md`, kanan atas) |
| Body | Padding `space-6`, scroll internal jika konten melebihi 70% tinggi viewport |
| Footer | Rata kanan, tombol "Batal" (Secondary) + tombol aksi utama (Primary), gap `space-3` |
| Animasi | Fade + scale-up ringan (dari 96% ke 100%) durasi 200ms |
| Perilaku Tutup | Tombol "X", tombol "Batal", atau klik overlay — sesuai NAV-006 |
| Unsaved Changes | Jika form memiliki perubahan belum tersimpan, tampilkan konfirmasi tambahan sebelum menutup — sesuai NAV-007 |
| URL/Breadcrumb | Modal tidak mengubah URL maupun breadcrumb halaman induk — sesuai NAV-011 |

### 26.1 Modal Kritis (Non-Dismissible)

Modal seperti **Konfirmasi QRIS saat checkout** hanya dapat ditutup melalui aksi eksplisit (tombol di dalam modal), tidak melalui klik overlay, untuk mencegah kehilangan data transaksi secara tidak sengaja (sesuai NAV-006).

| Perbedaan dari Modal Standar | Ketentuan |
|---|---|
| Klik Overlay | Dinonaktifkan (tidak menutup modal) |
| Tombol Close "X" | Disembunyikan atau dinonaktifkan jika relevan dengan konteks kritikalitas transaksi |
| Shadow | `shadow-xl` untuk penekanan visual lebih kuat |

---

## 27. DIALOG COMPONENT

Dialog merujuk pada modal konfirmasi ringkas (ukuran lebih kecil dari Modal form), digunakan untuk aksi destruktif/sensitif sesuai NAV-015: Nonaktifkan Barang, Nonaktifkan Kasir, Logout, Delete Confirmation generik.

| Property | Value |
|---|---|
| Max-width | 400px |
| Struktur | Icon status (`icon-xl`, warna sesuai konteks — `danger-600` untuk nonaktifkan, `warning-600` untuk logout) + Judul `heading-3` + Deskripsi `body` `text-secondary` |
| Footer | Tombol "Batal" (Secondary) + tombol aksi (Danger untuk aksi destruktif, Primary untuk aksi netral seperti Logout) |
| Contoh Copy | Judul: "Nonaktifkan Barang?" — Deskripsi: "Barang ini tidak akan muncul lagi di daftar penjualan Kasir, namun data historisnya tetap tersimpan." |
| Wajib Konfirmasi Eksplisit | Tidak ada opsi "jangan tampilkan lagi" untuk aksi destruktif — setiap kali aksi dipicu, dialog konfirmasi selalu muncul (NAV-015) |

---

## 28. TOAST NOTIFICATION

Toast digunakan untuk feedback non-blocking atas aksi yang berhasil/gagal (Simpan, Hapus, Checkout selesai).

| Property | Value |
|---|---|
| Posisi | Top-right (desktop), top-center (mobile) |
| Container | `surface-card`, `shadow-lg`, radius `radius-md`, max-width 360px, border-left 4px sesuai variant |
| Struktur | Icon status (`icon-md`) + Pesan (`body-sm`) + tombol close "X" opsional |
| Durasi | Auto-dismiss 4 detik (sukses/info), 6 detik (error, agar sempat dibaca) |
| Stack Behavior | Toast baru muncul di atas/bawah toast sebelumnya dengan gap `space-2`, maksimum 3 toast terlihat bersamaan |
| Animasi | Slide-in dari kanan/atas + fade, durasi 250ms |

### 28.1 Toast Variants

| Variant | Border-left / Icon | Contoh Pesan |
|---|---|---|
| Success | `success-600` / check-circle | "Barang berhasil disimpan" |
| Error | `danger-600` / alert-circle | "Gagal menyimpan data, silakan coba lagi" |
| Warning | `warning-600` / alert-triangle | "Stok Beras 5kg hampir habis" |
| Info | `info-600` / info-circle | "Sesi Anda akan berakhir dalam 5 menit" |

---

## 29. ALERT COMPONENT

Alert (inline banner) digunakan dalam konteks halaman/form, berbeda dari Toast yang bersifat sementara dan mengambang.

| Property | Value |
|---|---|
| Container | Background tint sesuai variant (contoh `warning-50`), border 1px sesuai variant (`warning-500`), border-left 4px lebih tegas, radius `radius-lg`, padding `space-4` |
| Struktur | Icon (`icon-md`) + Judul opsional (`body`, weight 600) + Deskripsi (`body-sm`) + Aksi opsional (link/button kecil) |
| Penggunaan Umum | Peringatan validasi form pada bagian atas form, notifikasi kontekstual halaman (contoh: banner "Barang Hampir Habis" di atas tabel Data Barang) |

### 29.1 Alert Variants

Mengikuti mapping warna semantik yang sama dengan Badge (Success/Warning/Danger/Info).

| Contoh Kasus | Variant |
|---|---|
| "Akun Anda telah dinonaktifkan, silakan hubungi Owner" | Danger |
| "Semua stok barang aman" | Success |
| "5 barang mendekati stok habis" | Warning |
| "Perubahan harga barang tidak memengaruhi transaksi yang sudah tercatat" | Info |

---

## 30. EMPTY STATE

Empty State wajib didefinisikan untuk setiap halaman yang menampilkan daftar/tabel data, sesuai Bagian 13 pada 05_Sitemap.md.

| Property | Value |
|---|---|
| Struktur | Illustration/Icon container (lihat Bagian 13) + Judul (`heading-3`) + Deskripsi (`body-sm`, `text-secondary`) + Primary Action Button (opsional) |
| Posisi | Center di dalam container card/tabel, padding vertikal `space-16` |
| Contoh Konten | Data Barang kosong: Judul "Belum Ada Barang" — Deskripsi "Tambahkan barang pertama Anda untuk mulai berjualan." — Button "Tambah Barang" |
| Contoh Konten | Hasil pencarian kosong: Judul "Barang Tidak Ditemukan" — Deskripsi "Coba kata kunci lain atau periksa ejaan." (tanpa Primary Action) |
| Contoh Konten | Dashboard "Barang Hampir Habis" kosong: Pesan singkat inline "Semua stok barang aman" dengan icon check, bukan full empty state (sesuai BR-DASH-004 Exception) |

---

## 31. LOADING STATE

| Konteks | Pola Loading |
|---|---|
| Full Page Load | Skeleton Loading (lihat Bagian 32), bukan spinner penuh layar, untuk mengurangi persepsi waktu tunggu |
| Tombol Aksi (Submit) | Spinner inline dalam tombol (lihat Bagian 20.3), tombol non-interaktif selama loading |
| Data Table Refresh | Overlay semi-transparan pada tabel + spinner kecil di tengah, mempertahankan data lama tetap terlihat samar hingga data baru selesai dimuat |
| Search Instant Filter | Skeleton baris singkat (2–3 baris) di bawah search bar saat mengetik, durasi sangat singkat |
| Spinner Standalone | Digunakan hanya untuk loading skala kecil/lokal (contoh: dalam dropdown async); ukuran 16–24px, warna `primary-600`, animasi rotate 360° linear 800ms |

---

## 32. SKELETON LOADING

| Property | Value |
|---|---|
| Warna Dasar | `neutral-200` |
| Animasi | Shimmer/pulse — gradient bergerak dari `neutral-200` ke `neutral-100` dan kembali, durasi 1.5s, infinite loop |
| Radius | Mengikuti radius elemen asli yang direpresentasikan (text line: `radius-sm`; card/image: `radius-lg`) |
| Skeleton Card (Statistic) | Persegi panjang label (60% lebar, 12px tinggi) + persegi panjang value (40% lebar, 28px tinggi), meniru struktur Statistic Card |
| Skeleton Table Row | 4–6 baris placeholder, masing-masing kolom direpresentasikan sebagai blok abu-abu dengan lebar proporsional terhadap kolom aslinya |
| Skeleton Product Card | Kotak 1:1 (gambar) + 2 baris teks pendek di bawahnya |
| Durasi Maksimum | Skeleton ditampilkan maksimum hingga data tersedia; jika lebih dari 8 detik, sistem menampilkan pesan tambahan "Memuat data..." untuk transparansi kepada pengguna |

---

## 33. CHARTS

Chart digunakan pada Dashboard Owner (Grafik Penjualan, sesuai BR-DASH-002) dan Laporan.

| Property | Value |
|---|---|
| Tipe Chart — Tren Penjualan | Line Chart atau Area Chart (area fill dengan gradient dari `primary-100` ke transparan), untuk menunjukkan tren dari waktu ke waktu |
| Tipe Chart — Perbandingan (Barang Terlaris) | Horizontal Bar Chart, memudahkan pembacaan nama barang yang panjang |
| Tipe Chart — Komposisi (opsional, kategori penjualan) | Donut Chart, bukan Pie Chart penuh, untuk ruang label tengah (contoh: total nominal) |
| Warna Data Series | Series utama menggunakan `primary-600`; jika multi-series (contoh: perbandingan periode), tambahkan `secondary-600` dan `warning-500` sebagai series kedua/ketiga |
| Grid Line | `neutral-200`, tipis, hanya horizontal (hindari grid vertikal yang membuat visual ramai) |
| Axis Label | `caption`, warna `text-secondary` |
| Tooltip | Muncul saat hover titik data, background `neutral-900`, teks `text-inverse`, radius `radius-sm`, menampilkan nominal Rupiah dengan format lengkap |
| Empty State Chart | Jika belum ada data transaksi pada periode yang dipilih, tampilkan pesan tengah chart "Belum ada data penjualan pada periode ini" alih-alih chart kosong tanpa keterangan |
| Responsif | Chart menyesuaikan lebar container penuh, tinggi tetap (contoh: 280–320px) di seluruh breakpoint desktop/tablet; pada mobile, chart dapat di-scroll horizontal jika data periode panjang (contoh: Grafik Bulanan/Tahunan) |

---

## 34. DASHBOARD WIDGETS

Struktur Dashboard mengikuti BR-DASH-001 s.d. BR-DASH-004, dengan perbedaan konten wajib antara Owner dan Kasir.

### 34.1 Dashboard Owner

| Widget | Tipe Komponen | Data |
|---|---|---|
| Penjualan Hari Ini | Statistic Card | Nominal Rupiah |
| Keuntungan Hari Ini | Statistic Card | Nominal Rupiah (khusus Owner — BR-DASH-002) |
| Jumlah Transaksi | Statistic Card | Angka |
| Barang Terjual | Statistic Card | Angka + satuan |
| Grafik Penjualan | Chart (Line/Area) | Tren penjualan periode berjalan |
| Barang Hampir Habis | List Widget (Card berisi mini-table/list, max 5 item + link "Lihat Semua" ke Data Barang) | Nama barang + sisa stok, Badge Warning |
| Hutang Belum Lunas | List Widget (Card berisi mini-table/list, max 5 item + link "Lihat Semua" ke Hutang Pelanggan) | Nama pelanggan + nominal outstanding, Badge Warning |

### 34.2 Dashboard Kasir

Sesuai BR-DASH-003, **tidak menampilkan** widget Keuntungan atau data finansial margin apa pun.

| Widget | Tipe Komponen | Data |
|---|---|---|
| Ringkasan Transaksi Hari Ini | Statistic Card | Jumlah transaksi yang diproses kasir tersebut hari ini |
| Barang Hampir Habis | List Widget | Sama seperti Owner |
| Hutang Pelanggan | List Widget | Sama seperti Owner |

### 34.3 Widget Layout Rule

Widget Statistic Card diletakkan pada baris grid teratas (lihat Bagian 15 Grid System), diikuti Grafik Penjualan (full-width, khusus Owner), lalu dua List Widget (Barang Hampir Habis & Hutang Belum Lunas) berdampingan pada baris berikutnya (50%/50% desktop, stacked mobile).

---

## 35. FORM GUIDELINES

| Aturan | Ketentuan |
|---|---|
| Layout Field | Single-column pada form pendek/modal (Tambah Kategori, Reset Password); dua kolom (grid 2) pada form panjang desktop (Tambah/Edit Barang, Pengaturan Profil Toko), tetap single-column pada mobile |
| Grouping | Field yang berkaitan dikelompokkan dalam satu section dengan `subtitle` sebagai judul grup (contoh: "Informasi Harga" memuat Harga Modal & Harga Jual berdampingan) |
| Label Position | Selalu di atas input (top-aligned), bukan inline kiri — mendukung keterbacaan pada layar sempit |
| Required Indicator | Asterisk merah setelah label, sesuai Bagian 21.2 |
| Validasi Real-Time | Validasi field-level muncul saat user meninggalkan field (on blur) untuk field kritis (contoh: cek duplikasi nama kategori/barang/username), sesuai BR-VAL-001 dan pesan error pada 02_PRD.md Bagian 14 |
| Validasi Harga Jual < Harga Modal | Ditampilkan sebagai error inline di bawah field Harga Jual: "Harga jual tidak boleh lebih kecil dari harga modal" |
| Tombol Aksi Form | Selalu di bagian bawah form, rata kanan: "Batal" (Secondary) di kiri tombol utama, tombol Simpan/Submit (Primary) paling kanan |
| Perilaku Simpan | Sesuai NAV-005 — validasi dulu, jika valid data disimpan dan redirect ke halaman induk dengan toast sukses; jika tidak valid, form tetap terbuka dengan error inline pada field terkait |
| Sticky Form Actions | Pada form panjang dengan scroll (contoh: Tambah Barang dengan banyak field), tombol aksi dapat sticky di bagian bawah viewport/modal |
| Autofocus | Field pertama pada form/modal menerima autofocus saat dibuka, kecuali form dengan konteks pencarian (search autofocus lebih diprioritaskan) |

---

## 36. DATA TABLE GUIDELINES

| Aturan | Ketentuan |
|---|---|
| Toolbar di Atas Tabel | Search bar (kiri) + Filter/Sort controls (tengah/kanan) + Primary Action Button "Tambah [Data]" (kanan) |
| Jumlah Baris Default | 10 baris per halaman, dengan opsi ubah ke 25/50 pada kontrol pagination |
| Kolom Wajib per Modul | Data Barang: Foto (jika ada), Nama, Kategori, Harga Modal, Harga Jual, Stok, Status, Aksi. Hutang Pelanggan: Nama Pelanggan, Total Outstanding, Status, Terakhir Transaksi, Aksi. Kelola Kasir: Nama, Username, Status, Aksi |
| Truncate Text Panjang | Nama barang/pelanggan yang panjang dipotong dengan ellipsis pada lebar kolom maksimum, dengan tooltip menampilkan teks lengkap saat hover |
| Baris dengan Status Nonaktif | Opacity baris diturunkan ringan (85%) untuk menandakan data tidak aktif, tanpa menyembunyikan data (sesuai BR-BRG-008: barang nonaktif tetap tampil di Data Barang) |
| Row Click Behavior | Klik pada baris (di luar kolom Aksi) mengarahkan ke halaman Detail/Drill-down sesuai hierarki pada 04_Information_Architecture.md |
| Konfirmasi Aksi Tabel | Aksi nonaktifkan/hapus dari tabel selalu memicu Dialog Component (Bagian 27), tidak langsung dieksekusi |

---

## 37. RESPONSIVE RULES

Sesuai prinsip **Desktop First** pada 02_PRD.md dan 04_Information_Architecture.md, namun tetap responsif penuh ke Tablet dan Mobile.

### 37.1 Breakpoints

| Breakpoint | Lebar |
|---|---|
| Mobile | < 768px |
| Tablet | 768px – 1023px |
| Laptop | 1024px – 1279px |
| Desktop | ≥ 1280px |

### 37.2 Sidebar Behavior

| Breakpoint | Perilaku |
|---|---|
| Desktop/Laptop | Sidebar persistent, expanded (260px) sebagai default |
| Tablet | Sidebar default collapsed ke icon-only (72px), dapat expand sementara via toggle/hover |
| Mobile | Sidebar disembunyikan, diakses melalui hamburger menu di Topbar, muncul sebagai overlay drawer full-height dengan backdrop |

### 37.3 Card Behavior

| Breakpoint | Perilaku |
|---|---|
| Desktop | Grid multi-kolom sesuai Bagian 15 (4 kolom Statistic Card) |
| Tablet | Grid menyesuaikan ke 2–3 kolom |
| Mobile | Stacked single-column, padding card diperkecil ke `space-4` |

### 37.4 Table Behavior

| Breakpoint | Perilaku |
|---|---|
| Desktop/Laptop | Tabel penuh dengan seluruh kolom terlihat |
| Tablet | Kolom non-esensial disembunyikan (contoh: kolom Harga Modal disembunyikan pada Data Barang, tetap dapat dilihat di Detail Barang) atau tabel scroll horizontal |
| Mobile | Tabel bertransformasi menjadi **Card List** — setiap baris data ditampilkan sebagai card ringkas (Nama sebagai judul, 2–3 data kunci sebagai sublabel, Badge status, dan aksi melalui icon menu titik tiga) |

### 37.5 Chart Behavior

| Breakpoint | Perilaku |
|---|---|
| Desktop/Laptop | Chart full-width dalam card, seluruh label axis terlihat |
| Tablet | Chart tetap full-width, label axis dapat dirotasi/disingkat jika diperlukan |
| Mobile | Chart scrollable horizontal untuk periode data panjang (Bulanan/Tahunan), tinggi chart dikurangi menjadi 220–240px |

### 37.6 Modul Kasir (POS) pada Mobile/Tablet

| Breakpoint | Perilaku |
|---|---|
| Desktop/Laptop | Split-view dua panel (Bagian 16.2) |
| Tablet | Split-view tetap dipertahankan jika lebar mencukupi (≥ 900px landscape); di bawah itu, mengikuti pola mobile |
| Mobile | Panel kiri (pencarian barang) full-screen sebagai tampilan utama; Panel kanan (keranjang) diakses melalui tombol floating "Keranjang (n item) — Rp [total]" di bagian bawah layar yang membuka bottom sheet berisi ringkasan checkout |

---

## 38. ACCESSIBILITY

| Aspek | Ketentuan |
|---|---|
| **Color Contrast** | Rasio kontras teks terhadap background minimum **4.5:1** untuk teks body (WCAG AA), minimum **3:1** untuk teks besar (≥18px bold/≥24px regular) dan komponen UI non-teks (border, icon fungsional). Seluruh token warna teks pada Bagian 7.5 telah diverifikasi memenuhi standar ini terhadap `bg-page` dan `surface-card`. |
| **Keyboard Navigation** | Seluruh elemen interaktif (link, button, input, select) dapat diakses dan dioperasikan penuh melalui keyboard (Tab, Shift+Tab, Enter, Space, Esc). Urutan Tab mengikuti urutan visual logis (left-to-right, top-to-bottom). Modal/Dialog menerapkan focus trap — fokus tidak dapat keluar dari modal hingga ditutup. |
| **Focus State** | Setiap elemen fokus menampilkan `shadow-focus` ring (Bagian 11) yang terlihat jelas, tidak pernah dihilangkan (tidak menggunakan `outline: none` tanpa pengganti visual). |
| **Error State** | Field error dikomunikasikan tidak hanya melalui warna (`danger-600`), tetapi juga melalui icon dan teks pesan eksplisit, agar tidak bergantung pada persepsi warna semata (mendukung pengguna dengan color blindness). |
| **Disabled State** | Elemen disabled memiliki `aria-disabled="true"` dan tidak menerima fokus keyboard, namun tetap terlihat (bukan disembunyikan) agar pengguna memahami elemen tersebut ada namun belum dapat digunakan. |
| **Required Field Indicator** | Selain asterisk visual, field wajib diberi atribut `aria-required="true"` untuk assistive technology. |
| **Target Sentuh (Touch Target)** | Minimum ukuran target sentuh 40x40px pada elemen interaktif di layar tablet/mobile, krusial untuk modul Kasir yang sering digunakan pada perangkat tablet di meja kasir. |
| **Alt Text** | Seluruh gambar fungsional (foto barang, logo toko, QRIS) memiliki teks alternatif deskriptif; ikon dekoratif menggunakan `aria-hidden="true"`. |
| **Bahasa & Label** | Seluruh label, pesan error, dan instruksi menggunakan Bahasa Indonesia yang jelas sesuai BR-ERR-001, mendukung pengguna dengan tingkat literasi digital yang bervariasi. |
| **Status Announcement** | Toast dan Alert kritis menggunakan `aria-live="polite"` (info/sukses) atau `aria-live="assertive"` (error) agar terbaca oleh screen reader tanpa memerlukan interaksi tambahan. |

---

## 39. ANIMATION GUIDELINES

Animasi digunakan secara **minimal dan fungsional**, mendukung prinsip Speed at the Counter — tidak boleh memperlambat persepsi pengguna terhadap kecepatan aplikasi.

| Elemen | Durasi | Easing | Catatan |
|---|---|---|---|
| Hover (button, card, row) | 120ms | ease-out | Perubahan warna/shadow saja, tanpa transform berlebihan |
| Modal/Dialog Open-Close | 200ms | ease-in-out | Fade + scale 96%→100% |
| Toast Enter/Exit | 250ms | ease-out (enter), ease-in (exit) | Slide + fade |
| Dropdown/Select Open | 150ms | ease-out | Fade + slight translate-y (4px) |
| Sidebar Collapse/Expand | 200ms | ease-in-out | Width transition |
| Skeleton Shimmer | 1500ms | linear, infinite | Lihat Bagian 32 |
| Page Transition | Tidak menggunakan animasi transisi halaman penuh (full-page transition) — perpindahan halaman bersifat instan untuk mendukung kecepatan kerja kasir |
| Micro-interaction Checkout Berhasil | 400ms | ease-out | Checkmark animasi ringan pada konfirmasi transaksi sukses, sebagai feedback positif tanpa menghalangi alur kerja berikutnya |
| Prinsip Umum | Tidak ada animasi yang melebihi 400ms untuk interaksi UI standar; animasi tidak boleh memblokir interaksi pengguna berikutnya (non-blocking) |
| Reduced Motion | Menghormati preferensi sistem `prefers-reduced-motion: reduce` dengan menonaktifkan animasi non-esensial (shimmer, slide, scale), mempertahankan hanya perubahan opacity sederhana |

---

## 40. UI DO'S AND DON'TS

| # | ✅ Do | ❌ Don't |
|---|---|---|
| 1 | Gunakan Badge warna semantik yang konsisten untuk status yang sama di seluruh halaman (Aktif selalu hijau) | Jangan gunakan warna berbeda untuk status yang sama pada halaman berbeda |
| 2 | Tampilkan format Rupiah lengkap dengan pemisah ribuan di seluruh nominal | Jangan menyingkat nominal (contoh "1.2jt") pada data finansial krusial seperti Laporan dan Struk |
| 3 | Sembunyikan seluruh elemen Keuntungan dari tampilan Kasir | Jangan menampilkan nominal Keuntungan/Margin di halaman mana pun yang diakses Kasir |
| 4 | Selalu tampilkan Dialog konfirmasi sebelum aksi nonaktifkan/hapus | Jangan mengeksekusi aksi destruktif langsung dari klik tunggal tanpa konfirmasi |
| 5 | Gunakan ukuran tombol besar (`lg`) pada aksi krusial modul Kasir | Jangan gunakan tombol kecil pada aksi Checkout — berisiko salah klik saat kondisi terburu-buru |
| 6 | Pertahankan struktur sidebar yang identik di semua halaman dalam satu role | Jangan mengubah urutan/isi sidebar antar halaman dalam sesi yang sama |
| 7 | Gunakan Skeleton Loading untuk pemuatan data tabel/dashboard | Jangan gunakan spinner penuh layar yang memblokir seluruh konten |
| 8 | Sediakan Empty State informatif dengan arahan aksi yang jelas | Jangan biarkan tabel/list kosong tanpa penjelasan apa pun |
| 9 | Gunakan satu warna aksen primer (`primary-600`) untuk seluruh aksi utama | Jangan mencampur banyak warna aksen berbeda untuk tombol dengan fungsi setara |
| 10 | Tampilkan pesan error spesifik dan actionable (contoh: "Stok tidak mencukupi, sisa: 3") | Jangan tampilkan pesan error generik ("Terjadi kesalahan") untuk kasus yang seharusnya spesifik |
| 11 | Jaga kepadatan visual rendah (whitespace cukup) pada halaman non-tabel | Jangan memadatkan terlalu banyak elemen dalam satu card tanpa hierarki visual |
| 12 | Gunakan icon linier konsisten di seluruh aplikasi | Jangan mencampur gaya icon berbeda (filled dan outline) dalam satu halaman |
| 13 | Pastikan status Barang Nonaktif tetap terlihat (opacity turun), bukan disembunyikan | Jangan menyembunyikan data nonaktif dari daftar — bertentangan dengan BR-BRG-008 |

---

## 41. FUTURE DESIGN SYSTEM

Elemen berikut **belum berlaku** pada versi StoreKuify saat ini, namun dicatat sebagai referensi awal untuk pengembangan lanjutan, konsisten dengan Future Scope pada 02_PRD.md, Future Business Rules pada 03_Business_Rules.md, dan Future Information Architecture pada 04_Information_Architecture.md:

1. **Dark Mode Penuh** — token warna dark mode telah disiapkan pada Bagian 7.7, namun implementasi UI toggle dan pengujian kontras dark mode belum menjadi bagian dari scope rilis ini.
2. **Komponen Notifikasi Panel (Topbar)** — jika fitur Notifikasi Otomatis ditambahkan (02_PRD.md Bagian 15), diperlukan komponen dropdown notifikasi baru pada Topbar dengan pola badge counter dan list item notifikasi.
3. **Komponen Barcode Scanner Input** — jika integrasi barcode scanner ditambahkan (02_PRD.md Bagian 15), diperlukan varian Search Component dengan mode scan aktif dan feedback visual audio-visual saat scan berhasil.
4. **Komponen Ekspor Laporan (PDF/Excel)** — jika fitur ekspor ditambahkan, diperlukan komponen tombol ekspor dengan dropdown pilihan format serta pola loading khusus untuk proses generate file.
5. **Komponen Selector Multi-Toko/Cabang** — jika dukungan multi-cabang ditambahkan, diperlukan komponen Store Switcher pada Topbar/Sidebar sesuai catatan pada 04_Information_Architecture.md Bagian 16.
6. **Komponen Print Struk Thermal** — jika cetak struk fisik ditambahkan, diperlukan template layout struk khusus format 58mm/80mm terpisah dari struk layar (on-screen receipt).
7. **Role Supervisor Visual Treatment** — jika role tambahan ditambahkan, diperlukan penyesuaian badge role dan skema visibilitas sidebar untuk role ketiga.

---

## 42. GLOSSARY

| Istilah | Definisi |
|---|---|
| **Design System** | Kumpulan standar visual (warna, tipografi, spacing, komponen) yang menjadi acuan tunggal desain dan pengembangan antarmuka aplikasi. |
| **Design Token** | Nilai atomik (warna, ukuran, radius) yang diberi nama variabel agar dapat digunakan konsisten dan diubah secara terpusat. |
| **Component** | Elemen UI reusable (Button, Card, Input, Modal, dsb.) dengan spesifikasi visual dan perilaku yang konsisten. |
| **Variant** | Versi berbeda dari satu komponen (contoh: Button Primary, Secondary, Danger) untuk konteks penggunaan berbeda. |
| **State** | Kondisi visual suatu elemen (default, hover, active, disabled, error, loading). |
| **Semantic Color** | Warna yang merepresentasikan makna/status tertentu (Success, Danger, Warning, Info), bukan sekadar dekorasi. |
| **Neutral Scale** | Rangkaian warna abu-abu/hitam-putih yang digunakan untuk teks, border, dan background non-aksen. |
| **Badge** | Komponen kecil untuk menampilkan status/label ringkas pada data (contoh: "Aktif", "Hampir Habis"). |
| **Skeleton Loading** | Pola loading berupa placeholder abu-abu yang meniru bentuk konten asli sebelum data selesai dimuat. |
| **Empty State** | Tampilan yang ditunjukkan ketika suatu halaman/komponen belum memiliki data untuk ditampilkan. |
| **Toast Notification** | Notifikasi sementara yang muncul mengambang untuk memberi umpan balik atas suatu aksi, hilang otomatis setelah beberapa detik. |
| **Alert** | Banner informasi/peringatan yang menempel pada konten halaman (inline), berbeda dari Toast yang mengambang sementara. |
| **Grid System** | Sistem kolom dan gutter yang mengatur penempatan elemen pada layout halaman. |
| **Breakpoint** | Titik lebar layar tertentu di mana layout menyesuaikan diri (responsive design). |
| **Elevation** | Persepsi kedalaman visual suatu elemen terhadap background, umumnya diwujudkan melalui shadow. |
| **Focus Ring** | Indikator visual (biasanya berupa outline/ring) yang menunjukkan elemen sedang menerima fokus keyboard. |
| **Tabular Nums** | Properti tipografi yang membuat seluruh digit angka memiliki lebar sama, memudahkan pembacaan angka pada tabel/kolom sejajar. |
| **Split-View Layout** | Pola layout dua panel berdampingan, digunakan pada modul Kasir untuk memisahkan area pencarian barang dan area keranjang/checkout. |
| **Sticky Element** | Elemen yang tetap terlihat pada posisi tertentu saat halaman di-scroll (contoh: tombol Checkout pada modul Kasir). |
| **WCAG** | *Web Content Accessibility Guidelines* — standar internasional untuk aksesibilitas konten web. |

---

**— AKHIR DOKUMEN 07_Design_System.md —**

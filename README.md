# E-Commerce UMKM Lokal (Aksara Lokal)
Tugas Besar Pemrograman Web II - CPMK-01 (Paket 2)

Repositori ini adalah hasil pengerjaan project akhir untuk mata kuliah Pemrograman Web II. Sistem ini pada dasarnya adalah platform e-commerce sederhana dengan multi-role (Admin, Seller, Buyer) yang ditujukan untuk membantu produk-produk UMKM lokal.

Project ini dibangun murni menggunakan PHP Native (versi 8.x), arsitektur OOP, PDO untuk penanganan database, dan Tailwind CSS (via CDN) untuk antarmuka pengguna, menyesuaikan dengan aturan tidak menggunakan web framework backend seperti Laravel atau CodeIgniter.

---

## Analisis Fitur Keseluruhan
Berikut adalah rincian fitur yang telah diimplementasikan dalam aplikasi ini sesuai dengan spesifikasi tugas Paket 2 dan beberapa tambahan eksplorasi:

### 1. Sistem Inti & Keamanan
- Arsitektur OOP: Menggunakan pewarisan (BaseModel) untuk efisiensi fungsi CRUD di seluruh class.
- Keamanan Database: Seluruh query murni menggunakan PDO Prepared Statements untuk mencegah SQL Injection, dengan koneksi Singleton.
- Autentikasi: Password di-hash menggunakan password_hash() dan diverifikasi dengan password_verify().
- CSRF Protection: Setiap form POST dilengkapi dengan token CSRF custom untuk mencegah serangan modifikasi state.

### 2. Role Buyer (Pembeli)
- Pencarian dan Filter: Pembeli bisa mencari produk berdasarkan kata kunci, memfilter berdasarkan kategori, rentang harga (min/max), dan melakukan sorting (harga termurah/termahal, terbaru).
- Keranjang Belanja (Session): Data keranjang disimpan di $_SESSION sehingga sangat ringan di sisi server dan tidak menumpuk di database sebelum checkout.
- Proses Checkout & Transaksi: Mendukung upload bukti pembayaran (divalidasi ketat hanya JPG/PNG dan maksimal 2MB).
- Transaksi Database & Pessimistic Locking (Tantangan Ekstra): Untuk mencegah anomali pesanan (misalnya dua pembeli serentak men-checkout barang dengan stok yang sisa 1), mekanisme checkout dibungkus penuh dengan PDO Transaction (`beginTransaction`, `commit`, `rollback`) dipadukan metode penguncian `SELECT ... FOR UPDATE` pada baris data. Metode ini secara ketat mencegah terjadinya *race condition* saat mengurangi stok.

### 3. Role Seller (Penjual)
- Dashboard Statistik: Halaman ringkasan untuk memantau performa toko, peringatan stok menipis, dan grafik penjualan 7 hari terakhir.
- ASCII Chart (Fitur Kunci Paket 2): Sesuai spesifikasi larangan penggunaan library eksternal, grafik pendapatan toko selama 7 hari terakhir dirender secara dinamis di server secara murni menggunakan logika iterasi pembentukan teks dan karakter ASCII, lalu ditampilkan dalam struktur tag preformatted-text. Sama sekali tidak memanggil instruksi Chart.js maupun library Javascript serupa.
- Manajemen Produk & Pesanan: Penjual memiliki wewenang untuk menambah produk, mengelola stok, dan melakukan update status pesanan (verifikasi resi/mengirim pesanan).

### 4. Role Admin (Administrator)
- Moderasi Produk: Semua produk yang diunggah seller harus melalui proses approval oleh admin sebelum muncul di halaman publik.
- Manajemen Promo (Voucher & Flash Sale): Admin dapat membuat kode voucher diskon dengan batas kuota pemakaian, serta mengatur jam tayang fitur Flash Sale.
- Flash Sale dengan JS Countdown: Tampilan di halaman utama memiliki penghitung waktu mundur JavaScript yang tersinkronisasi murni dari timestamp database.

---

## Struktur Direktori
- /classes: Berisi semua class model (User, Product, Order, Category, Voucher, Cart, BaseModel).
- /config: Konfigurasi inti seperti koneksi database.php dan app.php (helper untuk fungsi keamanan dan session).
- /views: File re-usable untuk UI/HTML, terbagi menjadi layout admin, seller, dan buyer.
- /public: Entry point utama; semua file yang langsung dipanggil melalui browser (index.php, login.php, dll).
- /database: Menyimpan file database.sql untuk keperluan import.

---

## Instruksi Instalasi Lokal (XAMPP/Laragon)

1. Clone Repository
Buka terminal/CMD, lalu arahkan ke folder `htdocs` (jika memakai XAMPP):
```bash
cd C:\xampp\htdocs
git clone https://github.com/mohammadirham37/nama-repo-kamu.git apakekmonyet
```

2. Persiapan Database
- Pastikan Apache dan MySQL sudah berjalan.
- Akses `http://localhost/phpmyadmin`.
- Buat database baru (misalnya dengan nama `aksara_lokal`).
- Import file `database.sql` yang ada di dalam root folder project ini ke database yang barusan dibuat.

3. Konfigurasi
Buka file `/config/database.php`. Silakan sesuaikan username dan password database dengan environment lokal Anda. Default bawaan XAMPP biasanya menggunakan user `root` dan password kosong.

4. Menjalankan Aplikasi
Akses URL berikut di browser:
```text
http://localhost/apakekmonyet/public/
```

Beberapa akun testing lokal yang bisa langsung dipakai (password semua akun: password123):
- Admin: admin (admin@aksaralokal.id)
- Seller: seller_bali (wayan@aksaralokal.id)
- Buyer: buyer_andi (andi@email.com)

---

## Troubleshooting Tambahan
- Jika bukti pembayaran atau gambar produk gagal diunggah, pastikan folder /public/assets/uploads/ dan /public/assets/images/ sudah memiliki permission untuk di-write (read/write access). Di environment Linux/Mac, gunakan chmod -R 777.
- Jika grafik ASCII terlihat berantakan, pastikan Anda tidak menggunakan ekstensi browser yang merubah font text berjenis monospace.

---

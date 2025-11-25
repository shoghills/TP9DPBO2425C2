# TP9DPBO2425C2

Saya Rifa Muhammad Danindra dengan Nim 2405981 mengerjakan tugas praktikum 9 dalam mata kuliah Desain Pemrograman Berorientasi Objek untuk keberkahan-Nya maka saya tidak akan melakukan kecurangan seperti yang telah di spesifikasikan Aamiin.

Desain Program

      mvp_template/
      ├── models/
      │   ├── DB.php
      │   ├── EventBalapan.php
      │   ├── KontrakModel.php
      │   ├── Pembalap.php
      │   ├── TabelEventBalapan.php   
      │   └── TabelPembalap.php
      ├── presenters/
      │   ├── KontrakPresenter.php
      │   ├── PresenterEventBalapan.php
      │   └── PresenterPembalap.php
      ├── template/
      │   ├── form.html               
      │   └── skin.html               
      ├── views/
      │   ├── KontrakView.php
      │   ├── ViewEventBalapan.php
      │   └── ViewPembalap.php
      ├── index.php
      └── mvp_db.sql

🚦 Alur Program MVP (Model-View-Presenter)
Struktur MVP Anda memisahkan tiga tanggung jawab utama:

View (ViewPembalap.php, ViewEventBalapan.php): Bertanggung jawab atas antarmuka pengguna (UI) dan menerima input pengguna (misalnya, klik tombol).

Presenter (PresenterPembalap.php, PresenterEventBalapan.php): Berisi logika bisnis (aturan) dan bertindak sebagai perantara antara View dan Model.

Model (TabelPembalap.php, TabelEventBalapan.php): Bertanggung jawab penuh untuk interaksi dengan database melalui kelas DB.php.

1. Alur Utama (Routing)
Proses dimulai dari index.php, yang berfungsi sebagai Controller terpusat (meskipun ini adalah pola MVP, index.php mengatur View mana yang akan ditampilkan).

Inisialisasi (index.php): Semua View, Presenter, dan Model di-include dan diinisialisasi. Presenter diinisialisasi dengan instance View dan Model yang diperlukan (Dependency Injection).

Penentuan Screen (index.php): Script memeriksa parameter $_GET['screen'] (pembalap atau event).

Aksi POST/Redirect (index.php): Jika ada form submission ($_POST), script memprosesnya, memanggil Presenter yang sesuai, dan segera me-redirect (Header Location) kembali ke tampilan daftar untuk mencegah resubmission.

Tampilan GET (index.php): Jika tidak ada POST/Redirect, switch ($currentScreen) memanggil method render yang tepat dari View yang dipilih ($viewPembalap->tampilPembalap() atau $viewEventBalapan->renderDaftar()).

2. Alur Operasi CRUD (Contoh: Menambah Pembalap)
Setiap operasi CRUD mengikuti pola komunikasi bolak-balik yang ketat antara tiga lapisan.
  
    A. Alur READ 
    B. Alur CREATE 
    C. Alur UPDATE 
    D. Alur DELETE 

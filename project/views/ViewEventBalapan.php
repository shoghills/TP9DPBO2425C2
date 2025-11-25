<?php

// require_once('../presenters/PresenterEventBalapan.php');
require_once('presenters/PresenterEventBalapan.php');

class ViewEventBalapan {
    private $presenter;
    
    public function __construct() {
        // Karena Presenter membutuhkan View, kita harus inisialisasi Presenter di sini
        $this->presenter = new PresenterEventBalapan($this);
    }
    
    // RENDER 1: Menampilkan Daftar (Read All)
    // Dipanggil langsung oleh index.php saat screen=event & action=null
    public function renderDaftar() {
        $data_events = $this->presenter->tampilkanSemuaEvent();
        
        echo "<h2>Daftar Event Balapan</h2>";
        // LINK TAMBAH: Menggunakan parameter routing yang konsisten dengan index.php
        echo '<a href="index.php?screen=event&action=add">Tambah Event Baru</a><br><br>';
        
        echo "<table>";
        echo "<tr><th>Nama Event</th><th>Mulai</th><th>Selesai</th><th>Lokasi</th><th>Aksi</th></tr>";
        foreach ($data_events as $event) {
            echo "<tr>";
            echo "<td>{$event['nama_event']}</td>";
            echo "<td>{$event['tanggal_mulai']}</td>";
            echo "<td>{$event['tanggal_selesai']}</td>";
            echo "<td>{$event['lokasi']}</td>";
            // Aksi menggunakan parameter routing yang konsisten: screen=event
            echo "<td>
                    <a href='index.php?screen=event&action=edit&id={$event['id']}'>Edit</a> | 
                    <a href='index.php?screen=event&action=delete&id={$event['id']}'>Hapus</a>
                  </td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    // RENDER 2: Menampilkan Form (Create/Update)
    // Dipanggil langsung oleh index.php saat action=add atau action=edit
    public function renderForm($action, $id = null) {
        $data = false;
        
        // Jika mode edit, ambil data dari Presenter
        if ($action === 'edit' && $id !== null) {
            $data = $this->presenter->getEventUntukEdit($id);
            if (!$data) {
                $this->tampilkanPesanError("Data Event tidak ditemukan.");
                return;
            }
        }
        
        $is_update = is_array($data);
        $judul = $is_update ? 'Ubah Event Balapan' : 'Tambah Event Balapan';
        
        // ACTION URL: POST akan dikirim kembali ke index.php
        // Tambahkan hidden field 'mode' untuk Presenter
        $action_url = "index.php"; 
        
        echo "<h2>$judul</h2>";
        echo "<form method='POST' action='$action_url'>";
        
        // --- HIDDEN FIELDS UNTUK ROUTING ---
        echo "<input type='hidden' name='mode' value='event'>"; // Penting untuk Presenter
        echo "<input type='hidden' name='action' value='". ($is_update ? 'edit' : 'add') ."'>";
        if ($is_update) {
            echo "<input type='hidden' name='id' value='{$data['id']}'>";
        }
        
        // --- INPUT FIELDS ---
        $nama_event = $is_update ? $data['nama_event'] : '';
        $tanggal_mulai = $is_update ? $data['tanggal_mulai'] : '';
        $tanggal_selesai = $is_update ? $data['tanggal_selesai'] : '';
        $lokasi = $is_update ? $data['lokasi'] : '';

        echo "Nama Event: <input type='text' name='nama_event' value='$nama_event' required><br>";
        echo "Tgl Mulai: <input type='date' name='tanggal_mulai' value='$tanggal_mulai' required><br>";
        echo "Tgl Selesai: <input type='date' name='tanggal_selesai' value='$tanggal_selesai'><br>";
        echo "Lokasi: <input type='text' name='lokasi' value='$lokasi'><br>";
        
        echo "<button type='submit'>Simpan</button>";
        echo "</form>";
        echo '<a href="index.php?screen=event">Batal</a>';
    }
    
    // Method Helper (tampilPesanSukses/Error tetap dipertahankan)
    public function tampilkanPesanSukses($pesan) {
        echo "<p style='color: green;'>Sukses: $pesan</p>";
    }
    
    public function tampilkanPesanError($pesan) {
        echo "<p style='color: red;'>Error: $pesan</p>";
    }

   
}
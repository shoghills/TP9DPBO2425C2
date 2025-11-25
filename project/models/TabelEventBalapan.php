<?php

include_once ("DB.php");
// Asumsikan Anda memiliki KontrakModel untuk konsistensi, atau buat KontrakEventBalapan.php
// include_once ("KontrakModel.php"); 

class TabelEventBalapan extends DB { // Jika Anda tidak punya KontrakModel umum, warisi langsung dari DB

    private $tabel = 'event_balapan';

    // Constructor untuk inisialisasi database
    public function __construct($host, $db_name, $username, $password) {
        parent::__construct($host, $db_name, $username, $password);
    }

    // Method untuk mendapatkan semua event balapan (R - Read All)
    public function getAllEvent(): array {
        $query = "SELECT * FROM " . $this->tabel . " ORDER BY tanggal_mulai DESC";
        $this->executeQuery($query);
        return $this->getAllResult();
    }

    // Method untuk mendapatkan event balapan berdasarkan ID (R - Read Single)
    public function getEventById($id): ?array {
        $query = "SELECT * FROM " . $this->tabel . " WHERE id = ?";
        $this->executeQuery($query, [$id]);
        $result = $this->getAllResult();
        // Mengembalikan baris pertama atau null jika tidak ditemukan
        return $result[0] ?? null; 
    }

    // Method untuk menambah event balapan (C - Create)
    public function addEvent($nama_event, $tanggal_mulai, $tanggal_selesai, $lokasi): void {
        $query = "INSERT INTO " . $this->tabel . " (nama_event, tanggal_mulai, tanggal_selesai, lokasi) VALUES (?, ?, ?, ?)";
        
        // Eksekusi query INSERT dengan prepared statement
        $this->executeQuery($query, [$nama_event, $tanggal_mulai, $tanggal_selesai, $lokasi]);
    }
    
    // Method untuk mengubah event balapan (U - Update)
    public function updateEvent($id, $nama_event, $tanggal_mulai, $tanggal_selesai, $lokasi): void {
        $query = "UPDATE " . $this->tabel . " SET nama_event = ?, tanggal_mulai = ?, tanggal_selesai = ?, lokasi = ? WHERE id = ?";
        
        // Eksekusi query UPDATE dengan prepared statement
        $this->executeQuery($query, [$nama_event, $tanggal_mulai, $tanggal_selesai, $lokasi, $id]);
    }
    
    // Method untuk menghapus event balapan (D - Delete)
    public function deleteEvent($id): void {
        $query = "DELETE FROM " . $this->tabel . " WHERE id = ?";
        
        // Eksekusi query DELETE dengan prepared statement
        $this->executeQuery($query, [$id]);
    }

}
// Catatan: Jika Anda menggunakan KontrakModel, tambahkan 'implements KontrakModel' setelah extends DB.
?>
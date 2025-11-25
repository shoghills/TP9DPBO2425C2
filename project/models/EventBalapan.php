<?php

require_once('DB.php');

class EventBalapan extends DB {
    
    private $tabel = 'event_balapan';

    public function __construct($db_host, $db_name, $db_user, $db_pass) {
        parent::__construct($db_host, $db_name, $db_user, $db_pass);
    }

    // R - Read All: Mengambil semua data event balapan
    public function getAllEvent() {
        $query = "SELECT * FROM " . $this->tabel . " ORDER BY tanggal_mulai DESC";
        // Perbaikan: Gunakan executeQuery tanpa parameter binding
        $this->executeQuery($query); 
        return $this->getAllResult(); 
    }

    // R - Read Single: Mengambil satu event berdasarkan ID
    public function getEventById($id_event) {
        $query = "SELECT * FROM " . $this->tabel . " WHERE id = ?";
        $params = [$id_event];
        // Perbaikan: Gunakan executeQuery dengan parameter binding
        $this->executeQuery($query, $params);
        
        // Asumsi DB.php belum punya getSingleResult, kita ambil semua lalu ambil elemen pertama
        $result = $this->getAllResult();
        return count($result) > 0 ? $result[0] : null; 
    }

    // C - Create: Menambah event balapan baru
    public function createEvent($data) {
        $query = "INSERT INTO " . $this->tabel . " (nama_event, tanggal_mulai, tanggal_selesai, lokasi) VALUES (?, ?, ?, ?)";
        $params = [
            $data['nama_event'], 
            $data['tanggal_mulai'], 
            $data['tanggal_selesai'], 
            $data['lokasi']
        ];
        
        // Perbaikan: Gunakan executeQuery dengan parameter binding
        return $this->executeQuery($query, $params);
    }
    
    // U - Update: Mengubah data event balapan
    public function updateEvent($id_event, $data) {
        $query = "UPDATE " . $this->tabel . " SET nama_event = ?, tanggal_mulai = ?, tanggal_selesai = ?, lokasi = ? WHERE id = ?";
        $params = [
            $data['nama_event'], 
            $data['tanggal_mulai'], 
            $data['tanggal_selesai'], 
            $data['lokasi'],
            $id_event
        ];
        
        // Perbaikan: Gunakan executeQuery dengan parameter binding
        return $this->executeQuery($query, $params);
    }

    // D - Delete: Menghapus event balapan
    public function deleteEvent($id_event) {
        $query = "DELETE FROM " . $this->tabel . " WHERE id = ?";
        $params = [$id_event];
        
        // Perbaikan: Gunakan executeQuery dengan parameter array, dan kembalikan hasilnya (true/false dari executeQuery)
        // Note: executeQuery harus mengembalikan nilai boolean atau PDOStatement
        return $this->executeQuery($query, $params); 
    }
}
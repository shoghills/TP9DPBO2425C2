<?php

// require_once('../models/EventBalapan.php');
require_once('models/EventBalapan.php');

class PresenterEventBalapan {
    private $model;
    private $view; 

    // Konstruktor: Menerima View dan inisialisasi Model
    public function __construct($view) {
        $this->model = new EventBalapan('localhost', 'mvp_db', 'root', ''); // <-- Pastikan ini ada!
        $this->view = $view; // View (misalnya ViewEventBalapan)
    }

    // R - Read All: Menampilkan semua event (Dipanggil View saat load halaman)
    public function tampilkanSemuaEvent() {
        return $this->model->getAllEvent();
    }

    // R - Read Single: Mengambil data event untuk form EDIT
    public function getEventUntukEdit($id_event) {
        return $this->model->getEventById($id_event);
    }
    
    // C - Create: Memproses penambahan event baru
    public function prosesTambahEvent($data_input) {
        // --- Contoh Validasi di Presenter ---
        if (empty($data_input['nama_event']) || empty($data_input['tanggal_mulai'])) {
            // $this->view->tampilkanPesanError("Nama event dan tanggal mulai wajib diisi.");
            return false;
        }

        $sukses = $this->model->createEvent($data_input);
        
        if ($sukses) {
            // $this->view->tampilkanPesanSukses("Event Balapan baru berhasil ditambahkan.");
        } 
        return $sukses;
    }
    
    // U - Update: Memproses perubahan data event
    public function prosesUbahEvent($id_event, $data_input) {
        // --- Contoh Validasi di Presenter ---
        if (empty($data_input['nama_event']) || empty($data_input['tanggal_mulai'])) {
            // $this->view->tampilkanPesanError("Nama event dan tanggal mulai wajib diisi.");
            return false;
        }

        $sukses = $this->model->updateEvent($id_event, $data_input);
        
        if ($sukses) {
            // $this->view->tampilkanPesanSukses("Event Balapan berhasil diubah.");
        }
        return $sukses;
    }

    // D - Delete: Memproses penghapusan event
    public function prosesHapusEvent($id_event) {
        $sukses = $this->model->deleteEvent($id_event);
        
        if ($sukses) {
            // $this->view->tampilkanPesanSukses("Event Balapan berhasil dihapus.");
        }
        return $sukses;
    }
}
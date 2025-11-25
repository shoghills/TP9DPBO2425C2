<?php

include_once ("models/DB.php");
include_once ("KontrakModel.php");

class TabelPembalap extends DB implements KontrakModel {

    // Konstruktor untuk inisialisasi database
    public function __construct($host, $db_name, $username, $password) {
        parent::__construct($host, $db_name, $username, $password);
    }

    // Method untuk mendapatkan semua pembalap
    public function getAllPembalap(): array {
        $query = "SELECT * FROM pembalap";
        $this->executeQuery($query);
        return $this->getAllResult();
    }

    // Method untuk mendapatkan pembalap berdasarkan ID
    public function getPembalapById($id): ?array {
        $this->executeQuery("SELECT * FROM pembalap WHERE id = ?", [$id]);
        $result = $this->getAllResult();
        return $result[0] ?? null;
    }

    // implementasikan metode CRUD di bawah ini sesuai kebutuhan

    public function addPembalap($nama, $tim, $negara, $poinMusim, $jumlahMenang): void {
        $query = "INSERT INTO pembalap (nama, tim, negara, poinMusim, jumlahMenang) VALUES (?, ?, ?, ?, ?)";
        
        // Eksekusi query INSERT dengan prepared statement
        $this->executeQuery($query, [$nama, $tim, $negara, $poinMusim, $jumlahMenang]);
    }
    
    public function updatePembalap($id, $nama, $tim, $negara, $poinMusim, $jumlahMenang): void {
        $query = "UPDATE pembalap SET nama = ?, tim = ?, negara = ?, poinMusim = ?, jumlahMenang = ? WHERE id = ?";
        
        // Eksekusi query UPDATE dengan prepared statement
        $this->executeQuery($query, [$nama, $tim, $negara, $poinMusim, $jumlahMenang, $id]);
    }
    
    public function deletePembalap($id): void {
        $query = "DELETE FROM pembalap WHERE id = ?";
        
        // Eksekusi query DELETE dengan prepared statement
        $this->executeQuery($query, [$id]);
    }

}

?>
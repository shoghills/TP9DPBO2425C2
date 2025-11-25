<?php
ob_start();

// INKLUSI PEMBALAP (LAMA)
include_once("models/DB.php");
include("models/TabelPembalap.php");
include("views/ViewPembalap.php");
include("presenters/PresenterPembalap.php");

// INKLUSI EVENT BALAPAN (BARU)
include("models/EventBalapan.php");
include("views/ViewEventBalapan.php");
// include("presenters/PresenterEventBalapan.php"); // Biarkan ini terkomentar

// 1. Inisialisasi Model, View, dan Presenter
// Sesuaikan parameter koneksi database Anda di sini
$db_host = 'localhost';
$db_name = 'mvp_db';
$db_user = 'root';
$db_pass = '';

// INISIALISASI PEMBALAP
$tabelPembalap = new TabelPembalap($db_host, $db_name, $db_user, $db_pass);
$viewPembalap = new ViewPembalap();
$presenterPembalap = new PresenterPembalap($tabelPembalap, $viewPembalap); // Ubah $presenter menjadi $presenterPembalap

// INISIALISASI EVENT BALAPAN (BARU)
$eventBalapanModel = new EventBalapan($db_host, $db_name, $db_user, $db_pass); 
$viewEventBalapan = new ViewEventBalapan();
// Pastikan PresenterEventBalapan.php telah diubah untuk menerima $eventBalapanModel
$presenterEventBalapan = new PresenterEventBalapan($viewEventBalapan, $eventBalapanModel);

// --- Penentuan Tampilan Utama (Screen) ---
$currentScreen = $_GET['screen'] ?? 'pembalap'; // Default ke 'pembalap'
$action = $_GET['action'] ?? null;
$id = $_GET['id'] ?? null;

// --- Penanganan Aksi CRUD (POST & GET) ---

// 2. Penanganan POST (ADD/EDIT)
if(isset($_POST['action'])){
    $aksi = $_POST['action'];
    $mode = $_POST['mode'] ?? 'pembalap'; // Tambahkan mode untuk menentukan Presenter mana yang dipanggil
    $id_data = $_POST['id'] ?? null;
    
    // Panggil Presenter yang sesuai
    if ($mode == 'pembalap') {
        // Logika POST Pembalap (HARUS ADA SEKARANG)
        
        // Ambil data dari POST
        $nama = $_POST['nama'] ?? '';
        $tim = $_POST['tim'] ?? '';
        $negara = $_POST['negara'] ?? '';
        $poinMusim = (int)($_POST['poinMusim'] ?? 0); 
        $jumlahMenang = (int)($_POST['jumlahMenang'] ?? 0);
        $id_pembalap = $_POST['id'] ?? null; // ID diperlukan untuk EDIT

        if ($aksi == 'add') {
            $presenterPembalap->tambahPembalap($nama, $tim, $negara, $poinMusim, $jumlahMenang);

        } else if ($aksi == 'edit' && $id_pembalap !== null) {
            $presenterPembalap->ubahPembalap($id_pembalap, $nama, $tim, $negara, $poinMusim, $jumlahMenang);
        }

    } else if ($mode == 'event') {
        $data_event = [
            'nama_event' => $_POST['nama_event'] ?? '',
            'tanggal_mulai' => $_POST['tanggal_mulai'] ?? '',
            'tanggal_selesai' => $_POST['tanggal_selesai'] ?? '',
            'lokasi' => $_POST['lokasi'] ?? ''
        ];
        
        if ($aksi == 'add') {
            $presenterEventBalapan->prosesTambahEvent($data_event);
        } else if ($aksi == 'edit' && $id_data !== null) {
            $presenterEventBalapan->prosesUbahEvent($id_data, $data_event);
        }
    }
    
    // Redirect kembali ke daftar utama yang sesuai
    header("Location: index.php?screen=$mode");
    exit();
} 

// Tambahkan Navigasi di sini
?>
<div style="margin-bottom: 20px; border-bottom: 1px solid #ccc; padding-bottom: 10px;">
    <a href="index.php?screen=pembalap">Daftar Pembalap</a> | 
    <a href="index.php?screen=event">Daftar Event Balapan</a>
</div>
<?php
ob_end_flush();

// 3. Penanganan GET (DELETE, Form ADD/EDIT, Tampil Daftar)

    switch ($currentScreen) {
        // KASUS 1: CRUD PEMBALAP
        case 'pembalap':
            if ($action == 'delete' && $id) {
                $presenterPembalap->hapusPembalap($id);
                header("Location: index.php?screen=pembalap");
                exit();
            } else if ($action == 'add' || ($action == 'edit' && $id)) {
                // Tampilkan form ADD/EDIT Pembalap
                $formHtml = $presenterPembalap->tampilkanFormPembalap($action == 'edit' ? $id : null);
                echo $formHtml;
            } else {
                // Tampilkan Daftar Utama Pembalap
                $html = $presenterPembalap->tampilkanPembalap();
                echo $html;
            }
            break;

        // KASUS 2: CRUD EVENT BALAPAN (BARU)
        case 'event':
            if ($action == 'delete' && $id) {
                $presenterEventBalapan->prosesHapusEvent($id);
                header("Location: index.php?screen=event");
                exit();
            } else if ($action == 'add' || ($action == 'edit' && $id)) {
                // Tampilkan form ADD/EDIT Event Balapan
                $viewEventBalapan->renderForm($action, $id);
            } else {
                // Tampilkan Daftar Utama Event Balapan
                $viewEventBalapan->renderDaftar();
            }
            break;

        default:
            // Tampilan default jika 'screen' tidak valid
            $html = $presenterPembalap->tampilkanPembalap();
            echo $html;
            break;
    }


?>

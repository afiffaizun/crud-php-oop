<?php
class Bayi
{
    private $id;
    private $nama;
    private $tinggi;
    private $berat;
    private $jenisKelamin;
    private $tanggalLahir;
    private $riwayat;
    private $catatan;

    private $user_id;

    private const TABLE = 'databayi';
    private $conn;

    public function __construct()
    {
        require_once dirname(__DIR__) . '/config/database.php';
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    
    // Ambil semua data bayi
    public function tampil_data()
    {
        // Menampilkan semua data bayi tanpa filter user_id
        $query = "SELECT * FROM " . self::TABLE . " ORDER BY id DESC";
        $result = $this->conn->query($query);
        $data = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }

    // Ambil data bayi berdasarkan ID
    public function getBayiById($id)
    {
        if (!isset($_SESSION)) session_start();
        $query = "SELECT * FROM " . self::TABLE . " WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result ? $result->fetch_assoc() : null;
    }

    // Tambah data bayi
    public function tambah()
    {
        if (empty($this->nama) || empty($this->jenisKelamin)) return false;
        if (!isset($_SESSION)) session_start();
        $user_id = $_SESSION['user_id'] ?? null;
        if (!$user_id) return false;
        $query = "INSERT INTO " . self::TABLE . " (nama, tinggi, berat, jenisKelamin, tanggalLahir, riwayat, catatan, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sddssssi", $this->nama, $this->tinggi, $this->berat, $this->jenisKelamin, $this->tanggalLahir, $this->riwayat, $this->catatan, $user_id);
        return $stmt->execute();
    }

    // Update data bayi
    public function update($id)
    {
        if (empty($this->nama) || empty($this->jenisKelamin)) return false;
        $query = "UPDATE " . self::TABLE . " SET nama=?, tinggi=?, berat=?, jenisKelamin=?, tanggalLahir=?, riwayat=?, catatan=? WHERE id=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sddssssi", $this->nama, $this->tinggi, $this->berat, $this->jenisKelamin, $this->tanggalLahir, $this->riwayat, $this->catatan, $id);
        return $stmt->execute();
    }

    // Hapus data bayi
    public function hapus($id)
    {
        $query = "DELETE FROM " . self::TABLE . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Cari data bayi berdasarkan nama
    public function search($keyword)
    {
        $keyword = "%{$keyword}%";
        $query = "SELECT * FROM " . self::TABLE . " WHERE nama LIKE ? ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $keyword);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }

    // Getter & Setter
    public function getId() { return $this->id; }
    public function setId($id) { $this->id = (int)$id; }
    public function getNama() { return $this->nama; }
    public function setNama($nama) { $this->nama = $nama; }
    public function getTinggi() { return $this->tinggi; }
    public function setTinggi($tinggi) { $this->tinggi = (float)$tinggi; }
    public function getBerat() { return $this->berat; }
    public function setBerat($berat) { $this->berat = (float)$berat; }
    public function getJenisKelamin() { return $this->jenisKelamin; }
    public function setJenisKelamin($jenisKelamin) { $this->jenisKelamin = $jenisKelamin; }
    public function getTanggalLahir() { return $this->tanggalLahir; }
    public function setTanggalLahir($tanggalLahir) { $this->tanggalLahir = $tanggalLahir; }
    public function getRiwayat() { return $this->riwayat; }
    public function setRiwayat($riwayat) { $this->riwayat = $riwayat; }
    public function getCatatan() { return $this->catatan; }
    public function setCatatan($catatan) { $this->catatan = $catatan; }

    public function getUserId() { return $this->user_id; }
    public function setUserId($user_id) { $this->user_id = (int)$user_id; }
}




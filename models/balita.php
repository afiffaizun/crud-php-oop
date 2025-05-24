<?php
/**
 * Class induk Model untuk koneksi database
 */
class Model
{
    protected $conn;
    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }
}

/**
 * Model sederhana untuk mengelola data bayi/balita
 */
class Bayi extends Model
{
    private $id;
    private $nama;
    private $tinggi;
    private $berat;
    private $jenisKelamin;
    private $tanggalLahir;
    private $riwayat;
    private $catatan;
    
    private const TABLE = 'databayi';

    // Ambil semua data bayi
    public function tampil_data()
    {
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
        $query = "INSERT INTO " . self::TABLE . " (nama, tinggi, berat, jenisKelamin, tanggalLahir, riwayat, catatan) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sddssss", $this->nama, $this->tinggi, $this->berat, $this->jenisKelamin, $this->tanggalLahir, $this->riwayat, $this->catatan);
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
   
}




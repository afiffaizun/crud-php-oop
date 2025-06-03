<?php
require_once 'manusia.php';

class Bayi extends Manusia
{
    private $tinggi;
    private $berat;
    private $tanggalLahir;
    private $orangTuaId;  
    private $riwayat;
    private $catatan;
    private const TABLE = 'databayi';


    // Tambah data bayi
    public function tambah()
    {
        $query = "INSERT INTO " . self::TABLE . " (nama, jenisKelamin, tinggi, berat, tanggalLahir, riwayat, catatan, orang_tua_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        $nama = $this->getNama();
        $jenisKelamin = $this->getJenisKelamin();

        $stmt->bind_param(
            "ssddsssi",
            $nama,
            $jenisKelamin,
            $this->tinggi,
            $this->berat,
            $this->tanggalLahir,
            $this->riwayat,
            $this->catatan,
            $this->orangTuaId
        );
        return $stmt->execute();
    }

    // Update data bayi
    public function update($id)
    {
        $query = "UPDATE " . self::TABLE . " SET nama=?, jenisKelamin=?, tinggi=?, berat=?, tanggalLahir=?, riwayat=?, catatan=?, orang_tua_id=? WHERE id=?";
        $stmt = $this->conn->prepare($query);

        // Use getter methods instead of direct property access
        $nama = $this->getNama();
        $jenisKelamin = $this->getJenisKelamin();

        $stmt->bind_param(
            "ssddsssii",
            $nama,
            $jenisKelamin,
            $this->tinggi,
            $this->berat,
            $this->tanggalLahir,
            $this->riwayat,
            $this->catatan,
            $this->orangTuaId,
            $id
        );
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
        $query = "SELECT * FROM " . self::TABLE . " WHERE nama LIKE ? ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $like = "%" . $keyword . "%";
        $stmt->bind_param("s", $like);
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

    // Add missing method
    public function getBayiById($id)
    {
        $query = "SELECT * FROM " . self::TABLE . " WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            error_log("Database error in getBayiById: " . $this->conn->error);
            return null;
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }

        return null;
    }

    // Add missing method
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

    public function setTinggi($tinggi)
    {
        $this->tinggi = (float) $tinggi;
    }
   
    public function setBerat($berat)
    {
        $this->berat = (float) $berat;
    }
    
    public function setTanggalLahir($tanggalLahir)
    {
        $this->tanggalLahir = $tanggalLahir;
    }
    
    public function setRiwayat($riwayat)
    {
        $this->riwayat = $riwayat;
    }
    
    public function setCatatan($catatan)
    {
        $this->catatan = $catatan;
    }
    
    public function setOrangTuaId($orangTuaId)
    {
        $this->orangTuaId = (int) $orangTuaId;
    }
}




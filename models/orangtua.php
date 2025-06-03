<?php
require_once 'manusia.php';

class OrangTua extends Manusia
{
    private $alamat;
    private $telepon;
    private const TABLE = 'orangtua';

    public function tambah_ortu()
    {
        $query = "INSERT INTO " . self::TABLE . " (nama, jenisKelamin, alamat, telepon) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $nama = $this->getNama();
        $jenisKelamin = $this->getJenisKelamin();
        $alamat = $this->getAlamat();
        $telepon = $this->getTelepon();
        $stmt->bind_param(
            "ssss",
            $nama,
            $jenisKelamin,
            $alamat,
            $telepon
        );
        return $stmt->execute();
    }

    public function tampil_orangtua()
    {
        $query = "SELECT * FROM " . self::TABLE . " ORDER BY orangtua_id DESC";
        $result = $this->conn->query($query);
        $data = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function tampil_orangtua_with_id($id)
    {
        $query = "SELECT * FROM " . self::TABLE . " WHERE orangtua_id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc(); // Return single row instead of array
        }

        return null;
    }

    public function setAlamat($alamat)
    {
        $this->alamat = $alamat;
    }

    public function getAlamat()
    {
        return $this->alamat;
    }

    public function setTelepon($telepon)
    {
        $this->telepon = $telepon;
    }

    public function getTelepon()
    {
        return $this->telepon;
    }
}

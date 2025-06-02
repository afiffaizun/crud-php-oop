<?php
require_once dirname(__DIR__) . '/config/database.php';

class Manusia
{
    protected $conn;
    protected $nama;       
    protected $jenisKelamin; 

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function setNama($nama)
    {
        $this->nama = $nama;
    }

    public function getNama()
    {
        return $this->nama;
    }

    public function setJenisKelamin($jenisKelamin)
    {
        $this->jenisKelamin = $jenisKelamin;
    }

    public function getJenisKelamin()
    {
        return $this->jenisKelamin;
    }
}
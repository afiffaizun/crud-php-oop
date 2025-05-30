<?php
class Database {
    private $host = "localhost:3307";
    private $db_name = "db_databayi";
    private $username = "root";
    private $password = "";
    public $conn;

    public function __construct() {}

    public function getConnection() {
        if ($this->conn === null) {
            try {
                $this->conn = new mysqli(
                    $this->host,
                    $this->username,
                    $this->password,
                    $this->db_name
                );
                if ($this->conn->connect_error) {
                    die("Koneksi gagal: " . $this->conn->connect_error);
                }
            } catch (Exception $exception) {
                die("Koneksi gagal: " . $exception->getMessage());
            }
        }
        return $this->conn;
    }
}
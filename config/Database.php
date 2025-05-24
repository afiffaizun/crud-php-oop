<?php
/**
 * Kelas Database untuk menangani koneksi database
 */
class Database
{
    // Properties database
    private $host = "localhost:3307";
    private $user = "root";
    private $pass = "";
    private $dbname = "db_databayi";

    // Property untuk koneksi
    private $conn;
    private static $instance = null;

    /**
     * Constructor dengan koneksi database
     */
    private function __construct()
    {
        try {
            $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);

            if ($this->conn->connect_error) {
                throw new Exception("Koneksi database gagal: " . $this->conn->connect_error);
            }

            // Set karakter encoding
            $this->conn->set_charset("utf8mb4");
        } catch (Exception $e) {
            die("Error koneksi database: " . $e->getMessage());
        }
    }

    /**
     * Mendapatkan instance database (Singleton pattern)
     * @return Database
     */
    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Mendapatkan koneksi database
     * @return mysqli
     */
    public function getConnection(): mysqli
    {
        return $this->conn;
    }
}
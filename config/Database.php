<?php
class Database
{
    private $host = "localhost:3307";
    private $db_name = "db_databayi";
    private $username = "root";
    private $password = "";
    private static $conn = null;


    public function getConnection()
    {
        if (self::$conn === null) {
            try {
                self::$conn = new mysqli(
                    $this->host,
                    $this->username,
                    $this->password,
                    $this->db_name
                );

                // Set character set to UTF-8
                self::$conn->set_charset("utf8");

                if (self::$conn->connect_error) {
                    throw new Exception("Koneksi gagal: " . self::$conn->connect_error);
                }
            } catch (Exception $exception) {
                die("Koneksi gagal: " . $exception->getMessage());
            }
        }
        return self::$conn;
    }
}
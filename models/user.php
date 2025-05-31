<?php

class Model
{
    protected $conn;
    public function __construct()
    {
        require_once dirname(__DIR__) . '/config/database.php';
        $db = new Database();
        $this->conn = $db->getConnection();
    }
}

class Pengguna extends Model
{
    private $username;
    private $password;
    const TABLE = 'pengguna'; // Ganti 'users' sesuai nama tabel user Anda

    public function login($username, $password)
    {
        $this->username = $username;
        $this->password = $password;

        $query = "SELECT * FROM " . self::TABLE . " WHERE username = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $this->username);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            if ($this->password === $row['password']) {
                // Set data session, gunakan user_id sebagai primary key
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['username'] = $row['username'];
                return true;
            }
        }

        return false;
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = array();
        session_destroy();
    }
}
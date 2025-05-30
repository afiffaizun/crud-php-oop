<?php

// Class induk untuk koneksi database
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

    // Tidak perlu constructor, gunakan milik BaseModel

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
            // Periksa password (di masa depan, gunakan password_hash dan password_verify)
            if ($this->password === $row['password']) {
                // Set data session
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                return true;
            }
        }

        return false;
    }

    public function logout()
    {
        // Pastikan session sudah dimulai sebelum mengakses/mengubah $_SESSION
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = array();
        session_destroy();
    }
}
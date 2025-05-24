<?php
class Pengguna
{
    private $username;
    private $password;
    private $conn;
    const TABLE = 'pengguna'; // Ganti 'users' sesuai nama tabel user Anda

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }

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
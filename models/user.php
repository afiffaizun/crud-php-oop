<?php

class Pengguna
{
    private $conn;
    private $username;
    private $password;
    const TABLE = 'pengguna';

    public function __construct()
    {
        require_once dirname(__DIR__) . '/config/database.php';
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function login($username, $password)
    {
        // Sanitize input
        $this->username = $this->conn->real_escape_string($username);
        $this->password = $password; // Consider using password_hash/password_verify

        $query = "SELECT * FROM " . self::TABLE . " WHERE username = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $this->username);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            // In a production environment, use password_verify instead of direct comparison
            if ($this->password === $row['password']) {
                // Set session data, use user_id as primary key
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
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

        // Return true to indicate successful logout
        return true;
    }
}
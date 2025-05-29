<?php
// filepath: c:\xampp\htdocs\webbayi\models\Model.php
require_once dirname(__DIR__) . '/config/Database.php';

class Model
{
    protected $conn;

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }
}
 
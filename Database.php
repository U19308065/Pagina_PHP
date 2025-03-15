<!-- filepath: c:\xampp\htdocs\xampp\Pagina PHP\Database.php -->
<?php
class Database {
    private $host = "sql10.freesqldatabase.com";
    private $user = "sql10765427";
    private $password = "QhG3L9eLZF";
    private $dbname = "sql10765427";
    private $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die("Conexión fallida: " . $this->conn->connect_error);
        }
    }

    public function getConnection() {
        return $this->conn;
    }

    public function closeConnection() {
        $this->conn->close();
    }
}
?>
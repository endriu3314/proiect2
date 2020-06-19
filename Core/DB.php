<?php
class DB
{
    private $host = '127.0.0.1';
    private $dbname = 'proiect2';
    private $username = 'root';
    private $password = '';
    private $charset = 'uft8mb4';
    private $collate = 'uft8mb4_unicode_ci';

    public $db;
    
    public function __construct()
    {
        $dsn = 'mysql: host=' . $this->host . ';dbname=' . $this->dbname;
        $opt = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_EMULATE_PREPARES => true,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );

        try {
            $this->db = new PDO($dsn, $this->username, $this->password, $opt);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
            exit;
        }
    }

    public function __destruct()
    {
        $this->db = null;
    }
}

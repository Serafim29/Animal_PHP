<?php 

class Database {
    private $pdo;
    public function __construct(){
        $this->pdo = new PDO("mysql:host=localhost;dbname=Animal", "root", "root");
    }
    public function getPDO(){
        try {
            $this->pdo = new PDO("mysql:host=localhost;dbname=Animal", "root", "root");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->pdo;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}



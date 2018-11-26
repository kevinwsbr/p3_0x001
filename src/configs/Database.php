<?php

class Database {
    public $db;
    private $data = array(
        'server'=>'localhost',
        'database'=>'iResearcher',
        'user'=>'root',
        'password'=>'root',
    );

    public function __construct()
    {
        $this->getInstance();
    }

    public function getInstance() {
        try {
            $this->db = new PDO('mysql:host=localhost;dbname=iResearcher', 'root','root');
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function protectPage()
    {
        session_start();
        if (empty($_SESSION["user"])) {
            $_SESSION["url"]=$_SERVER['REQUEST_URI'];
            header('Location: login.php');
        }
    }
}

?>
<?php

class Database {

    private $db;

    public function __construct()
    {
        try {
            $this->db = new PDO('mysql:host=localhost;dbname=iresearcher', 'root','root', array(
                PDO::ATTR_PERSISTENT => true
            ));
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo 'Ops, um erro foi encontrado: ' . $e->getMessage();
        }
    }

    public function getInstance() {
        return $this->db;
    }
}

<?php

class Utils {

    public function __construct()
    {

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
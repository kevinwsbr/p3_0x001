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

    public function salt()
    {
        $string = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ0123456789';
        $salt = '';
        for ($i = 1; $i <= 22; $i++) {
            $rand = mt_rand(1, strlen($string));
            $salt .= $string[$rand-1];
        }
        return $salt;
    }

    public function hash($password)
    {
        return crypt($password, '$2a$10$' . $this->salt() . '$');
    }
}
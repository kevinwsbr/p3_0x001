<?php

class User {
    protected $ID;
    protected $name;
    protected $username;
    protected $email;
    protected $password;
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getUser($user) {
        $sql='SELECT * FROM `users` WHERE `users`.`username` = :user ;';

        $db=$this->db->prepare($sql);
        $db->bindValue(':user', $user,PDO::PARAM_STR);
        $db->execute();

        return $db->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getUsers() {
        $sql='SELECT `name`, `email`, `username` FROM `users`;';

        $db=$this->db->prepare($sql);
        $db->execute();

        return $db->fetchAll(PDO::FETCH_ASSOC);
    }

    public function setData($user) {
        $this->ID = $user['ID'];
        $this->name = $user['name'];
        $this->username = $user['username'];
        $this->email = $user['email'];
        $this->password = $user['password'];
    }

    public function updateData() {
        if ($_SERVER['REQUEST_METHOD']=='POST') {
            $sql='UPDATE `users` SET `name` = :name, `username` = :user, `email` = :email WHERE `users`.`username` = :user;';
            
            $db=$this->db->prepare($sql);
            
            $db->bindValue(':name', $_POST['name'],PDO::PARAM_STR);
            //$db->bindValue(':username', $_POST['username'],PDO::PARAM_STR);
            $db->bindValue(':email', $_POST['email'],PDO::PARAM_STR);
            $db->bindValue(':user', $_POST['username'],PDO::PARAM_STR);

            $db->execute();
            header('Location: settings.php');
        }
    }

    public function getName() {
        return $this->name;
    }

    public function getID() {
        return $this->ID;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getUsername() {
        return $this->username;
    }

    public function sendMessage($user)
    {
        if ($_SERVER['REQUEST_METHOD']=='POST') {
            $sql='INSERT INTO `users_messages` (`idsender`,`idreceiver`,`content`) VALUES (:idsender,:idreceiver,:content);';
            
            $db=$this->db->prepare($sql);
            $db->bindValue(':idsender', $_SESSION['user']['username'],PDO::PARAM_STR);
            $db->bindValue(':idreceiver', $user,PDO::PARAM_STR);
            $db->bindValue(':content', $_POST['message'],PDO::PARAM_STR);
            
            $db->execute();
            header('Location: index.php');
        }
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD']=='POST') {
            $sql='INSERT INTO `users` (`name`,`username`,`email`,`password`) VALUES (:name,:username,:email,:password);';
            
            $db=$this->db->prepare($sql);
            $db->bindValue(':name', $_POST['name'],PDO::PARAM_STR);
            $db->bindValue(':username', $_POST['username'],PDO::PARAM_STR);
            $db->bindValue(':email', $_POST['email'],PDO::PARAM_STR);
            $db->bindValue(':password', $this->hash($_POST['password']),PDO::PARAM_STR);
            
            $db->execute();
            header('Location: index.php');
        }
    }

    public function login()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD']=='POST') {
            $user=$this->getUser($_POST['username']);

            if (crypt($_POST['password'], $user['password']) === $user['password']) {
                $_SESSION["user"] = $user;
            }

        } elseif ((!empty($_COOKIE['user'])) and (!empty($_COOKIE['password']))) {
            $cookie['user'] = base64_decode(substr($_COOKIE['blog_ghj'],22,strlen($_COOKIE['user'])));
            $cookie['password'] = base64_decode(substr($_COOKIE['blog_ghk'],22,strlen($_COOKIE['password'])));

            $user=$this->getUser($cookie['user']);

            if ($cookie['password']==$user['password']) {
                $_SESSION["user"] = $user;
            }

        }

        if (!empty($_SESSION["user"])) {
            if (empty($_SESSION["url"])) {
                header('Location: index.php');
            } else {
                header('Location: '.$_SESSION["url"]);
            }
        }
    }

    protected function salt()
    {
        $string = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ0123456789';
        $salt = '';
        for ($i = 1; $i <= 22; $i++) {
            $rand = mt_rand(1, strlen($string));
            $salt .= $string[$rand-1];
        }
        return $salt;
    }

    protected function hash($password)
    {
        return crypt($password, '$2a$10$' . $this->salt() . '$');
    }
 
    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        setcookie('blog_ghj');
        setcookie('blog_ghk');
        header('Location: login.php');
    }
    
}
?>
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

    public function setData($user) {
        $this->ID = $user['ID'];
        $this->name = $user['name'];
        $this->username = $user['username'];
        $this->email = $user['email'];
        $this->password = $user['password'];
    }

    public function getUser($user) {
        try {
            $sql='SELECT * FROM `users` WHERE `users`.`username` = :user ;';

            $db=$this->db->prepare($sql);
            $db->bindValue(':user', $user,PDO::PARAM_STR);
            $db->execute();

            return $db->fetch(PDO::FETCH_ASSOC);
        }catch(PDOException $e) {
            echo 'Ops, um erro foi encontrado: ' . $e->getMessage();
        }

    }

    public function getUsers() {
        try {
            $sql='SELECT `name`, `email`, `username` FROM `users`;';

            $db=$this->db->prepare($sql);
            $db->execute();

            return $db->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo 'Ops, um erro foi encontrado: ' . $e->getMessage();
        }

    }

    public function deleteMe() {
        if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_GET['delete'])) {
            try {
                $sql='SET foreign_key_checks = 0; DELETE FROM `users_messages` WHERE `users_messages`.`idsender` = :iduser OR `users_messages`.`idreceiver` = :iduser; DELETE FROM `groups_messages` WHERE `groups_messages`.`idsender` = :iduser; DELETE FROM `friendships` WHERE `friendships`.`idsender` = :iduser OR `friendships`.`idreceiver` = :iduser; DELETE FROM `groups_and_users` WHERE `groups_and_users`.`iduser` = :iduser; DELETE FROM `groups` WHERE `groups`.`idadmin` = :iduser; DELETE FROM `users` WHERE `users`.`ID` = :iduser;';
                $db=$this->db->prepare($sql);

                $db->bindValue(':iduser', $this->ID,PDO::PARAM_STR);

                $db->execute();

                $this->logout();
            } catch(PDOException $e) {
                echo 'Ops, um erro foi encontrado: ' . $e->getMessage();
            }

        }
    }

    public function updateData() {
        if ($_SERVER['REQUEST_METHOD']=='POST') {
            try {
                $sql='UPDATE `users` SET `name` = :name, `username` = :user, `email` = :email WHERE `users`.`username` = :user;';

                $db=$this->db->prepare($sql);

                $db->bindValue(':name', $_POST['name'],PDO::PARAM_STR);
                $db->bindValue(':username', $_POST['username'],PDO::PARAM_STR);
                $db->bindValue(':email', $_POST['email'],PDO::PARAM_STR);
                $db->bindValue(':user', $_POST['username'],PDO::PARAM_STR);

                $db->execute();
                header('Location: settings.php');
            } catch(PDOException $e) {
                echo 'Ops, um erro foi encontrado: ' . $e->getMessage();
            }
        }
    }

    public function updatePassword() {
        if ($_SERVER['REQUEST_METHOD']=='POST') {
            try {
                $utils = new Utils();

                $sql='UPDATE `users` SET `password` = :password WHERE `users`.`username` = :user;';

                $db=$this->db->prepare($sql);

                $db->bindValue(':password', $utils->hash($_POST['password']),PDO::PARAM_STR);
                $db->bindValue(':user', $_SESSION['user']['username'],PDO::PARAM_STR);

                $db->execute();
                header('Location: settings.php');
            } catch(PDOException $e) {
                echo 'Ops, um erro foi encontrado: ' . $e->getMessage();
            }
        }
    }

    public function getRequestedFriends() {
        try {
            $sql='SELECT `ID`, `name`, `username` FROM `users` INNER JOIN `friendships` ON `friendships`.`idsender` = `users`.`ID` WHERE `friendships`.`idreceiver` = :user AND `friendships`.`status` = "REQUESTED";';

            $db=$this->db->prepare($sql);
            $db->bindValue(':user', $this->ID,PDO::PARAM_STR);
            $db->execute();

            return $db->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo 'Ops, um erro foi encontrado: ' . $e->getMessage();
        }
    }

    public function getSentRequests() {
        try {
            $sql='SELECT `ID`, `name`, `username` FROM `users` INNER JOIN `friendships` ON `friendships`.`idreceiver` = `users`.`ID` WHERE `friendships`.`idsender` = :user AND `friendships`.`status` = "REQUESTED";';

            $db=$this->db->prepare($sql);
            $db->bindValue(':user', $this->ID,PDO::PARAM_STR);
            $db->execute();

            return $db->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo 'Ops, um erro foi encontrado: ' . $e->getMessage();
        }
    }

    public function confirmFriendship($friend) {
        try {
            if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_GET['confirm'])) {
                $sql='UPDATE `friendships` SET `status` = "ACCEPTED" WHERE `friendships`.`idreceiver` = :iduser AND `friendships`.`idsender` = :idfriend';

                $db=$this->db->prepare($sql);
                $db->bindValue(':iduser', $this->ID,PDO::PARAM_STR);
                $db->bindValue(':idfriend', $friend,PDO::PARAM_STR);
                $db->execute();
            }
        } catch(PDOException $e) {
            echo 'Ops, um erro foi encontrado: ' . $e->getMessage();
        }
    }

    public function rejectFriendship($friend) {
        if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_GET['reject'])) {
            try {
                $sql='DELETE FROM `friendships` WHERE `friendships`.`idreceiver` = :iduser AND `friendships`.`idsender` = :idsender;';

                $db=$this->db->prepare($sql);
                $db->bindValue(':iduser', $this->ID,PDO::PARAM_STR);
                $db->bindValue(':idsender', $friend,PDO::PARAM_STR);
                $db->execute();
            } catch(PDOException $e) {
                echo 'Ops, um erro foi encontrado: ' . $e->getMessage();
            }
        }
    }

    public function checkFriendship($username, $friends) {
        foreach ($friends as $friend) {
            if($username === $friend['username']) {
                return 1;
            }
        }
        return 0;
    }

    public function checkRequests() {
        $receivedRequests = $this->getRequestedFriends();
        $sentRequests = $this->getSentRequests();
        foreach ($receivedRequests as $request) {
            if($_GET['id'] === $request['username']) {
                return 1;
            }
        }

        foreach ($sentRequests as $request) {
            if($_GET['id'] === $request['username']) {
                return 1;
            }
        }
        return 0;
    }

    public function getConfirmedFriends() {
        try {
            $sql='SELECT `ID`, `name`, `username` FROM `users` INNER JOIN `friendships` ON (`friendships`.`idsender` = `users`.`ID` OR `friendships`.`idreceiver` = `users`.`ID`) WHERE (`friendships`.`idreceiver` = :user OR `friendships`.`idsender` = :user) AND `friendships`.`status` = "ACCEPTED" AND `users`.`ID` != :user;';

            $db=$this->db->prepare($sql);
            $db->bindValue(':user', $this->ID,PDO::PARAM_STR);
            $db->execute();

            return $db->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo 'Ops, um erro foi encontrado: ' . $e->getMessage();
        }

    }

    public function sendRequest()
    {
        if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_GET['request'])) {
            try {
                $sql='INSERT INTO `friendships` (`idsender`,`idreceiver`,`status`) VALUES (:idsender,:idreceiver,:status);';

                $db=$this->db->prepare($sql);
                $db->bindValue(':idsender', $_SESSION['user']['ID'],PDO::PARAM_STR);
                $db->bindValue(':idreceiver', $_GET['receiver'],PDO::PARAM_STR);
                $db->bindValue(':status', "REQUESTED",PDO::PARAM_STR);

                $db->execute();
                header('Location: users.php?id=' . $_GET['id']);
            } catch(PDOException $e) {
                echo 'Ops, um erro foi encontrado: ' . $e->getMessage();
            }
        }
    }

    public function joinGroup($group)
    {
        if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_GET['join'])) {
            try {
                $sql='INSERT INTO `groups_and_users` (`idgroup`,`iduser`) VALUES (:idgroup,:iduser);';

                $db=$this->db->prepare($sql);
                $db->bindValue(':idgroup', $group,PDO::PARAM_STR);
                $db->bindValue(':iduser', $_SESSION['user']['ID'],PDO::PARAM_STR);

                $db->execute();
                header('Location: groups.php?id=' . $group);
            } catch(PDOException $e) {
                echo 'Ops, um erro foi encontrado: ' . $e->getMessage();
            }
        }
    }

    public function register()
    {
        try {
            if ($_SERVER['REQUEST_METHOD']=='POST') {
                $utils = new Utils();
                $sql='INSERT INTO `users` (`name`,`username`,`email`,`password`) VALUES (:name,:username,:email,:password);';

                $db=$this->db->prepare($sql);
                $db->bindValue(':name', $_POST['name'],PDO::PARAM_STR);
                $db->bindValue(':username', $_POST['username'],PDO::PARAM_STR);
                $db->bindValue(':email', $_POST['email'],PDO::PARAM_STR);
                $db->bindValue(':password', $utils->hash($_POST['password']),PDO::PARAM_STR);

                $db->execute();
                header('Location: index.php');
            }
        }catch(PDOException $e) {
            switch ($e->getCode()) {
                case "23000":
                    echo "<div class=\"alert alert-danger\" role=\"alert\">Ops! Já existe um usuário cadastrado com esse e-mail/nome de usuário. Tente novamente! </div>";
                    break;
                default:
                    echo "<div class=\"alert alert-danger\" role=\"alert\">Ops! Um erro aconteceu. </div>";
                    break;
            }
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
            $cookie['user'] = base64_decode(substr($_COOKIE['if_usr'],22,strlen($_COOKIE['user'])));
            $cookie['password'] = base64_decode(substr($_COOKIE['if_pwd'],22,strlen($_COOKIE['password'])));

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

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        setcookie('if_usr');
        setcookie('if_pwd');
        header('Location: login.php');
    }
}
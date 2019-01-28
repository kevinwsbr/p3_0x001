<?php

class Message {
    private $ID;
    private $idSender;
    private $idReceiver;
    private $content;
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getMessages($user) {
        try {
            $sql='SELECT `users`.`name`, `users`.`username`, `users_messages`.`content` FROM `users` INNER JOIN `users_messages` ON `users`.`ID` = `users_messages`.`idsender` WHERE `users_messages`.`idreceiver` = :iduser;';

            $db=$this->db->prepare($sql);
            $db->bindValue(':iduser', $user, PDO::PARAM_STR);
            $db->execute();

            return $db->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo 'Ops, aconteceu o seguinte erro: ' . $e->getMessage();
        }

    }

    public function getGroupMessages($group) {
        try {
            $sql='SELECT `users`.`name`, `users`.`username`, `groups_messages`.`content` FROM `users` INNER JOIN `groups_messages` ON `users`.`ID` = `groups_messages`.`idsender` WHERE `groups_messages`.`idreceiver` = :idgroup;';

            $db=$this->db->prepare($sql);
            $db->bindValue(':idgroup', $group, PDO::PARAM_STR);
            $db->execute();

            return $db->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo 'Ops, aconteceu o seguinte erro: ' . $e->getMessage();
        }

    }

    public function sendGroupMessage($receiver)
    {
        if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['message'])) {
            try {
                $sql='INSERT INTO `groups_messages` (`idsender`,`idreceiver`,`content`) VALUES (:idsender,:idreceiver,:content);';

                $db=$this->db->prepare($sql);
                $db->bindValue(':idsender', $_SESSION['user']['ID'],PDO::PARAM_STR);
                $db->bindValue(':idreceiver', $receiver,PDO::PARAM_STR);
                $db->bindValue(':content', $_POST['message'],PDO::PARAM_STR);

                $db->execute();
                header('Location: index.php');
            } catch(PDOException $e) {
                echo 'Ops, aconteceu o seguinte erro: ' . $e->getMessage();
            }
        }
    }

    public function sendMessage($receiver)
    {
        if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['message'])) {
            try {
                $sql='INSERT INTO `users_messages` (`idsender`,`idreceiver`,`content`) VALUES (:idsender,:idreceiver,:content);';

                $db=$this->db->prepare($sql);
                $db->bindValue(':idsender', $_SESSION['user']['ID'],PDO::PARAM_STR);
                $db->bindValue(':idreceiver', $receiver,PDO::PARAM_STR);
                $db->bindValue(':content', $_POST['message'],PDO::PARAM_STR);

                $db->execute();
                header('Location: index.php');
            } catch(PDOException $e) {
                echo 'Ops, aconteceu o seguinte erro: ' . $e->getMessage();
            }

        }
    }

}
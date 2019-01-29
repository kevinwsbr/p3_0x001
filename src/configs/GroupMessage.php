<?php

class GroupMessage extends Message implements iMessage {

  public function __construct($db)
  {
    parent::__construct($db);
  }

    public function getMessages($group) {
        try {
            $sql='SELECT `users`.`name`, `users`.`username`, `groups_messages`.`content` FROM `users` INNER JOIN `groups_messages` ON `users`.`ID` = `groups_messages`.`idsender` WHERE `groups_messages`.`idreceiver` = :idgroup ORDER BY `groups_messages`.`ID` DESC;';

            $db=$this->db->prepare($sql);
            $db->bindValue(':idgroup', $group, PDO::PARAM_STR);
            $db->execute();

            return $db->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo 'Ops, aconteceu o seguinte erro: ' . $e->getMessage();
        }

    }

    public function sendMessage($receiver)
    {
        if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['message'])) {
            try {
                $sql='INSERT INTO `groups_messages` (`idsender`,`idreceiver`,`content`) VALUES (:idsender,:idreceiver,:content);';

                $db=$this->db->prepare($sql);
                $db->bindValue(':idsender', $_SESSION['user']['ID'],PDO::PARAM_STR);
                $db->bindValue(':idreceiver', $receiver,PDO::PARAM_STR);
                $db->bindValue(':content', $_POST['message'],PDO::PARAM_STR);

                $db->execute();
                header('Location: groups.php?id=' . $_GET['id']);
            } catch(PDOException $e) {
                echo 'Ops, aconteceu o seguinte erro: ' . $e->getMessage();
            }
        }
    }
}
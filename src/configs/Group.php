<?php
class Group {
    private $ID;
    private $IDAdmin;
    private $name;
    private $description;
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getID() {
        return $this->ID;
    }

    public function getIDAdmin() {
        return $this->IDAdmin;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setData($group) {
        $this->ID = $group['ID'];
        $this->IDAdmin = $group['idadmin'];
        $this->name = $group['name'];
        $this->description = $group['description'];
    }

    public function removeMember() {
        try {
            if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_GET['remove'])) {
                $sql='DELETE FROM `groups_and_users` WHERE `groups_and_users`.`idgroup` = :idgroup AND `groups_and_users`.`iduser` = :iduser;';

                $db=$this->db->prepare($sql);

                $db->bindValue(':iduser', $_GET['iduser'], PDO::PARAM_STR);
                $db->bindValue(':idgroup', $this->ID, PDO::PARAM_STR);

                $db->execute();

                header('Location: groups.php?id=' . $this->ID);
            }
        } catch(PDOException $e) {
            echo 'Ops, aconteceu o seguinte erro: ' . $e->getMessage();
        }

    }

    public function checkMembership($username, $members) {
        foreach ($members as $member) {
            if($username === $member['username']) {
                return 1;
            }
        }
        return 0;
    }

    public function getMembers() {
        try {
            $sql='SELECT `ID`, `name`, `username` FROM `users` INNER JOIN `groups_and_users` ON `users`.`ID` = `groups_and_users`.`iduser` WHERE `groups_and_users`.`idgroup` = :idgroup;';

            $db=$this->db->prepare($sql);
            $db->bindValue(':idgroup', $this->ID, PDO::PARAM_STR);
            $db->execute();

            return $db->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo 'Ops, aconteceu o seguinte erro: ' . $e->getMessage();
        }

    }

    public function addMember($memberID, $groupID){
      try {
        $sql='INSERT INTO `groups_and_users` (`idgroup`,`iduser`) VALUES (:idgroup,:iduser);';

        $db=$this->db->prepare($sql);
        $db->bindValue(':idgroup', $groupID, PDO::PARAM_STR);
        $db->bindValue(':iduser', $memberID, PDO::PARAM_STR);

        $db->execute();
      }catch(PDOException $e) {
        echo 'Ops, aconteceu o seguinte erro: ' . $e->getMessage();
      }
    }

    public function getGroups() {
        try {
            $sql='SELECT * FROM `groups`;';

            $db=$this->db->prepare($sql);
            $db->execute();

            return $db->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo 'Ops, aconteceu o seguinte erro: ' . $e->getMessage();
        }

    }

    public function getGroup($group) {
        try {
            $sql='SELECT * FROM `groups` WHERE `groups`.`ID` = :id ;';

            $db=$this->db->prepare($sql);
            $db->bindValue(':id', $group, PDO::PARAM_STR);
            $db->execute();

            return $db->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo 'Ops, aconteceu o seguinte erro: ' . $e->getMessage();
        }

    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD']=='POST') {
            try {
                $sql='INSERT INTO `groups` (`name`,`description`,`idadmin`) VALUES (:name,:description,:idadmin);';

                $db=$this->db->prepare($sql);
                $db->bindValue(':name', $_POST['name'],PDO::PARAM_STR);
                $db->bindValue(':description', $_POST['description'],PDO::PARAM_STR);
                $db->bindValue(':idadmin', $_SESSION['user']['ID'],PDO::PARAM_STR);

                $db->execute();

                $lastID = $this->db->lastInsertId();
                $this->addMember($_SESSION['user']['ID'], $lastID);

                header('Location: groups.php?id=' . $lastID);
            } catch(PDOException $e) {
                echo 'Ops, aconteceu o seguinte erro: ' . $e->getMessage();
            }
        }
    }
}
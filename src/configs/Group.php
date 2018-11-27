<?php
class Group {
    private $ID;
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

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getMembers() {
        $sql='SELECT `name`, `username` FROM `users` INNER JOIN `groups_and_users` ON `users`.`ID` = `groups_and_users`.`iduser` WHERE `groups_and_users`.`idgroup` = :idgroup;';

        $db=$this->db->prepare($sql);
        $db->bindValue(':idgroup', $this->ID, PDO::PARAM_STR);
        $db->execute();

        return $db->fetchAll(PDO::FETCH_ASSOC);
    }

    public function setData($group) {
        $this->ID = $group['ID'];
        $this->name = $group['name'];
        $this->description = $group['description'];
    }

    public function getGroups() {
        $sql='SELECT * FROM `groups`;';

        $db=$this->db->prepare($sql);
        $db->execute();

        return $db->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getGroup($group) {
        $sql='SELECT * FROM `groups` WHERE `groups`.`ID` = :id ;';

        $db=$this->db->prepare($sql);
        $db->bindValue(':id', $group, PDO::PARAM_STR);
        $db->execute();

        return $db->fetch(PDO::FETCH_ASSOC);
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD']=='POST') {
            $sql='INSERT INTO `groups` (`name`,`description`,`idadmin`) VALUES (:name,:description,:idadmin);';
            
            $db=$this->db->prepare($sql);
            $db->bindValue(':name', $_POST['name'],PDO::PARAM_STR);
            $db->bindValue(':description', $_POST['description'],PDO::PARAM_STR);
            $db->bindValue(':idadmin', $_SESSION['user']['ID'],PDO::PARAM_STR);
            
            $db->execute();
            
            header('Location: index.php');
        }
    }
}
?>
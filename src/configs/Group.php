<?php
class Group {
    private $name;
    private $description;
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
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
<?php

require 'configs/Database.php';
require 'configs/User.php';

$conn = new Database();

$user = new User($conn->db);
$user->logout();

?>
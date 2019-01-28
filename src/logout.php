<?php

require_once 'configs/Autoload.php';

$user = new User($db);

$user->logout();
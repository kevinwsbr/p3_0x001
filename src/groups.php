<?php

require 'configs/Database.php';
require 'configs/User.php';
require 'configs/Group.php';
require 'configs/Message.php';

$conn = new Database();
$conn->protectPage();

$user = new User($conn->db);
$displayedUser = new User($conn->db);
$message = new Message($conn->db);


$group = new Group($conn->db);
$group->setData($group->getGroup($_GET['id']));
$members = $group->getMembers();

$user->setData($user->getUser($_SESSION['user']['username']));
$user->joinGroup($group->getID());

$friends = $user->getConfirmedFriends();
$requestedFriends = $user->getRequestedFriends();

$message->sendGroupMessage($_GET['id']);
$messages = $message->getGroupMessages($_GET['id']);

$group->removeMember();
?>

<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

  <title><?php echo $group->getName(); ?> | iFace</title>
</head>

<body>
  <?php require_once 'components/header.php'; ?>
  <?php require_once 'components/sidebar-profile.php'; ?>

  <div class="col-md-6 gedf-main">

    <div class="h4"><?php echo $group->getName(); ?></div>
    <div class="h7 text-muted"><?php echo $group->getDescription(); ?></div>
    <form action="groups.php?id=<?php echo $group->getID(); ?>&join=true" method="POST">
    <button type="submit" class="btn btn-outline-primary btn-sm mt-2">Ingressar</button>
    </form>

    <div class="card gedf-card my-4">
      <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="posts-tab" data-toggle="tab" href="#posts" role="tab" aria-controls="posts"
              aria-selected="true">Enviar mensagem</a>
          </li>
        </ul>
      </div>
      <div class="card-body">
        <div class="tab-content" id="myTabContent">
          <form action="groups.php?id=<?php echo $group->getID(); ?>&message=true" method="POST">
<div class="tab-pane fade show active" id="posts" role="tabpanel" aria-labelledby="posts-tab">
            <div class="form-group">
              <label class="sr-only" for="message">post</label>
              <textarea name="message" class="form-control" id="message" rows="3" placeholder="Insira aqui sua mensagem..."></textarea>
            </div>

          </div>
        </div>
        <div class="btn-toolbar justify-content-between">
          <div class="btn-group">
            <button type="submit" class="btn btn-primary">Enviar</button>
          </div>
        </div>
          </form>
          
      </div>
    </div>

    <h4>Mensagens do grupo</h4>
    <?php foreach ($messages as $msg) {?>       
    <div class="card gedf-card my-3">
      <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <div class="h5 m-0"><?php echo $msg['name']?></div>
              <div class="h7 text-muted">@<?php echo $msg['username']?></div>
            </div>
          </div>
        </div>

      </div>
      <div class="card-body">
        <p class="card-text">
          <?php echo $msg['content']?>
        </p>
      </div>
    </div>
    <?php } ?>
  </div>
  <div class="col-md-3">
    <div class="card gedf-card">
      <div class="card-body">
        <h5 class="card-title">Membros</h5>
        <ul class="list-unstyled">
        <?php if (($user->getID() == $group->getIDAdmin())) { ?>
        <li class="d-inline"><a href="users.php?id=<?php echo $user->getUsername() ?>"><?php echo $user->getName() ?></a></li>
          <?php } ?>
          <?php foreach ($members as $item) {?>
          <div class="d-block">
          <li class="d-inline"><a href="users.php?id=<?php echo $item['username'] ?>"><?php echo $item['name'] ?></a></li>
            <form class="d-inline" action="groups.php?id=<?php echo $group->getID() ?>&iduser=<?php echo $item['ID'] ?>&remove=true" method="POST">
            <?php if (($user->getID() == $group->getIDAdmin()) && ($user->getID() != $item['ID'])) { ?>
              <button type="submit" class="btn badge badge-danger">Remover</button>
            <?php } ?>
              </form>
            <?php } ?>
          </div>
            
        </ul>
      </div>
    </div>
  </div>
  </div>
  </div>

  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/popper.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>
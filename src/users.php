<?php

require_once 'configs/Autoload.php';

$utils->protectPage();

$user = new User($db);
$message = new UserMessage($db);

$displayedUser = new User($db);

$user->setData($user->getUser($_SESSION['user']['username']));
$displayedUser->setData($user->getUser($_GET['id']));

$user->sendRequest();

$user->confirmFriendship($displayedUser->getID());
$user->rejectFriendship($displayedUser->getID());

$message->sendMessage($_GET['id']);

?>

<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

  <title>Perfil | iFace</title>
</head>

<body>
  <?php require_once 'components/header.php'; ?>
  <?php require_once 'components/sidebar-profile.php'; ?>

  <div class="col-md-6 gedf-main">

    <div class="card mb-4">
      <div class="card-body">
        <h5 class="card-title">
          <?php echo $displayedUser->getName() ?>
        </h5>
        <h6 class="card-subtitle mb-2 text-muted">@<?php echo $displayedUser->getUsername() ?>
        </h6>
          <?php $user->checkRequests();
             if (!$user->checkFriendship($displayedUser->getUsername(), $friends) && $displayedUser->getUsername() != $user->getUsername() && !$user->checkRequests()) {?>
                 <form action="users.php?id=<?php echo $displayedUser->getUsername() ?>&receiver=<?php echo $displayedUser->getID() ?>&request=true" method="POST">
                     <button type="submit" class="btn btn-outline-primary btn-sm mt-2">Adicionar amigo</button>
                 </form>
          <?php
             }
          ?>


      </div>
    </div>
     <?php if ($displayedUser->getUsername() != $user->getUsername()) {
     ?>
         <div class="card gedf-card mb-4">
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
                     <form action="users.php?id=<?php echo $displayedUser->getID(); ?>&message=true" method="POST">
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
     <?php
     }?>

  </div>
  <div class="col-md-3">
  </div>
  </div>
  </div>

  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/popper.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>
<?php

require_once 'configs/Autoload.php';
$utils->protectPage();

$user = new User($db);
$group = new Group($db);
$message = new UserMessage($db);

$groups = $group->getGroups();

$user->setData($user->getUser($_SESSION['user']['username']));
$messages = $message->getMessages($user->getID());
?>

<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <title>iFace</title>
</head>

<body>
  <?php require_once 'components/header.php'; ?>

  <?php require_once 'components/sidebar-profile.php'; ?>
  <div class="col-md-6 gedf-main">
    <h4>Minha caixa de entrada</h4>
      <?php if(count($messages) > 0 ) {
     foreach ($messages as $item) {?>
    <div class="card gedf-card my-3">
      <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <div class="h5 m-0"><?php echo $item['name']?></div>
              <div class="h7 text-muted">@<?php echo $item['username']?></div>
            </div>
          </div>
        </div>

      </div>
      <div class="card-body">
        <p class="card-text">
          <?php echo $item['content']?>
        </p>
      </div>
    </div>
     <?php }
      } else {
          echo "<span>Ops, ainda não há nenhuma mensagem aqui!</span>";
      }?>
  </div>
  <div class="col-md-3">
    <div class="card gedf-card">
      <div class="card-body">
        <h5 class="card-title">Comunidades</h5>
        <a class="btn btn-outline-primary btn-sm mb-2" href="create-group.php" role="button">Criar comunidade</a>

        <ul class="list-unstyled">
          <?php foreach ($groups as $item) {?>
            <li><a href="groups.php?id=<?php echo $item['ID'] ?>"><?php echo $item['name'] ?></a></li>
            <?php } ?>
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
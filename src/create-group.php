<?php

require_once 'configs/Autoload.php';

$utils->protectPage();

$user = new User($db);
$group = new Group($db);

$user->setData($user->getUser($_SESSION['user']['username']));
$group->register();

?>

<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

  <title>Criar comunidade | iFace</title>
</head>

<body>
  <?php require_once 'components/header.php'; ?>

  <?php require_once 'components/sidebar-profile.php'; ?>
  <div class="col-md-6 gedf-main">
    <h4>Criar comunidade</h4>
    <form action="create-group.php" method="POST">
      <div class="form-group">
            <label for="name">Nome</label>
            <input type="text" class="form-control" id="name" name="name">
          </div>

      <div class="form-group">
    <label for="description">Descrição</label>
    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
  </div>
      <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>
  </div>
  </div>
  </div>

  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/popper.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>
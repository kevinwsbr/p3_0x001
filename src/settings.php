<?php

require 'configs/Database.php';
require 'configs/User.php';

$conn = new Database();
$conn->protectPage();

$user = new User($conn->db);

$user->setData($user->getUser($_SESSION['user']['username']));
$user->updateData();

$user->deleteMe();
?>

<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

  <title>Editar perfil | iFace</title>
</head>

<body>
  <?php require_once 'components/header.php'; ?>

  <?php require_once 'components/sidebar-profile.php'; ?>
  <div class="col-md-6 gedf-main">
    <h4>Editar meu perfil</h4>
    <form action="settings.php" method="POST">
      <div class="row">
        <div class="col">
          <div class="form-group">
            <label for="name">Nome</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $user->getName(); ?>">
          </div>
        </div>
        <div class="col">
          <div class="form-group">
            <label for="username">Nome de usuário</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo $user->getUsername(); ?>">
          </div>
        </div>
      </div>

      <div class="form-group">
        <label for="email">E-mail</label>
        <input type="email" class="form-control" id="email" name="email" value="<?php echo $user->getEmail(); ?>">
      </div>
      <div class=" dropdown-divider"></div>
      <div class="form-group">
        <label for="password">Senha</label>
        <input type="password" class="form-control" id="password">
        <small>Insira sua senha atual para confirmar as alterações.</small>
      </div>
      <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
    <form action="settings.php?delete=true" method="post">
      <div class="dropdown-divider"></div>
      <button type="submit" class="btn btn-danger">Apagar meus dados</button>
    </form>
  </div>
  </div>
  </div>

  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/popper.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>
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

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
    crossorigin="anonymous">

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

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
    crossorigin="anonymous"></script>
</body>

</html>
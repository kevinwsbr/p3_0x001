<?php

require 'configs/Database.php';
require 'configs/User.php';

$conn = new Database();
$user = new User($conn->db);

$user->register();

?>

<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
    crossorigin="anonymous">

  <title>Cadastro | iFace</title>
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col col-12">
        <div class="h4 my-3">Cadastro | iFace</div>
        <form method="POST" action="register.php">
          <div class="form-group">
            <label for="username">Nome de usuário</label>
            <input name="username" type="text" class="form-control">
          </div>
          <div class="form-group">
            <label for="name">Nome / sobrenome</label>
            <input name="name" type="text" class="form-control">
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input name="email" type="email" class="form-control">
          </div>
          <div class="form-group">
            <label for="password">Senha</label>
            <input name="password" type="password" class="form-control">
          </div>
          <button type="submit" class="btn btn-primary">Registrar</button>
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
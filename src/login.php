<?php

require_once 'configs/Autoload.php';

$user = new User($db);

$user->login();

?>

<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

  <title>Login | iFace</title>
</head>

<body>
  <div class="container">
    <div class="row" style="height: 320px;margin-top: 160px;">
      <div class="col col-12 col-md-8 col-lg-4" style="margin: 0 auto;">
        <div class="h4 my-3">Entrar | iFace</div>
        <form method="POST" action="login.php">
          <div class="form-group">
            <label for="username">Nome de usuário</label>
            <input required id="username" name="username" type="text" class="form-control">
          </div>
          <div class="form-group">
            <label for="password">Senha</label>
            <input required id="password" name="password" type="password" class="form-control">
          </div>
          <small class="d-block mb-2">Não tem conta? <a href="register.php">Cadastre-se</a></small>
          <button type="submit" class="btn btn-primary">Entrar</button>
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
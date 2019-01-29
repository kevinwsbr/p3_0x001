<?php

require_once 'configs/Autoload.php';

$user = new User($db);

$user->register();

?>

<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

  <title>Cadastro | iFace</title>
</head>

<body>
  <div class="container">
    <div class="row" style="height: 400px;margin-top: 100px;">
      <div class="col col-12 col-md-8" style="margin: 0 auto;">
        <div class="h4 my-3">Cadastro | iFace</div>
        <form method="POST" action="register.php">
            <div class="row">
                <div class="col col-12 col-md-6">
                    <div class="form-group">
                        <label for="username">Nome de usuário</label>
                        <input name="username" type="text" class="form-control">
                    </div>
                </div>
                <div class="col col-12 col-md-6">
                    <div class="form-group">
                        <label for="name">Nome / sobrenome</label>
                        <input name="name" type="text" class="form-control">
                    </div>
                </div>
            </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input name="email" type="email" class="form-control">
          </div>
          <div class="form-group">
            <label for="password">Senha</label>
            <input name="password" type="password" class="form-control">
          </div>
          <small class="d-block mb-2">Já possui conta? <a href="login.php">Faça login</a></small>
          <button type="submit" class="btn btn-primary">Registrar</button>
        </form>
      </div>
    </div>
  </div>

  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/popper.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>
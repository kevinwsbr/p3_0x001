<?php

require 'configs/Database.php';
require 'configs/User.php';

$conn = new Database();
$conn->protectPage();

$user = new User($conn->db);

$user->setData($user->getUser($_SESSION['user']['username']));

?>

<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
    crossorigin="anonymous">
  <title>iFace</title>
</head>

<body>
  <?php require_once 'components/header.php'; ?>

  <?php require_once 'components/sidebar-profile.php'; ?>
  <div class="col-md-6 gedf-main">
    <h4>Minhas mensagens</h4>
    <div class="card gedf-card">
      <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <div class="h5 m-0">@LeeCross</div>
              <div class="h7 text-muted">Miracles Lee Cross</div>
            </div>
          </div>
        </div>

      </div>
      <div class="card-body">
        <p class="card-text">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo recusandae nulla rem eos ipsa
          praesentium esse magnam nemo dolor
          sequi fuga quia quaerat cum, obcaecati hic, molestias minima iste voluptates.
        </p>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card gedf-card">
      <div class="card-body">
        <h5 class="card-title">Comunidades</h5>
        <a class="btn btn-outline-primary btn-sm mb-2" href="create-group.php" role="button">Criar comunidade</a>
        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
          card's content.</p>
      </div>
    </div>
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
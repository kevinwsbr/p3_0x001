<?php

require 'configs/Database.php';
require 'configs/User.php';

$conn = new Database();
$conn->protectPage();

$user = new User($conn->db);
$displayedUser = new User($conn->db);

$user->setData($user->getUser($_SESSION['user']['username']));
$displayedUser->setData($user->getUser($_GET['id']));

?>

<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
    crossorigin="anonymous">

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
        <h6 class="card-subtitle mb-2 text-muted">@
          <?php echo $displayedUser->getUsername() ?>
        </h6>
        <a href="#" class="card-link">Adicionar amigo</a>
      </div>
    </div>
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
          <form action="" method="POST">
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
  </div>
  <div class="col-md-3">
    <div class="card gedf-card">
      <div class="card-body">
        <h5 class="card-title">Card title</h5>
        <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
          card's content.</p>
        <a href="#" class="card-link">Card link</a>
        <a href="#" class="card-link">Another link</a>
      </div>
    </div>
    <div class="card gedf-card">
      <div class="card-body">
        <h5 class="card-title">Card title</h5>
        <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
          card's content.</p>
        <a href="#" class="card-link">Card link</a>
        <a href="#" class="card-link">Another link</a>
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
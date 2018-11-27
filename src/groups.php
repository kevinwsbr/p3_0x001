<?php

require 'configs/Database.php';
require 'configs/User.php';
require 'configs/Group.php';

$conn = new Database();
$conn->protectPage();

$user = new User($conn->db);
$displayedUser = new User($conn->db);

$group = new Group($conn->db);
$group->setData($group->getGroup($_GET['id']));
$members = $group->getMembers();

$user->setData($user->getUser($_SESSION['user']['username']));

?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
    crossorigin="anonymous">

  <title><?php echo $group->getName(); ?> | iFace</title>
</head>

<body>
  <?php require_once 'components/header.php'; ?>
  <?php require_once 'components/sidebar-profile.php'; ?>

  <div class="col-md-6 gedf-main">

    <!--- \\\\\\\Post-->

    <div class="h4"><?php echo $group->getName(); ?></div>
    <div class="h7 text-muted">Comunidade do iFace</div>
    <a class="btn btn-outline-primary btn-sm mt-2" href="../settings.php" role="button">Ingressar</a>

    <!--- \\\\\\\Post-->
    <div class="card gedf-card">
      <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <div class="h5 m-0">@LeeCross</div>
              <div class="h7 text-muted">Miracles Lee Cross</div>
            </div>
          </div>
          <div>
            <div class="dropdown">
              <button class="btn btn-link dropdown-toggle" type="button" id="gedf-drop1" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-ellipsis-h"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="gedf-drop1">
                <div class="h6 dropdown-header">Configuration</div>
                <a class="dropdown-item" href="#">Save</a>
                <a class="dropdown-item" href="#">Hide</a>
                <a class="dropdown-item" href="#">Report</a>
              </div>
            </div>
          </div>
        </div>

      </div>
      <div class="card-body">
        <div class="text-muted h7 mb-2"> <i class="fa fa-clock-o"></i>10 min ago</div>
        <a class="card-link" href="#">
          <h5 class="card-title">Lorem ipsum dolor sit amet, consectetur adip.</h5>
        </a>

        <p class="card-text">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo recusandae nulla rem eos ipsa
          praesentium esse magnam nemo dolor
          sequi fuga quia quaerat cum, obcaecati hic, molestias minima iste voluptates.
        </p>
      </div>
      <div class="card-footer">
        <a href="#" class="card-link"><i class="fa fa-gittip"></i> Like</a>
        <a href="#" class="card-link"><i class="fa fa-comment"></i> Comment</a>
        <a href="#" class="card-link"><i class="fa fa-mail-forward"></i> Share</a>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card gedf-card">
      <div class="card-body">
        <h5 class="card-title">Membros</h5>
        <ul class="list-group">
          <?php foreach ($members as $item) {?>
            <li><a href="users.php?id=<?php echo $item['username'] ?>"><?php echo $item['name'] ?></a></li>
            <?php } ?>
        </ul>
      </div>
    </div>
  </div>
  </div>
  </div>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
    crossorigin="anonymous"></script>
</body>

</html>
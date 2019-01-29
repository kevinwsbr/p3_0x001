<?php

require_once 'configs/Autoload.php';

$utils->protectPage();

$user = new User($db);

$user->setData($user->getUser($_SESSION['user']['username']));
$user->updatePassword();

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
    <form action="change-password.php" method="POST">
        <div class="form-group">
            <label for="password">Nova senha</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Digite a nova senha">
        </div>
        <button type="submit" class="btn btn-primary">Alterar senha</button>
    </form>
</div>
</div>
</div>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
</body>

</html>
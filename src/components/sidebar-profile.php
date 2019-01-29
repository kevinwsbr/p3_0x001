<?php

$friends = $user->getConfirmedFriends();
$requestedFriends = $user->getRequestedFriends();

?>
<div class="container-fluid gedf-wrapper">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="h5">
                        <?php echo $user->getName() ?>
                    </div>
                    <div class="h7 text-muted">@<?php echo $user->getUsername() ?>
                    </div>
                    <a class="btn btn-outline-primary btn-sm mt-2" href="./settings.php" role="button">Editar perfil</a>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <div class="h6 text-muted">Amigos</div>
                        <ul class="list-unstyled">
                        <?php foreach ($friends as $item) {?>
                        <li><a href="users.php?id=<?php echo $item['username'] ?>"><?php echo $item['name'] ?></a></li>
                        <?php } ?>
                        </ul>
                    </li>
                    <li class="list-group-item">
                        <div class="h6 text-muted">Solicitações de amizade</div>
                        <ul class="list-unstyled">
                        <?php foreach ($requestedFriends as $item) {?>
                        <li>
                        <a href="users.php?id=<?php echo $item['username'] ?>"><?php echo $item['name'] ?></a>
                        <form class="d-inline" action="users.php?id=<?php echo $item['username'] ?>&confirm=true" method="POST">
                            <button type="submit" class="btn badge badge-success">Confirmar</button>
                        </form>
                        <form class="d-inline" action="users.php?id=<?php echo $item['username'] ?>&reject=true" method="POST">
                            <button type="submit" class="btn badge badge-danger">Recusar</button>
                        </form>
                        </li>
                        <?php } ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
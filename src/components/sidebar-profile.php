<?php ?>
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
                    <a class="btn btn-outline-primary btn-sm mt-2" href="../settings.php" role="button">Editar perfil</a>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <div class="h6 text-muted">Amigos</div>
                        <div class="h5">52.342</div>
                    </li>
                </ul>
            </div>
        </div>
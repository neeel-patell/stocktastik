<header class="jumbotron bg-dark p-5 mb-0">
    <div class="row container-fluid">
        <h4 class="text-monospace ml-2 p-0 col-lg-6 col-md-12">
            <a href="index.php" class="deep-orange-text link"><i class="fab fa-stack-exchange"></i> Stocktastik <i class="fas fa-dice-three"></i></a>
        </h4>
        <div class="col-lg-5 col-md-12 text-right">
            <div class="btn-group">
                <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user-alt"></i> <?php echo $name; ?>
                </button>
                <div class="dropdown-menu text-center">
                    <a class="dropdown-item" href="profile.php">Profile <i class="fas fa-user-alt"></i></a>
                    <a class="dropdown-item" href="index.php">Game <i class="fas fa-gamepad"></i></a>
                    <a class="dropdown-item" href="journal.php">Journal <i class="fas fa-file-signature"></i></a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="logout.php">Log Out <i class="fas fa-sign-out-alt"></i></a>
                </div>
            </div>
        </div>
    </div>
</header>
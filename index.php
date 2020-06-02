<?php
    session_start();
    $login = 0;
    if(isset($_SESSION['login']) == true){
        $login = $_SESSION['login'];
    }
?>
<!doctype html>
<html lang="en">
    <head>
        <title>Stocktastik</title>
        <?php include 'css_files.php'; ?>
    </head>
    <body>
        <header class="jumbotron bg-dark p-5 mb-0">
            <div class="row container-fluid">
                <h4 class="text-monospace ml-2 p-0 col-lg-6 col-md-12">
                    <a href="index.php" class="deep-orange-text link"><i class="fab fa-stack-exchange"></i> Stocktastik <i class="fas fa-dice-three"></i></a>
                </h4>
                <div class="col-lg-5 col-md-12 text-right">
                    
                    <?php if($login == 0){  ?>
                        <button class="btn deep-orange darken-2 text-white" onclick='location.href="user_login.php"'>Log In</button>
                    <?php } else{ 
                        include 'connection.php';
                        $conn = getConn();
                        $result = $conn->query("select first_name,last_name from login where id=$login");
                        $name = $result->fetch_array();
                        $name = $name['first_name']." ".$name['last_name'];
                    ?>
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
                    <?php } ?>
                </div>
            </div>
        </header>
        <div class="container-fluid purple-gradient p-5">
            <div class="container border-success card p-3">
                Page is Under Development .... 
            </div>
        </div>
        <footer class="jumbotron blue darken-2 p-5 mb-0">
            <h5 class="text-white text-right"><i class="far fa-copyright"></i> Lampros Tech</h5>
        </footer>
        <?php include 'js_files.php'; ?>
    </body>
</html>
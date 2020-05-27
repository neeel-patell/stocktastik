<?php
    session_start();
    if(isset($_SESSION['login']) == false){
        header('location: index.php');
    }
?>
<!doctype html>
<html lang="en">
    <head>
        <title>Stocktastik - Login</title>
        <?php include 'css_files.php'; ?>
    </head>
    <body>
        <header class="jumbotron bg-dark p-5 mb-0">
            <h4 class="text-monospace deep-orange-text ml-4"><i class="fab fa-stack-exchange"></i> Stocktastik <i class="fas fa-dice-three"></i></h4>
        </header>
        <div class="container-fluid purple-gradient p-5">
            <div class="container border-success card p-3">
                Page is Under Development .... 
            </div>
        </div>
        <footer class="jumbotron blue darken-2 p-5 mb-0">
            <h5 class="text-white text-right"><i class="far fa-copyright"></i> Lampros Tech</h5>
            <h5 class="text-monospace text-xl-center text-white"> - By Neeel-Patell</h5>
        </footer>
        <?php include 'js_files.php' ?>
    </body>
</html>
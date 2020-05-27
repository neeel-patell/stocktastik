<?php
    session_start();
    if(isset($_SESSION['login'])){
        header('location: home.php');
    }
?>
<!doctype html>
<html lang="en">
    <head>
        <title>Stocktastik - Forgot Password</title>
        <?php include 'css_files.php'; ?>
    </head>
    <body>
        <header class="jumbotron bg-dark p-5 mb-0">
            <h4 class="text-monospace deep-orange-text ml-4"><i class="fab fa-stack-exchange"></i> Stocktastik <i class="fas fa-dice-three"></i></h4>
        </header>
        <div class="container-fluid purple-gradient p-5">
            <div class="container border-success card p-3">
                <h3 class="text-center container-fluid">Forgot Password</h3>
                <hr class="bg-dark mb-5">
                <form class="container" action="send_password.php" method="post">
                    <div class="form-group row mb-0">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <?php if(isset($_GET['msg'])){ if($_GET['msg'] === 'noemail'){ ?>
                                <div class="alert alert-danger text-center" role="alert">Email is not registered ...</div>
                            <?php }} ?>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4 mb-3">
                            <label class="label">Email: <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" placeholder="Email Address" name="email" id="email" maxlength="256" required>
                        </div>
                        <div class="col-md-4"></div>
                    </div>
                    <div class="form-group text-center mb-0">
                        <input type="submit" value="Get Password" class="btn btn-success">
                    </div>
                    <div class="form-group text-center mb-0">
                        <input type="button" value="Back to Login Page" class="btn btn-danger" onclick='location.href="index.php"'>
                    </div>
                </form>
            </div>
        </div>
        <footer class="jumbotron blue darken-2 p-5 mb-0">
            <h5 class="text-white text-right"><i class="far fa-copyright"></i> Lampros Tech</h5>
            <h5 class="text-monospace text-xl-center text-white"> - By Neeel-Patell</h5>
        </footer>
        <script type="text/javascript">
            function showPass(chk,pass){
                var chk = document.getElementById(chk);
                if(chk.checked == true){
                    document.getElementById(pass).setAttribute("type","text");
                }
                else{
                    document.getElementById(pass).setAttribute("type","password");
            }
        </script>
        <?php include 'js_files.php' ?>
    </body>
</html>
                }
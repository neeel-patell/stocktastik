<?php
    session_start();
    $otp = $otpcounter = 0;
    if(isset($_SESSION['otp'])){
        $otp = $_SESSION['otp'];
    }
    if(isset($_SESSION['counter'])){
        $otpcounter = $_SESSION['counter'];
    }
?>
<!doctype html>
<html lang="en">
    <head>
        <title>Stocktastik - Registration</title>
        <?php include 'css_files.php'; ?>
    </head>
    <body>
        <header class="jumbotron bg-dark p-5 mb-0">
            <h4 class="text-monospace deep-orange-text ml-4"><i class="fab fa-stack-exchange"></i> Stocktastik <i class="fas fa-dice-three"></i></h4>
        </header>
        <div class="container-fluid purple-gradient p-5">
            <div class="container border-success card p-3">
                <h2 class="text-center container-fluid">Registration</h2>
                <hr class="bg-dark mb-5">
                <form class="container" action="get_otp.php" method="post" onsubmit="return check()">
                    <?php if(isset($_GET['msg'])){ 
                        if($_GET['msg'] === 'nm'){ ?>
                            <div class="alert alert-danger text-center" role="alert">One Time Password has not matched with which has sent on your Email...</div>
                        <?php } else if($_GET['msg'] === 'os'){ ?>
                            <div class="alert alert-success text-center" role="alert">OTP resent to your Email...</div>
                        <?php } else if($_GET['msg'] === 'ee'){ ?>
                            <div class="alert alert-danger text-center" role="alert">Email or Mobile Already Exist...</div>
                        <?php } if($otpcounter >= 5) {?>
                            <div class="alert alert-success text-center" role="alert">Please try Resend option maximum try of current OTP has been finished...</div>
                    <?php }} ?>
                    <div class="form-group row mb-0">
                        <div class="col-md-4 mb-3"></div>
                        <div class="col-md-4 mb-3">
                            <label class="label">Email: <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" placeholder="Enter Email" name="email" maxlength="256" id="email" <?php if($otp != 0) echo "value='".$_SESSION['email']."' disabled"; ?> required autofocus>
                        </div>
                        <div class="col-md-4 mb-3"></div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-4 mb-3"></div>
                        <div class="col-md-4 mb-3">
                            <label class="label">Mobile: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="Enter Mobile" name="mobile" maxlength="10" id="mobile" <?php if($otp != 0) echo "value='".$_SESSION['mobile']."' disabled"; ?> required>
                        </div>
                        <div class="col-md-4 mb-3"></div>
                    </div>

                    <?php if($otp == 0){ ?>
                    <div class="form-group text-center mb-0">
                        <input type="submit" value="Get OTP" class="btn btn-success">
                    </div>
                    <?php } ?>

                </form>

                <?php if($otp != 0){ ?>
                <form action="verify_otp.php" method="post" class="container">
                    <div class="form-group row mb-0">
                        <div class="col-md-4 mb-3"></div>
                        <div class="col-md-4 mb-3">
                            <label class="label">One Time Password: <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="Enter One Time Password" name="otp" maxlength="6" minlength="6" id="otp" required autofocus>
                            <a onclick='location.href="resend_otp.php"' class="btn p-1 btn-link text-primary">Resend OTP</a>
                        </div>
                        <div class="col-md-4 mb-3"></div>
                    </div>
                    <div class="form-group text-center mb-0">
                        <?php if($otpcounter < 5) { ?> <input type="submit" value="Submit" class="btn btn-success"> <?php } ?>
                        <input type="button" value="Reset" class="btn btn-danger" onclick='location.href="reset_otp.php"'>
                    </div>
                </form>
                <?php } ?>
                
            </div>
        </div>
        <footer class="jumbotron p-5 blue darken-2 p-3 mb-0">
            <h5 class="text-white text-right"><i class="far fa-copyright"></i> Lampros Tech</h5>
            <h5 class="text-monospace text-xl-center text-white"> - By Neeel-Patell</h5>
        </footer>
        <script type="text/javascript">
            function check(){
                if (/^\d{10}$/.test(document.getElementById('mobile').value)) {
                    return true;
                }
                else {
                    alert("Enter Valid Mobile Number");
                    return false;
                }
            }
        </script>
        <?php include 'js_files.php' ?>
    </body>
</html>
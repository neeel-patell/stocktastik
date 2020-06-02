<?php
    session_start();
    if(!isset($_SESSION['email']) || !isset($_SESSION['mobile'])){
        session_unset();
       //header('location: verify_email.php');
    }
    else{
        $email = $_SESSION['email'];
        $mobile = $_SESSION['mobile'];
        unset($_SESSION['otp']);
        unset($_SESSION['counter']);
        unset($_SESSION['otptime']);
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
                <h3 class="text-center container-fluid">Registration</h3>
                <hr class="bg-dark mb-5">
                <form class="container" action="add_user.php" method="post" onsubmit="return check()">
                    <div class="form-group row mb-0">
                        <div class="col-md-6 mb-3">
                            <label class="label">First Name:  <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="First Name" name="first_name" id="first_name" maxlength="30" required autofocus>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="label">Last Name:  <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="Last Name" name="last_name" id="last_name" maxlength="30" required>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-6 mb-3">
                            <label class="label">Email: <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" placeholder="Email Address" name="email" id="email" maxlength="256" <?php echo "value='$email' disabled"; ?> required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="label">Mobile Number:  <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="Mobile Number" name="mobile" id="mobile" maxlength="10" <?php echo "value='$mobile' disabled"; ?> minlength="10" required>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-6 mb-3">
                            <label class="label">Date of Birth: <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" placeholder="Birthday" name="dob" id="dob" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="label">City:  <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="City" name="city" id="city" maxlength="30" required>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-6 mb-3">
                            <label class="label">Bank Balance:  <span class="text-danger">*</span></label>
                            <div class="clearfix">
                                <input type="text" class="form-control w-50 float-left" placeholder="Rupees" name="bank_rupees" id="bank_rupees" min="1" max="9999999" required>
                                <input type="text" class="form-control w-50 float-right" placeholder="Paisa" name="bank_paisa" id="bank_paisa" min="0" max="99" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-6 mb-3">
                            <label class="label">Password: <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" placeholder="Password" name="password" id="pass" minlength="8" maxlength="24" id="password" required>
                            <label class="ml-4 mt-3 form-check-label"><input type="checkbox" tabindex="-1" name="chkpass" id="chkpass" onchange='showPass("chkpass","pass")' class="form-check-input">Show Password</label>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="label">Confirm Password:  <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" placeholder="Confirm Password" name="confirmpass" id="confirmpass" minlength="8" maxlength="24" required>
                            <label class="ml-4 mt-3 form-check-label"><input type="checkbox" tabindex="-1" id="chkconfirmpass" name="chkconfirmpass" onchange='showPass("chkconfirmpass","confirmpass")' class="form-check-input">Show Password</label>
                        </div>
                    </div>
                    <div class="form-group text-center mb-0">
                        <input type="submit" value="Register Me" class="btn btn-success">
                        <input type="button" value="Back" class="btn btn-danger" onclick='location.href="reset_otp.php"'>
                    </div>
                </form>
            </div>
        </div>
        <footer class="jumbotron blue darken-2 p-5 mb-0">
            <h5 class="text-white text-right"><i class="far fa-copyright"></i> Lampros Tech</h5>
        </footer>
        <script type="text/javascript">
            var maxdate = new Date();
            var dd = maxdate.getDate();
            var mm = maxdate.getMonth()+1;
            var yyyy = maxdate.getFullYear() - 18;
            if(dd<10){
                    dd='0'+dd;
                } 
                if(mm<10){
                    mm='0'+mm;
                } 
            maxdate = yyyy+'-'+mm+'-'+dd;
            document.getElementById('dob').setAttribute("max",maxdate);
            function showPass(chk,pass){
                var chk = document.getElementById(chk);
                if(chk.checked == true){
                    document.getElementById(pass).setAttribute("type","text");
                }
                else{
                    document.getElementById(pass).setAttribute("type","password");
                }
            }
            function check(){
                var regex = /^[a-zA-z]+([\s][a-zA-Z]+)*$/;
                if(regex.test(document.getElementById('first_name').value) === false){
                    alert("First Name can not contain any symbol or number");
                    return false;
                }
                else if(regex.test(document.getElementById('last_name').value) === false){
                    alert("Last Name can not contain any symbol or number");
                    return false;
                }
                else if(document.getElementById('pass').value != document.getElementById('confirmpass').value){
                    alert("Password and Confirm Password Should be Matched");
                    return false;
                }
                else{
                    return true;
                }
            }
        </script>
        <?php include 'js_files.php'; ?>
    </body>
</html>
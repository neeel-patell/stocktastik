<?php 
    include 'login_check.php'; 
    $msg = "";
    if(isset($_GET['msg'])){
        $msg = $_GET['msg'];
    }
    
    $city = $conn->query("select name,state_id from city");
    $query = "select first_name,last_name,email,city,dob,mobile from login where id=$login";
    $user = $conn->query($query);
    $user = $user->fetch_array();
    $query = "select name,state_id from city where id=".$user['city'];
    $result = $conn->query($query);
    $user_city = $result->fetch_array();
    $state = $conn->query("select name from state where id=".$user_city['state_id']);
    $state = $state->fetch_array();
    $user_city['state'] = $state['name'];

    $query = "select sum(amount)'diposite' from passbook where user_id=$login and method=0";
    $result = $conn->query($query);
    $bank = $result->fetch_array();
    $query = "select sum(amount)'balance' from passbook where user_id=$login and method=1";
    $result = $conn->query($query);
    $stock = $result->fetch_array();
    $stock_balance = $stock['balance'];
    $bank_balance = $bank['diposite'] - $stock_balance;
?>
<!doctype html>
<html lang="en">
    <head>
        <title>Stocktastik - Profile</title>
        <?php include 'css_files.php'; ?>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <div class="container-fluid p-3">
            <div class="row">
                <div class="col-lg-6 p-4">
                    <form class="border border-success rounded p-5" action="change_personal_data.php" method="post" onsubmit="return checkPersonal()">
                        
                        <?php if($msg === "done"){ ?>
                        <div class="alert alert-success h5" role="alert">Profile Updated... </div>
                        <?php } else if($msg === "fail"){ ?>
                        <div class="alert alert-danger h5" role="alert">Profile is not Updated... </div>
                        <?php } ?>

                        <h5 class="text-center">Personal Details <button type="button" id="btn_edit" onclick="visiblePersonal()" class="rounded ml-3 btn btn-warning p-2">Edit</button></h5>
                        <hr>
                        <div class="form-group">
                            <label class="label">First Name:</label>
                            <input type="text" class="form-control" name="first_name" id="first_name" maxlength="30" value="<?php echo $user['first_name']; ?>" required disabled>
                        </div>
                        <div class="form-group">
                            <label class="label">Last Name:</label>
                            <input type="text" class="form-control" name="last_name" id="last_name" maxlength="30" value="<?php echo $user['last_name']; ?>" required disabled>
                        </div>
                        <div class="form-group">
                            <label class="label">Email:</label>
                            <input type="text" class="form-control" value="<?php echo $user['email']; ?>" disabled>
                        </div>
                        <div class="form-group">
                        <label class="label">Mobile Number:</label>
                            <input type="text" class="form-control" name="mobile" id="mobile" value="<?php echo $user['mobile']; ?>" maxlength="10" disabled minlength="10" required>
                        </div>
                        <div class="form-group">
                            <label class="label">Date of Birth(DD-MM-YYYY): </label>
                            <input type="date" class="form-control" name="dob" id="dob" value="<?php echo date('Y-m-d',strtotime($user['dob'])); ?>" required disabled>
                        </div>
                        <div class="form-group">
                            <label class="label">City:</label>
                            <input list="city_list" disabled value="<?php echo $user_city['name'].'-'.$user_city['state']; ?>" class="form-control" name="city" id="city" required>
                            
                            <datalist id="city_list">
                            <?php 
                                while($row = $city->fetch_array()){ 
                                $state = $conn->query("select name from state where id=".$row['state_id']);
                                $state = $state->fetch_array();
                                $row['state'] = $state['name'];
                            ?>
                            <option value="<?php echo $row['name'].'-'.$row['state']; ?>"><?php echo $row['name'].' - '.$row['state']; ?></option>
                            <?php } ?>
                            
                            </datalist>
                        </div>
                        <div class="form-group text-center">
                            <input type="submit" value="Change Data" id="personal_submit" class="btn btn-success" disabled>
                        </div>
                    </form>
                </div>
                <div class="col-lg-6 p-4">
                    <div class="p-0 m-0">
                        <div class="border border-success rounded p-4">
                            <h5 class="text-center mt-3 pt-1">Account Details </h5>
                            <hr>
                            <div class="form-group">
                                <label class="label">Current Stock Balance: <?php echo $stock_balance.' &#8377;'; ?></label><br>
                                <label class="label">Current Bank Balance: <?php echo $bank_balance.' &#8377;'; ?></label>
                                <div class="border rounded p-3">
                                <h6>Deposite / Withdraw Bank Account:</h6>
                                    
                                    <?php if($msg === "baldone"){ ?>
                                    <div class="alert alert-success h5" role="alert">Your Account balance is Updated... </div>
                                    <?php } else if($msg === "balfail"){ ?>
                                    <div class="alert alert-danger h5" role="alert">Your Account balance is not Updated... </div>
                                    <?php } ?>
                                    
                                    <form action="manage_balance.php" method="post" class="mt-3">
                                        <div class="input-group">
                                            <input type="number" class="form-control col-md-6 mb-3 float-left" placeholder="Rupees" name="rupees" id="rupees" min="0" required max="10000">
                                            <input type="number" class="form-control col-md-3 mb-3 float-left" placeholder="Paisa" name="paisa" id="paisa" min="0" required max="99">
                                            <input type="submit" class="form-control col-md-3 float-right btn-success" name="mode" value="Deposite">
                                        </div>
                                    </form>
                                    <form action="manage_balance.php" method="post" class="mt-3">
                                        <div class="input-group mt-3">
                                            <input type="number" class="form-control col-md-6 mb-3 float-left" placeholder="Rupees" name="rupees" id="rupees" min="0" required max="10000">
                                            <input type="number" class="form-control col-md-3 mb-3 float-left" placeholder="Paisa" name="paisa" id="paisa" min="0" required max="99">
                                            <input type="submit" class="form-control col-md-3 float-right btn-danger" name="mode" value="Withdraw">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="border border-success rounded p-5 mt-1">
                            <h5 class="text-center">Change Password <button type="button" id="pass_edit" onclick="visiblePassword()" class="rounded ml-3 btn btn-warning p-2">Edit</button></h5>
                            <hr>
                            <div class="form-group">
                                <form action="change_password.php" method="post" onsubmit="return checkpassword()">
                                
                                    <?php if($msg === "passdone"){ ?>
                                    <div class="alert alert-success h5" role="alert">Your Password is Updated... </div>
                                    <?php } else if($msg === "passfail"){ ?>
                                    <div class="alert alert-danger h5" role="alert">Your Password is not Updated... </div>
                                    <?php } ?>
                                
                                    <input type="password" class="form-control mb-2" placeholder="Password" name="password" id="pass" minlength="8" maxlength="24" required disabled>
                                    <input type="password" class="form-control mb-2" placeholder="Confirm Password" name="confirmpass" id="confirmpass" minlength="8" maxlength="24" required disabled>
                                    <label class="ml-4 form-check-label"><input type="checkbox" tabindex="-1" id="chkconfirmpass" name="chkconfirmpass" onchange='showPass("chkconfirmpass","confirmpass"); showPass("chkconfirmpass","pass");' class="form-check-input" disabled>Show Password</label>
                                    <div class="text-center"><input type="submit" id="sub_pass" class="btn btn-danger mb-0 mt-2" value="Change" disabled></div>
                                </form>
                            </div>
                        </div>
                    </div>        
                </div>
            </div>
        </div>
        <footer class="jumbotron blue darken-2 p-5 mb-0">
            <h5 class="text-white text-right"><i class="far fa-copyright"></i> Lampros Tech</h5>
        </footer>
        <script type="text/javascript">
            function checkPersonal(){
                var regex = /^[a-zA-z]+([\s][a-zA-Z]+)*$/;
                if(regex.test(document.getElementById('first_name').value) === false){
                    alert("First Name can not contain any symbol or number");
                    return false;
                }
                else if(regex.test(document.getElementById('last_name').value) === false){
                    alert("Last Name can not contain any symbol or number");
                    return false;
                }
                else{
                    return true;
                }
            }
            function visiblePersonal(){
                if(document.getElementById('first_name').disabled === true){
                    document.getElementById('first_name').disabled = false;
                    document.getElementById('last_name').disabled = false;
                    document.getElementById('mobile').disabled = false;
                    document.getElementById('dob').disabled = false;
                    document.getElementById('city').disabled = false;
                    document.getElementById('personal_submit').disabled = false;
                    document.getElementById('btn_edit').innerHTML = "Make Uneditable";
                }
                else{
                    document.getElementById('first_name').disabled = true;
                    document.getElementById('last_name').disabled = true;
                    document.getElementById('mobile').disabled = true;
                    document.getElementById('dob').disabled = true;
                    document.getElementById('city').disabled = true;
                    document.getElementById('personal_submit').disabled = true;
                    document.getElementById('btn_edit').innerHTML = "Make Editable";
                }
            }
            function showPass(chk,pass){
                var chk = document.getElementById(chk);
                if(chk.checked == true){
                    document.getElementById(pass).setAttribute("type","text");
                }
                else{
                    document.getElementById(pass).setAttribute("type","password");
                }
            }
            function visiblePassword(){
                if(document.getElementById('pass').disabled == true){
                    document.getElementById('pass').disabled = false;
                    document.getElementById('confirmpass').disabled = false;
                    document.getElementById('chkconfirmpass').disabled = false;
                    document.getElementById('sub_pass').disabled = false;
                    document.getElementById('pass_edit').innerHTML = "Make Uneditable";
                }
                else{
                    document.getElementById('pass').disabled = true;
                    document.getElementById('confirmpass').disabled = true;
                    document.getElementById('chkconfirmpass').disabled = true;
                    document.getElementById('sub_pass').disabled = true;
                    document.getElementById('pass_edit').innerHTML = "Make Editable";
                }
            }
            function checkpassword(){
                if(document.getElementById('pass').value != document.getElementById('confirmpass').value){
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
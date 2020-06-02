<?php
    include 'login_check.php'; 
    $company = $conn->query("select symbol,name from company");
?>
<!doctype html>
<html lang="en">
    <head>
        <title>Stocktastik - Journal - Add Stock</title>
        <?php include 'css_files.php'; ?>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <div class="container-fluid row p-5">
            <div class="col-md-3"></div>
            <form class="col-md-6 card p-3 pl-5 pr-5" method="post" action="insert_stock.php">
                <h3 class="text-center">Add Stock</h3>
                <hr class="bg-dark mb-3">
                <div class="container mt-3 mb-3">
                    <label class="label">Stock Name :<span class="text-danger">*</span></label>
                    <input list="names" class="form-control" name="name" id="name">
                    <datalist id="names">
                        
                        <?php while($row = $company->fetch_array()){ ?> 
                        <option value="<?php echo $row['symbol']; ?>"><?php echo $row['name']; ?></option>
                        <?php } ?>
                    
                    </datalist>
                </div>
                <div class="container mt-3">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="label">Date(DD/MM/YYYY) :<span class="text-danger">*</span></label>
                            <input class="form-control" type="date" onchange="time_max()" name="stock_date" id="stock_date" placeholder="Date(DD/MM/YYYY)" required>
                        </div>
                        <div class="col-md-6 ">
                            <label class="label">Time(HH:MM AM/PM) :<span class="text-danger">*</span></label>
                            <input class="form-control" type="time" name="stock_time" id="stock_time" placeholder="Time(HH:MM AM/PM)" required>
                        </div>
                    </div>
                </div>
                <div class="container mt-3">
                    <label class="label">Price (&#8377;):<span class="text-danger">*</span></label>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <input class="form-control" type="number" name="rupees" id="rupees" placeholder="Rupees" min="1" max="9999999999" required>
                        </div>
                        <div class="col-md-6">
                            <input class="form-control" type="number" name="paisa" id=" paisa" placeholder="Paisa" min="0" max="99" value="00" required>
                        </div>
                    </div>
                </div>
                <div class="container mt-3 mb-3">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="label">Quantity :<span class="text-danger">*</span></label>
                            <input class="form-control" type="number" name="quantity" id="quantity" min="1" max="99999" placeholder="Enter quantity of stock you bought" required>
                        </div>
                        <div class="col-md-6">
                            <label class="label">Rule Followed :<span class="text-danger"></span></label>
                            <select class="form-control" name="rule" id="rule">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="container text-center mt-3">
                    <input type="submit" class="btn btn-success" value="ADD">
                    <input type="button" class="btn btn-danger" onclick='location.href="journal.php"' value="Back">
                </div>
            </form>
            <div class="col-md-3"></div>
        </div>
        <footer class="jumbotron blue darken-2 p-5 mb-0">
            <h5 class="text-white text-right"><i class="far fa-copyright"></i> Lampros Tech</h5>
        </footer>
        <script type="text/javascript">
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth()+1;    
            var yyyy = today.getFullYear();
            if(dd<10){
                dd='0'+dd;
            } 
            if(mm<10){
                mm='0'+mm;
            } 
            var max_date = yyyy+'-'+mm+'-'+dd;
            document.getElementById("stock_date").setAttribute("max", max_date);
            function time_max(){
                var hour = today.getHours();
                var min = today.getMinutes();
                if(hour<10){
                    hour = '0'+hour;
                }
                if(min<10){
                    min = '0'+min;
                }
                var max_time = hour+":"+min ;
                if(document.getElementById("stock_date").value == max_date){
                    document.getElementById("stock_time").max = max_time;
                }
                else{
                    document.getElementById("stock_time").removeAttribute("max");
                }
            }
        </script>
        <?php include 'js_files.php'; ?>
    </body>
</html>
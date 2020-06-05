<?php
    include 'login_check.php';
    $msg = "";
    unset($_SESSION['stock']);
    unset($_SESSION['view_stock']);
    if(isset($_GET['msg'])){
        $msg = $_GET['msg'];
    }
    $limit = $search = $page = "";
    if(isset($_GET['limit'])){
        $limit = $_GET['limit'];
    }
    else{
        $limit = 10;
    }
    if(isset($_GET['search'])){
        $search = $_GET['search'];
    }
    if(isset($_GET['page'])){
        $page = $_GET['page'];
        if($page === "" || $page <= 0){
            $page = 1; 
        }
    }
    else{
        $page = 1;
    }
    $query = "select id, name,`date`,`time`,quantity,price,rule_follow,description from journal where user_id=$login";
    if(!($search === "")){
        $search = strtolower($search);
        $query .= " AND lower(name) like ('%$search%')";
    }
    $count = $conn->query($query);
    $query .= " limit ".(($page-1)*$limit).", $limit";
    $stock_data = $conn->query($query);
    $total_data = mysqli_num_rows($count);
    $total_page = ceil($total_data / $limit);
    if($page > $total_page){
        $page = $total_page;
    }
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
        <title>Stocktastik - Journal</title>
        <?php include 'css_files.php'; ?>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <h1 class="text-center mt-5">Your Journal</h1>
        <a href="add_stock.php" class="h3 text-right link mt-3 mr-5" style="display: block"><span class="border p-3"><i class="fas fa-plus"></i> Add Stock</span></a>
        <div class="row pl-5 pr-5 mt-3">
            <p class="col-md-6 text-center mt-4"><span class="text-primary bg-warning border rounded p-3 border-success h5 text-monospace">Bank Balance : <?php echo $bank_balance; ?></span></p>
            <p class="col-md-6 text-center mt-4"><span class="text-danger bg-warning border rounded p-3 border-success h5 text-monospace">Stock Balance : <?php echo $stock_balance; ?></span></p>
        </div>
        <div class="row text-center">
            <div class="col-4"></div>
            <div class="col-md-4 mt-3">
                <?php if($msg === "nobal"){ ?>
                <div class="alert alert-warning h5" role="alert">Not Enough balance in Bank Account...</div>
                <?php } else if($msg === "added"){ ?>
                <div class="alert alert-success h5" role="alert">Stock Added Successfully... </div>
                <?php } else if($msg === "notadded"){ ?>
                <div class="alert alert-warning h5" role="alert">Not Enough balance in Bank Account... </div>
                <?php } else if($msg === "stocksold"){ ?>
                <div class="alert alert-success h5" role="alert">Stock sold(Removed) Successfully... </div>
                <?php } else if($msg === "stockfail"){ ?>
                <div class="alert alert-warning h5" role="alert">Stock is not removed from account... </div>
                <?php } ?>
            </div>
            <div class="col-4"></div>
        </div>
        <div class="table-responsive p-5 text-center">
            <div class="clearfix">
                <div class="float-left w-25">
                    <select class="custom-select mr-sm-2 form-control" id="limit" onchange='location.href="journal.php?limit="+document.getElementById("limit").value+"&page=<?php echo $page; ?>&search=<?php echo $search; ?>"'>
                        <option <?php if($limit == 10) echo 'selected'; ?> value="10">10</option>
                        <option <?php if($limit == 25) echo 'selected'; ?> value="25">25</option>
                        <option <?php if($limit == 50) echo 'selected'; ?> value="50">50</option>
                    </select>
                </div>
                <div class="float-right w-50">
                    <input type="search" class="form-control" placeholder="Search Stocks" id="search" name="search" maxlength="40" value="<?php echo $search; ?>" onchange='location.href="journal.php?limit=<?php echo $limit; ?>&page=<?php echo $page; ?>&search="+document.getElementById("search").value'>
                </div>
            </div>
            <table class="table table-sm mt-3 table-striped border text-monospace">
                <caption>List of Stocks</caption>
                <thead class="bg-dark text-white">
                    <tr>
                        <td class="h6 p-2">Date</td>
                        <td class="h6 p-2">Time</td>
                        <td class="h6 p-2">Stock Name</td>
                        <td class="h6 p-2">Quantity</td>
                        <td class="h6 p-2">Currently Available</td>
                        <td class="h6 p-2">Entry Price</td>
                        <td class="h6 p-2">Total Entry Price</td>
                        <td class="h6 p-2">Rule Follow</td>
                        <td class="h6 p-2">Description</td>
                        <td class="h6 p-2">Action</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        while($row = $stock_data->fetch_array()){
                            $query = "select sum(quantity)'quantity' from sold_stock where stock_id=".$row['id'];
                            $result = $conn->query($query);
                            $minus_quantity = $result->fetch_array();
                            $minus_quantity = $minus_quantity['quantity'];
                            $available_quantity = $row['quantity']-$minus_quantity;
                            $name = $row['name'];
                            $query = "select name from company where symbol='$name'";
                            $result = $conn->query($query);
                            $name1 = $result->fetch_array();
                            $name = "$name(".$name1['name'].")";
                            echo '<tr class="text-nowrap">';
                            echo '<td class="border p-2">'.date ("d-M-Y",strtotime($row['date'])).'</td>';
                            echo '<td class="border p-2">'.date ("h:i A",strtotime($row['time'])).'</td>';
                            echo '<td class="border p-2">'.$name.'</td>';
                            echo '<td class="border p-2">'.$row['quantity'].'</td>';
                            echo '<td class="border p-2">'.$available_quantity.'</td>';
                            echo '<td class="border p-2">'.$row['price'].'&#8377;</td>';
                            echo '<td class="border p-2">'.($row['price']*$row['quantity']).'&#8377;</td>';
                            echo '<td class="border p-2">';
                            if($row['rule_follow'] == 0) echo 'NO'; else echo "YES";
                            echo '</td>';
                            echo '<td class="border p-2">'.$row['description'].'</td>'; ?>
                            <td class="border p-2">
                                <?php if($available_quantity > 0) {  ?> <button class="btn btn-link p-0 m-0" onclick=location.href="sell_session.php?id="+<?php echo $row['id']; ?>>Sell</button> <br> <?php } ?>
                                <?php if($minus_quantity > 0) {  ?> <button class="btn btn-link p-0 m-0 text-nowrap" onclick=location.href="view_sold_session.php?id=<?php echo $row['id']; ?>">View Sold</button> <?php } ?>
                            </td>
                            <?php echo '</tr>';
                        }
                    ?> 
                </tbody>
                <thead class="bg-dark text-white">
                    <tr>
                        <td class="h6 p-2">Date</td>
                        <td class="h6 p-2">Time</td>
                        <td class="h6 p-2">Stock Name</td>
                        <td class="h6 p-2">Quantity</td>
                        <td class="h6 p-2">Currently Available</td>
                        <td class="h6 p-2">Entry Price</td>
                        <td class="h6 p-2">Total Entry Price</td>
                        <td class="h6 p-2">Rule Follow</td>
                        <td class="h6 p-2">Description</td>
                        <td class="h6 p-2">Action</td>
                    </tr>
                </thead>
            </table>
            <?php if(!($total_page <= 1)){ ?>
            <div class="container-fluid row">
                <div class="col-md-3"></div>
                <ul class="pagination pg-blue col-md-9 ">
                    <li class="page-item <?php if($page <= 1) echo 'disabled'; ?>">
                        <a class="page-link border border-primary" href="journal.php?limit=<?php echo $limit; ?>&page=<?php echo '1'; ?>&search=<?php echo $search; ?>" aria-label="Previous"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a>
                    </li>
                    <li class="page-item <?php if($page <= 1) echo 'disabled'; ?>"><a class="page-link border border-primary" href="journal.php?limit=<?php echo $limit; ?>&page=<?php echo $page-1; ?>&search=<?php echo $search; ?>">Previous</a></li>
                    
                    <?php if($total_page <= 7){ ?>
                    <li class="page-item <?php if($page == 1) echo "active"; ?>"><a class="page-link border border-primary" href="journal.php?limit=<?php echo $limit; ?>&page=<?php echo '1'; ?>&search=<?php echo $search; ?>">1</a></li>
                    <?php if($total_page >= 2){ ?><li class="page-item <?php if($page == 2) echo "active"; ?>""><a class="page-link border border-primary" href="journal.php?limit=<?php echo $limit; ?>&page=<?php echo '2'; ?>&search=<?php echo $search; ?>">2</a></li>
                    <?php } if($total_page >= 3){ ?><li class="page-item <?php if($page == 3) echo "active"; ?>""><a class="page-link border border-primary" href="journal.php?limit=<?php echo $limit; ?>&page=<?php echo '3'; ?>&search=<?php echo $search; ?>">3</a></li>
                    <?php } if($total_page >= 4){ ?><li class="page-item <?php if($page == 4) echo "active"; ?>""><a class="page-link border border-primary" href="journal.php?limit=<?php echo $limit; ?>&page=<?php echo '4'; ?>&search=<?php echo $search; ?>">4</a></li>
                    <?php } if($total_page >= 5){ ?><li class="page-item <?php if($page == 5) echo "active"; ?>""><a class="page-link border border-primary" href="journal.php?limit=<?php echo $limit; ?>&page=<?php echo '5'; ?>&search=<?php echo $search; ?>">5</a></li>
                    <?php } if($total_page >= 6){ ?><li class="page-item <?php if($page == 6) echo "active"; ?>""><a class="page-link border border-primary" href="journal.php?limit=<?php echo $limit; ?>&page=<?php echo '6'; ?>&search=<?php echo $search; ?>">6</a></li>
                    <?php } if($total_page == 7){ ?><li class="page-item <?php if($page == 7) echo "active"; ?>"><a class="page-link border border-primary" href="journal.php?limit=<?php echo $limit; ?>&page=<?php echo '7'; ?>&search=<?php echo $search; ?>">7</a></li><?php } ?>
                    <?php } else{ 
                        
                        if($page == 1 || $page == 2 || $page == 3) {?>
                            <li class="page-item <?php if($page == 1) echo "active"; ?>"><a class="page-link border border-primary" href="journal.php?limit=<?php echo $limit; ?>&page=<?php echo '1'; ?>&search=<?php echo $search; ?>">1</a></li>
                            <li class="page-item <?php if($page == 2) echo "active"; ?>"><a class="page-link border border-primary" href="journal.php?limit=<?php echo $limit; ?>&page=<?php echo '2'; ?>&search=<?php echo $search; ?>">2</a></li>
                            <li class="page-item <?php if($page == 3) echo "active"; ?>"><a class="page-link border border-primary" href="journal.php?limit=<?php echo $limit; ?>&page=<?php echo '3'; ?>&search=<?php echo $search; ?>">3</a></li>
                            <li class="page-item disabled"><a class="page-link border border-primary">........</a></li>
                            <li class="page-item"><a class="page-link border border-primary" href="journal.php?limit=<?php echo $limit; ?>&page=<?php echo $total_page; ?>&search=<?php echo $search; ?>"><?php echo $total_page; ?></a></li>
                    <?php }else if($page == ($total_page) || $page == ($total_page-1) || $page == ($total_page-2)){ ?>
                            <li class="page-item"><a class="page-link border border-primary" href="journal.php?limit=<?php echo $limit; ?>&page=<?php echo '1'; ?>&search=<?php echo $search; ?>">1</a></li>
                            <li class="page-item disabled"><a class="page-link border border-primary">........</a></li>
                            <li class="page-item <?php if($page == ($total_page-2)) echo "active"; ?>"><a class="page-link border border-primary" href="journal.php?limit=<?php echo $limit; ?>&page=<?php echo ($total_page-2); ?>&search=<?php echo $search; ?>"><?php echo ($total_page-2); ?></a></li>
                            <li class="page-item <?php if($page == ($total_page-1)) echo "active"; ?>"><a class="page-link border border-primary" href="journal.php?limit=<?php echo $limit; ?>&page=<?php echo ($total_page-1); ?>&search=<?php echo $search; ?>"><?php echo ($total_page-1); ?></a></li>
                            <li class="page-item <?php if($page == $total_page) echo "active"; ?>"><a class="page-link border border-primary" href="journal.php?limit=<?php echo $limit; ?>&page=<?php echo $total_page; ?>&search=<?php echo $search; ?>"><?php echo $total_page; ?></a></li>
                    <?php }else{ ?>
                            <li class="page-item"><a class="page-link border border-primary" href="journal.php?limit=<?php echo $limit; ?>&page=<?php echo '1'; ?>&search=<?php echo $search; ?>">1</a></li>
                            <li class="page-item disabled"><a class="page-link border border-primary">........</a></li>
                            <li class="page-item"><a class="page-link border border-primary" href="journal.php?limit=<?php echo $limit; ?>&page=<?php echo ($page-1); ?>&search=<?php echo $search; ?>"><?php echo ($page-1); ?></a></li>
                            <li class="page-item active"><a class="page-link border border-primary" href="journal.php?limit=<?php echo $limit; ?>&page=<?php $page; ?>&search=<?php echo $search; ?>"><?php echo ($page); ?></a></li>
                            <li class="page-item"><a class="page-link border border-primary" href="journal.php?limit=<?php echo $limit; ?>&page=<?php echo ($page+1); ?>&search=<?php echo $search; ?>"><?php echo ($page+1); ?></a></li>
                            <li class="page-item disabled"><a class="page-link border border-primary">........</a></li>
                            <li class="page-item"><a class="page-link border border-primary" href="journal.php?limit=<?php echo $limit; ?>&page=<?php echo $total_page; ?>&search=<?php echo $search; ?>"><?php echo $total_page; ?></a></li>
                    <?php } }?>
                    <li class="page-item <?php if($page >= $total_page) echo "disabled"; ?>"><a class="page-link border border-primary" href="journal.php?limit=<?php echo $limit; ?>&page=<?php echo $page+1; ?>&search=<?php echo $search; ?>">Next</a></li>
                    <li class="page-item <?php if($page >= $total_page) echo "disabled"; ?>">
                        <a class="page-link border border-primary" href="journal.php?limit=<?php echo $limit; ?>&page=<?php echo $total_page; ?>&search=<?php echo $search; ?>" aria-label="Next"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a>
                    </li>

                </ul>
            </div> 
            <?php } ?>
        </div>
        <footer class="jumbotron blue darken-2 p-5 mb-0">
            <h5 class="text-white text-right"><i class="far fa-copyright"></i> Lampros Tech</h5>
        </footer>
        <?php include 'js_files.php'; ?>
    </body>
</html>
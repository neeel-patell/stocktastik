<?php
    include 'login_check.php';
    $msg = "";
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
    $query = "select name,`date`,`time`,quantity,price,rule_follow,description from journal where user_id=$login";
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
        <a href="add_stock.php" class="h3 text-right link mr-5" style="display: block"><span class="border p-3"><i class="fas fa-plus"></i> Add Stock</span></a>
        <div class="row text-center">
            <div class="col-4"></div>
            <div class="col-md-4">
                <?php if($msg === "nobal"){ ?>
                <div class="alert alert-warning h5" role="alert">Not Enough balance in Bank Account...</div>
                <?php } else if($msg === "added"){ ?>
                <div class="alert alert-success h5" role="alert">Stock Added Successfully... </div>
                <?php } else if($msg === "notadded"){ ?>
                <div class="alert alert-warning h5" role="alert">Not Enough balance in Bank Account... </div>
                <?php } ?>
            </div>
            <div class="col-4"></div>
        </div>
        <div class="table-responsive mt-3 p-5 text-center">
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
                        <td class="h5">Date</td>
                        <td class="h5">Time</td>
                        <td class="h5 w-25">Stock Name</td>
                        <td class="h5">Quantity</td>
                        <td class="h5">Entry Price</td>
                        <td class="h5">Rule Follow</td>
                        <td class="h5">Description</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        while($row = $stock_data->fetch_array()){
                            echo '<tr>';
                            echo '<td class="border">'.date ("d-M-Y",strtotime($row['date'])).'</td>';
                            echo '<td class="border">'.date ("H:i A",strtotime($row['time'])).'</td>';
                            echo '<td class="border">'.$row['name'].'</td>';
                            echo '<td class="border">'.$row['quantity'].'</td>';
                            echo '<td class="border">'.$row['price'].'</td>';
                            echo '<td class="border">';
                            if($row['rule_follow'] == 0) echo 'NO'; else echo "YES";
                            echo '</td>';
                            echo '<td class="border">'.$row['description'].'</td>'; ?>
                            <!-- <td class="border"><button class="btn btn-link p-2 m-0" onclick=location.href="sell_session.php?id="+<?php// echo $row['id']; ?>>Sell</button></td> -->
                            <?php echo '</tr>';
                        }
                    ?> 
                </tbody>
                <thead class="bg-dark text-white">
                    <tr>
                        <td class="h5">Date</td>
                        <td class="h5">Time</td>
                        <td class="h5 w-25">Stock Name</td>
                        <td class="h5">Quantity</td>
                        <td class="h5">Entry Price</td>
                        <td class="h5">Rule Follow</td>
                        <td class="h5">Description</td>
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
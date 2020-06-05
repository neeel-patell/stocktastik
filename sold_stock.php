<?php
    include 'login_check.php';
    $stock = 0;
    if(isset($_SESSION['view_stock']) == false){
        header('location: journal.php');
    }
    else{
        $stock = $_SESSION['view_stock'];
    }
    $query = "select name,price,date,time,quantity,rule_follow,description from journal where id=$stock";
    $result = $conn->query($query);
    $buy_data = $result->fetch_array();

    $stock_name = $buy_data['name'];
    $query = "select name from company where symbol='$stock_name'";
    $stock_name1 = $conn->query($query);
    $stock_name1 = $stock_name1->fetch_array();
    $stock_name .= " - ".$stock_name1['name'];
    
    $query = "select price,date,time,quantity,rule_follow,description from sold_stock where stock_id=$stock order by date desc";
    $stock_data = $conn->query($query);

    $query = "select sum(quantity)'quantity' from sold_stock where stock_id=$stock";
    $sold_quantity = $conn->query($query);
    $sold_quantity = $sold_quantity->fetch_array();
    $sold_quantity = $sold_quantity['quantity'];
    
    $available_quantity = $buy_data['quantity']-$sold_quantity;
    
    $sold_total = 0;
    while($row = $stock_data->fetch_array()){
        $sold_total = $sold_total + ($row['quantity']*$row['price']);
    }
    
    $sell_total = $buy_data['price']*$buy_data['quantity'];
    $profit_rupees = $sold_total - $sell_total;
    $profit = ($profit_rupees*100)/$sell_total;
    $profit = number_format($profit,2);

    $main_total = 0;
    mysqli_data_seek($stock_data,0);
?>
<!doctype html>
<html lang="en">
    <head>
        <title>Stocktastik - Sold Stock</title>
        <?php include 'css_files.php'; ?>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <h1 class="text-center mt-5">Sold stock</h1>
        <a href="journal.php" class="h6 link p-3 border text-white float-right bg-danger mr-5" style="display: inline-block">Go to Journal</a>
        <div class="table-responsive p-3 text-center">
            <div class="container border p-3 rounded border-dark">
                <p class="text-left text-primary">Buy Details</p>
                <h5>Name : <?php echo $stock_name; ?></h5>
                <h6>Date and Time : <?php echo date('d-M-Y',strtotime($buy_data['date']))." - ".date('H:i A',strtotime($buy_data['time'])); ?></h6>
                <h6>Entry Price : <?php echo $buy_data['price']." &#8377;"; ?></h6>
                <h6>Quantity : <?php echo $buy_data['quantity']; ?></h6>
                <h6>Total Entry Price : <?php echo $sell_total." &#8377;"; ?></h6>
                <h6>Rule Follow on entry : <?php if($buy_data['rule_follow'] == 0) echo "No"; else echo "Yes"; ?></h6>
                <?php if($buy_data['description'] != "") { ?>
                <h6>Description : <?php echo $buy_data['description']; ?></h6>
                <?php } ?>
            </div>
            
            <?php if($available_quantity == 0){ 
                if($profit >= 0) {?>
            <div class="container text-center">
                <span class="card p-3 mt-3 text-white bg-success h5" style="display: inline-block">Profit : <?php echo "$profit_rupees &#8377 / $profit %"; ?></span>
            </div>
            <?php } else { ?>
            <div class="container text-center">
                <span class="card p-3 mt-3 text-white bg-danger h5" style="display: inline-block">Loss : <?php echo (0-$profit_rupees)." &#8377; / ".(0-$profit)." %"; ?></span>
            </div>
            <?php }} else {?>
            <div class="container text-center">
                <span class="card p-3 mt-3 h6" style="display: inline-block">You can see profit/loss margin after selling all stocks you bought in this purchase</span>
            </div>
            <?php } ?>
            
            <table class="table table-sm mt-3 table-striped border text-monospace">
                <caption>List of Sold Stocks</caption>
                <thead class="bg-dark text-white">
                    <tr>
                        <td class="h6 p-2">Date</td>
                        <td class="h6 p-2">Time</td>
                        <td class="h6 p-2">Quantity</td>
                        <td class="h6 p-2">Exit Price</td>
                        <td class="h6 p-2">Total Exit Price</td>
                        <td class="h6 p-2">Rule Follow</td>
                        <td class="h6 p-2">Description</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        while($row = $stock_data->fetch_array()){
                            echo '<tr class="text-nowrap">';
                            echo '<td class="border p-2">'.date ("d-M-Y",strtotime($row['date'])).'</td>';
                            echo '<td class="border p-2">'.date ("h:i A",strtotime($row['time'])).'</td>';
                            echo '<td class="border p-2">'.$row['quantity'].'</td>';
                            echo '<td class="border p-2">'.$row['price'].'&#8377;</td>';
                            echo '<td class="border p-2">'.($row['price']*$row['quantity']).'&#8377;</td>';
                            echo '<td class="border p-2">';
                            if($row['rule_follow'] == 0) echo 'NO'; else echo "YES";
                            echo '</td>';
                            echo '<td class="border p-2">'.$row['description'].'</td>'; ?>
                            <?php echo '</tr>';
                        }
                    ?> 
                </tbody>
                <thead class="bg-dark text-white">
                    <tr>
                        <td class="h6 p-2">Date</td>
                        <td class="h6 p-2">Time</td>
                        <td class="h6 p-2">Quantity</td>
                        <td class="h6 p-2">Exit Price</td>
                        <td class="h6 p-2">Total Exit Price</td>
                        <td class="h6 p-2">Rule Follow</td>
                        <td class="h6 p-2">Description</td>
                    </tr>
                </thead>
            </table>
        </div>
        <footer class="jumbotron blue darken-2 p-5 mb-0">
            <h5 class="text-white text-right"><i class="far fa-copyright"></i> Lampros Tech</h5>
        </footer>
        <?php include 'js_files.php'; ?>
    </body>
</html>
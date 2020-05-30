<?php 
    $msg = "";
    if(isset($_GET['msg'])){
        $msg = $_GET['msg'];
    }
?>
<!doctype html>
<html lang="en">
    <head>
        <title>Stocktastik - Journal - Add Stock</title>
        <?php include 'css_files.php'; ?>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <nav class="navbar bg-light navbar-expand-lg">
            <button class="navbar-toggler text-right" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-chevron-circle-down fa-2x"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbar">
                <ul class="navbar-nav">
                    <li class="navbar-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="stock" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Stock
                        </a>
                        <div class="dropdown-menu text-center" aria-labelledby="stock">
                            <a class="dropdown-item" href="add_stock.php">Add Stock</a>
                            <a class="dropdown-item" href="view_stock.php">View Stock</a>
                        </div>
                    </li>
                    <li class="navbar-item">
                        <a class="nav-link" href="manage_balance.php">Manage Balance</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="container-fluid row p-5">
            <div class="col-md-3"></div>
            <form class="col-md-6 card p-3 pl-5 pr-5" method="post" action="insert_stock.php">
                <h3 class="text-center">Add Stock</h3>
                <hr class="bg-dark mb-3">
                
                <?php if($msg === "nobal"){ ?>
                <div class="alert alert-danger text-center" role="alert">Not Enough Balance ...</div>
                <?php }else if($msg === "added"){ ?>
                <div class="alert alert-success text-center" role="alert">Stock Added ...</div>
                <?php }else if($msg === "notadded"){ ?>
                <div class="alert alert-success text-center" role="alert">Stock has not Added ...</div>
                <?php } ?>
                
                <div class="container mt-3">
                    <label class="label">Name :<span class="text-danger">*</span></label>
                    <input class="form-control" type="text" name="name" id="name" placeholder="Enter Name" maxlength="40" required autofocus>
                </div>
                <div class="container mt-3">
                    <label class="label">Price :<span class="text-danger">*</span></label>
                    <div class="row">
                        <div class="col-6">
                            <input class="form-control" type="number" name="rupees" id="rupees" placeholder="Rupees" min="1" max="99999999" required autofocus>
                        </div>
                        <div class="col-6">
                            <input class="form-control" type="number" name="paisa" id="paisa" placeholder="Paisa" min="0" max="99" value="00" required autofocus>
                        </div>
                    </div>
                </div>
                <div class="container mt-3">
                    <label class="label">Quantity :<span class="text-danger">*</span></label>
                    <input class="form-control" type="number" name="quantity" id="quantity" min="1" max="99999" placeholder="Enter quantity of stock you bought" required autofocus>   
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
            <h5 class="text-monospace text-xl-center text-white"> - By Neeel-Patell</h5>
        </footer>
        <?php include 'js_files.php'; ?>
    </body>
</html>
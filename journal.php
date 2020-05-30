<!doctype html>
<html lang="en">
    <head>
        <title>Stocktastik - Journal</title>
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
        <footer class="jumbotron blue darken-2 p-5 mb-0">
            <h5 class="text-white text-right"><i class="far fa-copyright"></i> Lampros Tech</h5>
            <h5 class="text-monospace text-xl-center text-white"> - By Neeel-Patell</h5>
        </footer>
        <?php include 'js_files.php'; ?>
    </body>
</html>
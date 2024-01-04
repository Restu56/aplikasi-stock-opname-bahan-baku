<?php 
require 'function.php';
require 'cek.php';


//get data 
// ambil data total stock
$getstock  = mysqli_query($conn, "select * from stock");
$countstock = mysqli_num_rows($getstock); // menghitung seluruh kolom 

// ambil data total masuk
$getmasuk  = mysqli_query($conn, "select * from masuk");
$countmasuk = mysqli_num_rows($getmasuk);

// ambil data total keluar
$getkeluar  = mysqli_query($conn, "select * from keluar");
$countkeluar = mysqli_num_rows($getkeluar);

// data chart stock
$qry1 = mysqli_query($conn, "select jenis, sum(stock) as 'jumlah' from stock group by jenis");
foreach ($qry1 as $data1){
    $jenis[] = $data1['jenis'];
    $jumlah[] = $data1['jumlah'];
}

// data chart masuk
$juli = mysqli_query($conn, "SELECT  SUM(qty) as 'juli' FROM masuk WHERE tanggal BETWEEN '2022-07-01' AND '2022-07-30';");
$agustus = mysqli_query($conn, "SELECT  SUM(qty) as 'agustus' FROM masuk WHERE tanggal BETWEEN '2022-08-01' AND '2022-08-19';");


; ?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Index</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-light bg-light">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php">
                <img src="gambar/logo.png" alt="" weight="35" height="45" />
            </a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>            
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link text-primary" href="dashboard.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-chart-line"></i></div>
                                Dashboard
                            </a>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-boxes-packing"></i></div>
                                Stock Barang
                            </a>
                            <a class="nav-link" href="masuk.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-box-open"></i></div>
                                Barang Masuk
                            </a>
                            <a class="nav-link" href="keluar.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-truck-ramp-box"></i></div>
                                Barang Keluar
                            </a>
                            <a class="nav-link" href="stock_opname.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-boxes-stacked"></i></div>
                                Stock Opname
                            </a>
                            <a class="nav-link" href="stock_opname.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-boxes-stacked"></i></div>
                                About
                            </a>
                            <a class="nav-link" href="logout.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-right-from-bracket"></i></div>
                                Logout
                            </a> 
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h4 class="mt-4"><strong><i class="fa-solid fa-chart-line"></i> DASHBOARD</strong></h4>
                        <div class="card mb-8 bg-white">
                            <div class="card-header">                           
                                <div class="row">
                                    <div class="col">
                                        <div class="card bg-danger  text-white p-3">
                                            <h1 class="text-center"><i class="fa-solid fa-boxes-packing"></i></h1>
                                            <h5 class="text-center">Total Barang Stock  : <?=$countstock;?></h5>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card bg-warning  text-white p-3">
                                            <h1 class="text-center"><i class="fa-solid fa-box-open"></i></h1>
                                            <h5 class="text-center">Total Barang Masuk : <?=$countmasuk;?></h5>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card bg-primary  text-white p-3">
                                            <h1 class="text-center"><i class="fa-solid fa-truck-ramp-box"></i></h1>
                                            <h5 class="text-center">Total Barang Keluar : <?=$countkeluar;?></h5>
                                        </div>
                                    </div>  
                                </div>
                                <div class="row pt-2" >                                  
                                    <div class="col-xl-6" width="500px">
                                        <div class="card mb-4 bg-light text-dark">
                                            <div class="card-header" >
                                                <i class="fas fa-chart-column me-1"></i>
                                                 Stock Barang
                                            </div> 
                                            <div class="card-body">                                               
                                                <canvas id="piechart"></canvas>
                                            </div>                                           
                                        </div>
                                    </div>
                                    <div class="col-xl-6" width="500px">
                                        <div class="card mb-4 bg-light text-dark">
                                            <div class="card-header" >
                                                <i class="fas fa-chart-column me-1"></i>
                                                 Barang Masuk
                                            </div> 
                                            <div class="card-body">                                               
                                                <canvas id="barchart"></canvas>
                                            </div>                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const pie = document.getElementById('piechart');

            new Chart(pie, {
            type: 'bar',
            data: {
                labels: ['Additive', 'Binder', 'Filler', 'pigment', 'Solvent',],
                datasets: [{
                    label: '# of Votes',
                    data: <?php echo json_encode($jumlah);?>,
                    backgroundColor: [
                        'rgb(230, 25, 25)',
                        'rgb(245, 129, 5)',
                        'rgb(251, 255, 8)',
                        'rgb(0, 247, 12)',
                        'rgb(5, 151, 255)'
                    ],
                borderWidth: 1
                }]
            },
            options: {
                scales: {
                y: {
                    beginAtZero: true
                }
                }
            }
            });
        </script>
         <script>
            const bar = document.getElementById('barchart');

            new Chart(bar, {
            type: 'bar',
            data: {
                labels: ['Januari', 'Februari', 'Maret', 'April', 
                        'May', 'Juni', 'Juli', 'August', 'September', 
                        'Oktober', 'November', 'Desember'],
                    datasets: [{
                    label: '# of Votes',
                    data: [1022, 2023, 1945, 2336, 3667, 2009, 3007, 2097, 3097, 2982, 2021, 2087],
                    backgroundColor: [
                        'rgb(5, 151, 255)',
                        'rgb(5, 151, 255)',
                        'rgb(5, 151, 255)',
                        'rgb(5, 151, 255)',
                        'rgb(5, 151, 255)',
                        'rgb(5, 151, 255)',
                        'rgb(5, 151, 255)',
                        'rgb(5, 151, 255)',
                        'rgb(5, 151, 255)',
                        'rgb(5, 151, 255)',
                        'rgb(5, 151, 255)',
                        'rgb(5, 151, 255)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                y: {
                    beginAtZero: true
                }
                }
            }
            });
        </script>
         <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>

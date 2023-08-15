<?php 
require 'function.php';
require 'cek.php';

; ?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard - SB Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-light bg-light">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="stock_opname.php">
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
                            <a class="nav-link" href="dashboard.php">
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
                            <a class="nav-link text-primary" href="stock_opname.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-boxes-stacked"></i></div>
                                Stock Opname
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
                        <h4 class="mt-4"><strong><i class="fa-solid fa-boxes-stacked"></i>STOCK OPNAME</strong></h4>
                        <div class="card mb-4">
                            <div class="card-header">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahso">
                                <i class="fa-solid fa-plus"></i>Tambah SO
                                </button>
                               <button type="button" class="btn btn-danger">
                               <i class="fa-solid fa-file"></i> Export Data
                                </button>
                                <div class="container p-1">
                                        <div class="row">
                                            <form action="post" class="form-inline"></form>
                                            <div class="col">
                                                <input type="date" name="tglmulai" class="form-control">
                                            </div>
                                            <div class="col">
                                                <input type="date" name="tglmulai" class="form-control">
                                            </div>                                           
                                            <div class="col">
                                                <button type="submit" name="filtertgl" class="btn btn-primary">Filter</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <div class="card-body">
                            <div class="table-responsive">
                                <table  class="table table-bordered table-striped" id="datatablesSimple" width="100%" cellspasing="0">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No.</th>
                                            <th>Tanggal</th>
                                            <th>Nama Barang</th>
                                            <th>Stock Sistem</th>
                                            <th>Stock Fisik</th>
                                            <th>Selisih</th>
                                            <th>Selisih dana</th>
                                            <th>Petugas</th>
                                            <th>Keterangan</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                        if(isset($_POST['filtertgl'])){
                                            
                                            $mulai = $_POST['tgl_mulai'];
                                            $akhir = $_POST['tgl_akhir'];
                                            if($mulai != null || $akhir != null){
                                            
                                                $ambilsemuadatastock = mysqli_query($conn, "select * from stockopname so, stock s where s.idbarang = so.idbarang and
                                                 tanggal BETWEEN  '$mulai' and DATE_ADD('$akhir', INTERVAL 1 DAY) order by idstockopname DESC"); 
                                            } else {
                                                $ambilsemuadatastock = mysqli_query($conn, "select * from stockopname so, stock s where s.idbarang = so.idbarang  ORDER BY idstockopname DESC");
                                            }
                                        
                                        
                                        } else {
                                            $ambilsemuadatastock = mysqli_query($conn, "select * from stockopname so, stock s where s.idbarang = so.idbarang");

                                        }                                      
                                        $i=1;
                                        while($data=mysqli_fetch_array($ambilsemuadatastock)){
                                            $ids = $data['idstockopname'];
                                            $idb = $data['idbarang'];
                                            $tanggal =$data['tanggal'];
                                            $namabarang = $data['namabarang'];
                                            $jenis = $data['jenis'];
                                            $qty = $data['stocksistem'];
                                            $stockfisik = $data['stockfisik'];
                                            $selisih = $data['selisih'];
                                            $petugas = $data['petugas'];
                                            $keterangan = $data['keterangan'];
                                            $harga = $data['harga'];
                                            $selisihharga = $data['selisih_harga'] ;
                                                                                    
                                        ; ?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><?=$tanggal;?></td>
                                            <td><?=$namabarang;?></td>
                                            <td><?=$qty;?></td>
                                            <td><?=$stockfisik;?></td>
                                            <td><?=$selisih;?></td>
                                            <td>Rp. <?= number_format($selisihharga,2,',','.')   ;?></td>
                                            <td><?=$petugas;?></td>
                                            <td><?=$keterangan;?></td>

                                        </tr>
                                         <!-- Edit Modal -->
                                        <div class="modal" id="edit<?=$ids;?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"><strong>EDIT STOCK OPNAME</strong></h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="post">
                                                        <div class="modal-body">
                                                            <input type="number" name="stockfisik" value="<?=$stockfisik;?>" class="form-control" placeholder="Stock fisik" required>
                                                            <br>
                                                            <input type="text" name="petugas" value="<?=$petugas;?>" class="form-control" placeholder="Petugas" required>
                                                            <br>
                                                            <input type="hidden" name="idb" value="<?=$idb;?>">
                                                            <input type="hidden" name="idm" value="<?=$ids;?>">
                                                            <button type="submit" class="btn btn-primary" name="updatebarangso">Submit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>                                       
                                        <?php 
                                        } 
                                        ; ?>                                  
                                    </tbody>
                                </table>  
                            </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
    <!-- The Modal -->
    <div class="modal" id="tambahso">
        <div class="modal-dialog">
            <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Stock Opname</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <form method="post">
            <div class="modal-body">
                <select name="barangnya" class="form-control">
                    <?php  
                        $ambilsemuadatanya = mysqli_query($conn, "select * from stock");
                        while($fetcharray = mysqli_fetch_array($ambilsemuadatanya)){
                            $namabarangnya = $fetcharray['namabarang'];
                            $idbarangnya = $fetcharray['idbarang'];

                    ?>    
                        
                        <option value="<?=$idbarangnya;?>"><?=$namabarangnya;?></option>

                    <?php  
                        }
                    ?>         
                </select>
                <br>
                <input type="number" name="stockfisik" min="1" max="10000" step="0.01" placeholder="Stock fisik" class="form-control" required>
                <br>
                <input type="text" name="petugas" placeholder="Petugas" class="form-control" required>
                <br>
                <button type="submit" class="btn btn-primary" name="tambahbarangso">Submit</button>
            </div>
            </form>
        </div>
    </div>
</html>

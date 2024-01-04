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
            <a class="navbar-brand ps-3" href="keluar.php">
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
                            <a class="nav-link text-primary" href="keluar.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-truck-ramp-box"></i></div>
                                Barang Keluar
                            </a>
                            <a class="nav-link" href="stock_opname.php">
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
                        <h4 class="mt-4"><strong><i class="fa-solid fa-truck-ramp-box"></i>BARANG KELUAR</strong></h4>
                        <div class="card mb-4">
                            <div class="card-header">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah">
                                    <i class="fa-solid fa-plus"></i> Tambah Barang
                                </button>
                                    <a href="export_keluar.php" type="button" class="btn btn-danger">Export Data</a>
                                </button>
                                <form method="post" class="row g-3 mt-1">
                                    <div class="col-md-3">
                                        <input type="date" class="form-control" name="tgl_mulai">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="date" class="form-control" name="tgl_akhir">
                                    </div>
                                    <div class="col-md-3">
                                        <button class="btn btn-primary" name="filtertglkeluar">Filter</button>
                                    </div>
                                </form> 
                            </div>                      
                            <div class="card-body">
                                <table  class="table table-bordered table-striped" id="datatablesSimple" width="100%" cellspasing="0">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Tanggal</th>
                                            <th>Nama Barang</th>
                                            <th>Jumlah</th>
                                            <th>Total Harga</th>
                                            <th>Petugas</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                        $i=1;
                                        if(isset($_POST['filtertglkeluar'])){
                                            
                                            $mulai = $_POST['tgl_mulai'];
                                            $akhir = $_POST['tgl_akhir'];
                                            if($mulai != null || $akhir != null){
                                            
                                                $ambilsemuadatastock = mysqli_query($conn, "select * from keluar k, stock s where s.idbarang = k.idbarang and
                                                 tanggal BETWEEN  '$mulai' and DATE_ADD('$akhir', INTERVAL 1 DAY) order by idkeluar DESC"); 
                                            } else {
                                                $ambilsemuadatastock = mysqli_query($conn, "select * from keluar k, stock s where s.idbarang = k.idbarang  ORDER BY idkeluar DESC");
                                            }
                                        
                                        
                                        } else {
                                            $ambilsemuadatastock = mysqli_query($conn, "select * from keluar k, stock s where s.idbarang = k.idbarang");

                                        }
                                        while($data=mysqli_fetch_array($ambilsemuadatastock)){
                                            $idk = $data['idkeluar'];
                                            $idb = $data['idbarang'];
                                            $tanggal = $data['tanggal'];
                                            $namabarang = $data['namabarang'];
                                            $qty = $data['qty'];
                                            $total = $data['harga'] * $data['qty'];
                                            $petugas = $data['petugas'];

                                        ; ?>
                                        <tr>
                                            <td><?=$i++;?>.</td>
                                            <td><?=$tanggal;?></td>
                                            <td><?=$namabarang;?></td>
                                            <td><?=$qty;?></td>
                                            <td>Rp.<?=number_format($total,'2',',','.');?></td>
                                            <td><?=$petugas;?></td>
                                            <td>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit<?=$idk;?>"><i class="fa-solid fa-pen-to-square"></i></button>
                                                <input type="hidden" name="idbarangyangmaudihapus" value="<?=$idb;?>">
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?=$idk;?>"><i class="fa-solid fa-trash-can"></i></button>     
                                            </td>

                                        </tr>
                                        <!-- Edit Modal -->
                                        <div class="modal" id="edit<?=$idk;?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"><strong>EDIT BARANG</strong></h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="post">
                                                        <div class="modal-body">
                                                            <input type="text" name="penerima" value="<?=$petugas;?>" class="form-control" required>
                                                            <br>
                                                            <input type="number" name="qty" value="<?=$qty;?>" class="form-control" required>
                                                            <br>
                                                            <input type="hidden" name="idb" value="<?=$idb;?>">
                                                            <input type="hidden" name="idk" value="<?=$idk;?>">
                                                            <button type="submit" class="btn btn-primary" name="updatebarangkeluar">Submit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Delete Modal -->
                                        <div class="modal" id="delete<?=$idk;?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <!-- Modal Header -->
                                                    <div class="modal-header">
                                                        <h4 class="modal-title"><strong>HAPUS BARANG</strong></h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <form method="post">
                                                        <div class="modal-body">
                                                            Apakah Anda yakin akan menghapus <strong><?=$namabarang;?></strong> ?
                                                            <input type="hidden" name="idb" value="<?=$idb;?>">
                                                            <input type="hidden" name="kty" value="<?=$qty;?>">
                                                            <input type="hidden" name="idk" value="<?=$idk;?>">
                                                            <br>
                                                            <br>
                                                            <button type="submit" class="btn btn-danger" name="hapusbarangkeluar">Hapus</button>
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
    <div class="modal" id="tambah">
        <div class="modal-dialog">
            <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Barang Keluar</h4>
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
                <input type="number" name="qty" placeholder="Jumlah.." class="form-control" required>
                <br>
                <input type="text" name="petugas" placeholder="Petugas.." class="form-control" required>
                <br>
                <input type="text" name="penerima" placeholder="Penerima.." class="form-control" required>
                <br>
                <button type="submit" class="btn btn-primary" name="addbaranagkeluar">Submit</button>
            </div>
            </form>
        </div>
    </div>
</html>

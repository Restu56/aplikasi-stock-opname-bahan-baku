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
        <title>Barang Masuk</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-light bg-light">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="masuk.php">
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
                            <a class="nav-link text-primary" href="masuk.php">
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
                        <h4 class="mt-4"><strong><i class="fa-solid fa-box-open"></i>BARANG MASUK</strong></h4>
                        <div class="card mb-4">
                            <div class="card-header">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah">
                                    <i class="fa-solid fa-plus"></i> Tambah Barang
                                </button>
                                    <a href="export_masuk.php" type="button" class="btn btn-danger">Export Data</a>
                                </button>
                                <form method="post" class="row g-3 mt-1">
                                    <div class="col-md-3">
                                        <input type="date" class="form-control" name="tgl_mulai">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="date" class="form-control" name="tgl_akhir">
                                    </div>
                                    <div class="col-md-3">
                                        <button class="btn btn-primary" name="filtertglmasuk">Filter</button>
                                    </div>
                                </form>
                                
                            </div>       
                            <div class="card-body">
                                <div class="datatablesSimple">                    
                                    <table  class="table table-bordered table-striped" id="datatablesSimple" width="100%" cellspasing="0">                                                           
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Nama Barang</th>
                                                <th>Jumlah</th>
                                                <th>Petugas</th>
                                                <th>Aksi</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            if(isset($_POST['filtertglmasuk'])){
                                                $mulai = $_POST['tgl_mulai'];
                                                $akhir = $_POST['tgl_akhir'];
                                                if($mulai != null || $akhir != null){
                                                
                                                    $ambilsemuadatastock = mysqli_query($conn, "select * from masuk m, stock s  where s.idbarang = m.idbarang and
                                                   tanggal BETWEEN  '$mulai' and DATE_ADD('$akhir', INTERVAL 1 DAY) order by idmasuk DESC"); 
                                                } else {
                                                    $ambilsemuadatastock = mysqli_query($conn, "select * from masuk m, stock s  where s.idbarang = m.idbarang  ORDER BY idmasuk DESC");
                                                }
                                            
                                            
                                            } else {
                                                $ambilsemuadatastock = mysqli_query($conn, "select * from masuk as m, stock as s  where s.idbarang = m.idbarang");

                                            }
                                            while($data=mysqli_fetch_array($ambilsemuadatastock)){
                                                $idm = $data['idmasuk'];
                                                $idb = $data['idbarang'];
                                                $tanggal = $data['tanggal'];
                                                $namabarang = $data['namabarang'];
                                                $qty = $data['qty'];
                                                $petugas = $data['petugas'];

                                                                                        
                                            ; ?>
                                            <tr>
                                                <td><?=$tanggal;?></td> 
                                                <td><?=$namabarang;?></td>   
                                                <td><?=$qty;?></td>   
                                                <td><?=$petugas;?></td>                
                                                <td>
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit<?=$idm;?>"><i class="fa-solid fa-pen-to-square"></i></button>
                                                    <input type="hidden" name="idbarangyangmaudihapus" value="<?=$idb;?>">
                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?=$idm;?>"><i class="fa-solid fa-trash-can"></i></button>     
                                            
                                                </td>

                                            </tr>
                                            <!-- Edit Modal -->
                                            <div class="modal" id="edit<?=$idm;?>">
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
                                                                <input type="datetime" name="tgl" value="<?=$tanggal;?>" class="form-control" placeholder="tanggal" required>
                                                                <br>       
                                                                <input type="text" name="idb" value="<?=$idb;?>" class="form-control" placeholder="id barang" required>
                                                                <br>
                                                                <input type="number" min="1" max="1000" step="0.01" name="qty" value="<?=$qty;?>" class="form-control" placeholder="Jumlah" required>
                                                                <br>
                                                                <input type="hidden" name="idm" value="<?=$idm;?>">
                                                                <button type="submit" class="btn btn-primary" name="updatebarangmasuk">Submit</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Delete Modal -->
                                            <div class="modal" id="delete<?=$idm;?>">
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
                                                                <input type="hidden" name="idm" value="<?=$idm;?>">
                                                                <br>
                                                                <br>
                                                                <button type="submit" class="btn btn-danger" name="hapusbarangmasuk">Hapus</button>
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
                <h4 class="modal-title">Barang Masuk</h4>
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
                <input type="number" min="1" max="1000" step="0.01" name="qty" placeholder="Jumlah" class="form-control" required>
                <br>
                <input type="text" name="petugas" placeholder="petugas" class="form-control">
                <br>
                <button type="submit" class="btn btn-primary" name="barangmasuk">Submit</button>
            </div>
            </form>
        </div>
    </div>
</html>

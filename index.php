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
                            <a class="nav-link" href="dashboard.php">
                                <div class="sb-nav-link-icon"><i class="fa-solid fa-chart-line"></i></div>
                                Dashboard
                            </a>
                            <a class="nav-link text-primary" href="index.php">
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
                        <h4 class="mt-4"><strong><i class="fa-solid fa-boxes-packing"></i> STOCK BARANG</strong></h4>
                        <div class="card mb-4">
                            <div class="card-header">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah">
                                    <i class="fa-solid fa-plus"></i> Tambah Barang
                                </button>
                                    <a href="export_stock.php" type="button" class="btn btn-danger">Export Data</a>
                                </button>
                            </div>
                            <div class="card-body">
                                <table  class="table table-bordered table-striped" id="datatablesSimple" width="100%" cellspasing="0">
                                   
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>kode</th>
                                            <th>Nama Barang</th>
                                            <th>Jenis</th>
                                            <th>Stock</th>
                                            <th>Harga</th>
                                            <th>Total</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $ambilsemuadatastock = mysqli_query($conn, "select * from stock");
                                        $i = 1;
                                        while($data=mysqli_fetch_array($ambilsemuadatastock)){
                                            $namabarang = $data['namabarang'];
                                            $kode = $data['kode'];
                                            $jenis = $data['jenis'];
                                            $stock = $data['stock'];
                                            $idb = $data['idbarang']; 
                                            $harga = $data['harga'];
                                            $total = $data['harga'] * $data['stock']                                        
                                        ; ?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><?=$kode;?></td>
                                            <td><?=$namabarang;?></td>
                                            <td><?=$jenis;?></td>
                                            <td><?=$stock;?></td>
                                            <td>Rp. <?= number_format($harga,2,',','.');?></td>
                                            <td>Rp. <?= number_format($total,2,',','.');?></td>
                                            <td>
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit<?=$idb;?>"><i class="fa-solid fa-pen-to-square"></i></button>
                                                <input type="hidden" name="idbarangyangmaudihapus" value="<?=$idb;?>">
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?=$idb;?>"><i class="fa-solid fa-trash-can"></i></button>     
                                            </td>
                                        </tr>
                                        <!-- Edit Modal -->
                                        <div class="modal" id="edit<?=$idb;?>">
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
                                                            <input type="text" name="kode" value="<?=$kode;?>" class="form-control" placeholder="kode" required>
                                                            <br>
                                                            <input type="text" name="namabarang" value="<?=$namabarang;?>" class="form-control" placeholder="nama barang" required>
                                                            <br>
                                                            <input type="text" name="jenis" value="<?=$jenis;?>" class="form-control" placeholder="jenis" required>
                                                            <br>
                                                            <input type="number" min="<?=$harga;?> - 10000" max="1000000" step="1000" name="harga" value="<?=$harga;?>" class="form-control" placeholder="jenis" required>
                                                            <input type="hidden" name="idb" value="<?=$idb;?>">
                                                            <br>
                                                            <button type="submit" class="btn btn-primary" name="updatebarang">Submit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Delete Modal -->
                                        <div class="modal" id="delete<?=$idb;?>">
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
                                                            <br>
                                                            <br>
                                                            <button type="submit" class="btn btn-danger" name="hapusbarang">Hapus</button>
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
                    <h4 class="modal-title">Tambah Barang</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <form method="post">
                    <div class="modal-body">
                        <input type="text" name="kode" placeholder="Kode.." class="form-control" required>
                        <br>
                        <input type="text" name="namabarang" placeholder="Nama Barang.." class="form-control" required>
                        <br>
                        <input type="text" name="jenis" placeholder="Jenis.." class="form-control" required>
                        <br>
                        <input type="number" name="stock" placeholder="Quantity.." class="form-control" required>
                        <br>
                        <input type="number" name="harga" placeholder="Harga per satuan.." class="form-control" required>
                        <br>
                        <button type="submit" class="btn btn-primary" name="tambahbarangbaru">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</html>

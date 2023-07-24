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
    <title>Stock Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
  </head>
  <body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
      <!-- Navbar Brand-->
      <a class="navbar-brand ps-3" href="index.php">
        <img src="gambar/logo.png" alt="" weight="35" height="45" />
      </a>
      <!-- Sidebar Toggle-->
      <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    </nav>
    <div id="layoutSidenav">
      <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
          <div class="sb-sidenav-menu">
            <div class="nav">
              <a class="nav-link" href="index.php">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Stock Barang
              </a>
              <a class="nav-link" href="masuk.php">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Barang Masuk
              </a>
              <a class="nav-link" href="keluar.php">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Barang Keluar
              </a>
              <a class="nav-link" href="stock_opname.php">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Stock Opname
              </a>
              <a class="nav-link" href="logout.php"> Logout </a>
            </div>
          </div>
        </nav>
      </div>
      <div id="layoutSidenav_content">
        <main>
          <div class="container-fluid px-4">
            <h4 class="mt-4"><strong>STOCK BARANG</strong></h4>
            <ol class="breadcrumb mb-4">
              <li class="breadcrumb-item active">Lorem ipsum dolor sit amet consectetur adipisicing elit. Aperiam, voluptatibus.</li>
            </ol>

            <div class="card mb-4">
              <div class="card-header">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahstock">Tambah Barang</button>
                <a href="export.php" class="btn btn-danger">Export Data</a>
              </div>
              <div class="card-body">
                <?php  
                                    $ambildatastock = mysqli_query($conn, "select * from stock where stock < 1");

                                    while($fetch=mysqli_fetch_array($ambildatastock)){
                                        $barang = $fetch['namabarang'];
                                    

                                ?>
                <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                  <strong>Perhatian!</strong> Stock
                  <?=$barang;?>telah habis
                </div>
                <?php 
                                };
                                ?>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspasing="0">
                    <thead class="table table-dark">
                      <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>jenis</th>
                        <th>Stock</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php  
                                        $ambilsemuadatastock = mysqli_query($conn,"select * from stock");
                                        $i=1;
                                        while($data=mysqli_fetch_array($ambilsemuadatastock)){
                                            $namabarang = $data['namabarang'];
                                            $jenis = $data['jenis'];
                                            $stock = $data['stock'];
                                            $idb = $data['idbarang'];
                                        ;?>

                      <tr>
                        <td><?=$i++;?></td>
                        <td><?=$namabarang;?></td>
                        <td><?=$jenis;?></td>
                        <td><?=$stock;?></td>
                        <td>
                          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit">Edit</button>
                          <!-- <input type="hidden" name="idbarangyangmaudihapus" value="<?=$idb;?>"> -->
                          <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#del">Delete</button>
                        </td>
                      </tr>
                      <!-- Edit Modal -->
                      <div class="modal fade" id="edit">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Edit Barang</h4>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                              <br />
                            </div>

                            <form method="post">
                              <div class="modal-body">
                                <input type="text" name="namabarang" placeholder="Nama Bahan Baku" class="form-control" required />
                                <br />
                                <input type="text" name="jenis" placeholder="Jenis Bahan Baku" class="form-control" required />
                                <br />
                                <input type="number" name="stock" class="form-control" placeholder="Stock" required />
                                <br />
                                <button type="submit" class="btn btn-primary" name="addnewbarang">Submit</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>

                      <!-- Delete Modal -->
                      <div class="modal fade" tabindex="-1" id="del">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                              <h4 class="modal-title">Delete Barang</h4>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                              <br />
                            </div>

                            <!-- Modal body -->
                            <form method="post">
                              <div class="modal-body">
                                <input type="text" name="namabarang" placeholder="Nama Bahan Baku" class="form-control" required />
                                <br />
                                <input type="text" name="jenis" placeholder="Jenis Bahan Baku" class="form-control" required />
                                <br />
                                <input type="number" name="stock" class="form-control" placeholder="Stock" required />
                                <br />
                                <button type="submit" class="btn btn-primary" name="addnewbarang">Submit</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                      <?php  
                                        }
                                        ;?>
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
  <div class="modal fade" id="tambahstock">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Tambah Barang</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          <br />
        </div>

        <!-- Modal body -->
        <form method="post">
          <div class="modal-body">
            <input type="text" name="namabarang" placeholder="Nama Bahan Baku" class="form-control" required />
            <br />
            <input type="text" name="jenis" placeholder="Jenis Bahan Baku" class="form-control" required />
            <br />
            <input type="number" name="stock" class="form-control" placeholder="Stock" required />
            <br />
            <button type="submit" class="btn btn-primary" name="addnewbarang">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</html>

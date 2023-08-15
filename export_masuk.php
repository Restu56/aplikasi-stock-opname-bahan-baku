<?php 
require 'function.php';
require 'cek.php';


?>
<html>
<head>
  <title>Stock Barang</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
</head>

<body>
<div class="container">
<h2>Stock Bahan</h2>
<h4>(Inventory)</h4>
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
    <div class="data-tables datatable-dark">
        <table class="table table-bordered table-striped" id="exportmasuk" width="100%" cellspasing="0">                   
            <thead class="table table-dark text-center">
                <tr>
                    <th width="200">Tanggal Masuk</th>
                    <th width="200">Nama Barang</th>
                    <th width="150">Jumlah</th>
                    <th width="200">Harga</th>
                    <th width="200">Total</th>
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
                $harga = $data['harga'];
                $total = $data['harga'] * $data['qty'];
                $petugas = $data['petugas'];                                           
            ; ?>
                <tr>
                    <td align="center"><?php echo$tanggal;?></td>
                    <td align="left"><?php echo$namabarang;?></td>
                    <td align="center"><?php echo$qty;?></td>
                    <td align="right">Rp.<?php echo number_format($harga,2,',','.');?></td>    
                    <td align="right">Rp.<?php echo number_format($total,2,',','.');?></td>                

                </tr> 
                
                
                <?php  
                }
                ;?>                                                 
            </tbody>
        </table>					
    </div>
</div>
	
<script>
$(document).ready(function() {
    $('#exportmasuk').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf', 'print'
        ]
    } );
} );

</script>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>

	

</body>

</html>
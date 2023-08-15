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
            <button class="btn btn-primary" name="filtertanggal">Filter</button>
        </div>
    </form>
    <div class="data-tables datatable-dark">
        <table class="table table-bordered table-striped" id="exportmasuk" width="100%" cellspasing="0">                   
            <thead class="table table-dark text-center">
                <tr>
                    <th width="300">Tanggal SO</th>
                    <th width="200">Nama Barang</th>
                    <th width="150">Stock Sistem</th>
                    <th width="150">Stock Fisik</th>
                    <th width="100">Selisih</th>
                    <th width="200">Selisih Dana</th>
                    <th width="200">Keterangan</th>
                </tr>
            </thead>
            <tbody>  
            <?php 
            if(isset($_POST['filtertanggal'])){
                $mulai = $_POST['tgl_mulai'];
                $akhir = $_POST['tgl_akhir'];
                if($mulai != null || $akhir != null){
                
                    $ambilsemuadatastock = mysqli_query($conn, "select * from stockopname so, stock s  where s.idbarang = so.idbarang and
                    tanggal BETWEEN  '$mulai' and '$akhir' order by idstockopname DESC"); 
                } else {
                    $ambilsemuadatastock = mysqli_query($conn, "select * from stockopname so, stock s  where s.idbarang = so.idbarang  ORDER BY idstockopname DESC");
                }
            
            
            } else {
                $ambilsemuadatastock = mysqli_query($conn, "select * from stockopname so, stock s  where s.idbarang = so.idbarang");

            }
            while($data=mysqli_fetch_array($ambilsemuadatastock)){
                $id = $data['idstockopname'];
                $idb = $data['idbarang'];
                $tanggal = $data['tanggal'];
                $namabarang = $data['namabarang'];
                $qty = $data['stocksistem'];
                $stockfisik = $data['stockfisik']; 
                $selisih = $data['selisih'];
                $selisihdana = $data['selisih_harga'];
                $keterangan = $data['keterangan'];                                    
            ; ?>
                <tr>
                    <td align="center"><?php echo$tanggal;?></td>
                    <td align="left"><?php echo$namabarang;?></td>
                    <td align="center"><?php echo$qty;?></td>
                    <td align="center"><?php echo$stockfisik;?></td>  
                    <td align="center"><?php echo$selisih;?></td>  
                    <td align="right">Rp.<?php echo number_format($selisihdana,2,',','.');?></td>
                    <td align="center"><?php echo$keterangan;?></td>

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
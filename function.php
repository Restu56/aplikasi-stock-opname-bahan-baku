<?php  
session_start();
 
//connect to db
$conn = mysqli_connect("localhost:3307", "root", "", "stokbarang");

// menambah barang baru
if(isset($_POST['addnewbarang'])){

    $namabarang = $_POST['namabarang'];
    $jenis = $_POST['jenis'];
    $stock = $_POST['stock'];


    $addtotable = mysqli_query($conn, "insert into stock (namabarang, jenis, stock) 
                            values('$namabarang', '$jenis', '$stock')");
    if($addtotable){
        header('location:index.php');
    }else{
        echo 'Gagal';
        header('location:index.php');
    }
};


// menambah barang masuk 
if(isset($_POST['barangmasuk'])){
    $barangnya = $_POST['barangnya'];
    $qty = $_POST['qty'];
    $penerima = $_POST['penerima'];
 
    

    $cekstocksekarang = mysqli_query($conn, "select * from stock where idbarang = '$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang + $qty;

    $addtomasuk   = mysqli_query($conn, "insert into masuk (idbarang, keterangan,qty) values('$barangnya', '$penerima', '$qty')");
    $updatestockmasuk = mysqli_query($conn, "update stock set stock='$tambahkanstocksekarangdenganquantity' where idbarang='$barangnya'");
    if($addtomasuk&&$updatestockmasuk){
        header('location:masuk.php');
    }else{
        echo 'Gagal';
        header('location:masuk.php');
    }

}

// menambah barang keluar 
if(isset($_POST['addbarangkeluar'])){
    $barangnya = $_POST['barangnya'];
    $qty = $_POST['qty'];
    $penerima = $_POST['penerima'];
 
    

    $cekstocksekarang = mysqli_query($conn, "select * from stock where idbarang = '$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang - $qty;

    $addtokeluar   = mysqli_query($conn, "insert into keluar (idbarang, penerima,qty) values('$barangnya', '$penerima', '$qty')");
    $updatestockmasuk = mysqli_query($conn, "update stock set stock='$tambahkanstocksekarangdenganquantity' where idbarang='$barangnya'");
    if($addtokeluar&&$updatestockmasuk){
        header('location:keluar.php');
    }else{
        echo 'Gagal';
        header('location:keluar.php');
    }

}

// update info barang
if(isset($_POST["updatebarang"])){
    $idb  = $_POST["idb"];
    $namabarang = $_POST["namabarang"];
    $jenis = $_POST["jenis"];

    $update = mysqli_query($conn, "update stock set namabarang='$namabarang', jenis='$jenis' where idbarang='$idb'");
    if($update){
        header("location:index.php");
    } else {
        echo 'Gagal';
        header("location:index.php");
    }
}

// Menghapus barang dari stock
if(isset($_POST['hapusbarang'])){
    $idb = $_POST['idb'];

   $hapus = mysqli_query($conn, "delete from stock where idbarang='$idb'"); 
    if($hapus){
     header("location:index.php");
   } else {
      echo 'Gagal';
     header("location:index.php");
   }
}

// mengubah barang masuk
if(isset($_POST{'editbarangmasuk'})){
    $idb = $_POST['idb'];
    $idm = $_POST['idm'];
    $namabarang = $_POST['namabarang'];
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn, "select * from stovk where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrg = $stock['stock'];

    $qtyskrg = mysqli_query($conn, "select * from masuk where idmasuk='$idm'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtynya['qty'];

    if($qty>$qtysekarang){
        $selisih = $qty - $qtyskrg;
        $kurangin = $stockskrg - $selisih; 
        $kurangistocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang-'$idb");
        $updatenya = mysqli_query($conn, "update masuk set qty='$qty',keterangan='$keterangan' where idmasuk='$idm'");
            if($kurangstocknya&&$updatenya){
                header('location:masuk.php');
            }else {
                echo 'Gagal';
                header('location:masuk.php');
            }
    }else {
        $selisih = $qtyskrg-$qty;
        $kurangin = $stockskrg + $selisih;
        $kurangistocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update masuk set qty='$$qty', keterangan='$keterangan' where idmasuk='$idm'");
        if($kurangstocknya&&$updatenya){
            header('location:masuk.php');
        }else {
            echo 'Gagal';
            header('location:masuk.php');
        }
    }
}

// menghapus data barang masuk
if(isset($_POST['hapusbarangmasuk'])){
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idm = $_POST['idm'];

    $getdatastock = mysqli_query($conn, "select * from stock where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stock = $data['stock'];

    $selisih = $stock-$qty;
    
    $update = mysqli_query($conn, "update stock set stock='$selisih' where idbarang='$idb'"); 
    $hapusdata = mysqli_query($conn, "delete from masuk where idmasuk='$idm'");

    if($update&&$hapusdata){
        header('location:masuk.php');
    }else {
        header('location:masuk.php');
    }
}

//mengubah data barang keluar
if(isset($_POST{'editbarangmasuk'})){
    $idb = $_POST['idb'];
    $idm = $_POST['idk'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn, "select * from stock where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrg = $stock['stock'];

    $qtyskrg = mysqli_query($conn, "select * from keluar where idkeluar='$idk'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtynya['qty'];

    if($qty>$qtysekarang){
        $selisih = $qty - $qtyskrg;
        $kurangin = $stockskrg - $selisih; 
        $kurangistocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang-'$idb");
        $updatenya = mysqli_query($conn, "update keluar set qty='$qty',penerima='$penerima' where idkeluar='$idk'");
            if($kurangstocknya&&$updatenya){
                header('location:keluar.php');
            }else {
                echo 'Gagal';
                header('location:keluar.php');
            }
    }else {
        $selisih = $qtyskrg-$qty;
        $kurangin = $stockskrg + $selisih;
        $kurangistocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update keluar set qty='$$qty', penerima='$penerima' where idkeluar='$idk'");
        if($kurangstocknya&&$updatenya){
            header('location:keluar.php');
        }else {
            echo 'Gagal';
            header('location:keluar.php');
        }
    }
}

// menghapus data barang keluar
if(isset($_POST['hapusbarangkeluar'])){
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idm = $_POST['idm'];

    $getdatastock = mysqli_query($conn, "select * from stock where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stock = $data['stock'];

    $selisih = $stock-$qty;
    
    $update = mysqli_query($conn, "update stock set stock='$selisih' where idbarang='$idb'"); 
    $hapusdata = mysqli_query($conn, "delete from keluar where idkeluar='$idk'");

    if($update&&$hapusdata){
        header('location:keluar.php');
    }else {
        header('location:keluar.php');
    }
}



; ?>





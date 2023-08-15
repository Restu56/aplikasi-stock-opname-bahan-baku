<?php 
session_start();


$conn = mysqli_connect("localhost:3307", "root", "", "db");

//sign up 
if(isset($_POST['regis'])){
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $confirm = $_POST['confirm_password'];
    //enkripsi password 
    $pass = password_hash($pass, PASSWORD_BCRYPT);
    // menambahkan ke db 
    $query = "insert into user (nama, email, password) VALUES('$nama','$email', '$pass')";
    $daftar = mysqli_query($conn, $query);

    if($daftar){
        echo "
        <script>
        alert('user berhasil ditambahkan!');
        document.location.href = 'login.php';
        </script>
        

        ";
    } else {
        echo "
        <script>
        alert('user gagal ditambahkan!');
        document.location.href = 'login.php';
        </script>
        ";
    }
};

// login
if(isset($_POST['login'])){
    $email = $_POST['email'];
    $pass = $_POST['password'];
      
    // menambagkan ke db 
    $query = "select * from user where email='$email'";
    $cekdb = mysqli_query($conn, $query);
    $hitung = mysqli_num_rows($cekdb);
    $pw = mysqli_fetch_array($cekdb);
    $passwordskrg = $pw['password'];

    if($hitung > 0){
        $_SESSION['login'] = 'True';
        // jika ada
        //verifikasi password
        if(password_verify($pass, $passwordskrg)){           
            header('location:dashboard.php');
        } else {
            // jika password salah
            echo "
            <script>
            alert('password salah!');
            document.location.href = 'login.php';
            </script>
            ";

        }
       
    } else {
        echo "
        <script>
        alert('login gagal!');
        document.location.href = 'login.php';
        </script>
        ";
    }
};





// menambah barang baru 
if(isset($_POST['tambahbarangbaru'])){
    $kode = $_POST['kode'];
    $namabarang = $_POST['namabarang'];
    $jenis = $_POST['jenis'];  
    $stock = $_POST['stock'];
    $harga = $_POST['harga'];

    $query = "insert into stock (kode, namabarang, jenis, stock, harga) values ('$kode', '$namabarang', '$jenis', '$stock', '$harga')";
    $addtotable = mysqli_query($conn, $query);
    if($addtotable){
        echo "
        <script>
            alert('data berhasil ditambahkan!');
            document.location.href = 'index.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('data gagal ditambahkan!');
            document.location.href = 'index.php';
        </script>
        ";
    }
    
}


// menambah barang masuk 
if(isset($_POST['barangmasuk'])){
    $barangnya = $_POST['barangnya'];
    $qty = $_POST['qty'];
    $petugas = $_POST['petugas'];
   
    $cekstocksekarang = mysqli_query($conn, "select * from stock where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $cekstocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $cekstocksekarang+$qty;

    $addtomasuk = mysqli_query($conn, "insert into masuk (idbarang,qty, petugas) values ('$barangnya', '$qty', '$petugas')");
    $updatestockmasuk = mysqli_query($conn, "update stock set stock='$tambahkanstocksekarangdenganquantity' where idbarang='$barangnya'");
    if($addtomasuk && $updatestockmasuk){
        echo "
        <script>
            alert('data berhasil ditambahkan!');
            document.location.href = 'masuk.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('data gagal ditambahkan!');
            document.location.href = 'masuk.php';
        </script>
        ";
    }
}


// menambah barang keluar 
if(isset($_POST['addbaranagkeluar'])){
    $barangnya = $_POST['barangnya'];
    $qty = $_POST['qty'];
    $petugas = $_POST['petugas'];
    $penerima = $_POST['penerima'];
   
    $cekstocksekarang = mysqli_query($conn, "select * from stock where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $cekstocksekarang = $ambildatanya['stock'];
    if($cekstocksekarang >= $qty){
        // kalau barangnya cukup
        $tambahkanstocksekarangdenganquantity = $cekstocksekarang-$qty;

        $addtomasuk = mysqli_query($conn, "insert into keluar (idbarang, petugas, penerima, qty) values ('$barangnya', '$petugas', '$penerima', '$qty')");
        $updatestockmasuk = mysqli_query($conn, "update stock set stock='$tambahkanstocksekarangdenganquantity' where idbarang='$barangnya'");
        if($addtomasuk && $updatestockmasuk){
            echo "
            <script>
                alert('data berhasil ditambahkan!');
                document.location.href = 'keluar.php';
            </script>
            ";
        } else {
            echo "
            <script>
                alert('data gagal ditambahkan!');
                document.location.href = 'keluar.php';
            </script>
            ";
        }
    } else {
        // kalau barangngnya gak cukup
        echo "
        <script>
            alert('stock tidak mencukupi');
            document.location.href = 'keluar.php';
        </script>
        ";
        
    }
}

//menambah barang stock opname
if(isset($_POST['tambahbarangso'])){
    $barangnya = $_POST['barangnya'];
    $stockfisik = $_POST['stockfisik'];
    $petugas = $_POST['petugas'];


    $cekstocksekarang = mysqli_query($conn, "select * from stock where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $cekstocksekarang = $ambildatanya['stock'];
    $cekharga =  $ambildatanya['harga'];

    // menghitung selisih
    $selisih = $cekstocksekarang - $stockfisik;
    
    // Menghitung selisih dalam persentase
    $persentase_selisih = $selisih / $cekstocksekarang * 100;

    //tolerasi selisih
    $toleransiselisih = 0.4;
    // menghitung harga dikali jumlah selisih
    $selisihharga =  $cekharga * $selisih;

    // Cek apakah selisih stock fisik lebih dari stock
    if ($persentase_selisih > $toleransiselisih ) {
        $persennya =  number_format($persentase_selisih,2);
        $keterangan = "Selisih $persennya%";
    }  else{
        $keterangan = "OK!";
    }  
    $addtoso = mysqli_query($conn, "INSERT into stockopname (idbarang, stocksistem, stockfisik, selisih, selisih_harga, petugas, keterangan) values ('$barangnya', '$cekstocksekarang', '$stockfisik', '$selisih','$selisihharga','$petugas','$keterangan')");
    $updatestockopname = mysqli_query($conn, "UPDATE stockopname SET selisih = '$selisih' where idbarang = '$barangnya'");

    if($addtoso && $updatestockopname ){
        echo "
            <script>
                alert('data berhasil ditambahkan!');
                document.location.href = 'stock_opname.php';
            </script>
            ";
        } else {
            echo "
            <script>
                alert('data gagal ditambahkan!');
                document.location.href = 'stock_opname.php';
            </script>
            ";

    }
}

//update  barang dari stock
if(isset($_POST['updatebarang'])){
    $idb = $_POST['idb'];
    $namabarang = $_POST['namabarang'];
    $jenis = $_POST['jenis'];
    $kode = $_POST['kode'];
    $harga = $_POST['harga'];

    $update = mysqli_query($conn, "update stock set kode='$kode',namabarang='$namabarang', jenis='$jenis', harga='$harga' where idbarang='$idb'");
    if($update){
        header('location:indy.php');
    } else {
        echo "Gagal";
        header('location:index.php');
    }
}

// menghapus barang dari stock
if(isset($_POST['hapusbarang'])){
    $idb = $_POST['idb'];

    $hapus = mysqli_query($conn, "delete from stock where idbarang='$idb'");
    if($hapus){
        header('location:index.php');
    } else {
        echo "Gagal";
        header('location:index.php');
    }
}

// edit barang masuk
if(isset($_POST['updatebarangmasuk'])){
    $idb = $_POST['idb'];
    $idm = $_POST['idm'];
    $petugas = $_POST['petugas'];
    $qty = $_POST['qty'];
    $tanggal = $_POST['tgl'];


    $lihatstock = mysqli_query($conn, "select * from stock where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrg = $stocknya['stock'];

    $qtyskrg = mysqli_query($conn, "select * from masuk where idmasuk='$idm'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtynya['qty'];

    if($qty>$qtyskrg){
            $selisih = $qty;
            $kurangin = $stockskrg - $selisih;
            $kuranginstocknya = mysqli_query($conn, "update stock set stock='$selisih' where idbarang='$idb'");
            $updatenya = mysqli_query($conn, "update masuk set qty='$qty', tanggal='$tanggal', petugas='$petugas' where idmasuk='$idm'");
                if($kuranginstocknya && $updatenya){
                    header('location:masuk.php');
                } else {
                    echo "Gagal";
                    header('location:masuk.php');
                }
        }else{
            $selisih =  $qty - $stockskrg;
            $kurangin = $stockskrg + $selisih;
            $kuranginstocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
            $updatenya = mysqli_query($conn, "update masuk set qty='$qty', tanggal='$tanggal', idbarang='$idb', petugas='$petugas' where idmasuk='$idm'");
                if($kuranginstocknya && $updatenya){
                    header('location:masuk.php');
                } else {
                    echo "Gagal";
                    header('location:masuk.php');
                }

    }
    

}


// hapus barang masuk
if(isset($_POST['hapusbarangmasuk'])){
    $idb = $_POST['idb'];
    $idm = $_POST['idm'];
    $qty = $_POST['kty'];

    $getdatastock = mysqli_query($conn, "select * from stock where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stock = $data['stock'];

    $selisih = $stock - $qty;

    $update = mysqli_query($conn, "update stock set stock='$selisih' where idbarang='$idb'");
    $hapusdata = mysqli_query($conn, "delete from masuk where idmasuk='$idm'");

    if($update&&$hapusdata){
        header("location:masuk.php");
    } else {
        header("location:masuk.php");
    }
}

// edit barang keluar
if(isset($_POST['updatebarangkeluar'])){
    $idb = $_POST['idb'];
    $idk = $_POST['idk'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn, "select * from stock where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrg = $stocknya['stock'];

    $qtyskrg = mysqli_query($conn, "select * from keluar where idkeluar='$idk'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtynya['qty'];

    if($sqty>$qtyskrg){
            $selisih = $qty-$qtyskrg;
            $kurangin = $stockskrg - $selisih;
            $kuranginstocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
            $updatenya = mysqli_query($conn, "update keluar set qty='$qty', penerima='$penerima' where idkeluar='$idk'");
                if($kuranginstocknya && $updatenya){
                    header('location:masuk.php');
                } else {
                    echo "Gagal";
                    header('location:masuk.php');
                }
        }else{
            $selisih = $qtyskrg - $qty;
            $kurangin = $stockskrg + $selisih;
            $kuranginstocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idbarang='$idb'");
            $updatenya = mysqli_query($conn, "update keluar set qty='$qty', penerima='$penerima' where idkeluar='$idk'");
                if($kuranginstocknya && $updatenya){
                    header('location:keluar.php');
                } else {
                    echo "Gagal";
                    header('location:keluar.php');
                }

    }
    

}

// hapus barang keluar
if(isset($_POST['hapusbarangkeluar'])){
    $idb = $_POST['idb'];
    $idk = $_POST['idk'];
    $qty = $_POST['kty'];

    $getdatastock = mysqli_query($conn, "select * from stock where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stock = $data['stock'];

    $selisih = $stock + $qty;

    $update = mysqli_query($conn, "update stock set stock='$selisih' where idbarang='$idb'");
    $hapusdata = mysqli_query($conn, "delete from keluar where idkeluar='$idk'");

    if($update&&$hapusdata){
        header("location:keluar.php");
    } else {
        header("location:keluar.php");
    }
}



; ?>

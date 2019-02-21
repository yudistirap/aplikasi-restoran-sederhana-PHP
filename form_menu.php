<?php
	require 'config/koneksi.php';
	require 'config/function.php';

	 if(isset($_POST['simpan'])){
        $menu = $_POST['menu'];
        $jenis = $_POST['level'];
        $harga = $_POST['harga'];
        $status = $_POST['status'];
        $kategori = $_POST['kategori'];

        $lokasi_file = $_FILES['foto']['tmp_name'];
        $nama_file = $_FILES['foto']['name'];
        $folder = "img/$nama_file";

        $upload = move_uploaded_file($lokasi_file, "$folder");

        $query = mysqli_query($conn, "INSERT INTO tb_menu VALUES('','$menu','$jenis','$harga','$status','$nama_file','$kategori') ");

        if($query){
            echo "<script>alert('berhasil');document.location.href='form_menu.php';</script>";
        }else{
            echo "<script>alert('gagal');</script>";
        }
    }

    if(isset($_GET['edit'])){
        $query = mysqli_query($conn, "SELECT * FROM tb_menu WHERE kd_menu = '$_GET[id]' ");
        $ambil = mysqli_fetch_assoc($query);
        // var_dump($ambil['foto']);
        // die();

        $sql = "SELECT * FROM tb_kategori WHERE kd_kategori = '$ambil[kd_kategori]' ";
        $query1 = mysqli_query($conn, $sql);
        $ambil1 = mysqli_fetch_assoc($query1);

    }

    if(isset($_POST['update'])){
    	$menu = $_POST['menu'];
        $jenis = $_POST['level'];
        $harga = $_POST['harga'];
        $status = $_POST['status'];
        $kategori = $_POST['kategori'];

        $lokasi_file = $_FILES['foto']['tmp_name'];
        $nama_file = $_FILES['foto']['name'];
        $folder = "img/$nama_file";

        $upload = move_uploaded_file($lokasi_file, "$folder");

        $sql = "UPDATE tb_menu SET menu = '$menu', jenis = '$jenis', harga = '$harga', status = '$status', foto = '$nama_file', kd_kategori = '$kategori' WHERE kd_menu = '$_GET[id]' ";
        $query = mysqli_query($conn, $sql);

        if($query){
            echo "<script>alert('berhasil');document.location.href='form_menu.php';</script>";
        }else{
            echo "<script>alert('gagal');</script>";
        }
    }

    if(isset($_GET['hapus'])){
        $query = mysqli_query($conn, "DELETE FROM tb_menu WHERE kd_menu = '$_GET[id]' ");

        if($query){
            echo "<script>alert('berhasil');document.location.href='form_menu.php';</script>";
        }else{
            echo "<script>alert('gagal');</script>";
        }
    }

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/form_menu.css">
    <title>Menu</title>
</head>
<body>
    <div class="container">
        <nav>
            <span id="brand">
                <a href="form_menu.html">Menu</a>
            </span>
             <span id="brand" style="float: right; margin-right: 40px; ">
                <a href="form_login.php">Logout</a>
            </span>
            <span id="brand" style="float: right; margin-right: 0px; ">
                <a href="form_kelola_user.php">User</a>
            </span>
             <span id="brand" style="float: right; margin-right: 0px; ">
                <a href="form_kategori.php">Kategori</a>
            </span>
             <span id="brand" style="float: right; margin-right: 0px; ">
                <a href="form_transaksi.php">Transaksi</a>
            </span>
             <span id="brand" style="float: right; margin-right: 0px; ">
	                <a href="form_laporan.php">Laporan</a>
	            </span>
        </nav>
        <br><br><br>
        <div class="tabel" style="margin-left: 100px;">
            <form method="post">
                <tr class="tr-cari">
                    <td><input type="search" name="tcari" class="tcari" value="<?= @$_POST['tcari'] ?>"></td>
                    <td><input type="submit" name="cari" value="Cari" class="cari"></td>
                </tr><br><br>
                <table border="1" cellspacing="1">
                    <tr>
                        <th>Menu</th>
                        <th>Jenis</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Foto</th>
                        <th>Kode</th>
                        <th>Aksi</th>
                    </tr>
                    <?php
                        $sql = "SELECT * FROM tb_menu";

                        if(isset($_POST['cari'])){
                            $cari = $_POST['tcari'];
                            $sql ="SELECT * FROM tb_menu WHERE menu LIKE '%$cari%' ";
                        }else{
                            $sql = "SELECT * FROM tb_menu";
                        }

                        $query = mysqli_query($conn, $sql);
                        $no = 1;
                        while($row=mysqli_fetch_assoc($query)): ?>
                    <tr>
                        <td><?= $row['menu'] ?></td>
                        <td><?= $row['jenis'] ?></td>
                        <td><?= $row['harga'] ?></td>
                        <td><?= $row['status'] ?></td>
                        <td><img src="img/<?= $row['foto'] ?>" width="80" height="70"></td>
                        <td><?= $row['kd_kategori'] ?></td>
                        <td>
                            <a href="form_menu.php?edit&id=<?= $row['kd_menu'] ?>">Edit</a> |
                            <a href="form_menu.php?hapus&id=<?= $row['kd_menu'] ?>">Hapus</a>
                        </td>
                    </tr>
                	<?php endwhile; ?>
                </table>
            </form>
        </div>
        <div class="wdh">
            <form method="post" enctype="multipart/form-data">
                <table >
                    <tr class="tr">
                        <td>Menu</td>
                        <td><input type="text" name="menu" value="<?= @$ambil['menu'] ?>"></td>
                    </tr>
                    <tr class="tr">
                        <td>Jenis</td>
                        <td>
                            <select name="level">
                            	<?php if(isset($_GET['edit'])): ?>
									<option value="<?= @$ambil['jenis'] ?>"><?= @$ambil['jenis'] ?></option>
                            	<?php else: ?>
									<option value="">--Pilih--</option>
                               	 	<option value="makanan">Makanan</option>
                                	<option value="minuman">Minuman</option>
                            	<?php endif; ?>
                            </select>
                        </td>
                    </tr>
                    <tr class="tr">
                        <td>Harga</td>
                        <td><input type="text" name="harga" value="<?= @$ambil['harga'] ?>"></td>
                    </tr>
                    <tr class="tr">
                        <td>Status</td>
                        <td><input type="text" name="status" value="<?= @$ambil['status'] ?>"></td>
                    </tr>
                    <tr class="tr">
                        <td>Foto</td>
                        <td><input type="file" name="foto" value="<?= @$ambil['foto'] ?>"></td>
                    </tr>
                    <tr class="tr">
                        <td>Kategori</td>
                        <td>
                            <select name="kategori">
                            	<?php if(isset($_GET['edit'])): ?>
									<option value="<?= @$ambil['kd_kategori'] ?>"><?= @$ambil1['kategori'] ?></option>
									<?php
										$sql = "SELECT * FROM tb_kategori";
                                		$query = mysqli_query($conn, $sql);

                          				while($row = mysqli_fetch_assoc($query)): ?>
								 			<option value="<?= $row['kd_kategori']; ?>"><?= $row['kategori'] ?></option>
									?>
									<?php endwhile; ?>
                            	<?php else: ?>
									<option value="">--Pilih--</option>
                               	 <?php
                                	$sql = "SELECT * FROM tb_kategori";
                                	$query = mysqli_query($conn, $sql);

                          			while($row = mysqli_fetch_assoc($query)): ?>
								 		<option value="<?= $row['kd_kategori']; ?>"><?= $row['kategori'] ?></option>
								<?php endwhile; ?>
                            	<?php endif; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                        	<?php if(isset($_GET['edit'])){ ?>
                        		<input type="submit" name="update" value="Update">
                        	<?php }else{ ?>
								<input type="submit" name="simpan" value="Simpan">
                        	<?php } ?>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</body>
</html>

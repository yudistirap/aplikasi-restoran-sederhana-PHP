<?php
	session_start();

	require 'config/koneksi.php';

	if(isset($_POST['selesai'])){

		$sql = "TRUNCATE TABLE tb_transaksi";
		$query = mysqli_query($conn, $sql);

		 if($query){
            echo "<script>alert('selesai belanja');document.location.href='form_transaksi.php';</script>";
        }else{
            echo "<script>alert('gagal');</script>";
        }
	}
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Struk</title>
	<link rel="stylesheet" href="css/form_struk.css">
</head>
<body>
	<div>
		<nav>
            <span id="brand">
                <a href="form_struk.html">Struk</a>
            </span>
             <span id="brand" style="float: right; margin-right: 40px; ">
                <a href="form_login.php">Logout</a>
             </span>
             <span id="brand" style="float: right; margin-right: 40px; ">
                <a href="form_transaksi.php">Kembali</a>
             </span>

	              <span id="brand" style="float: right; margin-right: 0px; ">
	                <a href="form_kelola_user.php">User</a>
	            </span>
	             <span id="brand" style="float: right; margin-right: 0px; ">
	                <a href="form_menu.php">Menu</a>
	            </span>
	             <span id="brand" style="float: right; margin-right: 0px; ">
	                <a href="form_kategori.php">Kategori</a>
	            </span>
	            <span id="brand" style="float: right; margin-right: 0px; ">
	                <a href="form_laporan.php">Laporan</a>
	            </span>

        </nav>
	</div>
	<div class="">
		<div class="card">
		  <div class="container">
		  	<h2>Struk Belanja</h2>
		  		<table border="1">
		  			<tr>
		  				<th>Menu</th>
		  				<th>Harga</th>
		  				<th>Jumlah</th>
		  				<th>Subtotal</th>
		  				<th>Tanggal</th>
		  			</tr>
		  			 <?php

                        $sql = "SELECT * FROM query_struk";
						$query = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_assoc($query)):
                     ?>
		  			<tr>
		  				<td><?= $row['menu'] ?></td>
		  				<td><?= $row['harga'] ?></td>
		  				<td><?= $row['jumlah'] ?></td>
		  				<td><?= $row['subtotal'] ?></td>
		  				<td><?= $row['tgl_transaksi'] ?></td>
		  			</tr>
		  			<?php endwhile; ?>
		  		</table>
		  		<br>
			    <div>
				    <label>Total</label>
				    <input type="text" name="" value="<?= @$_SESSION['total'] ?>">
			    </div>
			    <div>
				    <label>Pembayaran</label>
				    <input type="text" name="" value="<?= $_SESSION['pembayaran'] ?>">
			    </div>
			    <div>
				    <label>Kembali</label>
				    <input type="text" name="" value="<?= @$_SESSION['kembali'] ?>">
			    </div>
			    <br>
			    <p style="text-align: center;">---Terima Kasih---</p>
			    <form method="post">
				    <div>
				    		<input type="submit" name="selesai" value="Selesai" style="margin-left: 90px;"><br>
				    </div>
			    </form>
		  </div>
		</div>
	</div>
</body>
</html>

<?php 
	
	session_start();

	require 'config/koneksi.php';


 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Laporan</title>
	<link rel="stylesheet" href="css/form_kategori.css">
</head>
<body>
	<div>
		<nav>
            <span id="brand">
                <a href="form_laporan.html">Laporan</a>
            </span>
             <span id="brand" style="float: right; margin-right: 40px; ">
                <a href="form_login.php">Logout</a>
             </span>
             <span id="brand" style="float: right; margin-right: 40px; ">
                <a href="form_transaksi.php">Kembali</a>
             </span>
			<?php if( $_SESSION['level'] == 'admin'): ?>
	              <span id="brand" style="float: right; margin-right: 0px; ">
	                <a href="form_kelola_user.php">Kelola</a>
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
        	<?php endif; ?>
        </nav>
	</div>
	<div>
		<form method="post">
			<table align="center">
				<tr>
					<td>
						<label>Dari</label>
						<input type="date" name="dari">
					</td>
					<td>
					<label>Sampai</label>
					<input type="date" name="sampai">
					</td>
					<td>
						<input type="submit" name="cari" value="Cari">
					</td>
				</tr>
			</table>
		</form>
		<br><br>
		<table align="center" border="1" cellpadding="5">
			<tr>
				<th>no</th>
				<th>kode transaksi</th>
				<th>jumlah</th>
				<th>subtotal</th>
				<th>tanggal transaksi</th>
				<th>no meja</th>
			</tr>
			 <?php 
	                        $sql = "SELECT * FROM query_laporan";

	                        if(isset($_POST['cari'])){
	                            $dari = $_POST['dari'];
	                            $sampai = $_POST['sampai'];

	                            $sql ="SELECT * FROM query_laporan WHERE tgl_transaksi BETWEEN '$dari' AND '$sampai' ";
	                        }else{
	                            $sql = "SELECT * FROM query_laporan";
	                        }
	                        $query = mysqli_query($conn, $sql);
	                        $no = 1;
	            while($row=mysqli_fetch_assoc($query)): ?>
			<tr>
				<td><?= $no; ?></td>
				<td><?= $row['kd_transaksi'] ?></td>
				<td><?= $row['jumlah'] ?></td>
				<td><?= $row['subtotal'] ?></td>
				<td><?= $row['tgl_transaksi'] ?></td>
				<td><?= $row['no_meja'] ?></td>
			</tr>
			<?php $no++ ?>
			<?php endwhile; ?>
		</table>
	</div>
</body>
</html>
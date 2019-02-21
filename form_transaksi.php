<?php
	session_start();

	require 'config/koneksi.php';

	// SAAT ON CHANGE AUTO NAMPILIN VALUES
	if(isset($_POST['menu'])){
		$kode = $_POST['menu']; // result is menu
		$sql = "SELECT * FROM tb_menu";
		$query = mysqli_query($conn, $sql);
		$res = mysqli_fetch_assoc($query);

		if($kode == $res['menu']){
			$output = $res['menu'];
		}else{
			$output = $kode;
		}
		//var_dump(@$kode);
		//die();

		$_SESSION['menu'] = $kode;
	}

	if(isset($_GET['hapus'])){
        $query = mysqli_query($conn, "DELETE FROM tb_transaksi WHERE kd_transaksi = '$_GET[id]' ");

        if($query){
            echo "<script>alert('berhasil');document.location.href='form_transaksi.php';</script>";
        }else{
            echo "<script>alert('gagal');</script>";
        }
    }

	if(isset($_POST['bayar'])){
		$total = $_POST['total'];
		$pembayaran = $_POST['pembayaran'];

		$_SESSION['total'] = $total;
		$_SESSION['pembayaran'] = $pembayaran;

		$kembali = $pembayaran - $total;

		$_SESSION['kembali'] = $kembali;

		echo "<script>document.location.href='form_struk.php';</script>";
	}

	if(isset($_POST['pesan'])){
        $no_transaksi = $_POST['no_transaksi'];
        //$menu = $_POST['menu'];
        //$harga = $_POST['harga'];
        $jumlah = $_POST['jumlah'];
        $subtotal = $_POST['subtotal'];
        $no_meja = $_POST['no_meja'];
        // var_dump($no_meja);
        // die();

        // pilih data yang sesuai kd-session
        $sql1 = mysqli_query($conn, "SELECT * FROM tb_menu WHERE menu = '$_SESSION[menu]' ");
		$result = mysqli_fetch_assoc($sql1);

        // pilih salah satu di tb_menu
        $sql = "SELECT * FROM tb_menu WHERE kd_menu = '$result[kd_menu]' ";
        $query1 = mysqli_query($conn, $sql);
        $ambil1 = mysqli_fetch_assoc($query1);
        $kd_menu = $ambil1['kd_menu'];

        // tanggal now
        $tanggal = date('Y-m-d');

        // pilih data yang sesuai kd-session
        $sql3 = mysqli_query($conn, "SELECT * FROM tb_user WHERE level = '$_SESSION[level]' ");
		$result1 = mysqli_fetch_assoc($sql3);

        // pilih salah satu di tb_user
        $sql4 = "SELECT * FROM tb_user WHERE level = '$result1[level]' ";
        $query3 = mysqli_query($conn, $sql4);
        $ambil2 = mysqli_fetch_assoc($query3);
        $kd_user = $ambil2['kd_user'];

        $query = mysqli_query($conn, "INSERT INTO tb_transaksi VALUES('$no_transaksi','$kd_menu','$jumlah','$subtotal','$tanggal','$kd_user', '$no_meja') ");

        // insert laporan
        $sql5 = "INSERT INTO tb_laporan VALUES ('','$no_transaksi','$jumlah','$subtotal','$tanggal','$no_meja')";
        $query5 = mysqli_query($conn, $sql5);



        if($query){
            echo "<script>alert('berhasil');document.location.href='form_transaksi.php';</script>";
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
    <link rel="stylesheet" href="css/form_transaksi.css">
    <title>Transaksi</title>
</head>
<body>
    <div class="container">
        <nav>
            <span id="brand">
                <a href="form_transaksi.html">Transaksi</a>
            </span>
             <span id="brand" style="float: right; margin-right: 40px; ">
                <a href="form_login.php">Logout</a>
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
        <br><br><br>
        <div class="tabel" style="margin-right: 200px; ">
                <form method="post">
                	 <tr class="tr-cari">
                    <td><input type="search" name="tcari" class="tcari" value="<?= @$_POST['tcari'] ?>"></td>
                    <td><input type="submit" name="cari" value="Cari" class="cari"></td>
                </tr><br><br>
	                <table border="1" cellspacing="1">
	                    <tr>
	                        <th>Kode Transaksi</th>
	                        <th>Kode Menu</th>
	                        <th>Jumlah</th>
	                        <th>Subtotal</th>
	                        <th>Tanggal</th>
	                        <th>Kode User</th>
	                        <th>No Meja</th>
	                        <th>Aksi</th>
	                    </tr>
	                    <?php
	                        $sql = "SELECT * FROM tb_transaksi";

	                        if(isset($_POST['cari'])){
	                            $cari = $_POST['tcari'];
	                            $sql ="SELECT * FROM tb_transaksi WHERE kd_menu LIKE '%$cari%' OR kd_transaksi  LIKE '%$cari%' ";
	                        }else{
	                            $sql = "SELECT * FROM tb_transaksi";
	                        }

	                        $query = mysqli_query($conn, $sql);
	                        $no = 1;
	                        while($row=mysqli_fetch_assoc($query)): ?>
	                    <tr>
	                        <td><?= $row['kd_transaksi'] ?></td>
	                        <td><?= $row['kd_menu'] ?></td>
	                        <td><?= $row['jumlah'] ?></td>
	                        <td>
	                        	<input type="text" name="totals" style="width: 50px;" value="<?= $row['subtotal'] ?>" readonly>
	                        </td>
	                        <td><?= $row['tgl_transaksi'] ?></td>
	                        <td><?= $row['kd_user'] ?></td>
	                        <td><?= $row['no_meja'] ?></td>
	                        <td>

	                            <a href="form_transaksi.php?hapus&id=<?= $row['kd_transaksi'] ?>">Hapus</a>
	                        </td>
	                    </tr>
	                    <?php endwhile; ?>
	                </table>
	                <br>
	                <input type="submit" name="selesai" value="Selesai" style="float: right;">
                </form>
                <br><br>
            <form method="post">
            	<div class="trs" style="margin-left: 115px;">
                <table>
                	<tr class="tr" >
                        <td >Total</td>
                        <td>
                        	<?php
                        		$sql4 = "SELECT SUM(subtotal) as subtotal FROM tb_transaksi";
                        		$query4 = mysqli_query($conn, $sql4);
                        		$ambil3 = mysqli_fetch_assoc($query4);
                        		$total = $ambil3['subtotal'];
                        	 ?>
                        	<?php if(isset($_POST['selesai'])): ?>
                        		<input type="text" name="total" value="<?= $total; ?>" readonly>
                        	<?php elseif(isset($_POST['bayar'])): ?>
								<input type="text" name="total" value="<?= $_SESSION['total'] ?>">
                        	<?php else: ?>
								<input type="text" name="total" value="">
                        	<?php endif; ?>
                        </td>
                    </tr>
                    <tr class="tr" >
                        <td >Pembayaran</td>
                        <td>
                        	<?php if(isset($_POST['bayar'])): ?>
                        		<input type="text" name="pembayaran" value="<?= $_SESSION['pembayaran'] ?>">
                        	<?php else: ?>
								<input type="text" name="pembayaran">
                        	<?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" name="bayar" value="Bayar" class="bayar"></td>
                    </tr>
                    <tr class="tr" >
                        <td >Kembali</td>
                        <td>
                        	<?php if(isset($_POST['bayar'])): ?>
                        		<input type="text" name="kembali" value="<?= @$kembali ?>">
                        	<?php else: ?>
								<input type="text" name="kembali">
                        	<?php endif; ?>
                        </td>
                    </tr>
                </table>
            	</div>
            </form>
        </div>
        <div class="wdh">
            <form method="post">
                <table >
                	<tr class="tr">
                        <td>No Transaksi</td>
                        <td><input type="text" name="no_transaksi"></td>
                    </tr>
                    <tr class="tr">
                        <td>Menu</td>
                        <td>
                            <select name="menu" onchange="this.form.submit()">
                                <option selected value="">--Pilih--</option>
                                <?php
                                	$sql = "SELECT * FROM tb_menu";
                                	$query = mysqli_query($conn, $sql);

                          			while($row = mysqli_fetch_assoc($query)): ?>
                                	<option value="<?= $row['menu'] ?>"><?= $row['menu'] ?></option>
                                	<?php if( $row['menu'] == $output){ ?>
										<option selected value="<?= @$output ?>"><?= @$output ?></option>
						    		<?php } ?>
                                 <?php endwhile; ?>
                                <option value="">Reset</option>
                            </select>
                        </td>
                    </tr>
                    <tr class="tr">
                        <td>Harga</td>
                        <td>
                        	<?php
					    	if(isset($_SESSION['menu'])){
					    		$sql = mysqli_query($conn, "SELECT * FROM tb_menu WHERE menu = '$_SESSION[menu]' ");
					    		$result = mysqli_fetch_assoc($sql);
						 	?>
                        		<input type="text" name="harga" readonly value="<?= $result['harga'] ?>">
                        	<?php }else{ ?>
								<input type="text" name="harga" readonly>
                        	<?php } ?>
                        </td>
                    </tr>
                    <tr class="tr">
                        <td>Jumlah</td>
                        <td><input type="number" name="jumlah" onchange="submit()" value="<?php if(@$_POST[menu]){ echo @$_POST['jumlah'];} ?>" required ></td>
                    </tr>

                            <?php
                            if(isset($_SESSION['menu'])){
                                $sql = mysqli_query($conn, "SELECT * FROM tb_menu WHERE menu = '$_SESSION[menu]'");
                                $result = mysqli_fetch_assoc($sql);
                                $harga = $result['harga'];
                                @$subtotal = @$_POST['harga'] * @$_POST['jumlah'];
                            ?>

                    <tr class="tr">
                        <td>Subtotal</td>
                        <td>
							<input type="text" name="subtotal" value="<?php echo $subtotal; ?>" readonly="" >
                        
                        </td>
                    </tr>
                    <?php } ?>
                    <tr class="tr">
                        <td>No Meja</td>
                        <td>
                            <select name="no_meja">
                                <option value="">--Pilih--</option>
                               	<?php for($i= 1; $i <= 100; $i++): ?>
									<option value="<?= $i ?>"><?= 'Meja '.$i ?></option>
                               	<?php endfor; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" name="pesan" value="Pesan"></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</body>
</html>

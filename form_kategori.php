<?php
    require 'config/koneksi.php';

     if(isset($_POST['simpan'])){
        $kategori = $_POST['kategori'];

        $query = mysqli_query($conn, "INSERT INTO tb_kategori VALUES('','$kategori') ");

        if($query){
            echo "<script>alert('berhasil');document.location.href='form_kategori.php';</script>";
        }else{
            echo "<script>alert('gagal');</script>";
        }
    }

    if(isset($_GET['edit'])){
        $query = mysqli_query($conn, "SELECT * FROM tb_kategori WHERE kd_kategori = '$_GET[id]' ");
        $ambil = mysqli_fetch_assoc($query);
    }

    if(isset($_POST['update'])){
        $kategori = $_POST['kategori'];

        $query = mysqli_query($conn, "UPDATE tb_kategori SET kategori = '$kategori' WHERE kd_kategori = '$_GET[id]' ");
        if($query){
            echo "<script>alert('berhasil');document.location.href='form_kategori.php';</script>";
        }else{
            echo "<script>alert('gagal');</script>";
        }
    }

    if(isset($_GET['hapus'])){
        $query = mysqli_query($conn, "DELETE FROM tb_kategori WHERE kd_kategori = '$_GET[id]' ");

        if($query){
            echo "<script>alert('berhasil');document.location.href='form_kategori.php';</script>";
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
    <link rel="stylesheet" href="css/form_kategori.css">
    <title>Kategori</title>
</head>
<body>
    <div class="container">
        <nav>
            <span id="brand">
                <a href="form_kategori.php">Kategori</a>
            </span>
             <span id="brand" style="float: right; margin-right: 40px; ">
                <a href="form_login.php">Logout</a>
            </span>
             <span id="brand" style="float: right; margin-right: 0px; ">
                <a href="form_kelola_user.php">Kelola</a>
            </span>
             <span id="brand" style="float: right; margin-right: 0px; ">
                <a href="form_menu.php">Menu</a>
            </span>
             <span id="brand" style="float: right; margin-right: 0px; ">
                <a href="form_transaksi.php">Transaksi</a>
            </span>
             <span id="brand" style="float: right; margin-right: 0px; ">
                    <a href="form_laporan.php">Laporan</a>
                </span>
        </nav>
        <br><br><br>
        <div class="tabel">
            <form method="post">
                <tr class="tr-cari">
                    <td><label>Kategori</label></td>
                    <td><input type="text" name="kategori" class="tcari" value="<?= @$ambil['kategori'] ?>"></td>
                    <td>
                        <?php if(isset($_GET['edit'])): ?>
                            <input type="submit" name="update" value="Update" class="cari">
                        <?php else: ?>
                            <input type="submit" name="simpan" value="Simpan" class="cari">
                        <?php endif; ?>
                    </td>
                </tr><br><br>
                <table border="1" cellspacing="1">
                    <tr>
                        <th>Kode Kategori</th>
                        <th>Kategori</th>
                        <th>Aksi</th>
                    </tr>
                    <?php

                        $sql = "SELECT * FROM tb_kategori";
                        $query = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_assoc($query)):
                     ?>
                    <tr>
                        <td><?= $row['kd_kategori'] ?></td>
                        <td><?= $row['kategori'] ?></td>
                        <td>
                            <a href="form_kategori.php?edit&id=<?= $row['kd_kategori'] ?>">Edit</a> |
                            <a href="form_kategori.php?hapus&id=<?= $row['kd_kategori'] ?>">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </table>
            </form>
        </div>
    </div>
</body>
</html>

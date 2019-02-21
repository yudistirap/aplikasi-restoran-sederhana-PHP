<?php
    require 'config/koneksi.php';

    if(isset($_POST['simpan'])){
        $nama = $_POST['nama'];
        $no_hp = $_POST['no_hp'];
        $user = $_POST['username'];
        $pass = $_POST['password'];
        $level = $_POST['level'];

        $query = mysqli_query($conn, "INSERT INTO tb_user VALUES('','$nama','$no_hp','$user','$pass','$level') ");

        if($query){
            echo "<script>alert('berhasil');document.location.href='form_kelola_user.php';</script>";
        }else{
            echo "<script>alert('gagal');</script>";
        }
    }

    if(isset($_GET['edit'])){
        $query = mysqli_query($conn, "SELECT * FROM tb_user WHERE kd_user = '$_GET[id]' ");
        $ambil = mysqli_fetch_assoc($query);
    }

    if(isset($_POST['update'])){
        $nama = $_POST['nama'];
        $no_hp = $_POST['no_hp'];
        $user = $_POST['username'];
        $pass = $_POST['password'];
        $level = $_POST['level'];

        $query = mysqli_query($conn, "UPDATE tb_user SET nama = '$nama', no_hp = '$no_hp', username = '$user', password = '$pass', level = '$level' WHERE kd_user = '$_GET[id]' ");
        if($query){
            echo "<script>alert('berhasil');document.location.href='form_kelola_user.php';</script>";
        }else{
            echo "<script>alert('gagal');</script>";
        }
    }

     if(isset($_GET['hapus'])){
        $query = mysqli_query($conn, "DELETE FROM tb_user WHERE kd_user = '$_GET[hps]' ");

        if($query){
            echo "<script>alert('berhasil');document.location.href='form_kelola_user.php';</script>";
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
    <link rel="stylesheet" href="css/form_kelola.css">
    <title>Kelola User</title>
</head>
<body>
    <div class="container">
        <nav>
            <span id="brand">
                <a href="form_kelola_user.html">Kelola User</a>
            </span>
             <span id="brand" style="float: right; margin-right: 40px; ">
                <a href="form_login.php">Logout</a>
            </span>
            <span id="brand" style="float: right; margin-right: 0px; ">
                <a href="form_kategori.php">Kategori</a>
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
                    <?php if(isset($_POST['cari'])){ ?>
                        <td><input type="text" name="tcari" class="tcari" value="<?= $_POST['tcari'] ?>"></td>
                    <?php }else{ ?>
                        <td><input type="text" name="tcari" class="tcari" value=""></td>
                    <?php } ?>
                    <td><input type="submit" name="cari" value="Cari" class="cari"></td>
                </tr><br><br>
                <table border="1" cellpadding="5" cellspacing="1">
                    <tr>
                        <th>Nama</th>
                        <th>No HP</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Level</th>
                        <th>Aksi</th>
                    </tr>
                    <?php
                        $sql = "SELECT * FROM tb_user";

                        if(isset($_POST['cari'])){
                            $cari = $_POST['tcari'];
                            $sql ="SELECT * FROM tb_user WHERE nama LIKE '%$cari%' ";
                        }else{
                            $sql = "SELECT * FROM tb_user";
                        }

                        $query = mysqli_query($conn, $sql);
                        $no = 1;
                        while($row=mysqli_fetch_assoc($query)): ?>
                    <tr>
                        <td><?= $row['nama'] ?></td>
                        <td><?= $row['no_hp'] ?></td>
                        <td><?= $row['username'] ?></td>
                        <td><?= $row['password'] ?></td>
                        <td><?= $row['level'] ?></td>
                        <td>
                            <a href="form_kelola_user.php?edit&id=<?= $row['kd_user'] ?>">Edit</a> |
                            <a href="form_kelola_user.php?hapus&hps=<?= $row['kd_user'] ?>">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </table>
            </form>
        </div>
        <div class="wdh">
            <form method="post">
                <table >
                    <tr class="tr">
                        <td>Nama</td>
                        <td><input type="text" name="nama" value="<?= @$ambil['nama'] ?>"></td>
                    </tr>
                    <tr class="tr">
                        <td>No HP</td>
                        <td><input type="text" name="no_hp" value="<?= @$ambil['no_hp'] ?>"></td>
                    </tr>
                    <tr class="tr">
                        <td>Username</td>
                        <td><input type="text" name="username" value="<?= @$ambil['username'] ?>"></td>
                    </tr>
                    <tr class="tr">
                        <td>Password</td>
                        <td><input type="password" name="password" value="<?= @$ambil['password'] ?>"></td>
                    </tr>
                    <tr class="tr">
                        <td>Level</td>
                        <td>
                            <select name="level">
                                <?php if(isset($_GET['edit'])){ ?>
                                    <option value="<?= @$ambil['level'] ?>"><?= @$ambil['level'] ?></option>
                                     <option value="admin">Admin</option>
                                    <option value="kasir">Kasir</option>
                                <?php }else{ ?>
                                    <option value="">--Pilih--</option>
                                    <option value="admin">Admin</option>
                                    <option value="kasir">Kasir</option>
                                <?php } ?>
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

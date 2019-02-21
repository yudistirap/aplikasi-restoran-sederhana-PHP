<?php
	session_start();

	require 'config/koneksi.php';


	if(isset($_POST['submit'])){
		$user = $_POST['username'];
		$pass = $_POST['password'];


		$query = mysqli_query($conn, "SELECT * FROM tb_user WHERE username = '$user' and password = '$pass' ");
		


		if(mysqli_num_rows($query) > 0){
			$ambil = mysqli_fetch_array($query);
			if( $ambil['level'] == 'Admin'){
				$_SESSION['Admin'] = $user;
				header('location: form_kelola_user.php');
			}elseif ( $ambil['level'] == 'kasir'){
				$_SESSION['kasir'] = $user;
				header('location: form_transaksi.php');
			}else{
				header('location: form_login.php');
			}
	}
}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/logins.css">
    <title>Login User</title>
</head>
<body style="text-align: center;">
 <form method="post"><br><br><br><br><br><br><br><br><br><br>
 
 <label for="username">Username</label> <input type="username" name="username" autocomplete="off" id="username"></input>
<br><br>
 <label for="password">Password</label> <input type="password" name="password" id="password"></input>
 <br><br>
 <button type="submit" name="submit" value="login">Login</button>

 </form>
 
 </body>
</html>

<?php 
	require 'koneksi.php';

	function logins($login){
		global $conn;

		$user = $login['username'];
		$pass = $login['password'];

		$query = ("SELECT * FROM tb_user WHERE username = '$user' AND password = '$pass' ");
		$result = mysqli_query($conn, $query);

		return mysqli_affected_rows($conn);
	}

	function upload(){
		
	}

 ?>
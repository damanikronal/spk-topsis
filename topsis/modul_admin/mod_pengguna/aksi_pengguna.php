<?php
session_start();
include "../../config/koneksi.php";

$modul=$_GET[modul];
$act=$_GET[act];

// Hapus Karyawan
if ($modul=='pengguna' AND $act=='hapus'){
  mysql_query("DELETE FROM pengguna WHERE username='$_GET[id]'");
  header('location:../../indexs.php?modul='.$modul);
}

// Input Karyawan
elseif ($modul=='pengguna' AND $act=='input'){
  $pass=md5($_POST[password]);
  mysql_query("INSERT INTO pengguna(
								 email,
  								 username,
								 password
								 ) 
	                       VALUES('$_POST[email]',
                                '$_POST[username]',
								'$pass'
								)");
  header('location:../../indexs.php?modul='.$modul);
}

// Update Karyawan
elseif ($modul=='pengguna' AND $act=='update'){
  if (empty($_POST[password])) {
     mysql_query("UPDATE pengguna SET level = '$_POST[level]' 
                           WHERE  username       = '$_POST[id]'");
  }
  // Apabila password diubah
  else{
    $pass=md5($_POST[password]);
    mysql_query("UPDATE pengguna SET password = '$pass', level = '$_POST[level]' 
                           WHERE  username       = '$_POST[id]'");
  }
  header('location:../../indexs.php?modul='.$modul);
}
?>


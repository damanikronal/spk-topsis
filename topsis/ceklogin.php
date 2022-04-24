<?php
include "config/koneksi.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}

$username = anti_injection($_POST[username]);
$pass     = anti_injection(md5($_POST[password]));

// pastikan username dan password adalah berupa huruf atau angka.
if (!ctype_alnum($username) OR !ctype_alnum($pass)){
  echo "<div align=center>";
  echo "<p>Login Gagal</p><br>";
  echo "<p>Menuju Ke Halaman Utama, Klik <a href='index.php'>disini</a></p></div>";
}
else{
$login=mysql_query("SELECT * FROM pengguna WHERE username='$username' AND password='$pass'");
$ketemu=mysql_num_rows($login);
$r=mysql_fetch_array($login);

// Apabila username dan password ditemukan
if ($ketemu > 0){
  session_start();

  $_SESSION[namauser]     = $r[username];
  $_SESSION[passuser]     = $r[password];
  $_SESSION[leveluser]    = $r[level];

	$sid_lama = session_id();
	
	session_regenerate_id();

	$sid_baru = session_id();

  header('location:indexs.php?modul=beranda');
}
else{
  echo "<link href=main.css rel=stylesheet type=text/css>";
  echo "<center>LOGIN GAGAL! <br><br> 
        Kemungkinan hal ini disebabkan karena : <br><br>
        Username atau Password Anda tidak benar.<br>
		";
  echo "<a href=index.php><b>ULANGI LAGI</b></a></center>";
}
}
?>
<?php
  session_start();
  session_destroy();
  echo "<center>Anda telah sukses keluar sistem <b>[LOGOUT]<b>";

// Apabila setelah logout langsung menuju halaman utama website, aktifkan baris di bawah ini:
  echo "<meta http-equiv='refresh' content='10;URL=index.php'>";
  echo "<p class='text2'>Otomatis menuju ke halaman utama</p>";
  
?>

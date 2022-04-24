<?php
session_start();
include "../../config/koneksi.php";

$modul=$_GET[modul];
$act=$_GET[act];

// Hapus kriteria
if ($modul=='kriteria' AND $act=='hapus'){
  mysql_query("DELETE FROM kriteria WHERE id_kriteria='$_GET[id]'");
  header('location:../../indexs.php?modul='.$modul);
}

// Input kriteria
elseif ($modul=='kriteria' AND $act=='input'){
  mysql_query("INSERT INTO kriteria(id_kriteria, nama_kriteria, tipe) VALUES('$_POST[id_kriteria]', '$_POST[nama_kriteria]', '$_POST[tipe]')");
  header('location:../../indexs.php?modul='.$modul);
}

// Update kriteria
elseif ($modul=='kriteria' AND $act=='update'){
  mysql_query("UPDATE kriteria SET id_kriteria = '$_POST[id_kriteria]', nama_kriteria = '$_POST[nama_kriteria]', tipe = '$_POST[tipe]' WHERE id_kriteria = '$_POST[id]'");
  mysql_query("UPDATE bobot_kriteria SET id_kriteria = '$_POST[id_kriteria]' WHERE id_kriteria = '$_POST[id]'");
  header('location:../../indexs.php?modul='.$modul);
}
?>

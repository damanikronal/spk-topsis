<?php
session_start();
include "../../config/koneksi.php";

$modul=$_GET[modul];
$act=$_GET[act];
$jlhkriteria = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM kriteria"),0); // Jumlah Kriteria

// Hitung Matrik Perbandingan
if ($modul=='bobot' AND $act=='normalisasi'){
	// FISRT STEP : NORMALISATION BOBOT SCALE
	$jumlah=0;
	for ($i=1;$i<=$jlhkriteria;$i++){
		$w[$i] = $_POST['bobot'.$i];
		$jumlah += $w[$i];
	}
	for ($i=1;$i<=$jlhkriteria;$i++){
		$nama_kriteria[$i] = $_POST['nama_kriteria'.$i];
		$w[$i] = $_POST['bobot'.$i];
		$wn[$i] = round(($w[$i]/$jumlah),2);
		mysql_query("INSERT INTO bobot_kriteria(id_kriteria,bobot) 
		VALUES('$i', '$wn[$i]')");
	}
  header('location:../../indexs.php?modul='.$modul);
}
elseif ($modul=='bobot' AND $act=='hitungulang'){
  mysql_query("DELETE FROM bobot_kriteria");
  header('location:../../indexs.php?modul='.$modul);
}

?>


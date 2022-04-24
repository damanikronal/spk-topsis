<?php
session_start();
include "../../config/koneksi.php";

$modul=$_GET[modul];
$act=$_GET[act];
$jlhkriteria = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM kriteria"),0); // Jumlah Kriteria

// Hapus section
if ($modul=='alternatif' AND $act=='hapus'){
  mysql_query("DELETE FROM alternatif WHERE id_alt='$_GET[id]'");
  mysql_query("DELETE FROM matrik WHERE id_alt='$_GET[id]'");
  header('location:../../indexs.php?modul='.$modul);
}

// Input kriteria
elseif ($modul=='alternatif' AND $act=='input'){
  if ($_POST[nm_alt] !=''){
  	mysql_query("INSERT INTO alternatif(id_alt, nm_alt) VALUES('$_POST[id_alt]', '$_POST[nm_alt]')");
  	for ($i=1;$i<=$jlhkriteria;$i++){ // Criteria
		$x[$i] = $_POST['nilai'.$i];
		$y = $x[$i];
		$z[$i] = $_POST['id_kriteria'.$i];
		$zz = $z[$i];
		mysql_query("INSERT INTO matrik(id_alt, id_kriteria, nilai) VALUES('$_POST[id_alt]', '$zz', '$y')");
	}
  	header('location:../../indexs.php?modul='.$modul);
  }
  else{
  	echo "
  		<script>
		alert('! Maaf Seluruh Field Harus Diisi')
		location = '../../indexs.php?modul=alternatif&act=tambah';
		</script>
	";
  }
}

// Update kriteria
elseif ($modul=='alternatif' AND $act=='update'){
  if ($_POST[id_alt] !='' AND $_POST[nm_alt] !=''){
  	mysql_query("UPDATE alternatif SET id_alt = '$_POST[id_alt]', nm_alt = '$_POST[nm_alt]' WHERE id_alt = '$_POST[id_alt]'");
  	for ($i=1;$i<=$jlhkriteria;$i++){ // Criteria
		$x[$i] = $_POST['nilai'.$i];
		$y = $x[$i];
		mysql_query("UPDATE matrik 
		SET nilai = '$y'  
		WHERE id_alt = '$_POST[id_alt]' AND id_kriteria = '$i'");
	}
  	header('location:../../indexs.php?modul='.$modul);
  }
  else{
  	echo "
  		<script>
		alert('! Maaf Seluruh Field Harus Diisi')
		location = '../../indexs.php?modul=alternatif&act=edit&id=$_POST[id]';
		</script>
	";
  }
}
?>

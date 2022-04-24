<?php
$aksi="modul_admin/mod_bobot/aksi_matrik.php";
switch($_GET[act]){
  // Tampil Matrik Perbandingan Kriteria
  default:
  	$tampil1=mysql_query("SELECT id_kriteria, bobot FROM bobot_kriteria ORDER BY id_kriteria");
	$r1=mysql_num_rows($tampil1);
	if ($r1 > 0){
    	echo "<h2>Bobot Akhir Kriteria</h2>";
		echo "
			<table>
          <tr><th>kriteria</th><th>bobot</th></tr>"; 
		$tampil2=mysql_query("SELECT k.nama_kriteria, b.bobot
		 FROM bobot_kriteria b, kriteria k
		 WHERE b.id_kriteria=k.id_kriteria
		 ORDER BY b.id_kriteria");
		while ($r2=mysql_fetch_array($tampil2)){
		   echo "<tr>
		   		<td>$r2[nama_kriteria]</td>
				 <td>$r2[bobot]</td>
				 </tr>";
		}
		echo "</table>";
		echo "<br>";
		echo "<a href=$aksi?modul=bobot&act=hitungulang>Hitung ulang normalisasi bobot kriteria.</a>";
	}
	else{
		echo "Belum dilakukan normalisasi bobot kriteria. 
		<br><a href=?modul=bobot&act=normalisasi>Buat Normalisasi Bobot Kriteria</a>";
	}
    break;
  
  // Matrik Perbandingan
  case "normalisasi":
    echo "<h2>Normalisasi Bobot Kriteria</h2>";
    echo "<form method='post' action='$aksi?modul=bobot&act=normalisasi'>
		  <table>
          <tr><th>kriteria</th><th>nilai (bobot kriteria)</th></tr>"; 
    $jlhkriteria = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM kriteria"),0); // Jumlah Kriteria
	for ($i=1; $i<=$jlhkriteria; $i++){
		$queri2=mysql_query("SELECT * FROM kriteria WHERE id_kriteria='$i' ORDER BY id_kriteria ASC");
		$kriteria2=mysql_fetch_array($queri2);
		echo "<tr>";
		echo "
			<td>$kriteria2[nama_kriteria]<input type=hidden name='id_kriteria".$i."' value='$kriteria2[id_kriteria]'>
			<input type=hidden name='nama_kriteria".$i."' value='$kriteria2[nama_kriteria]'></td>
			<td><input type=text name='bobot".$i."'></td>
		";
		echo "</tr>";
	}
    echo "</table>
	<input type='submit' name='Submit' value='Submit'><input type=button value=Batal onclick=self.history.back()></form>";
	break;
}
?>
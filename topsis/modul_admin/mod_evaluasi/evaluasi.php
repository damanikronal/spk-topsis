<?php

// Jumlah Alternatif
$jlh_alt = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM alternatif"),0);

// Jumlah Kriteria
$jlh_cri = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM kriteria"),0);

switch($_GET[act]){
  // Tampil Kelas
  default:
  	$tampil1=mysql_query("SELECT id_kriteria, bobot FROM bobot_kriteria ORDER BY id_kriteria");
	$r1=mysql_num_rows($tampil1);
	if ($r1 > 0){
    	echo "<h2>Pemilihan Tempat Kost Mahasiswa</h2>";
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
		echo "<a href=?modul=evaluasi&act=topsis>Gunakan bobot kriteria dan Cari Tempat Kost.</a>";
		echo "<br>";
		echo "Atau<br/>";
		echo "<a href=modul_admin/mod_bobot/aksi_matrik.php?modul=bobot&act=hitungulang>Hitung ulang bobot kriteria dan Cari Tempat Kost.</a>";
	}
	else{
		echo "<a href=?modul=bobot&act=normalisasi>Hitung ulang bobot kriteria dan Cari Tempat Kost.</a>";
	}
    break;
   
  case "topsis":
    // TOPSIS ALGORITHM

	// Step 1 : Buat Matrik Normalisasi R
	for ($i=1;$i<=$jlh_cri;$i++){
		$total=0;
		for ($j=1;$j<=$jlh_alt;$j++){
			$val = mysql_result(mysql_query("SELECT nilai FROM matrik WHERE id_kriteria ='$i' AND id_alt ='$j'"),0);
			$tem_val = pow($val,2);
			$total=$total + $tem_val;
		}
		$m[$i]=$total;
	}
	for ($i=1;$i<=$jlh_alt;$i++){
		for ($j=1;$j<=$jlh_cri;$j++){
			$val_alt = mysql_result(mysql_query("SELECT nilai FROM matrik WHERE id_kriteria ='$j' AND id_alt ='$i'"),0);
			$r[$i][$j]=round(($val_alt / sqrt($m[$j])),4);
		}
	}
	
	// Step 2 : Buat Matrik Normalisasi Y
	mysql_query("DELETE FROM matrik_norm");
	for ($i=1;$i<=$jlh_alt;$i++){
		for ($j=1;$j<=$jlh_cri;$j++){
			$w = mysql_result(mysql_query("SELECT bobot FROM bobot_kriteria WHERE id_kriteria ='$j'"),0);
			$y[$i][$j]=round(($w * $r[$i][$j]),4);
			$k=$y[$i][$j];
			mysql_query("INSERT INTO matrik_norm(id_alt,id_kriteria,nilai_norm) VALUES('$i', '$j', '$k')");
		}
	}
	
	// Step 3 : Cari Solusi Ideal Positif (A+)
	for ($i=1;$i<=$jlh_cri;$i++){
		for ($j=1;$j<=$jlh_alt;$j++){
			// Kueri Ambil Tipe Kriteria
			$cek=mysql_query("SELECT tipe FROM kriteria WHERE id_kriteria='$i'");
			$ccek=mysql_fetch_array($cek);
			// Cek Tipe Kriteria
			if ($ccek[tipe]=="COST"){
				$kueri1 = mysql_query("SELECT min(nilai_norm) FROM matrik_norm WHERE id_kriteria ='$i'");
				$val1=mysql_fetch_row($kueri1);
			}
			elseif ($ccek[tipe]=="BENEFIT"){
				$kueri2 = mysql_query("SELECT max(nilai_norm) FROM matrik_norm WHERE id_kriteria ='$i'");
				$val1=mysql_fetch_row($kueri2);
			}
			$tem_val1=round($val1[0],4);
		}
		$a_plus[$i]=$tem_val1;
	}
	
	// Step 3 : Cari Solusi Ideal Negatif (A-)
	for ($i=1;$i<=$jlh_cri;$i++){
		for ($j=1;$j<=$jlh_alt;$j++){
			// Kueri Ambil Tipe Kriteria
			$cek=mysql_query("SELECT tipe FROM kriteria WHERE id_kriteria='$i'");
			$ccek=mysql_fetch_array($cek);
			// Cek Tipe Kriteria
			if ($ccek[tipe]=="COST"){
				$kueri3 = mysql_query("SELECT max(nilai_norm) FROM matrik_norm WHERE id_kriteria ='$i'");
				$val2=mysql_fetch_row($kueri3);
			}
			elseif ($ccek[tipe]=="BENEFIT"){
				$kueri4 = mysql_query("SELECT min(nilai_norm) FROM matrik_norm WHERE id_kriteria ='$i'");
				$val2=mysql_fetch_row($kueri4);
			}
			$tem_val2=round($val2[0],4);
		}
		$a_minus[$i]=$tem_val2;
	}
	
	// Step 4 : Hitung Jarak Antara Alternatif dengan Solusi Ideal Positif (D+)
	for ($i=1;$i<=$jlh_alt;$i++){
		$tot_plus=0;
		for ($j=1;$j<=$jlh_cri;$j++){
			$sum_plus=pow(($a_plus[$j]-$y[$i][$j]),2);
			$tot_plus=$tot_plus + round($sum_plus,4);
		}
		$d_plus[$i]=round(sqrt($tot_plus),4);
	}
	
	// Step 5 : Hitung Jarak Antara Alternatif dengan Solusi Ideal Negatif (D-)
	for ($i=1;$i<=$jlh_alt;$i++){
		$tot_minus=0;
		for ($j=1;$j<=$jlh_cri;$j++){
			$sum_minus=pow(($y[$i][$j]-$a_minus[$j]),2);
			$tot_minus=$tot_minus + round($sum_minus,4);
		}
		$d_minus[$i]=round(sqrt($tot_minus),4);
	}
	
	// Step 6 : FINAL STEP - Hitung Preferensi Setiap Alternatif (V)
	mysql_query("DELETE FROM hasil");
	for ($i=1;$i<=$jlh_alt;$i++){
		$tem_v[$i]=round(($d_minus[$i]/($d_plus[$i]+$d_minus[$i])),4);
		$v=$tem_v[$i];
		mysql_query("INSERT INTO hasil(id_alt,bobot_hasil) VALUES('$i', '$v')");
	}
	
	// Cari Tempat Kost dengan Bobot Terbesar
	echo "<h2>Pemilihan Tempat Kost Mahasiswa</h2>";
    echo "<table>
          <tr><th>alternatif</th><th>nilai (bobot kriteria)</th></tr>"; 
	$querialt=mysql_query("SELECT h.bobot_hasil, a.nm_alt FROM hasil h, alternatif a WHERE h.id_alt=a.id_alt ORDER BY h.bobot_hasil DESC");
    while ($alth=mysql_fetch_array($querialt)){
		echo "<tr><td>$alth[nm_alt]</td><td>$alth[bobot_hasil]</td></tr>";
	}
	$rialt=mysql_query("SELECT h.bobot_hasil, a.nm_alt FROM hasil h, alternatif a WHERE h.id_alt=a.id_alt ORDER BY h.bobot_hasil DESC");
	$ralt=mysql_fetch_array($rialt);
	echo "<tr><td colspan='2'>Rekomendasi Pilihan Tempat Kost : $ralt[nm_alt] dengan Bobot $ralt[bobot_hasil]</td></tr>";
    echo "</table>";
	echo "<h2>Cetak Hasil Keputusan</h2>
          <form method='POST' action='config/cetak.php'>
          <table>
		  ";?> 
		  
	<?
	echo "
		  <tr><td colspan=2><input type=submit name=submit value=Cetak></td></tr>
          </table></form>"; 
	break;

}

?>

<?php

include "koneksi.php";

// Jumlah Alternatif
$jlh_alt = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM alternatif"),0);

// Jumlah Kriteria
$jlh_cri = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM kriteria"),0);

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

?>
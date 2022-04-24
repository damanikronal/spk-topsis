<?
// Otomasi Kode Kriteria
$oto_cri=mysql_query("SELECT id_kriteria FROM kriteria ORDER BY id_kriteria DESC LIMIT 1");
$rows=mysql_num_rows($oto_cri);
if ($rows >= 1) {
	$temcri=mysql_fetch_row($oto_cri);
	$val_otocri = $temcri[0] + 1;
}
else{
	$val_otocri=1;
}
// Otomasi Kode Alterntif
$oto_alt=mysql_query("SELECT id_alt FROM alternatif ORDER BY id_alt DESC LIMIT 1");
$rowalt=mysql_num_rows($oto_alt);
if ($rowalt >= 1) {
	$temalt=mysql_fetch_row($oto_alt);
	$val_otoalt = $temalt[0] + 1;
}
else{
	$val_otoalt=1;
}
?>
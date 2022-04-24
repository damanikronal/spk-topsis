<?php
$aksi="modul_admin/mod_alternatif/aksi_alternatif.php";
$jlhkriteria = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM kriteria"),0); // Jumlah Kriteria

switch($_GET[act]){
  // Tampil Kriteria
  default:
    echo "<h2>Manajemen Data Alternatif</h2>
          <input type=button value='Tambah Alternatif' 
          onclick=\"window.location.href='?modul=alternatif&act=tambah';\">
          <table>
          <tr><th>id alternatif</th><th>nama alternatif</th><th>aksi</th></tr>"; 
	// Paging
  	$hal = $_GET[hal];
	if(!isset($_GET['hal'])){ 
		$page = 1; 
		$hal = 1;
	} else { 
		$page = $_GET['hal']; 
	}
	$jmlperhalaman = 10;  // jumlah record per halaman
	$offset = (($page * $jmlperhalaman) - $jmlperhalaman);
    $tampil=mysql_query("SELECT * FROM alternatif ORDER BY id_alt ASC LIMIT $offset, $jmlperhalaman");
    while ($r=mysql_fetch_array($tampil)){
       echo "<tr><td>$r[id_alt]</td>
             <td>$r[nm_alt]</td>
             <td><a href=?modul=alternatif&act=edit&id=$r[id_alt]>Edit</a> | ";
?>
	   <a href="modul_admin/mod_alternatif/aksi_alternatif.php?modul=alternatif&act=hapus&id=<? echo "$r[id_alt]"; ?>" target="_self" 
	 onClick="return confirm('Apakah Anda yakin menghapus data ini ?' +  '\n' 
							+ ' <?php echo "- Id Alternatif  = $r[id_alt]"; ?> ' +  '\n' 
							+ ' <?php echo "- Alternatif = $r[nm_alt]"; ?> ' +  '\n \n' 
						+ ' Jika YA silahkan klik OK, Jika TIDAK klik BATAL.')">Hapus</a></td>            
<?	   
	   echo "</tr>";
    }
    echo "</table>";
	// membuat nomor halaman
	$total_record = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM alternatif"),0);
	$total_halaman = ceil($total_record / $jmlperhalaman);
	echo "<center>Halaman :<br/>"; 
	$perhal=4;
	if($hal > 1){ 
		$prev = ($page - 1); 
		echo "<a href=indexs.php?modul=alternatif&hal=$prev> << </a> "; 
	}
	if($total_halaman<=10){
	$hal1=1;
	$hal2=$total_halaman;
	}else{
	$hal1=$hal-$perhal;
	$hal2=$hal+$perhal;
	}
	if($hal<=5){
	$hal1=1;
	}
	if($hal<$total_halaman){
	$hal2=$hal+$perhal;
	}else{
	$hal2=$hal;
	}
	for($i = $hal1; $i <= $hal2; $i++){ 
		if(($hal) == $i){ 
			echo "[<b>$i</b>] "; 
			} else { 
		if($i<=$total_halaman){
				echo "<a href=indexs.php?modul=alternatif&hal=$i>$i</a> "; 
		}
		} 
	}
	if($hal < $total_halaman){ 
		$next = ($page + 1); 
		echo "<a href=indexs.php?modul=alternatif&hal=$next>>></a>"; 
	} 
	echo "</center><br/>";
    break;
  
  // Form Tambah Kategori
  case "tambah":
  include "config/otomasi.php";
    echo "<h2>Tambah Alternatif</h2>
          <form method=POST action='$aksi?modul=alternatif&act=input'>
          <table>
          <tr><td>Id Alternatif</td><td> : <input readonly type=text name='id_alt' value='$val_otoalt'></td></tr>
		  <tr><td>Nama Alternatif</td><td> : <input type=text name='nm_alt'></td></tr>";
	for ($i=1; $i<=$jlhkriteria; $i++){
			$queri2=mysql_query("SELECT * FROM kriteria WHERE id_kriteria='$i' ORDER BY id_kriteria ASC");
			$kriteria2=mysql_fetch_array($queri2);
			echo "<tr>";
			echo "
			<td>
			$kriteria2[nama_kriteria]<input type=hidden name='id_kriteria".$i."' value='$kriteria2[id_kriteria]'>
			</td>
			<td> : <input type=text name='nilai".$i."'></td>
				 ";
			echo "</tr>";
	}
	echo "<tr><td colspan=2><input type=submit name=submit value=Simpan>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
     break;
  
  // Form Edit Kategori  
  case "edit":
    $edit=mysql_query("SELECT * FROM alternatif WHERE id_alt='$_GET[id]'");
    $r=mysql_fetch_array($edit);
	$edit1=mysql_query("SELECT m.nilai, k.nama_kriteria, m.id_kriteria FROM matrik m, kriteria k
	 WHERE m.id_alt='$_GET[id]' AND k.id_kriteria=m.id_kriteria ORDER BY id_alt,id_kriteria ASC");

    echo "<h2>Edit Alternatif</h2>
          <form method=POST action=$aksi?modul=alternatif&act=update>
          <input type=hidden name=id value='$r[id_alt]'>
          <table>
          <tr><td>Id Alternatif</td><td> : <input type=text readonly name='id_alt' value='$r[id_alt]'></td></tr>
		  <tr><td>Nama Alternatif</td><td> : <input type=text name='nm_alt' value='$r[nm_alt]'></td></tr>";
	while ($r1=mysql_fetch_array($edit1)){
       echo "<tr><td>$r1[nama_kriteria]</td><td> : <input type=text name='nilai".$r1[id_kriteria]."' value='$r1[nilai]'></td></tr>";
	}	  
	echo "<tr><td colspan=2><input type=submit value=Update>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
    break;  
	
}
?>


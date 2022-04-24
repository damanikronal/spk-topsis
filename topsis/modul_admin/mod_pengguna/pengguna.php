<?php
$aksi="modul_admin/mod_pengguna/aksi_pengguna.php";
switch($_GET[act]){
  // Tampil Karyawan
  default:
    echo "<h2>Manajemen Data Pengguna</h2>
          <input type=button value='Tambah Pengguna' onclick=\"window.location.href='?modul=pengguna&act=tambah';\">
          <table>
          <tr><th>email</th><th>username</th><th>password</th><th>level</th><th>aksi</th></tr>"; 
	// Paging
  	$hal = $_GET[hal];
	if(!isset($_GET['hal'])){ 
		$page = 1; 
		$hal = 1;
	} else { 
		$page = $_GET['hal']; 
	}
	$jmlperhalaman = 5;  // jumlah record per halaman
	$offset = (($page * $jmlperhalaman) - $jmlperhalaman);
    $tampil=mysql_query("SELECT * FROM pengguna ORDER BY username ASC LIMIT $offset, $jmlperhalaman");
    while ($r=mysql_fetch_array($tampil)){
       echo "<tr>
			 <td>$r[email]</td>
             <td>$r[username]</td>
			 <td>$r[password]</td>
			 <td>$r[level]</td>
		     <td><a href=?modul=pengguna&act=edit&id=$r[username]>Edit</a> | ";
	               
?>
	   <a href="modul_admin/mod_pengguna/aksi_pengguna.php?modul=pengguna&act=hapus&id=<? echo "$r[username]"; ?>" target="_self" 
	 onClick="return confirm('Apakah Anda yakin menghapus data ini ?' +  '\n' 
							+ ' <?php echo "- Email  = $r[email]"; ?> ' +  '\n'
							+ ' <?php echo "- Username  = $r[username]"; ?> ' +  '\n \n' 
						+ ' Jika YA silahkan klik OK, Jika TIDAK klik BATAL.')">Hapus</a></td>            
<?	   
	   echo "</tr>";
    }
    echo "</table>";
	// membuat nomor halaman
	$total_record = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM pengguna"),0);
	$total_halaman = ceil($total_record / $jmlperhalaman);
	echo "<center>Halaman :<br/>"; 
	$perhal=4;
	if($hal > 1){ 
		$prev = ($page - 1); 
		echo "<a href=indexs.php?modul=pengguna&hal=$prev> << </a> "; 
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
				echo "<a href=indexs.php?modul=pengguna&hal=$i>$i</a> "; 
		}
		} 
	}
	if($hal < $total_halaman){ 
		$next = ($page + 1); 
		echo "<a href=indexs.php?modul=pengguna&hal=$next>>></a>"; 
	} 
	echo "</center><br/>";
    break;
  
  case "tambah":
    echo "<h2>Tambah Pengguna</h2>
          <form method=POST action='$aksi?modul=pengguna&act=input'>
          <table>
          <tr><td>Email</td>     <td> : <input type=text name='email'></td></tr>
          <tr><td>Username</td> <td> : <input type=text name='username' size=30></td></tr>
		  <tr><td>Password</td>   <td> : <input type=password name='password' size=20></td></tr>
		  <tr><td colspan=2><input type=submit value=Simpan>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
     break;
    
  case "edit":
    $edit=mysql_query("SELECT * FROM pengguna WHERE username='$_GET[id]'");
    $r=mysql_fetch_array($edit);

    echo "<h2>Edit Pengguna</h2>
          <form method=POST action=$aksi?modul=pengguna&act=update>
          <input type=hidden name=id value='$r[username]'>
          <table>
		  <tr><td>Email</td> <td> : <input type=text readonly name='email' size=30 value='$r[email]'></td></tr>
		  <tr><td>Username</td>     <td> : <input type=text readonly name='username' value='$r[username]'></td></tr>
          <tr><td>Password</td>     <td> : <input type=text name='password'></td></tr>
		  <tr><td colspan=2>*) Apabila password tidak diubah, dikosongkan saja.</td></tr>";

    if ($r[level]=='admin'){
      echo "<tr><td>Level</td>     <td> : <input type=radio name='level' value='admin' checked> Admin   
                                           <input type=radio name='level' value='user'> User
                                           </td></tr>";
    }
    else  if ($r[level]=='user'){
      echo "<tr><td>Level</td>     <td> : <input type=radio name='level' value='admin'> Admin   
                                           <input type=radio name='level' value='user' checked> User
                                           </td></tr>";
    }
    echo "
          <tr><td colspan=2><input type=submit value=Update>
                            <input type=button value=Batal onclick=self.history.back()></td></tr>
          </table></form>";
    break;  
}
?>

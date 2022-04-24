<?php
session_start();

if (empty($_SESSION[username]) AND empty($_SESSION[passuser])){
  echo "<link href='main.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=index.php><b>LOGIN</b></a></center>";
}
else{
?>
<?php
include "config/setting.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style.css" />
<title><?php echo "$title"; ?></title>
</head>
<body>

<div id="wrap">

<div id="header">
<h1><a href="http://kroseva.wordpress.com"><?php echo "$header"; ?></a></h1>
<h2>DSS using TOPSIS Algorithm</h2>
</div>

<div id="menu">
<ul>
<li><a href="?modul=beranda">Home</a></li>
</ul>
</div>

<div id="contentwrap"> 

<div id="content">
<?php
include "content.php";
?> 
<div style="clear: both;"> </div>
</div>

<div id="sidebar">
<h3>Navigation </h3>
<ul>
  <?php include "menu.php"; ?>
  <li><a href=?modul=bantuan>Bantuan</a></li>
  <li><a href=?modul=tentang>Tentang SPK</a></li>
  <li><a href=logout.php>Logout</a></li>
</ul>
</div>

<div style="clear: both;"> </div>

</div>

<div id="footer">
<a href="http://kroseva.wordpress.com/"><?php echo " $footer"; ?></a> | Template by <a href="http://youngdriversinsurancezone.com/">Young Drivers Insurance</a></p>
</div>

</div>

</body>
</html>
<?php
}
?>

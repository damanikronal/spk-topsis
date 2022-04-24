<?php
include "config/koneksi.php";
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
<li><a href="index.php">Home</a></li>
</ul>
</div>

<div id="contentwrap"> 

<div id="content">

<h2>Definisi Sistem</h2>

<p>Sistem Pendukung Keputusan Pemilihan Tempat Kost adalah sebuah sistem informasi yang dipakai untuk mendukung pengambilan keputusan dalam hal pemilihan tempat kost mahasiswa. 
Adapun sistem ini dibangun menggunakan bahasa pemrograman PHP dan memakai MySQl dalam hal pengolahan database.</p> 

<p>Pemilihan tempat kost mahasiswa dikategorikan sebagai permasalahan Multi Attribut Decision Making (MADM).
Dengan kriteria penilaian yang ditinjau adalah Jarak dengan kampus, fasilitas kamar, biaya listrik, jarak dengan fasilitas umum dan harga sewa. 
Untuk membantu dalam menentukan pilihan yang tepat, dipakai algoritma 
<a href="http://en.wikipedia.org/wiki/TOPSIS">Technique for Order Preference by Similarity to Ideal Solution (TOPSIS) </a>.</p>

<div style="clear: both;"> </div>
</div>

<div id="sidebar">
<h3>Control Panel </h3>
<?php include "login.php"; ?>
</div>

<div style="clear: both;"> </div>

</div>

<div id="footer">
<a href="http://kroseva.wordpress.com/"><?php echo " $footer"; ?></a> | Template by <a href="http://youngdriversinsurancezone.com/">Young Drivers Insurance</a></p>
</div>

</div>

</body>
</html>

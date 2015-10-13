<?php
// Memanggil berkas EXIF.PHP untuk membaca parameter informasi photo
require_once "exif.php";
// Mendefinisikan waktu pada saat dieksekusi
$sekarang = date("Y-m-d");
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<title>Identifikasi Photo Digital</title>
<script
src="http://maps.googleapis.com/maps/api/js">
</script>
<script>
var myCenter=new google.maps.LatLng(<?php echo $result[0]; ?>, <?php echo $result[1]; ?>);

function initialize()
{
var mapProp = {
  center:myCenter,
  zoom:15,
  mapTypeId:google.maps.MapTypeId.ROADMAP
  };

var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);

var marker=new google.maps.Marker({
  position:myCenter,
  });

marker.setMap(map);
}

google.maps.event.addDomListener(window, 'load', initialize);
</script>
</head>

<body>
<!-- Fixed navbar -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Menu</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Identifikasi Photo Digital</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="index.html">Beranda</a></li>
            <li><a href="#about">Tentang</a></li>
            <li><a href="#contact">Kontak</a></li>
 		</ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container theme-showcase" role="main">

      <!-- Main jumbotron for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1>Identifikasi Photo Digital</h1>
        <p>Menemukan beberapa informasi yang terdapat dalam berkas photo digital.</p>
      </div>


      <div class="page-header">
          <div class="row">

            <div class="col-sm-6">

<div class="panel panel-default">
<div class="panel-heading">
Lokasi Photo
</div>
<div class="panel-body">
<?php
// Tidak akan memunculkan informasi GPS jika GPSLatitudeRef bernilai 'Tidak terdeteksi'
if(($camera['GPSLatitudeRef'] == 'Tidak terdeteksi') OR ($camera['GPSLatitudeRef'] == '')){
echo "<strong>Informasi Lokasi tidak terdeteksi</strong>";
} else {
?>
<div  id="googleMap" style="width:420px;height:300px;"></div>
<?php
}
?>
</div>
</div>
</div>

<div class="col-sm-6">
<div class="panel panel-default">
<div class="panel-heading">
Photo
</div>
<div class="panel-body">
<img src="<?php echo $image; ?>" width="420px" height="300px" />
</div>
</div>
</div>
<div class="col-lg-12">
<br />

<table class="table table-bordered">
<thead>
<tr>
<th>Nama Informasi</th>
<th>Nilai Informasi</th>
</tr>
</thead>
<tbody>
<tr>
<td>Perangkat: </td>
<td><?php echo $camera['make'] . " " . $camera['model'] . "<br />"; ?></td>
</tr>
<tr>
<td>Exposure Time: </td>
<td><?php echo $camera['exposure'] . "<br />"; ?></td>
</tr>
<tr>
<td>Aperture/Bukaan: </td>
<td><?php echo $camera['aperture'] . "<br />"; ?></td>
</tr>
<tr>
<td>ISO: </td>
<td><?php echo $camera['iso'] . "<br />"; ?></td>
</tr>
<?php
if($camera['date'] == 'Tidak terdeteksi'){

} else {
?>
<tr>
<td>Diambil pada waktu: </td>
<td><?php echo $camera['date'] . "<br />"."Sekitar ".date_diff(date_create($camera['date']), date_create($sekarang))->format('%y tahun %d hari %h jam and %i menit %s detik yang lalu');
; ?></td>
</tr>
<?php
}
?>
<tr>
<td>Ukuran: </td>
<td><?php echo $camera['width'] . " x ".$camera['height']."<br />"; ?></td>
</tr>
<tr>
<td>Megapixels: </td>
<td><?php echo $megapixels ."<br />"; ?></td>
</tr>
<tr>
<td>Rasio: </td>
<td><?php echo $camera['ratio_pixels'] ."<br />"; ?></td>
</tr>
<tr>
<td>Megapixels: </td>
<td><?php echo $megapixels ."<br />"; ?></td>
</tr>
<?php
if($camera['GPSLatitudeRef'] == 'Tidak terdeteksi'){

} else {
?>
<tr>
<td>GPSLatitudeRef: </td>
<td><?php echo $camera['GPSLatitudeRef'] ."<br />"; ?></td>
</tr>
<tr>
<td>GPSLatitude: </td>
<td><?php echo "" . implode(" ",$camera['GPSLatitude']) ."<br />"; ?></td>
</tr>
<tr>
<td>GPSLongitudeRef: </td>
<td><?php echo $camera['GPSLongitudeRef'] ."<br />"; ?></td>
</tr>
<tr>
<td>GPSLongitude: </td>
<td><?php echo "" . implode(" ",$camera['GPSLongitude']) ."<br />"; ?></td>
</tr>
<tr>
<td>GPS: </td>
<td><?php echo "" . implode(" ",$result) ."<br />"; ?></td>
</tr>
<?php
}
?>
	</tbody>
</table>

</div>
</div>
</div>
</div>
</body>
</html>

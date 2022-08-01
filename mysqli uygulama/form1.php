<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
?>
<?php require_once("form2.php"); ?>
<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Veritabanı İşlemleri</title>
</head>

<body>
<?php
@$islem=$_GET["islem"];
@$id=$_GET["id"];

switch($islem){
    case "sil":?>
    <table class="table  table-bordered table-hover" style="text-align:center">
    <thead>
      <tr class="table-light">
        <th colspan="8"><?php islemler::sil($id,$db); ?><th>
        </thead>
    <tbody>  
            
<?php
    break;

    case "ekle"://veri eklenecek alan
      islemler::ekleme($db);
    break;

    case "ekleson"://veritabanına veriyi ekleme
      islemler::ekleson($db);
    break;

    case "guncelle":
      islemler::guncelleme($db);
    break;

    case "guncelleson":
      islemler::guncelleson($db);
    break;
    

    case "aramasonuc":
      islemler::aramasonuc($db);
    break;

    default:
?>
<div class="container">
  <h2>ÜYELER</h2><?php islemler::kayitsayisi($db);  ?>

    
  <table class="table  table-bordered table-hover" style="text-align:center">
  <thead> 
      <tr>
      <th colspan="8"> <?php islemler::aramaform(); ?></th>
      </tr>
    </thead>
    <thead> 
      <tr class="table-light">
        <th>Üye id</th>
        <th>Ad</th>
        <th>Soyad</th>
        <th>Tc</th>
        <th>Meslek</th>
        <th>Aidat</th>
        <th>Üye Tipi</th>
        <th>İşlemler <a href="form1.php?islem=ekle" class="btn btn-success">EKLE</a></th>
      </tr>
    </thead>
    <tbody>  
      
<?php
islemler::listele($db);//sadece static fonksiyonlara bu şekilde erişilir.
?>
</tbody>   
</table>
</div>


<?php
}
?>
</body>
</html>
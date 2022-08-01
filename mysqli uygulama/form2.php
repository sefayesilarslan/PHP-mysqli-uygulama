<?php

$db=new mysqli("localhost","kullaniciadi","şifre","veritabaniadi") or die("Veritabanı Baglantısı başarısız!!!");
$db->set_charset("utf8");

class islemler{
    public static function listele($veri){

        $sorgu="select * from kisisel";
        $veriler=$veri->prepare($sorgu);
        $veriler->execute();
        $sonuc=$veriler->get_result();  
        
        if($sonuc->num_rows==0){
            echo '<tr class="table-danger">
            <td colspan="8"><p class="text-danger">Kayıt Yok</p></td>
            </tr>';
        }
        else{
            while($satir=$sonuc->fetch_assoc()){
            echo '<tr>
              <td>'.$satir["id"].'</td>
              <td>'.$satir["ad"].'</td>
              <td>'.$satir["soyad"].'</td>
              <td>'.$satir["tc"].'</td>
              <td>'.$satir["meslek"].'</td>
              <td>'.$satir["aidat"].'</td>
              <td>'.islemler::yetki($satir["yetki"]).'</td>
              <td style="text-align:center;"><a href="form1.php?islem=guncelle&id='.$satir["id"].'" class="btn btn-info" >Güncelle</a>
              <a href="form1.php?islem=sil&id='.$satir["id"].'"" class="btn btn-danger" >Sil</a>
              
              </td>
            </tr>';
            }
            $veri->close();
        }
        
    }

public static function yetki($veri){
    $sondurum;

   if($veri==1){
        return $sondurum='<p class="text-success">Normal Üye</p>';
   }
   elseif($veri==2){  
        return  $sondurum='<p class="text-warning">Özel Üye</p>';
        }
    elseif ($veri==3){
        return  $sondurum='<p class="text-danger">Yönetici Üye</p>';
    }
 
}

public static function sil($veri1,$veri2){

    if($veri1!=""){
        $sil="delete from kisisel where id=$veri1";
        $tamam=$veri2->prepare($sil);
        $tamam->execute();
        $sonuc=$tamam->get_result();
        
            if(!$sonuc){
                echo '<div class=text-success>Kayıt başarılı bir şekilde Silinmiştir...<br>Ana sayfaya Yönlendiriliyor....</div>';
                header("refresh:3;url=form1.php");
            }
            else{
                echo '<div class=text-danger>Hata meydana geldi !!!!<br>Ana sayfaya Yönlendiriliyorsunuz....</div>';
                header("refresh:3;url=form1.php");
            }
    

    }
    else{
        echo '<div class=text-danger>Hata meydana geldi !!!!<br>Ana sayfaya Yönlendiriliyor....</div>';
                header("refresh:3;url=form1.php");
    }


}

public static function ekleme(){
?>
<form action="form1.php?islem=ekleson" method="POST">
<table class="table  table-bordered " style="text-align:center">
   
   <thead>
     <tr>
       <th colspan="12">YENI ÜYE KAYDET</th>      
     </tr>
   </thead>
   
   <tbody>
   <tr>
   <th colspan="4"></th>
   <th colspan="4">Ad</th>
   <th colspan="4" style="text-align:left;"><input name="ad" type="text" /></th>
   </tr>
   
   <tr>
   <th colspan="4"></th>
   <th colspan="4">Soyad</th>
   <th colspan="4" style="text-align:left;"><input name="soyad" type="text" /></th>
   </tr>
   
   <tr>
   <th colspan="4"></th>
   <th colspan="4">Tc</th>
   <th colspan="4" style="text-align:left;"><input name="tc" type="text" /></th>
   </tr>
   
   <tr>
   <th colspan="4"></th>
   <th colspan="4">Meslek</th>
   <th colspan="4" style="text-align:left;"><input name="meslek" type="text" /></th>
   </tr>
   
   <tr>
   <th colspan="4"></th>
   <th colspan="4">Aidat</th>
   <th colspan="4" style="text-align:left;"><input name="aidat" type="text" /></th>
   </tr>
   
   <tr>
   <th colspan="4"></th>
   <th colspan="4">Yetki</th>
   <th colspan="4" style="text-align:left;">
   <select name="yetki">
   <option value="1">Normal Üye </option>
   <option value="2">Özel Üye</option>
   <option value="3">Yönetici Üye</option>
   </select></th>
   </tr>
   
    <tr>
   <th colspan="12"><input type="submit" name="formbuton" class="btn btn-success" value="EKLE"></th>

   </tr>
   
   </tbody>
   
   
</table>
</form>
<?php
}

public static function ekleson($veri){
$button=$_POST["formbuton"];

if($button){
    $ad=htmlspecialchars($_POST["ad"]);
    $soyad=htmlspecialchars($_POST["soyad"]);
    $tc=htmlspecialchars($_POST["tc"]);
    $meslek=htmlspecialchars($_POST["meslek"]);
    $aidat=htmlspecialchars($_POST["aidat"]);
    $yetki=htmlspecialchars($_POST["yetki"]);

$sqlekleme="insert into kisisel(ad,soyad,tc,meslek,aidat,yetki) VALUES('$ad','$soyad',$tc,'$meslek',$aidat,$yetki)";//stringleri tırnak içine almamız gerekiyor
$ekle=$veri->prepare($sqlekleme);
$ekle->execute();
$eklendi=$ekle->get_result();
        if(!$eklendi){
            echo '<div class=text-success>Kayıt başarılı bir şekilde Eklenmiştir...<br>Ana sayfaya Yönlendiriliyor....</div>';
            header("refresh:3;url=form1.php");
        }
        else{
            echo '<div class=text-danger>Kayıt BAŞARISIZ OLDU !!!!<br>Ana sayfaya Yönlendiriliyor....</div>';
            header("refresh:3;url=form1.php");
        }

}
else{
    echo '<div class=text-danger>HATA MEYDANA GELDİ<br>Ana sayfaya Yönlendiriliyor....</div>';
    header("refresh:3;url=form1.php");
}
$veri->close();
}

public static function guncelleme($gundb){
    @$id=$_GET["id"];
    $liste="select * from kisisel where id=$id";
    $guncelle=$gundb->prepare($liste);
    $guncelle->execute();
    $guncellendi=$guncelle->get_result();
    $result=$guncellendi->fetch_assoc();

    ?>
    <form action="form1.php?islem=guncelleson" method="POST">
    <table class="table  table-bordered " style="text-align:center">
       
       <thead>
         <tr>
           <th colspan="12">GÜNCELLEME FORMU</th>      
         </tr>
       </thead>
       
       <tbody>
       <tr>
       <th colspan="4"></th>
       <th colspan="4">Ad</th>
       <th colspan="4" style="text-align:left;"><input name="ad" type="text" value="<?php echo $result["ad"]; ?>" /></th>
       </tr>
       
       <tr>
       <th colspan="4"></th>
       <th colspan="4">Soyad</th>
       <th colspan="4" style="text-align:left;"><input name="soyad" type="text" value="<?php echo $result["soyad"]; ?>"  /></th>
       </tr>
       
       <tr>
       <th colspan="4"></th>
       <th colspan="4">Tc</th>
       <th colspan="4" style="text-align:left;"><input name="tc" type="text" value="<?php echo $result["tc"]; ?>"  /></th>
       </tr>
       
       <tr>
       <th colspan="4"></th>
       <th colspan="4">Meslek</th>
       <th colspan="4" style="text-align:left;"><input name="meslek" type="text" value="<?php echo $result["meslek"]; ?>"  /></th>
       </tr>
       
       <tr>
       <th colspan="4"></th>
       <th colspan="4">Aidat</th>
       <th colspan="4" style="text-align:left;"><input name="aidat" type="text" value="<?php echo $result["aidat"]; ?>"  /></th>
       </tr>
       
       <tr>
       <th colspan="4"></th>
       <th colspan="4">Yetki</th>
       <th colspan="4" style="text-align:left;">
       <select name="yetki">
        <?php
                if($result["yetki"]==1 ){
                    echo'<option value="1" selected="selected">Normal Üye </option>
                    <option value="2">Özel Üye</option>
                    <option value="3">Yönetici Üye</option>';
                }
                elseif($result["yetki"]==2 ){
                    echo'<option value="1">Normal Üye </option>
                    <option value="2"  selected="selected">Özel Üye</option>
                    <option value="3">Yönetici Üye</option>';
                }
                elseif($result["yetki"]==3 ){
                    echo'<option value="1">Normal Üye </option>
                    <option value="2"  >Özel Üye</option>
                    <option value="3" selected="selected">Yönetici Üye</option>';
                }

        ?>
       </select></th>
       </tr>
       
        <tr>
            
       <th colspan="12">
       <input type="hidden" name="uyeid" value="<?php echo $result["id"]; ?>">
        <input type="submit" name="formbuton" class="btn btn-success" value="EKLE"></th>
    
       </tr>
       
       </tbody>
       
       
    </table>
    </form>
    <?php
    }

    public static function guncelleson($veri){
        $button=$_POST["formbuton"];
        
        if($button){
            $id=$_POST["uyeid"];
            $ad=htmlspecialchars($_POST["ad"]);
            $soyad=htmlspecialchars($_POST["soyad"]);
            $tc=htmlspecialchars($_POST["tc"]);
            $meslek=htmlspecialchars($_POST["meslek"]);
            $aidat=htmlspecialchars($_POST["aidat"]);
            $yetki=htmlspecialchars($_POST["yetki"]);
        
        $sqlguncelle="update kisisel set ad='$ad',soyad='$soyad',tc=$tc,meslek='$meslek',aidat=$aidat,yetki=$yetki where id=$id" ;//stringleri tırnak içine almamız gerekiyor
        $guncelleson=$veri->prepare($sqlguncelle);
        $guncelleson->execute();
        $guncellendi=$guncelleson->get_result();
                if(!$guncellendi){
                    echo '<div class=text-success>Kayıt Güncellendi...<br>Ana sayfaya Yönlendiriliyor....</div>';
                    header("refresh:3;url=form1.php");
                }
                else{
                    echo '<div class=text-danger>Güncelleme BAŞARISIZ OLDU !!!!<br>Ana sayfaya Yönlendiriliyor....</div>';
                    header("refresh:3;url=form1.php");
                }
        
        }
        else{
            echo '<div class=text-danger>HATA MEYDANA GELDİ<br>Ana sayfaya Yönlendiriliyor....</div>';
            header("refresh:3;url=form1.php");
        }
        $veri->close();
        }

public static function aramaform(){
    ?>
    <form action="form1.php?islem=aramasonuc" method="POST">
    Aranacak Veri : <select name="kriter">
      <option value="ad">Ad</option>
      <option value="soyad">Soyad</option>
      <option value="tc">Tc</option>
      <option value="meslek">Meslek</option>
      <option value="aidat">Aidat</option>
      <option value="yetki">Üye Tipi</option>
    </select>
    <input type="text" name="ara" placeholder="Aranacak Veri">
    <input type="submit" name="buton" value="ARA">
</form>
<?php
}

public static function aramasonuc($dbveri){
?>
<div class="container">
  <h2><a href="form1.php">Ana Sayfaya Dön</a><br>Arama sonuçları</h2>

    
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
        $kriter=htmlspecialchars($_POST["kriter"]);
        $veri=htmlspecialchars($_POST["ara"]);
        $buton=$_POST["buton"];


        if($buton){
            if($kriter=="ad" || $kriter=="soyad" || $kriter=="meslek"){
                $ara="select * from kisisel where $kriter LIKE'%$veri%'";
                $aramasonucu=$dbveri->prepare($ara);
                $aramasonucu->execute();
                $bulundu=$aramasonucu->get_result();

                         if($bulundu->num_rows!=0){

                                while($satir=$bulundu->fetch_assoc()){
                                    echo '<tr>
                                    <td>'.$satir["id"].'</td>
                                    <td>'.$satir["ad"].'</td>
                                    <td>'.$satir["soyad"].'</td>
                                    <td>'.$satir["tc"].'</td>
                                    <td>'.$satir["meslek"].'</td>
                                    <td>'.$satir["aidat"].'</td>
                                    <td>'.islemler::yetki($satir["yetki"]).'</td>
                                    <td style="text-align:center;"><a href="form1.php?islem=guncelle&id='.$satir["id"].'" class="btn btn-info" >Güncelle</a>
                                    <a href="form1.php?islem=sil&id='.$satir["id"].'"" class="btn btn-danger" >Sil</a>
                                    
                                    </td>
                                    </tr>';
                                    }
                         }
                         else{
                            echo '<div class=text-danger>Böyle Bir Kayıt YOk!!!<br>Ana sayfaya Yönlendiriliyor....</div>';
                            header("refresh:3;url=form1.php");
                         }



            }
            else{
                    //Diger kriterleri bulmak için
                    $ara="select * from kisisel where $kriter LIKE'$veri'";
                    $aramasonucu=$dbveri->prepare($ara);
                    $aramasonucu->execute();
                    $bulundu=$aramasonucu->get_result();
    
                             if($bulundu->num_rows!=0){
    
                                    while($satir=$bulundu->fetch_assoc()){
                                        echo '<tr>
                                        <td>'.$satir["id"].'</td>
                                        <td>'.$satir["ad"].'</td>
                                        <td>'.$satir["soyad"].'</td>
                                        <td>'.$satir["tc"].'</td>
                                        <td>'.$satir["meslek"].'</td>
                                        <td>'.$satir["aidat"].'</td>
                                        <td>'.islemler::yetki($satir["yetki"]).'</td>
                                        <td style="text-align:center;"><a href="form1.php?islem=guncelle&id='.$satir["id"].'" class="btn btn-info" >Güncelle</a>
                                        <a href="form1.php?islem=sil&id='.$satir["id"].'"" class="btn btn-danger" >Sil</a>
                                        
                                        </td>
                                        </tr>';
                                        }
                             }
                             else{
                                echo '<div class=text-danger>Böyle Bir Kayıt YOk!!!<br>Ana sayfaya Yönlendiriliyor....</div>';
                                header("refresh:3;url=form1.php");
                             }

            }
        }
        
?>
</tbody>   
</table>
</div>




<?php
}

public static function kayitsayisi($satir){

    $veritabanı="select * from kisisel";
    $satirsayisi=$satir->prepare($veritabanı);
    $satirsayisi->execute();
    $satirsonuc=$satirsayisi->get_result();

    echo '<p class=text-warning>Toplam kayıtlı üye sayısı : <strong>'.$satirsonuc->num_rows.'<strong><p>';
    
}

}


    



?>
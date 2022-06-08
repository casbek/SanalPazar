<?php

    require "libs/vars.php";
    require "libs/functions.php";  
  

?>

 

<?php include "views/_header.php" ?>
<?php include "views/_navbar.php" ?>

<?php  
            if(isset($_SESSION["kullanici_id"])){ 
                $id = $_SESSION["kullanici_id"];
                $kisi=getPerson($id);
                $person = mysqli_fetch_assoc($kisi);    
             
          
            }

 
     ?>
 
  
       
<div class="container container_grid">
        <div class="aside beyaz_fon">
            <div class="kategori">

                <p class="aside_paragraf">Bilgilerim</p>

                <hr>
                <ul class=" ">
                    <li>İsim: <?php echo $person["isim"]; ?> </li>
                    <li>email: <?php echo $person["email"]; ?> </li>
                    <li>tel: <?php  if($person["tel"]=="NULL"){
                        echo "tel yok";}
                        else{
                           echo $person["tel"]; 
                        } ?> </li>
                    <li>kullanici id: <?php echo $person["kullanici_id"]; ?> </li>
                </ul>
                <hr>
                <ul class="">
                  <li><a class="color_blue" href="hesapsifre.php">Şifre Değiştir</a></li>
                    <li><a class="color_blue" href="hesapmail.php">E-Posta Değiştir</a></li>
                    <li><a class="color_blue" href="hesaptelefon.php">Telefon Ekle/Değiştir</a></li>
                    <li><a class="color_blue" href="ilanlarim.php">İlan İşlemleri</a></li>
                </ul>
            </div>
          
            
             
             

        </div>
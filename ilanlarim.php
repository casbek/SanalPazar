<?php

    require "libs/vars.php";
    require "libs/functions.php";  
?>
<?php if (!isLoggedin()){ 
           header("Location: login.php"); die();
        }  


        if(isset($_GET["id"])){ 
            $id = $_GET["id"];
            $result = getProductbyId($id);
            $selecteProduct = mysqli_fetch_assoc($result);   
            $dizi=explode(" ",$id); // cümlemiz boşluklardan bölünecek
            $urunID=$dizi[0];
            $dizislem=$dizi[1];
            $message="";
             
            if($dizislem=="S"){
                productDelete($urunID);
                $message= $urunID."nolu dizi silindi";
            } else{
                $message= "bilinmeyen silme hatası";
            }
             
        }
    
?>




 
<?php include "views/_header.php" ?>
 
 <style>
     a{
         text-decoration: none;
     }
 </style>
 
<?php include "views/_navbar.php" ?>
<?php if (!empty($message)): ?>
    <p class="text-center"><strong><?php echo "$message" ?> </strong>  </p>
     
        <?php endif; ?>
  
<div   class="container container_grid">
          <div class="aside beyaz_fon">
            <div>

                <p class="aside_paragraf">Hesap Ayarları</p>

                <hr>
                <ul class="">
                <li><a class="color_blue" href="bilgilerim.php">Bilgilerim</a></li>
                <li><a class="color_blue" href="hesapsifre.php">Şifre Değiştir</a></li>
                    <li><a class="color_blue" href="hesapmail.php">E-Posta Değiştir</a></li>
                    <li><a class="color_blue" href="hesaptelefon.php">Telefon Ekle/Değiştir</a></li>
                    <li><a class="color_blue" href="ilanlarim.php">İlan İşlemleri</a></li>
                </ul>
            </div>
         
             
             

          </div>



      



       <div class="section">
 
             
          <?php  
                $result = getMyProducts($id);
                 
                $person = mysqli_fetch_assoc(getPerson($_SESSION["kullanici_id"]));
          ?>
             <?php if (mysqli_num_rows($result) > 0): ?>

                    <?php while($urun = mysqli_fetch_assoc($result)): ?>

                        <div class="box relative">
                                <a href=""><i class="fa-solid fa-xmark"></i></a>
                                <div class="imgcontainer">
                                    <img src="<?php echo "img/".$urun["imageUrl"]?>" alt="bibersivri">
                                </div>
                                <div class="space"></div>
                                <div class="a_container">
                                    <p class="text-center m_size"><b><?php echo $urun["title"]?></b></p>
                                    <p class="text-center "><a class="isim_yazi" href="#"><?php echo $person["isim"]?></a></p>
                                    <div class="space"></div>
                                    <div class="bilgi">
                                        <a class="Location text-center color_black xs_size " href="#"><i
                                                class="fa-solid fa-location-dot"></i><b><?php echo $urun["sehir"]?></b> </a>
                                        <a class="fiyat text-center color_green xs_size" href=""> <b><?php echo $urun["price"]?> TL</b></a>
                                    </div>
                                    <div class="space"></div>
                                    <div class="duzenle">
                                         
                                        <a style="color: red;" class="Location text-center color_black xs_size " href="ilanlarim.php?id=<?php echo $urun["id"]." S" ?>"><i class="fa-solid fa-trash-can"></i><b>Sil</b> </a>
                                        <a class="fiyat text-center color_green xs_size" href="ilanDuzenle.php?id=<?php echo $urun["id"]?>"> <b><i class="fa-solid fa-pen"></i>Duzenle</b></a>
                                    </div>
                                </div>
                         </div>

                    <?php endwhile; ?>
             <?php else: ?>
                 <p style="font-weight:bold;  font-size: 1rem;">Herhangi bir ilanınız bulunamadı. İlan vermek için <a style="color:blue;" href="ilanver.php">Tıklayınız</a></p>
                     
             <?php endif; ?> 
  

        
          
            
         
       
        
        
         
         
       
          
       </div>
</div>

<?php include "views/_footer.php" ?>
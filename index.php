<?php

    require "libs/vars.php";
    require "libs/functions.php";  
  

?>

 

<?php include "views/_header.php" ?>
<?php include "views/_navbar.php" ?>



<div class="container container_grid">
        <div class="aside beyaz_fon">
            <div class="kategori">

                <p class="aside_paragraf">Kategoriler</p>

                <hr>
                <ul class=" ">
                    <li>Meyve-Sebze</li>
                    <li>Kuru gıdalar</li>
                    <li>Tohumlar</li>
                    <li>Dondurulmuş ürünler</li>
                </ul>
            </div>
            <div class="urun_etiketi">
                <p class="aside_paragraf">Ürün Etiketleri</p>
                <hr>
                <ul class="">
                    <li>Seradan</li>
                    <li>Tarladan</li>
                    <li>Bahçeden</li>
                </ul>
            </div>
             
             

        </div>

        <!--sectionn-->
     <div class="section">
          
          
          <?php  

          //q kontrol et eger varsa like ile filtereme yap yoksa aşşayı çaliştir

          if (isset($_GET["q"])) {
               $result=getProductsByKeyword($_GET["q"]);
          } else {
            $result = getHomePageProducts();
          }
          


 
                 
                
            ?>


        <?php if (mysqli_num_rows($result) > 0): ?>

            <?php while($urun = mysqli_fetch_assoc($result)): ?>
                  
                <div class="box">
                <a style="text-decoration: none;" href="<?php echo "product-details.php?id=".$urun["id"]; ?>"> 
                    <div class="imgcontainer">
                        <img src="img/<?php echo $urun["imageUrl"]?>">
                    </div>
                    <div class="space"></div>
                    <div class="a_container">
                        <p class="text-center m_size color_black"><b><?php echo $urun["title"]?></b></p>
                        <p class="text-center "><a class="isim_yazi" href="">
                            <?php  
                             $person = mysqli_fetch_assoc(getPerson($urun["owner_id"]));
                            echo $person["isim"];
                            ?>
                        </a></p>
                        <div class="space"></div>
                        <div class="bilgi">
                            <a class="Location text-center color_black xs_size " href="#"><i
                                    class="fa-solid fa-location-dot"></i><b> <?php echo $urun["sehir"]?></b> </a>
                            <a class="fiyat text-center color_green xs_size" href=""> <b><?php echo $urun["price"]?> TL</b></a>
                        </div>
                    </div>
                 </a>
                </div>
                 
            <?php endwhile; ?>
        <?php else: ?>
            <div class="alert alert-warning">
                    <p>Bu aramaya uygun ürün bulunamadı.</p>
            </div>
       <?php endif; ?> 

            <!--section bitiş-->
    </div>
  </div>









<?php include "views/_footer.php" ?>
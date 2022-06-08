<?php

    require "libs/vars.php";
    require "libs/functions.php";  
  

?>

 

<?php include "views/_header.php" ?>
<?php include "views/_navbar.php" ?>

<?php  
            if(isset($_GET["id"])){ 
                $id = $_GET["id"];
                $result = getProductbyId($id);
                $selecteProduct = mysqli_fetch_assoc($result);   

                 
                $kisi=getPerson($selecteProduct["owner_id"]);
                $person = mysqli_fetch_assoc($kisi);    
             
                $resultt=getProductbyId($_GET["id"]);
                $urun = mysqli_fetch_assoc($resultt);
            }

            //id kontrol et eger varsa like ile filtereme yap yoksa aşşayı çaliştir

if (isset($_GET["id"])) {
    $result=getProductbyId($_GET["id"]);
} else {
 $result = getHomePageProducts();
}
     ?>
 
  
       
<div class="container container_grid">
        <div class="aside beyaz_fon">
            <div class="kategori">

                <p class="aside_paragraf">Bilgiler</p>

                <hr>
                <ul class=" ">
                    <li>İsim: <?php echo $person["isim"]; ?> </li>
                    <li>email: <?php echo $person["email"]; ?> </li>
                    <li>tel: <?php echo $person["tel"]; ?> </li>
                     
                </ul>
            </div>
            <div class="urun_etiketi">
                <p class="aside_paragraf">Ürün Etiketleri</p>
                <hr>
                <ul class="">
                <li> <?php echo $urun["ubilgisi"]; ?> </li>
                <li> <?php echo $urun["uetiketi"]; ?> </li>
                <li> <?php echo $urun["ikategori"]; ?> </li>
                <li> <?php echo "Tarih: ".$urun["dateAdded"]; ?> </li>
                </ul>
            </div>
            
             
             

        </div>

        <!--sectionn-->
     <div class="section">
        <?php if (!empty($urun)): ?>
                <div class="box">
                    <div class="imgcontainer">
                        <img src="img/<?php echo $urun["imageUrl"]?>">
                    </div>
                    <div class="space"></div>
                    <div class="a_container">
                        <p class="text-center m_size"><b><?php echo $urun["title"]?></b></p>
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
                </div>
        <?php else: ?>
            <div class="alert alert-warning">
                    <p>Bu aramaya uygun ürün bulunamadı.</p>
            </div>
       <?php endif; ?> 

            <!--section bitiş-->
    </div>
  </div>



<?php include "views/_footer.php" ?>
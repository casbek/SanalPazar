<?php 
//gerekli dosyalar repuire edildi
 require "libs/vars.php";
 require "libs/ayar.php";
 require "libs/functions.php";
 if (!isLoggedin()){ 
    header("Location: login.php"); die();
 }  
 ?>


 <?php 
 
 if (isset($_POST["ilanUpdate"]) &&  isset($_SESSION["kullanici_id"])  &&  isset($_GET["id"]) ) {
 $kategori=$urun=$urunetiketi=$urunbaslik=$sehir=$fiyat=$foto= "";
 $kategori_err=$urun_err=$urunetiketi_err=$urunbaslik_err=$sehir_err=$fiyat_err=$foto_err= "";
 $kİd=$_SESSION["kullanici_id"];
 //verileri kontrol et ve işle

  // ilan kategorisi
    if(!empty($_POST['kategori'])) {
        $kategori = $_POST['kategori'];
         
    } else {
       $kategori_err="kategori hatası";
    }
  //ürün bilgisi
  if(!empty($_POST['urun'])) {
    $urun = $_POST['urun'];
     
    } else {
    $urun_err="urun hatası";
    }
  //urun etiketi
 
    if(!empty($_POST['radio'])) {
        $urunetiketi = $_POST['radio'];
    } else {
        $urunetiketi_err="urunetiketi hatası";
    }
  //urunbaslik
   
  if (empty(trim($_POST["urunbaslik"]))) {
    $urunbaslik_err = "urunbaslik girmelisiniz.";
  } elseif (strlen(trim($_POST["urunbaslik"])) < 8 or strlen(trim($_POST["urunbaslik"])) > 79) {
    $urunbaslik_err = "urunbaslik 10-80 karakter arasında olmalıdır.";
  } else {
          $urunbaslik = $_POST["urunbaslik"];
         }
 //sehir
 if(!empty($_POST['Sehir'])) {
    $sehir = $_POST['Sehir'];
     
} else {
   $sehir="Sehir hatası";
}
//fiyat
if (empty(trim($_POST["fiyat"]))) {
    $fiyat_err = "fiyat girmelisiniz.";
  } elseif ($_POST["fiyat"] < 1 or $_POST["fiyat"] >10000000) {
    $fiyat_err = "fiyat 1-10.000.000 karakter arasında olmalıdır.";
  } elseif (!is_numeric($_POST["fiyat"])) {
    $fiyat_err = "fiyat numeric dehil";
  } else {
          $fiyat = $_POST["fiyat"];
         }

//foto kontrol
 
if (isset($_FILES["foto"]) && $_FILES["foto"]["error"]==0) {

       
        
    $uploadOk = 1;
    $fileTmpPath = $_FILES["foto"]["tmp_name"];
    $fileName = $_FILES["foto"]["name"];
    $dosya_uzantilari = array('jpg','jpeg','png');

    # dosya seçilmiş mi?
    if(empty($fileName)){
        $foto_err= "dosya seçiniz.";
        $uploadOk = 0;
    }

    # dosya boyutunu kontrol et.
    $fileSize = $_FILES["foto"]["size"];

    if($fileSize > 5000000) { # 5000KB
        $foto_err= "Dosya boyutu fazla.<br>";
        $uploadOk = 0;
    }

    # dosya uzantısını kontrol et.
    $dosyaAdi_Arr = explode(".", $fileName); 
    $dosyaAdi_uzantisiz = $dosyaAdi_Arr[0];
    $dosya_uzantisi = $dosyaAdi_Arr[1];

    if(!in_array($dosya_uzantisi, $dosya_uzantilari)) {
        $foto_err=  "dosya uzantısı kabul edilmiyor. "."kabul edilen dosya uzantıları: ".implode(',', $dosya_uzantilari);
        $uploadOk = 0;
    }

    # dosya ismini kontrol ederek random isim.
    $yeni_dosyaAdi = md5(time().$dosyaAdi_uzantisiz).'.'.$dosya_uzantisi;

    $uploadFolder = './img/';
    $dest_path = $uploadFolder.$yeni_dosyaAdi;

    
} else {
    $foto_err='hata: '.$_FILES["fileToUpload"]["error"];
     
}







   //err kontrol et ve sql ile veritabanına işle

   if (empty($kategori_err) && empty($urun_err) && empty($urunetiketi_err) && empty($urunbaslik_err) && empty($sehir_err) && empty($fiyat_err) && empty($foto_err) ){
   
        if(move_uploaded_file($fileTmpPath, $dest_path)) {
            $foto="foto yüklendi";
        } else {
            $foto_err="foto yüklenmedi";
        }
       $silId= $_GET["id"];
        updateProducts($kategori, $urun, $urunetiketi, $urunbaslik, $sehir , $fiyat, $yeni_dosyaAdi, $kİd, $silId);
        header("Location: ilanlarim.php"); die();
    }else{
        $url= "ilanDuzenle.php?id=".$_GET["id"];
        header("Location: $url"); 
        die();
         
    }




   }else{
       //buraya hata yazdır
   }
    
 
 ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ilan duzenle</title>
    <meta name="keyword" content="üreticiden,sahibinden,tarladan,tarım">
    <meta name="description" content="Tarim ürünlerini direk üreticiden alın">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Google font popiness quicksand-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&family=Quicksand:wght@500;700&display=swap"
        rel="stylesheet">

    <!--font awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css ">

    <link rel="stylesheet" href="views/css/global.css">
    <link rel="stylesheet" href="views/css/main.css">
 

    <style>
        .alert {
    padding: 20px;
    background-color: #f44336; /* Red */
    color: white;
    margin-bottom: 15px;
    text-align: center;
    }

    /* The close button */
    .closebtn {
    margin-left: 15px;
    color: white;
    font-weight: bold;
    float: right;
    font-size: 22px;
    line-height: 20px;
    cursor: pointer;
    transition: 0.3s;
    }

    /* When moving the mouse over the close button */
    .closebtn:hover {
    color: black;
    }
    </style>
</head>

<body class="gri_fon">
<?php include "views/_navbar.php" ?>
        
    <!--ilan ver form-->
   
     <!--giriş yapılmadıysa -->
   
          <?php  
            
                $result = getProducts($_GET["id"]);
                if (mysqli_num_rows($result) > 0){
                    $product = mysqli_fetch_assoc($result);
                }
                  
          ?>
             <?php if (!empty($product)): ?>

                    
      <div class="ilan-ver-container">
          <p style="color: red; font-size:2rem;" class="text-center">İlan Düzenle</p>
           <form action="<?php echo "ilanDuzenle.php?id=".$_GET["id"]; ?>" method="post" enctype="multipart/form-data"> 
                    <div class="ilan-ver-item">
                        <h1>İlan Kategorisi</h1>
                        <p></p>
                        <div class="ilan-item-content">
                            <?php if(!empty($kategori_err)){
                               echo $kategori_err;
                            }?>
                            <select name="kategori" id="kategori"><option <?php if( $product["ikategori"]=="meyvesebze"){echo "selected";}?> value="meyvesebze">Meyve Sebze</option>
                                <option <?php if( $product["ikategori"]=="kurugıda"){echo "selected";}?> value="kurugıda">Kuru Gıdalar</option>
                                <option <?php if( $product["ikategori"]=="tohum"){echo "selected";}?> value="tohum">Tohum</option>
                                <option <?php if( $product["ikategori"]=="dondurulmus"){echo "selected";}?> value="dondurulmus">Dondurulmuş Ürünler</option>
                            </select>
                        </div>
                    </div>
                    <div class="ilan-ver-item">
                        <h1>Ürün Bilgisi</h1>
                        <div class="ilan-item-content">
                        <?php if(!empty($urun_err)){
                               echo $urun_err;
                            }?>
                            <select name="urun" id="urun_ad">
                                <option   hidden disabled selected  value value="0">Lütfen Ürün Seçiniz</option>
                                <option <?php if( $product["ubilgisi"]=="armut"){echo "selected";}?> value="armut">ARMUT </option>
                                <option <?php if( $product["ubilgisi"]=="biber"){echo "selected";}?> value="biber">BİBER </option>
                                <option <?php if( $product["ubilgisi"]=="domates"){echo "selected";}?> value="domates">DOMATES</option>
                                <option <?php if( $product["ubilgisi"]=="elma"){echo "selected";}?> value="elma">ELMA</option>
                                <option <?php if( $product["ubilgisi"]=="erik"){echo "selected";}?> value="erik">ERİK </option>
                                <option <?php if( $product["ubilgisi"]=="incir"){echo "selected";}?> value="incir">İncir</option>
                                <option <?php if( $product["ubilgisi"]=="kabak"){echo "selected";}?> value="kabak">KABAK</option>
                                <option <?php if( $product["ubilgisi"]=="kayısı"){echo "selected";}?> value="kayısı">KAYISI</option>
                                <option <?php if( $product["ubilgisi"]=="karpuz"){echo "selected";}?> value="karpuz">KARPUZ</option>
                                <option <?php if( $product["ubilgisi"]=="kavun"){echo "selected";}?> value="kavun">KAVUN</option>
                                <option <?php if( $product["ubilgisi"]=="kiraz"){echo "selected";}?> value="kiraz">KİRAZ</option>
                                <option <?php if( $product["ubilgisi"]=="limon"){echo "selected";}?> value="limon">LİMON </option>
                                <option <?php if( $product["ubilgisi"]=="mandalina"){echo "selected";}?> value="mandalina">MANDALİNA </option>
                                <option <?php if( $product["ubilgisi"]=="marul"){echo "selected";}?> value="marul">MARUL</option>
                                <option <?php if( $product["ubilgisi"]=="muz"){echo "selected";}?> value="muz">MUZ </option>
                                <option <?php if( $product["ubilgisi"]=="nar"){echo "selected";}?> value="nar">NAR </option>
                                <option <?php if( $product["ubilgisi"]=="patates"){echo "selected";}?> value="patates">PATATES </option>
                                <option <?php if( $product["ubilgisi"]=="diger"){echo "selected";}?> value="diger">Diger(Listede Yok)</option>
                            </select>
                        </div>
                    </div>

                    <div class="ilan-ver-item">
                        <h1>Ürün Etiketi</h1>
                        <div class="ilan-item-content">
                        <?php if(!empty($urunetiketi_err)){
                               echo $urunetiketi_err;
                            }?>
                            <input <?php if( $product["uetiketi"]=="tarladan"){echo "checked";}?> type="radio" id="tarla" name="radio" value="tarladan">
                            <label for="tarla">Tarladan</label><br>
                            <input <?php if( $product["uetiketi"]=="seradan"){echo "checked";}?>  type="radio" id="sera" name="radio" value="seradan">
                            <label for="sera">Seradan</label><br>
                            <input <?php if( $product["uetiketi"]=="bahceden"){echo "checked";}?>  type="radio" id="bahce" name="radio" value="bahceden">
                            <label for="bahce">Bahçeden</label>
                        </div>
                    </div>
                    <div class="ilan-ver-item">
                        <h1>Ürün Başligi</h1>
                        <div class="ilan-item-content">
                        <?php if(!empty($urunbaslik_err)){
                               echo $urunbaslik_err;
                            }?>
                            <input required placeholder="Ürün basligi(max80 karakter)" name="urunbaslik" type="text" minlength="8" maxlength="80"  value="<?php if(!empty($product["title"])){echo $product["title"];}?>">
                            
                            
                        </div>
                    </div>

                    <div class="ilan-ver-item">
                        <h1>Ürün Bölgesi</h1>
                        <div class="ilan-item-content">
                        <?php if(!empty($sehir_err)){
                               echo $sehir_err;
                            }?>
                            <select name="Sehir" required>
                                    <option  hidden disabled selected value value="0">Lütfen Bölge Seçiniz</option>
                                    <option <?php if( $product["sehir"]=="İstanbul"){echo "selected";}?> value="İstanbul">İstanbul</option>
                                    <option <?php if( $product["sehir"]=="Ankara"){echo "selected";}?> value="Ankara">Ankara</option>
                                    <option <?php if( $product["sehir"]=="İzmir"){echo "selected";}?> value="İzmir">İzmir</option>
                                    <option <?php if( $product["sehir"]=="Adana"){echo "selected";}?> value="Adana">Adana</option>
                                    <option <?php if( $product["sehir"]=="Adıyaman"){echo "selected";}?> value="Adıyaman">Adıyaman</option>
                                    <option <?php if( $product["sehir"]=="Afyonkarahisar"){echo "selected";}?> value="Afyonkarahisar">Afyonkarahisar</option>
                                    <option <?php if( $product["sehir"]=="Ağrı"){echo "selected";}?> value="Ağrı">Ağrı</option>
                                    <option <?php if( $product["sehir"]=="Aksaray"){echo "selected";}?> value="Aksaray">Aksaray</option>
                                    <option <?php if( $product["sehir"]=="Amasya"){echo "selected";}?> value="Amasya">Amasya</option>
                                    <option <?php if( $product["sehir"]=="Antalya"){echo "selected";}?> value="Antalya">Antalya</option>
                                    <option <?php if( $product["sehir"]=="Ardahan"){echo "selected";}?> value="Ardahan">Ardahan</option>
                                    <option <?php if( $product["sehir"]=="Artvin"){echo "selected";}?> value="Artvin">Artvin</option>
                                    <option <?php if( $product["sehir"]=="Aydın"){echo "selected";}?> value="Aydın">Aydın</option>
                                    <option <?php if( $product["sehir"]=="Balıkesir"){echo "selected";}?> value="Balıkesir">Balıkesir</option>
                                    <option <?php if( $product["sehir"]=="Bartın"){echo "selected";}?> value="Bartın">Bartın</option>
                                    <option <?php if( $product["sehir"]=="Batman"){echo "selected";}?> value="Batman">Batman</option>
                                    <option <?php if( $product["sehir"]=="Bayburt"){echo "selected";}?> value="Bayburt">Bayburt</option>
                                    <option <?php if( $product["sehir"]=="Bilecik"){echo "selected";}?> value="Bilecik">Bilecik</option>
                                    <option <?php if( $product["sehir"]=="Bingöl"){echo "selected";}?> value="Bingöl">Bingöl</option>
                                    <option <?php if( $product["sehir"]=="Bitlis"){echo "selected";}?> value="Bitlis">Bitlis</option>
                                    <option <?php if( $product["sehir"]=="Bolu"){echo "selected";}?> value="Bolu">Bolu</option>
                                    <option <?php if( $product["sehir"]=="Burdur"){echo "selected";}?> value="Burdur">Burdur</option>
                                    <option <?php if( $product["sehir"]=="Bursa"){echo "selected";}?> value="Bursa">Bursa</option>
                                    <option <?php if( $product["sehir"]=="Çanakkale"){echo "selected";}?> value="Çanakkale">Çanakkale</option>
                                    <option <?php if( $product["sehir"]=="Çankırı"){echo "selected";}?> value="Çankırı">Çankırı</option>
                                    <option <?php if( $product["sehir"]=="Çorum"){echo "selected";}?> value="Çorum">Çorum</option>
                                    <option <?php if( $product["sehir"]=="Denizli"){echo "selected";}?> value="Denizli">Denizli</option>
                                    <option <?php if( $product["sehir"]=="Diyarbakır"){echo "selected";}?> value="Diyarbakır">Diyarbakır</option>
                                    <option <?php if( $product["sehir"]=="Düzce"){echo "selected";}?> value="Düzce">Düzce</option>
                                    <option <?php if( $product["sehir"]=="Edirne"){echo "selected";}?> value="Edirne">Edirne</option>
                                    <option <?php if( $product["sehir"]=="Elazığ"){echo "selected";}?> value="Elazığ">Elazığ</option>
                                    <option <?php if( $product["sehir"]=="Erzincan"){echo "selected";}?> value="Erzincan">Erzincan</option>
                                    <option <?php if( $product["sehir"]=="Erzurum"){echo "selected";}?> value="Erzurum">Erzurum</option>
                                    <option <?php if( $product["sehir"]=="Eskişehir"){echo "selected";}?> value="Eskişehir">Eskişehir</option>
                                    <option <?php if( $product["sehir"]=="Gaziantep"){echo "selected";}?> value="Gaziantep">Gaziantep</option>
                                    <option <?php if( $product["sehir"]=="Giresun"){echo "selected";}?> value="Giresun">Giresun</option>
                                    <option <?php if( $product["sehir"]=="Gümüşhane"){echo "selected";}?> value="Gümüşhane">Gümüşhane</option>
                                    <option <?php if( $product["sehir"]=="Hakkâri"){echo "selected";}?> value="Hakkâri">Hakkâri</option>
                                    <option <?php if( $product["sehir"]=="Hatay"){echo "selected";}?> value="Hatay">Hatay</option>
                                    <option <?php if( $product["sehir"]=="Iğdır"){echo "selected";}?> value="Iğdır">Iğdır</option>
                                    <option <?php if( $product["sehir"]=="Isparta"){echo "selected";}?> value="Isparta">Isparta</option>
                                    <option <?php if( $product["sehir"]=="Kahramanmaraş"){echo "selected";}?> value="Kahramanmaraş">Kahramanmaraş</option>
                                    <option <?php if( $product["sehir"]=="Karabük"){echo "selected";}?> value="Karabük">Karabük</option>
                                    <option <?php if( $product["sehir"]=="Karaman"){echo "selected";}?> value="Karaman">Karaman</option>
                                    <option <?php if( $product["sehir"]=="Kars"){echo "selected";}?> value="Kars">Kars</option>
                                    <option <?php if( $product["sehir"]=="Kastamonu"){echo "selected";}?> value="Kastamonu">Kastamonu</option>
                                    <option <?php if( $product["sehir"]=="Kayseri"){echo "selected";}?> value="Kayseri">Kayseri</option>
                                    <option <?php if( $product["sehir"]=="Kırıkkale"){echo "selected";}?> value="Kırıkkale">Kırıkkale</option>
                                    <option <?php if( $product["sehir"]=="Kırklareli"){echo "selected";}?> value="Kırklareli">Kırklareli</option>
                                    <option <?php if( $product["sehir"]=="Kırşehir"){echo "selected";}?> value="Kırşehir">Kırşehir</option>
                                    <option <?php if( $product["sehir"]=="Kilis"){echo "selected";}?> value="Kilis">Kilis</option>
                                    <option <?php if( $product["sehir"]=="Kocaeli"){echo "selected";}?> value="Kocaeli">Kocaeli</option>
                                    <option <?php if( $product["sehir"]=="Konya"){echo "selected";}?> value="Konya">Konya</option>
                                    <option <?php if( $product["sehir"]=="Kütahya"){echo "selected";}?> value="Kütahya">Kütahya</option>
                                    <option <?php if( $product["sehir"]=="Malatya"){echo "selected";}?> value="Malatya">Malatya</option>
                                    <option <?php if( $product["sehir"]=="Manisa"){echo "selected";}?> value="Manisa">Manisa</option>
                                    <option <?php if( $product["sehir"]=="Mardin"){echo "selected";}?> value="Mardin">Mardin</option>
                                    <option <?php if( $product["sehir"]=="Mersin"){echo "selected";}?> value="Mersin">Mersin</option>
                                    <option <?php if( $product["sehir"]=="Muğla"){echo "selected";}?> value="Muğla">Muğla</option>
                                    <option <?php if( $product["sehir"]=="Muş"){echo "selected";}?> value="Muş">Muş</option>
                                    <option <?php if( $product["sehir"]=="Nevşehir"){echo "selected";}?> value="Nevşehir">Nevşehir</option>
                                    <option <?php if( $product["sehir"]=="Niğde"){echo "selected";}?> value="Niğde">Niğde</option>
                                    <option <?php if( $product["sehir"]=="Ordu"){echo "selected";}?> value="Ordu">Ordu</option>
                                    <option <?php if( $product["sehir"]=="Osmaniye"){echo "selected";}?> value="Osmaniye">Osmaniye</option>
                                    <option <?php if( $product["sehir"]=="Rize"){echo "selected";}?> value="Rize">Rize</option>
                                    <option <?php if( $product["sehir"]=="Sakarya"){echo "selected";}?> value="Sakarya">Sakarya</option>
                                    <option <?php if( $product["sehir"]=="Samsun"){echo "selected";}?> value="Samsun">Samsun</option>
                                    <option <?php if( $product["sehir"]=="Siirt"){echo "selected";}?> value="Siirt">Siirt</option>
                                    <option <?php if( $product["sehir"]=="Sinop"){echo "selected";}?> value="Sinop">Sinop</option>
                                    <option <?php if( $product["sehir"]=="Sivas"){echo "selected";}?> value="Sivas">Sivas</option>
                                    <option <?php if( $product["sehir"]=="Şırnak"){echo "selected";}?> value="Şırnak">Şırnak</option>
                                    <option <?php if( $product["sehir"]=="Tekirdağ"){echo "selected";}?> value="Tekirdağ">Tekirdağ</option>
                                    <option <?php if( $product["sehir"]=="Tokat"){echo "selected";}?> value="Tokat">Tokat</option>
                                    <option <?php if( $product["sehir"]=="Trabzon"){echo "selected";}?> value="Trabzon">Trabzon</option>
                                    <option <?php if( $product["sehir"]=="Tunceli"){echo "selected";}?> value="Tunceli">Tunceli</option>
                                    <option <?php if( $product["sehir"]=="Şanlıurfa"){echo "selected";}?> value="Şanlıurfa">Şanlıurfa</option>
                                    <option <?php if( $product["sehir"]=="Uşak"){echo "selected";}?> value="Uşak">Uşak</option>
                                    <option <?php if( $product["sehir"]=="Van"){echo "selected";}?> value="Van">Van</option>
                                    <option <?php if( $product["sehir"]=="Yalova"){echo "selected";}?> value="Yalova">Yalova</option>
                                    <option <?php if( $product["sehir"]=="Yozgat"){echo "selected";}?> value="Yozgat">Yozgat</option>
                                    <option <?php if( $product["sehir"]=="Zonguldak"){echo "selected";}?> value="Zonguldak">Zonguldak</option>
                            </select>
                        </div>
                    </div>

                    <div class="ilan-ver-item">
                        <h1>Fiyat</h1>
                        <div class="ilan-item-content">
                        <?php if(!empty($fiyat_err)){
                               echo $fiyat_err;
                            }?>
                            <input id="fiyat" name="fiyat"   value="<?php if(!empty($product['price'])){echo $product['price'];}?>" type="number" min="1" max="10000000" >
                            <label for="fiyat">TL</label>
                        </div>
                    </div>

                    <div class="ilan-ver-item">
                        <h1>Fotograf Yükle</h1>
                        <div class="ilan-item-content foto-diza">
                        <?php if(!empty($foto_err)){
                               echo $foto_err;
                            }?>
                            
                            <input type="file" name="foto"> 
                            
                            
                            
                        </div>
                    </div>

                    <input id="ilan-upload" type="submit" name="ilanUpdate" value="güncelle">
           </form>

          
      </div>
            
                    <?php else: ?>
            
                    <?php endif; ?> 
  
   
     
 
   
    



     

</body>

</html>
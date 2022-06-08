<?php 
//gerekli dosyalar repuire edildi
 require "libs/vars.php";
 require "libs/ayar.php";
 require "libs/functions.php";
 ?>

 <?php 
 
 if (isset($_POST["ilanver"]) &&  isset($_SESSION["kullanici_id"])) {
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
   echo "foto yükleme hatalari ";
     
}







   //err kontrol et ve sql ile veritabanına işle

   if (empty($kategori_err) && empty($urun_err) && empty($urunetiketi_err) && empty($urunbaslik_err) && empty($sehir_err) && empty($fiyat_err) && empty($foto_err) ){
   
        if(move_uploaded_file($fileTmpPath, $dest_path)) {
            $foto="foto yüklendi";
        } else {
            $foto_err="foto yüklenmedi";
        }
     
        setProducts($kategori, $urun, $urunetiketi, $urunbaslik, $sehir , $fiyat, $yeni_dosyaAdi, $kİd);
        header("Location: ilanlarim.php"); die();
    }else{
        echo "bazı hatalar mevcut";
    }
   }
    
 
 ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İlanver</title>
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
  <?php if (!isLoggedin()): ?>
            <div class="alert">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
           Giriş yapmadan ilan veremessiniz. <a href="login.php">Giriş Yap</a>
      </div>
        
  <?php else: ?>
      <div class="ilan-ver-container">
           <form action="ilanver.php" method="post" enctype="multipart/form-data"> 
                    <div class="ilan-ver-item">
                        <h1>İlan Kategorisi</h1>
                        <p></p>
                        <div class="ilan-item-content">
                            <?php if(!empty($kategori_err)){
                               echo $kategori_err;
                            }?>
                            <select name="kategori" id="kategori">
                                <option value="meyvesebze">Meyve Sebze</option>
                                <option value="kurugıda">Kuru Gıdalar</option>
                                <option value="tohum">Tohum</option>
                                <option value="dondurulmus">Dondurulmuş Ürünler</option>
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
                                <option  hidden disabled selected value value="0">Lütfen Ürün Seçiniz</option>
                                <option value="armut">ARMUT </option>
                                <option value="biber">BİBER </option>
                                <option value="domates">DOMATES</option>
                                <option value="elma">ELMA</option>
                                <option value="erik">ERİK </option>
                                <option value="incir">İncir</option>
                                <option value="kabak">KABAK</option>
                                <option value="kayısı">KAYISI</option>
                                <option value="karpuz">KARPUZ</option>
                                <option value="kavun">KAVUN</option>
                                <option value="kiraz">KİRAZ</option>
                                <option value="limon">LİMON </option>
                                <option value="mandalina">MANDALİNA </option>
                                <option value="marul">MARUL</option>
                                <option value="muz">MUZ </option>
                                <option value="nar">NAR </option>
                                <option value="patates">PATATES </option>
                                <option value="diger">Diger(Listede Yok)</option>
                            </select>
                        </div>
                    </div>

                    <div class="ilan-ver-item">
                        <h1>Ürün Etiketi</h1>
                        <div class="ilan-item-content">
                        <?php if(!empty($urunetiketi_err)){
                               echo $urunetiketi_err;
                            }?>
                            <input type="radio" id="tarla" name="radio" value="tarladan">
                            <label for="tarla">Tarladan</label><br>
                            <input type="radio" id="sera" name="radio" value="seradan">
                            <label for="sera">Seradan</label><br>
                            <input type="radio" id="bahce" name="radio" value="bahceden">
                            <label for="bahce">Bahçeden</label>
                        </div>
                    </div>
                    <div class="ilan-ver-item">
                        <h1>Ürün Başligi</h1>
                        <div class="ilan-item-content">
                        <?php if(!empty($urunbaslik_err)){
                               echo $urunbaslik_err;
                            }?>
                            <input required placeholder="Ürün basligi(max80 karakter)" name="urunbaslik" type="text" minlength="8" maxlength="80" id="baslik">
                            
                            
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
                                <option value="İstanbul">İstanbul</option>
                                <option value="Ankara">Ankara</option>
                                <option value="İzmir">İzmir</option>
                                <option value="Adana">Adana</option>
                                <option value="Adıyaman">Adıyaman</option>
                                <option value="Afyonkarahisar">Afyonkarahisar</option>
                                <option value="Ağrı">Ağrı</option>
                                <option value="Aksaray">Aksaray</option>
                                <option value="Amasya">Amasya</option>
                                <option value="Antalya">Antalya</option>
                                <option value="Ardahan">Ardahan</option>
                                <option value="Artvin">Artvin</option>
                                <option value="Aydın">Aydın</option>
                                <option value="Balıkesir">Balıkesir</option>
                                <option value="Bartın">Bartın</option>
                                <option value="Batman">Batman</option>
                                <option value="Bayburt">Bayburt</option>
                                <option value="Bilecik">Bilecik</option>
                                <option value="Bingöl">Bingöl</option>
                                <option value="Bitlis">Bitlis</option>
                                <option value="Bolu">Bolu</option>
                                <option value="Burdur">Burdur</option>
                                <option value="Bursa">Bursa</option>
                                <option value="Çanakkale">Çanakkale</option>
                                <option value="Çankırı">Çankırı</option>
                                <option value="Çorum">Çorum</option>
                                <option value="Denizli">Denizli</option>
                                <option value="Diyarbakır">Diyarbakır</option>
                                <option value="Düzce">Düzce</option>
                                <option value="Edirne">Edirne</option>
                                <option value="Elazığ">Elazığ</option>
                                <option value="Erzincan">Erzincan</option>
                                <option value="Erzurum">Erzurum</option>
                                <option value="Eskişehir">Eskişehir</option>
                                <option value="Gaziantep">Gaziantep</option>
                                <option value="Giresun">Giresun</option>
                                <option value="Gümüşhane">Gümüşhane</option>
                                <option value="Hakkâri">Hakkâri</option>
                                <option value="Hatay">Hatay</option>
                                <option value="Iğdır">Iğdır</option>
                                <option value="Isparta">Isparta</option>
                                <option value="Kahramanmaraş">Kahramanmaraş</option>
                                <option value="Karabük">Karabük</option>
                                <option value="Karaman">Karaman</option>
                                <option value="Kars">Kars</option>
                                <option value="Kastamonu">Kastamonu</option>
                                <option value="Kayseri">Kayseri</option>
                                <option value="Kırıkkale">Kırıkkale</option>
                                <option value="Kırklareli">Kırklareli</option>
                                <option value="Kırşehir">Kırşehir</option>
                                <option value="Kilis">Kilis</option>
                                <option value="Kocaeli">Kocaeli</option>
                                <option value="Konya">Konya</option>
                                <option value="Kütahya">Kütahya</option>
                                <option value="Malatya">Malatya</option>
                                <option value="Manisa">Manisa</option>
                                <option value="Mardin">Mardin</option>
                                <option value="Mersin">Mersin</option>
                                <option value="Muğla">Muğla</option>
                                <option value="Muş">Muş</option>
                                <option value="Nevşehir">Nevşehir</option>
                                <option value="Niğde">Niğde</option>
                                <option value="Ordu">Ordu</option>
                                <option value="Osmaniye">Osmaniye</option>
                                <option value="Rize">Rize</option>
                                <option value="Sakarya">Sakarya</option>
                                <option value="Samsun">Samsun</option>
                                <option value="Siirt">Siirt</option>
                                <option value="Sinop">Sinop</option>
                                <option value="Sivas">Sivas</option>
                                <option value="Şırnak">Şırnak</option>
                                <option value="Tekirdağ">Tekirdağ</option>
                                <option value="Tokat">Tokat</option>
                                <option value="Trabzon">Trabzon</option>
                                <option value="Tunceli">Tunceli</option>
                                <option value="Şanlıurfa">Şanlıurfa</option>
                                <option value="Uşak">Uşak</option>
                                <option value="Van">Van</option>
                                <option value="Yalova">Yalova</option>
                                <option value="Yozgat">Yozgat</option>
                                <option value="Zonguldak">Zonguldak</option>
                            </select>
                        </div>
                    </div>

                    <div class="ilan-ver-item">
                        <h1>Fiyat</h1>
                        <div class="ilan-item-content">
                        <?php if(!empty($fiyat_err)){
                               echo $fiyat_err;
                            }?>
                            <input id="fiyat" name="fiyat" type="number" min="1" max="10000000" >
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

                    <input id="ilan-upload" type="submit" name="ilanver" value="Submit">
           </form>

          
      </div>
  <?php endif; ?> 
     <!--giriş yapıldıysa-->



     

</body>

</html>
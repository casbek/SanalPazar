<?php

    require "libs/vars.php";
    require "libs/functions.php";  
?>
<?php if (!isLoggedin()){ 
           header("Location: login.php"); die();
        }  

       
        if (isset($_POST["telekle"])) {

            $password  = $telefon = "";
            $password_err  = $telefon_err ="";   
            $kİd=$_SESSION["kullanici_id"];


            //sifre kontrol
            if (empty(trim($_POST["password"]))) {
                $password_err = "password girmelisiniz.";
              }  else {
                $password = $_POST["password"];
                  
                $result=getPerson($kİd);
                
                 if (mysqli_num_rows($result) > 0){
                  while($person = mysqli_fetch_assoc($result)){
                    if($person["password"]!=$password){
                      $password_err="mevcut şifre yanlis";
                    } 
                  }
                 } 
              }

              //telefon kontrol
              if(empty(trim($_POST["telefon"]))) {
                $telefon_err = "telefon girmelisiniz.";
            } elseif (!preg_match('/^[0-9]{10}+$/', $_POST["telefon"])) {
                $telefon_err = "hatalı telefon girdiniz.";
            } elseif (strlen(trim($_POST["telefon"])) <=9  or strlen(trim($_POST["telefon"])) >= 11) {
                $telefon_err = "eksik veya yanlış telefon girdiniz.";
            } else {
              $tel = $_POST['telefon'];
              $res=  getPhone($tel);
            
                if(mysqli_num_rows($res) > 0){
                  $telefon_err="telefon başkası kullanıyor";  
                   
                    }else{
                        $telefon = $_POST['telefon'];
                        }
                 }
      
      
                 if (empty($password_err) && empty($telefon_err)) {
                   setPhone($kİd,$tel);
                  } 
      


       
       
       
       
       
       
       
            }
  








?>












  
<?php include "views/_header.php" ?>

 
<?php include "views/_navbar.php" ?>

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

       <div class="sifre-degis beyaz_fon">
       <form action="hesaptelefon.php" method="post">
           <h3>E-Telefon Ekle/Değiştir</h3>
           <br>
           <?php if (!empty($password_err) or !empty($telefon_err) ) {
                     echo  "hata: ".$password_err." ".$telefon_err;
                   } 
         ?>
      
          <ul class="listnone">
              <li>
                  <label for="m_sifre">Yeni Telefon No</label>
                <input id="telefon" name="telefon" id="telefon" maxlength="10" required type="tel" placeholder="(sıfır olmadan giriniz)"/>
            </li>
              <li>
                <label for="password">Mevcut Şifre</label>
                <input type="password" name="password" id="password" />
                </li>
              
          </ul>
          <button class="degistir" name="telekle">Kaydet</button>
        </form>
         
          
       </div>
    </div>


    <?php include "views/_footer.php" ?>
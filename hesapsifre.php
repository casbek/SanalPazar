<?php

    require "libs/vars.php";
    require "libs/functions.php";  
  

?>
<?php if (!isLoggedin()){ 
           header("Location: login.php"); die();
        }  
       

     
        if (isset($_POST["sifredegis"])) {
           
          $password  = $newpassword = $currentpassword  = "";
          $password_err  = $newpassword_err = $currentpassword_err  = "";        
          
          $kİd=$_SESSION["kullanici_id"];
          $password = $_POST['password'];
          $newpassword = $_POST['newpassword'];
          $currentpassword = $_POST['currentpassword'];       

           //sql yap ve sonucu mevcut şifre ile karşılaştır
                 // validate password
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
 
             // validate newpassword
        if (empty(trim($_POST["newpassword"]))) {
          $newpassword_err = "password girmelisiniz.";
        } elseif (strlen($_POST["newpassword"]) < 6) {
          $newpassword_err = "password min. 6 karakter olmalıdır.";
        } else {
          $newpassword = $_POST["newpassword"];
        }

        // validate currentpassword 
        if (empty(trim($_POST["currentpassword"]))) {
          $currentpassword_err = "currentpassword girmelisiniz.";
        } else {
          $currentpasnewpassword = $_POST["currentpassword"];
          if (empty($password_err) && ($newpassword != $currentpassword)) {
            $currentpassword_err = "parolalar eşleşmiyor.";
          }
        }
         
         
        if (empty($password_err) && empty($newpassword_err) && empty($currentpassword_err)) {
       echo $kİd." ".$newpassword ;
       SetPassword($kİd,$newpassword);
       header("Location: logout.php"); die();
               
        } 

 


        };
     
 
                 
?>
 
<?php include "views/_header.php" ?>

 
<?php include "views/_navbar.php" ?>
 
  <!-- section başlangıç-->
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
           <form action="hesapsifre.php" method="post">
           <h3>Şifre Değiştir</h3>
           <br>
           <?php if (!empty($password_err) or !empty($newpassword_err) or !empty($currentpassword_err)) {
                     echo  "hata: ".$password_err." ".$newpassword_err." ".$currentpassword_err;
                   } 
         ?>
      
          <ul class="listnone">
              <li>
                  <label for="m_sifre">Mevcut Şifre</label>
                <input type="password" name="password" id="password" />
            </li>
              <li>
                <label for="y_sifre">Yeni Şifre </label>
                <input type="password" name="newpassword" id="newpassword" />
                </li>
              <li>
                <label for="yt_sifre">Yeni Şifre(Tekrar) </label>
                <input type="password" name="currentpassword" id="currentpassword" />
              </li>
          </ul>
          <button class="degistir" name="sifredegis" id="sifredegis" >Kaydet</button>
        </form>
         
          
       </div>
    

</div>
 
       <?php include "views/_footer.php" ?>
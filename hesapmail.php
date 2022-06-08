<?php

    require "libs/vars.php";
    require "libs/functions.php";  
  

?>
<?php if (!isLoggedin()){ 
           header("Location: login.php"); die();
        }  


  if (isset($_POST["maildegis"])) {

          $password  = $eposta = "";
          $password_err  = $eposta_err ="";     

          $kİd=$_SESSION["kullanici_id"];
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
        
        //validate email
        if(empty(trim($_POST["eposta"]))) {
          $eposta_err = "email girmelisiniz.";
      } elseif (!filter_var($_POST["eposta"], FILTER_VALIDATE_EMAIL)) {
          $eposta_err = "hatalı email girdiniz.";
      } else {
        $bmail = $_POST['eposta'];
        $res=  getMail($bmail);
      
          if(mysqli_num_rows($res) > 0){
            $eposta_err="eposta başkası kullanıyor";  
             
              }else{
                  $eposta = $_POST['eposta'];
                  }
           }


           if (empty($password_err) && empty($eposta_err)) {
             setMail($kİd,$eposta);
       header("Location: logout.php"); die();

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
                <ul  >
                <li><a class="color_blue" href="bilgilerim.php">Bilgilerim</a></li>
                   <li><a class="color_blue" href="hesapsifre.php">Şifre Değiştir</a></li>
                    <li><a class="color_blue" href="hesapmail.php">E-Posta Değiştir</a></li>
                    <li><a class="color_blue" href="hesaptelefon.php">Telefon Ekle/Değiştir</a></li>
                    <li><a class="color_blue" href="ilanlarim.php">İlan İşlemleri</a></li>
                </ul>
            </div>
         
             
             

        </div>

       <div class="sifre-degis beyaz_fon">
       <form action="hesapmail.php" method="post">
           <h3>E-Posta Değiştir</h3>
           <br>
           <?php if (!empty($password_err) or !empty($eposta_err) ) {
                     echo  "hata: ".$password_err." ".$eposta_err;
                   } 
         ?>
      
          <ul class="listnone">
                <li>
                    <label for="email">Yeni E-Posta</label>
                    <input id="eposta"  name="eposta" type="mail" />
                </li>
                <li>
                    <label for="password">Mevcut Şifre</label>
                    <input type="password" name="password" id="password" />
                    </li>
              
          </ul>
          <button class="degistir" name="maildegis" id="maildegis" >Kaydet</button>
            </form>
          
       </div>
    </div>











<?php include "views/_footer.php" ?>



<?php

//ayar kodları
require "libs/vars.php";
require "libs/functions.php";
require "libs/ayar.php";
 
 
 
$isim  = $email = $password = $confirm_password = "";
$isim_err  = $email_err =$password_err= $confirm_password_err = "";
//register php kodlarını buraya yazıyoruz.
 if (isset($_POST["kaydol"])) {

        // validate isim
        if (empty(trim($_POST["isim"]))) {
          $isim_err = "isim girmelisiniz.";
        } elseif (strlen(trim($_POST["isim"])) < 3 or strlen(trim($_POST["isim"])) > 24) {
          $isim_err = "username 3-24 karakter arasında olmalıdır.";
        } elseif (!preg_match('/^[a-zA-Z\s]*$/', $_POST["isim"])) {
          $isim_err = "isim sadece  harf ve boşluk karakterinden oluşmalıdır.";
        } else {
                $isim = $_POST["isim"];
               }
       
  

               
               
      // validate email
      if(empty(trim($_POST["email"]))) {
        $email_err = "email girmelisiniz.";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $email_err = "hatalı email girdiniz.";
    } else {
      $bmail = $_POST['email'];
      $sql = "SELECT * FROM users WHERE email='$bmail'";
      $res = mysqli_query($connection, $sql);
    
      if(mysqli_num_rows($res) > 0){
        $email_err="Sorry... email already taken";  
        echo "Sorry... email already taken";  
      }else{
        $email = $_POST['email'];
      }
         
       
     
     
     
      }
      
       
        // validate password
        if (empty(trim($_POST["password"]))) {
          $password_err = "password girmelisiniz.";
        } elseif (strlen($_POST["password"]) < 6) {
          $password_err = "password min. 6 karakter olmalıdır.";
        } else {
          $password = $_POST["password"];
        }

        // validate confirm password
        if (empty(trim($_POST["confirm_password"]))) {
          $confirm_password_err = "confirm_password girmelisiniz.";
        } else {
          $confirm_password = $_POST["confirm_password"];
          if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "parolalar eşleşmiyor.";
          }
        }
        
       
       
      if (empty($isim_err) && empty($email_err) && empty($password_err) &&empty($confirm_password_err)) {
        $sql = "INSERT INTO users (isim, email, password) VALUES (?,?,?)";

        if ($stmt = mysqli_prepare($connection, $sql)) {

          $param_isim = $isim;
          $param_email = $email;
          $param_password =$password;

          mysqli_stmt_bind_param($stmt, "sss", $param_isim, $param_email, $param_password);

          if (mysqli_stmt_execute($stmt)) {
            header("location: login.php");
          } else {
            echo mysqli_error($connection);
            echo "hata oluştu";
          }
        }
      }
}
 

?>





<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kayıt Ol</title>


  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    
  <link rel="stylesheet" href="views/css/global.css">
  <link rel="stylesheet" href="views/css/main.css">
  <link rel="stylesheet" href="views/css/login-sign.css">
  <!--Google font popiness quicksand-->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&family=Quicksand:wght@500;700&display=swap" rel="stylesheet">
  <!--font awesome-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css ">
</head>

<body>
  <div class="container_login">
    <div class="center">
      <div class="icon text-center"> <b>Sanal</b> Pazar-Kaydol</div>
      <?php echo $isim_err." ".$email_err." ".$password_err." ".$confirm_password_err; ?>  

      <form action="kaydol.php" method="post">

         

          <div class="txt_field">
            <input type="text" name="isim" id="isim" class="form-control <?php echo (!empty($isim_err)) ? 'is-invalid': ''?>" value="<?php echo $isim; ?>">
            <span ></span>
            <label for="isim">İsim</label>
             
          </div>

        <div class="txt_field">
          <input type="email" name="email" id="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid': ''?>" value="<?php echo $email; ?>">
          <span ></span>
          <label for="email">Eposta</label>
           
        </div>

        <div class="txt_field">

          <input type="password" name="password" id="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid': ''?>" >
          <span ></span>
          <label for="password">Şifre</label>
         

        </div>
        <div class="txt_field">

          <input type="password" name="confirm_password" id="confirm_password"  class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid': ''?>">
          <span ></span>
          <label for="confirm_password">sifre tekrar</label>
          

        </div>

        <input type="submit" name="kaydol" value="Submit">
        <div class="signup_link">

          Üye misiniz? <a href="login.php">Giriş Yap</a>

        </div>

      </form>


      <div class="social-btns-container">
        <a href="">
          <div class="social-google">
            <div><i class="fa-brands fa-google-plus-square "></i></div>
            <p> Google ile Kaydol </p>
          </div>
        </a>

        <a href="">
          <div class="social-facebook">
            <div><i class="fa-brands fa-facebook "></i></div>
            <p>Facebook ile Kaydol </p>
          </div>
        </a>

      </div>

    </div>
  </div>

</body>

</html>
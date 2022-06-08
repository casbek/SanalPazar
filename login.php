<?php 
//gerekli dosyalar repuire edildi
 require "libs/vars.php";
 require "libs/ayar.php";
 require "libs/functions.php";
 
 if(isLoggedin()) {//giriş yapıldıysa direk yönelndirmek için
     header("location: index.php");
     exit;   
 }

 $email =  $password = "";
 $email_err = $password_err = $login_err= "";



 if (isset($_POST["login"])) {
//  echo "deneme buraya geldi1";
  if(empty(trim($_POST["email"]))) {
      $email_err = "email girmelisiniz.";
  } else {
      $email = trim($_POST["email"]);
      
  }

  if(empty(trim($_POST["password"]))) {
      $password_err = "password girmelisiniz.";
  } else {
      $password = trim($_POST["password"]);
       
  }

  if(empty($email_err) && empty($password_err)) {
      $sql = "SELECT kullanici_id, email, password, user_type FROM users WHERE email = ?";
      
      if($stmt = mysqli_prepare($connection, $sql)) {
          $param_email =  $email;
          $param_password=$password;
          mysqli_stmt_bind_param($stmt, "s", $param_email);
           
          if(mysqli_stmt_execute($stmt)) {
              mysqli_stmt_store_result($stmt);
             
              if(mysqli_stmt_num_rows($stmt) == 1) {
                 
                  mysqli_stmt_bind_result($stmt,$kullanici_id,$email,$passwordv,$user_type);
                   
                  if(mysqli_stmt_fetch($stmt)) {
                     
                      if($password==$passwordv) {
                        echo "deneme buraya geldi password verify";
                          $_SESSION["loggedin"] = true;
                          $_SESSION["kullanici_id"] = $kullanici_id;
                          $_SESSION["email"] = $email;
                          $_SESSION["user_type"] = $user_type;

                          header("location: index.php");
                      } else {
                          $login_err = "yanlış parola girdiniz";
                      }
                  } 
              } else {
                  $login_err = "yanlış email girdiniz";
              }
          } else {
              $login_err = "bilinmeyen bir hata oluştu.";
          }
          mysqli_stmt_close($stmt);
      }
  }

  mysqli_close($connection);
}








?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Giriş Yap</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">

  <link rel="stylesheet" href="views/css/global.css">
  <link rel="stylesheet" href="views/css/main.css">
  <link rel="stylesheet" href="views/css/login-sign.css">
  <!--Google font popiness quicksand-->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&family=Quicksand:wght@500;700&display=swap"
    rel="stylesheet">
  <!--font awesome-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css ">
</head>
<body>
  <div class="container_login">
    <div class="center">
      <div class="icon text-center"> <b>Sanal</b>Pazar-Giriş</div>
      
      <form action="login.php" method="POST">
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
        
        <div class="pass">Şifremi Unuttum?</div>
        <input   type="submit" name="login" value="Submit">
        <div class="signup_link">
          Üye Degil misiniz? <a href="kaydol.php">Kaydol</a>
        </div>
      </form>
    
    
    
    
      <div class="social-btns-container">
        <a href="">
          <div class="social-google">
            <div><i class="fa-brands fa-google-plus-square "></i></div>
            <p> Google ile Giriş Yap </p>
          </div>
        </a>
         
         <a href=""><div class="social-facebook">
            <div><i class="fa-brands fa-facebook "></i></div>
            <p>Facebook ile Giriş Yap  </p>
          </div></a>
         
      </div>

    </div>
  </div>
  </div>
</body>
</html>
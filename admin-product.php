<?php

    require "libs/vars.php";
    require "libs/functions.php";  
    if(!isAdmin()) {
        header("location: unauthorize.php");
        exit;
    }

?>


<?php 
       if(isset($_GET["id"])){ 
        $id = $_GET["id"];
        $dizi=explode(" ",$id); // cümlemiz boşluklardan bölünecek
        $dizId=$dizi[0];
        $dizislem=$dizi[1];

        $result = getProductbyId($dizId);
        $selecteProduct = mysqli_fetch_assoc($result);   
         
        $message="";

        if($dizislem=="O"){
            productActive($dizId);
            $message= $dizId."nolu dizi onaylandi";
        }elseif($dizislem=="S"){
            productDelete($dizId);
            $message= $dizId."nolu dizi silindi";
        }else{
            echo "bilinmeyen dizi hatası";
        }
         
    }




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ureticiden</title>
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
    <link rel="stylesheet" href="views/css/hesap.css">
      <!--fboostrap-->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

   <style>
       a{
           text-decoration: none;
       }
   </style>
</head>

<body class="gri_fon">
<?php include "views/_navbar.php" ?>

<div class="container my-3">

    <div class="row">

        <div class="col-12">

          
        <?php if (!empty($message)): ?>
            <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong> <?php echo "$message" ?>
            </div>
        <?php endif; ?>

         
      

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 80px;">Image</th>
                        <th>Title</th>
                        <th>sehir</th>
                        <th>Category</th>
                        <th style="width: 100px;">is active</th>
                        <th style="width: 100px;">is home</th>
                        <th style="width: 130px;"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $result = getAdminProducts();  while($urunler = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td>
                                <img src="img/<?php echo $urunler["imageUrl"]?>" alt="" class="img-fluid">
                            </td>
                            <td><?php echo $urunler["title"]?></td>
                            <td><?php echo $urunler["sehir"]?></td>
                            <td> <?php echo $urunler["ikategori"]?></td> </td>
                            <td>
                                <?php if($urunler["isActive"]): ?>
                                    <i class="fas fa-check"></i>
                                <?php else: ?>
                                    <i class="fas fa-times"></i>
                                <?php endif; ?>
                            </td>
                            
                            <td>
                                <a class="btn btn-primary btn-sm" href="admin-product.php?id=<?php echo $urunler["id"]." O"?>">onayla</a>
                                <a class="btn btn-danger btn-sm" href="admin-product.php?id=<?php echo $urunler["id"]." S"?>">sil</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            

        </div>    
    
    </div>

</div>

<?php include "views/_footer.php" ?>


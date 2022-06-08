    <!-- navbar  -->
    <header class="beyaz_fon">
        <div class="container">
            <nav>
                <div class="icon"> <a class="color_black" href="index.php"><b>Sanal</b>Pazar</a></div>
                <div class="search_box">
                    <form action="index.php" method="GET"> 
                    <input type="text" placeholder="Search" name="q">
                    <button   class="fa-solid fa-magnifying-glass"></button>
                    </form>
                </div>
                <ol>
                 
                    <li> 
                    <?php if (isLoggedin()): ?>
                       <a href="ilanver.php" class="ilanver"><i class="fa-solid fa-plus"></i>İlan ver</a> 
                    <?php else: ?>
                       <a href="login.php" class="ilanver"><i class="fa-solid fa-plus"></i>İlan ver</a>
                    <?php endif; ?>
                   </li>
                   <li> 
                    <?php if (isLoggedin() && isAdmin()): ?>
                       <a href="admin-product.php" class="ilanver">Admin</a> 
                    <?php endif; ?>
                   </li>


                    <?php if (isLoggedin()): ?>
                        <li><ul class="listnone relative"><li style="text-align: left;"><a class="color_blue" href="hesapsifre.php"> hesap
                        ayarları</a></li>
                        <li class="textnone">
                                <div class="dropdown-content">
                                    <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> <b>Çıkış Yap</b></a>
                                 </div>
                                <a class="profil" href="logout.php"> <b><?php 
                                $id=$_SESSION["kullanici_id"];
                                 $resultt=getPerson($id);
                                 $person = mysqli_fetch_assoc($resultt);
                                 echo $person["isim"];
                                ?></b>
                                      
                                    <i class="fa-solid fa-angle-down">
                                    </i>
                                </a>
                            </li>
                        </ul>

                    </li>
                    <?php else: ?>
                            <li >
                                <a style="color:black;display: inline-block;  padding: 10px;"  id="kaydoll" href="login.php">
                                 <b style="font-size:1rem ;">Giriş Yap/Kaydol</b></a>
                            </li>
                    <?php endif; ?>    
                </ol>
            </nav>
        </div>
    </header>
    <!-- navbar  bitiss -->
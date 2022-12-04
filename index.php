<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- bylem tu -->
    <title>MinersMC</title>
    <link rel="icon" type="image/png" href="./resources/logo.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mukta&family=Nunito:wght@200;300;400&family=Work+Sans&display=swap" rel="stylesheet">


    <style>
        #body{
            background: repeat url("./resources/bg2.png");
            color: white;
            position: relative;
        }
        h1{
            font-family: 'Work Sans', sans-serif;
        }
        #title{
            font-family: 'Mukta', sans-serif;
        }
        .banner{
            top: 50%;
            transform: translateY(-50%);
            bottom: initial;transform-style: preserve-3d;
            -moz-transform-style: preserve-3d;
            -webkit-transform-style: preserve-3d;
        }
        .outline{
            text-shadow: -1.35px -1.35px 0 #000, 1.35px -1.35px 0 #000, -1.35px 1.35px 0 #000, 1.35px 1.35px 0 #000;
        }
        .outline2{
            text-shadow: -1px -1px 10px #111, 1px -1px 10px #111, -1px 1px 10px #111, 1px 1px 10px #111;
        }
        .boxoutline{
            box-shadow: -1px -1px 10px #202020, 1px -1px 10px #202020, -1px 1px 10px #202020, 1px 1px 10px #202020;
        }
        .card-img-top{
            background-image: url("./resources/card.png");
        }
        .separator{
            margin: 25px 0;
            background-color: white;
            border: 0;
            height:2px;
        }
        .btn-outline-primary{
            color:black;
            border-color:#00FF7F;
            margin:5px;
            box-shadow:2px 2px 3px #000, inset 2px 2px 3px #000;
            border-width: 3px;
        }
        .btn-outline-primary:hover{
            box-shadow: 2px 2px 3px #000, inset 0px 0px 0px #000;
            border-color:#00FF7F;
            background-color:#00FF7F;
            color: black;
        }
        .btn:focus{
            box-shadow: 0 0 0 .25rem rgba(0, 179, 89,.5) !important;
        }
        .btn:active{
            background-color: #00b359;
            border-color: #00FF7F;
        }
        .btn-primary{
            background-color:#00FF7F;
            color:black;
            border: none;
        }
        .btn-primary:hover{
            background-color:#00b359;
            color:black;
            border: none;
        }
        .btn-primary:focus{
            background-color:#00b359;
        }
        .card-title{
            font-family: 'Nunito', sans-serif;
        }
        .card{
            border-width: 0px;
        }
        .card-img-top.produkt{
            height: 333px;
            width: 333px;
        }
        .kategoria{
            padding: 40px 0;
            margin: 25px 0;
        }
        .navbar-dark .navbar-nav .nav-link{
            font-family: 'Nunito', sans-serif;
            font-size: 22px;
            color: white;
        }
        .navbar-dark{
            background: repeat url("./resources/dirt.jpg");
        }
        .scrolled-down{
            transform:translateY(-100%); transition: all 0.3s ease-in-out;
        }
        .scrolled-up{
            transform:translateY(0); transition: all 0.3s ease-in-out;
        }
        .modal-header{
            color: white;
            background: repeat url("./resources/dirt.jpg");
        }
        .modal-body{
            color: white;
            background-color: #333;
        }
        .modal-footer{
            background: repeat url("./resources/dirt.jpg");
        }
        .btn-primary{
            background-color:#00FF7F;
            color:black;
            border: none;
        }
        .btn-primary:hover{
            background-color:#00b359;
            color:black;
            border: none;
        }
        .btn-secondary{
            background-color:#444;
            color:white;
            border: none;
        }
        .card-body{
            color:black;
        }
        .faq{
            background-color: rgba(255, 255, 255, 0.2);
            margin-left:50px;
            margin-right:50px;
            margin-bottom:25px;
            padding:20px;
        }
        .produkt{
            margin-bottom:75px;
        }
    </style>

</head>
<body data-bs-spy="scroll" data-bs-target="#navigacja" id="body">

<div class="container-fluid">
    <nav class="navbar autohide fixed-top navbar-dark navbar-expand-md justify-content-center">
        <div class="container">
            <a href="#" class="navbar-brand d-flex w-50 me-auto"><img src="./resources/logo.png" style="height:50px;" /></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsingNavbar3">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse collapse w-100" id="collapsingNavbar3">
                <ul class="navbar-nav w-100 justify-content-center">
                    <li class="nav-item" style="margin-right:50px;">
                        <a class="nav-link" href="#aktualnosci">Aktualności</a>
                    </li>
                    <li class="nav-item" style="margin-right:50px;">
                        <a class="nav-link" href="#sklep">Sklep</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#kontakt">Kontakt</a>
                    </li>

                </ul>
                <div class="nav navbar-nav ms-auto w-100"></div>
            </div>
        </div>
    </nav>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> <!-- banner -->

            <div id="banner" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="./resources/banner.jpg" alt="Banner strony" class="d-block w-100" />
                        <div class="carousel-caption banner">
                            <h1 id="title" class="d-none d-sm-block" style="font-style:bold;font-size:100px;text-shadow:2px 2px 5px #000;">MinersMC</h1>
                            <h1 id="title" class="d-block d-sm-none" style="font-style:bold;font-size:50px;text-shadow:2px 2px 5px #000;">MinersMC</h1> <!-- tylko dla xs -->
                            <div style="height:75px;" class="d-none d-sm-none d-md-none d-lg-block"></div>
                            <p style="font-style: italic;font-size:40px;text-shadow:2px 2px 2px #000;" class="d-none d-sm-block">mc.miners.pl</p>
                            <p style="font-style: italic;font-size:40px;text-shadow:2px 2px 2px #000;" class="outline d-block d-sm-none">mc.miners.pl</p> <!-- tylko dla xs -->
                            <p class="outline d-none d-sm-none d-md-block" style="color:#30f329;font-size:40px;">🟢 Online</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <p>
            <h1 class="text-center kategoria">
                Poznaj nasze tryby gry
            </h1>
            </p>
            <div class="carousel slide boxoutline" data-bs-ride="carousel" id="trybygry" style="width:80%;margin: 0px auto;">

                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#trybygry" data-bs-slide-to="0" class="active"></button>
                    <button type="button" data-bs-target="#trybygry" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#trybygry" data-bs-slide-to="2"></button>
                </div>

                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="./resources/skyblock.png" alt="Skyblock" class="d-block w-100">
                        <div class="carousel-caption banner">
                            <h1 class="outline2 h1 d-none d-sm-block" style="font-size:70px;margin:50px;">
                                Skyblock
                            </h1>
                            <h1 class="outline2 h1 d-block d-sm-none" style="font-size:30px;margin:0px auto;"> <!-- wyświetlane tylko na xs -->
                                Skyblock
                            </h1>
                            <p class="outline2 d-none d-sm-none d-md-none d-lg-block" style="font-size:35px;">
                                Przeżyj na bezludnej wyspie w przestworzach
                            </p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="./resources/towny.jpg" alt="Towny" class="d-block w-100">
                        <div class="carousel-caption banner">
                            <h1 class="outline2 h1 d-none d-sm-block" style="font-size:70px;margin:50px;">
                                Towny
                            </h1>
                            <h1 class="outline2 h1 d-block d-sm-none" style="font-size:30px;margin:0px auto;"> <!-- wyświetlane tylko na xs -->
                                Towny
                            </h1>
                            <p class="outline2 d-none d-sm-none d-md-none d-lg-block" style="font-size:35px;">
                                Wznieś i powiększaj swoje miasto
                            </p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="./resources/creative.png" alt="Creative" class="d-block w-100">
                        <div class="carousel-caption banner">
                            <h1 class="outline2 h1 d-none d-sm-block" style="font-size:70px;margin:50px;">
                                Creative
                            </h1>
                            <h1 class="outline2 h1 d-block d-sm-none" style="font-size:30px;margin:0px auto;"> <!-- wyświetlane tylko na xs -->
                                Creative
                            </h1>
                            <p class="outline2 d-none d-sm-none d-md-none d-lg-block" style="font-size:35px;">
                                Buduj imponujące budowle na działkach 256x256
                            </p>
                        </div>
                    </div>
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#trybygry" data-bs-slide="prev" style="background-color: rgba(0, 0, 0, 0.5);">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#trybygry" data-bs-slide="next" style="background-color: rgba(0, 0, 0, 0.5);">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="separator"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center kategoria" id="aktualnosci">
                Aktualności
            </h1>
            <h3 style="margin-left:50px;margin-right:50px;padding:20px;"> Najnowszy wpis: </h3>

            <div style="background-color: rgba(255, 255, 255, 0.2);margin-left:50px;margin-right:50px;padding:20px;">

            <?php
                require("backrooms/bd-authorize.php"); //Autoryzacja dostępu do bazy danych

                $pdo = new PDO('mysql:host=' . $mysql_host . ';dbname=' . $database . ';port=' . $port, $username, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $shorttext = "";

                $stmt = $pdo->query('SELECT `data`, `tytul`, `tresc` FROM `wpisy` order by id_wpisu DESC limit 1;');
                foreach ($stmt as $row) {

                    echo "<p>".$row['data']."</p>";
                    echo "<h2 style='text-decoration:underline;'>".$row['tytul']."</h2>";
                    if (strlen($row['tresc']) > 450)
                    {
                        $str = 0;
                        $shorttext = substr($row['tresc'],0,450);
                        $pos = strrpos($shorttext, ' ');
                        if ($pos !== false && $pos > 200){
                            $str = substr($str,0,$pos);
                        }
                        $shorttext .= '...';
                        echo "<p style='font-size:20px;' class='d-md-block d-none'>".$row['tresc']."</p>";
                        echo "<p style='font-size:20px;' class='d-md-none d-block'>".$shorttext."</p>";
                    } else {
                        echo "<p style='font-size:20px;'>".$row['tresc']."</p>";
                    }


                }
                $stmt->closeCursor();
                ?>
                <p>
                    <a class="btn btn-outline-primary" href="#">Wszystkie aktualności</a>
                </p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 text-center">
        <h1 class="text-center kategoria" id="sklep">
            Wesprzyj serwer kupując w naszym sklepie
        </h1>
		<?php
		require("./backrooms/bd-authorize.php"); 
		
		 try{
            $pdo = new PDO('mysql:host=' . $mysql_host . ';dbname=' . $database . ';port=' . $port, $username, $password);

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
            $stmta = $pdo->query('SELECT * FROM produkty WHERE id_produktu=1;');
			$stmtb = $pdo->query('SELECT * FROM produkty WHERE id_produktu=2;');
			$stmtc = $pdo->query('SELECT * FROM produkty WHERE id_produktu=4;'); //trzeba to odkomentowac gdy bedzie 3 produkt
           
               
      
		
		echo'
        <div class="row">';
		
		 foreach ($stmta as $row) {
            echo '<div class="col-md-4 d-flex justify-content-center produkt">
            <div class="card" style="width:400px;">
                <img class="card-img-top produkt'.$row['id_produktu'].'" src="'.$row['obraz'].'" alt="Card image">
                <div class="card-body">
                    <h3 class="card-title produkt'.$row['id_produktu'].'">'.$row['nazwa'].'</h3>
                    <p class="card-text produkt'.$row['id_produktu'].'" style="font-size:22px;">'.$row['cena'].' zł</p>
                    <input type="hidden" class="produkt'.$row['id_produktu'].'" value="'.$row['opis'].'">
                    <a class="btn btn-outline-primary text-center" style="width:50%;margin: 0px auto;font-size:18px;" onclick="showProd('.$row['id_produktu'].')" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Wybierz</a>
                </div>
            </div>
        </div>';
		 }
			
			 foreach ($stmtb as $row) {
                echo '<div class="col-md-4 d-flex justify-content-center produkt">
                <div class="card" style="width:400px;">
                    <img class="card-img-top produkt'.$row['id_produktu'].'" src="'.$row['obraz'].'" alt="Card image">
                    <div class="card-body">
                        <h3 class="card-title produkt'.$row['id_produktu'].'">'.$row['nazwa'].'</h3>
                        <p class="card-text produkt'.$row['id_produktu'].'" style="font-size:22px;">'.$row['cena'].' zł</p>
                        <input type="hidden" class="produkt'.$row['id_produktu'].'" value="'.$row['opis'].'">
                        <a class="btn btn-outline-primary text-center" style="width:50%;margin: 0px auto;font-size:18px;" onclick="showProd('.$row['id_produktu'].')" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Wybierz</a>
                    </div>
                </div>
            </div>';
		 }
			//tu trzeba skopiowac powyzsze jako stmtc
            foreach ($stmtc as $row) {
                echo '<div class="col-md-4 d-flex justify-content-center produkt">
                    <div class="card" style="width:400px;">
                        <img class="card-img-top produkt'.$row['id_produktu'].'" src="'.$row['obraz'].'" alt="Card image">
                        <div class="card-body">
                            <h3 class="card-title produkt'.$row['id_produktu'].'">'.$row['nazwa'].'</h3>
                            <p class="card-text produkt'.$row['id_produktu'].'" style="font-size:22px;">'.$row['cena'].' zł</p>
                            <input type="hidden" class="produkt'.$row['id_produktu'].'" value="'.$row['opis'].'">
                            <a class="btn btn-outline-primary text-center" style="width:50%;margin: 0px auto;font-size:18px;" onclick="showProd('.$row['id_produktu'].')" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Wybierz</a>
                        </div>
                    </div>
                </div>';
            }
		
		      
            $stmta->closeCursor();
			$stmtb->closeCursor();
			$stmtc->closeCursor();  
			
        } catch(PDOException $e) {
            echo '😵';
        }
		
		?>
		
		
        <div style="padding:40px;">
            <a class="btn btn-outline-primary text-center" style="min-width:35%;max-width:635px;margin: 0px auto;font-size:22px;" href="./sklep">Zobacz pełną ofertę</a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="separator"></div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h1 class="text-center kategoria" id="kontakt">
            Kontakt
        </h1>
        <div class="row" style="margin-bottom:100px;">
            <div class="col-md-4 d-flex justify-content-center">
                <a class="btn btn-outline-primary text-center" style="width:400px;font-size:22px;" href="https://discord.com/"><img src="https://cdn.iconscout.com/icon/free/png-256/discord-3691244-3073764.png" style="height:64px;width:64px;margin-right:25px;" />Discord</a>
            </div>
            <div class="col-md-4 d-flex justify-content-center">
                <a class="btn btn-outline-primary text-center" style="width:400px;font-size:22px;" href="https://twitter.com/RetroTechDreams"><img src="https://www.freepnglogos.com/uploads/twitter-logo-png/twitter-logo-vector-png-clipart-1.png" style="height:64px;width:64px;margin-right:25px;" />Twitter</a>
            </div>
            <div class="col-md-4 d-flex justify-content-center">
                <a class="btn btn-outline-primary text-center disabled" style="width:400px;font-size:22px;color:white;" href="/sklep"><img src="https://icon-library.com/images/white-email-icon-png/white-email-icon-png-16.jpg" style="height:64px;width:64px;margin-right:25px;" />minersmc@mc.pl</a>
            </div>
        </div>
    </div>
</div>
<div style="text-align:center;color:white;">Wdrożenie - AM 2022</div>
</div>



<div class="fixed-bottom" id="alert">
<div class="alert alert-primary d-flex align-items-center" role="alert" >
<img src="./resources/cookie.png" style="width:60px;height:60px; padding:10px;">
  <div>
    <p><strong>Ta strona używa ciasteczek. Korzystając ze strony wyrażasz zgodę na warunki naszej polityki prywatności.</strong><br>Zapoznaj się z naszą <a href="polityka.html">polityką prywatności.</a></p>
  </div>
  <br>
  <button type="button" class="btn btn-outline-primary text-center" id="accept" onclick="aaa();">Rozumiem</button>
 <a class="btn btn-outline-primary text-center" href="bluescreen.html">Nie wyrażam zgody</a>
</div>
</div>



<script>
var alert=document.getElementById("alert");
var accept=document.getElementById("accept");
var body=document.getElementById("body");
function aaa(){
	alert.style.display = "none";
	
}
document.addEventListener("DOMContentLoaded", function(event) {
  alert.style.display = "block";

});
	
	

</script>
<script src="./resources/scroll.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
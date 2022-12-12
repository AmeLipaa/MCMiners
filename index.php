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
        body{
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
        .separator{
            margin: 25px 0;
            background-color: white;
            border: 0;
            height:2px;
        }
        .btn-outline-primary{
            color:white;
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
        .card-title{
            font-family: 'Nunito', sans-serif;
        }
        .card{
            border-width: 0px;
        }
        .kategoria{
            padding: 40px 0;
            margin-top: 25px;
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
        .bi{
            margin-right: 25px;
        }
    </style>

</head>
<body data-bs-spy="scroll" data-bs-target="#navigacja">

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
                        $shorttext = substr($row['tresc'],0,450);
                        $pos = strrpos($shorttext, ' ');
                        if ($pos !== false && $pos > 200)
                            $str = substr($str,0,$pos);
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
        <div class="row">
            <div class="col-md-4 d-flex justify-content-center" style="margin-top: 25px;">
                <div class="card" style="width:400px;height:500px;">
                    <img class="card-img-top" src="./resources/vip.png" alt="Card image">
                    <div class="card-body">
                        <h3 class="card-title" style="color:black;">Ranga VIP</h3>
                        <p class="card-text" style="color:black;font-size:22px;">3.99zł/miesiąc</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 d-flex justify-content-center" style="margin-top: 25px;">
                <div class="card" style="width:400px;height:500px;">
                    <img class="card-img-top" src="./resources/wedit.png" alt="Card image">
                    <div class="card-body">
                        <h3 class="card-title" style="color:black;">WorldEdit na Creative</h3>
                        <p class="card-text" style="color:black;font-size:22px;">0.99zł/miesiąc</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 d-flex justify-content-center" style="margin-top: 25px;">
                <div class="card" style="width:400px;height:500px;">
                    <img class="card-img-top" src="./resources/unban.png" alt="Card image">
                    <div class="card-body">
                        <h3 class="card-title" style="color:black;">Unban</h3>
                        <p class="card-text" style="color:black;font-size:22px;">35.00zł/jednorazowo</p>
                    </div>
                </div>
            </div>
        </div>
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
                <a class="btn btn-outline-primary text-center" style="width:400px;font-size:22px;" href="https://discord.com/">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-discord" viewBox="0 0 16 16">
                        <path d="M13.545 2.907a13.227 13.227 0 0 0-3.257-1.011.05.05 0 0 0-.052.025c-.141.25-.297.577-.406.833a12.19 12.19 0 0 0-3.658 0 8.258 8.258 0 0 0-.412-.833.051.051 0 0 0-.052-.025c-1.125.194-2.22.534-3.257 1.011a.041.041 0 0 0-.021.018C.356 6.024-.213 9.047.066 12.032c.001.014.01.028.021.037a13.276 13.276 0 0 0 3.995 2.02.05.05 0 0 0 .056-.019c.308-.42.582-.863.818-1.329a.05.05 0 0 0-.01-.059.051.051 0 0 0-.018-.011 8.875 8.875 0 0 1-1.248-.595.05.05 0 0 1-.02-.066.051.051 0 0 1 .015-.019c.084-.063.168-.129.248-.195a.05.05 0 0 1 .051-.007c2.619 1.196 5.454 1.196 8.041 0a.052.052 0 0 1 .053.007c.08.066.164.132.248.195a.051.051 0 0 1-.004.085 8.254 8.254 0 0 1-1.249.594.05.05 0 0 0-.03.03.052.052 0 0 0 .003.041c.24.465.515.909.817 1.329a.05.05 0 0 0 .056.019 13.235 13.235 0 0 0 4.001-2.02.049.049 0 0 0 .021-.037c.334-3.451-.559-6.449-2.366-9.106a.034.034 0 0 0-.02-.019Zm-8.198 7.307c-.789 0-1.438-.724-1.438-1.612 0-.889.637-1.613 1.438-1.613.807 0 1.45.73 1.438 1.613 0 .888-.637 1.612-1.438 1.612Zm5.316 0c-.788 0-1.438-.724-1.438-1.612 0-.889.637-1.613 1.438-1.613.807 0 1.451.73 1.438 1.613 0 .888-.631 1.612-1.438 1.612Z"/>
                    </svg>
                    Discord
                </a>
            </div>
            <div class="col-md-4 d-flex justify-content-center">
                <a class="btn btn-outline-primary text-center" style="width:400px;font-size:22px;" href="https://twitter.com/RetroTechDreams">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
                        <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>
                    </svg>
                    Twitter
                </a>
            </div>
            <div class="col-md-4 d-flex justify-content-center">
                <a class="btn btn-outline-primary text-center disabled" style="width:400px;font-size:22px;color:white;" href="/sklep">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="currentColor" class="bi bi-envelope-at-fill" viewBox="0 0 16 16">
                        <path d="M2 2A2 2 0 0 0 .05 3.555L8 8.414l7.95-4.859A2 2 0 0 0 14 2H2Zm-2 9.8V4.698l5.803 3.546L0 11.801Zm6.761-2.97-6.57 4.026A2 2 0 0 0 2 14h6.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.606-3.446l-.367-.225L8 9.586l-1.239-.757ZM16 9.671V4.697l-5.803 3.546.338.208A4.482 4.482 0 0 1 12.5 8c1.414 0 2.675.652 3.5 1.671Z"/>
                        <path d="M15.834 12.244c0 1.168-.577 2.025-1.587 2.025-.503 0-1.002-.228-1.12-.648h-.043c-.118.416-.543.643-1.015.643-.77 0-1.259-.542-1.259-1.434v-.529c0-.844.481-1.4 1.26-1.4.585 0 .87.333.953.63h.03v-.568h.905v2.19c0 .272.18.42.411.42.315 0 .639-.415.639-1.39v-.118c0-1.277-.95-2.326-2.484-2.326h-.04c-1.582 0-2.64 1.067-2.64 2.724v.157c0 1.867 1.237 2.654 2.57 2.654h.045c.507 0 .935-.07 1.18-.18v.731c-.219.1-.643.175-1.237.175h-.044C10.438 16 9 14.82 9 12.646v-.214C9 10.36 10.421 9 12.485 9h.035c2.12 0 3.314 1.43 3.314 3.034v.21Zm-4.04.21v.227c0 .586.227.8.581.8.31 0 .564-.17.564-.743v-.367c0-.516-.275-.708-.572-.708-.346 0-.573.245-.573.791Z"/>
                    </svg>
                    minersmc@mc.pl
                </a>
            </div>
        </div>
    </div>
</div>
<div style="text-align:center;color:white;">Wdrożenie - AM 2022</div>
</div>
<script src="./resources/scroll.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
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
            text-align: center;
            margin: 40px;
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
        .btn:focus{
            box-shadow: 0 0 0 .25rem rgba(0, 179, 89,.5) !important;
        }
        .btn:active{
            background-color: #00b359;
            border-color: #00FF7F;
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
        .entry{
            background-color: rgba(0, 0, 0, 0.75);
            margin: 25px 50px 25px 50px;
            padding: 20px;
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
                        <a class="nav-link" href="index.php">Powrót</a>
                    </li>
                    <li class="nav-item" style="margin-right:50px;">
                        <a class="nav-link" href="#">Początek</a>
                    </li>
                </ul>
                <div class="nav navbar-nav ms-auto w-100"></div>
            </div>
        </div>
    </nav>

    <div class="row">
        <div class="col-md-12">
            <h1>Wpisy</h1>
            <div class="separator"></div>
        </div>
    </div>
    <div class="row" style="background: no-repeat fixed center url('./resources/background4.png')">
        <?php
        require("backrooms/bd-authorize.php"); //Autoryzacja dostępu do bazy danych

        $pdo = new PDO('mysql:host=' . $mysql_host . ';dbname=' . $database . ';port=' . $port, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->query('SELECT `data`, `tytul`, `tresc` FROM `wpisy` order by id_wpisu DESC;');
        foreach ($stmt as $row) {
            echo '<div class="col-md-12">
                    <div class="entry">
                        <p>'.$row['data'].'</p>
                        <h2 style="text-decoration:underline;">'.$row['tytul'].'</h2>
                        <p style="font-size:20px;">'.$row['tresc'].'</p>
                    </div>
                   </div>';
        }
        $stmt->closeCursor();
        ?>
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
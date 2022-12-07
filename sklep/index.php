<?php
session_start();
require("../backrooms/bd-authorize.php"); //Autoryzacja dostępu do bazy danych
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>MinersMC</title>
    <link rel="icon" type="image/png" href="../resources/logo.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mukta&family=Nunito:wght@200;300;400&family=Work+Sans&display=swap" rel="stylesheet">


    <style>
        body{
            background: repeat url("../resources/bg2.png");
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
            background-image: url("../resources/card.png");
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
        .kategoria, #faq{
            padding: 40px 0;
        }
        #faq{
            margin: 25px 0;
        }
        .navbar-dark .navbar-nav .nav-link{
            font-family: 'Nunito', sans-serif;
            font-size: 22px;
            color: white;
        }
        .navbar-dark{
            background: repeat url("../resources/dirt.jpg");
        }
        .scrolled-down{
            transform:translateY(-100%); transition: all 0.3s ease-in-out;
        }
        .scrolled-up{
            transform:translateY(0); transition: all 0.3s ease-in-out;
        }
        .modal-header{
            color: white;
            background: repeat url("../resources/dirt.jpg");
        }
        .modal-body{
            color: white;
            background-color: #333;
        }
        .modal-footer{
            background: repeat url("../resources/dirt.jpg");
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
        #search{
            vertical-align: middle;
        }
        .search{
            color: white;
        }
        .search:hover{
            color: black;
        }
        .darkbg{
            background-color: rgba(0, 0, 0, 0.6);
            padding-bottom: 25px;
            margin-bottom: 25px;
            margin-top: 25px;
        }
        .forminput {
            border-radius: 3px;
            border-color: gray;
            border-style: solid;
            border-width: 1px;
            background-color: white;
            height: 30px;
            vertical-align: middle;
        }
    </style>

</head>
<body data-bs-spy="scroll" data-bs-target="#navigacja">

<div class="container-fluid">
    <nav class="navbar autohide fixed-top navbar-dark navbar-expand-md justify-content-center">
        <div class="container">
            <a href="#" class="navbar-brand d-flex w-50 me-auto"><img src="../resources/logo.png" style="height:50px;" /></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsingNavbar3">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse collapse w-100" id="collapsingNavbar3">
                <ul class="navbar-nav w-100 justify-content-center">
                    <li class="nav-item" style="margin-right:50px;">
                        <a class="nav-link" href="..">Powrót</a>
                    </li>
                    <li class="nav-item" style="margin-right:50px;">
                        <a class="nav-link" href="#sklep">Oferta</a>
                    </li>
                    <li class="nav-item" style="margin-right:50px;">
                        <a class="nav-link" href="#faq">FAQ</a>
                    </li>
                </ul>
                <div class="nav navbar-nav ms-auto w-100"></div>
            </div>
        </div>
    </nav>

    <div class="row">
        <div class="col-md-12 text-center" style="background: no-repeat fixed center url('../resources/background4.png');">
            <div class="darkbg">
                <?php
                if(!isset($_SESSION['user'])){
                    echo '
                    <h1 class="text-center kategoria">
                        Zaloguj się lub stwórz konto<br>
                        <div class="row" style="margin-top: 50px;">
                            <div class="col-4 d-sm-none d-sm-none d-md-block"></div>
                            <div class="col-12 col-md-2">
                                <a href="./konto/index.php" class="btn btn-primary text-center w-100 mt-1" data-bs-target="_self">Zaloguj</a>
                            </div>
                            <div class="col-12 col-md-2">
                                <a href="./konto/register.php" class="btn btn-primary text-center w-100 mt-1" data-bs-target="_self">Utwórz konto</a>
                            </div>
                            <div class="col-4 d-sm-none d-sm-none d-md-block"></div>
                        </div>
                    </h1>';
                } else {
                    include('../backrooms/welcome.php');
                        echo '
                        <div class="row" style="margin-top: 25px;">
                            <div class="col-4 d-sm-none d-sm-none d-md-block"></div>
                            <div class="col-12 col-md-2">
                                <a href="./konto/panel.php" class="btn btn-primary text-center w-100 mt-1" data-bs-target="_self">Profil</a>
                            </div>
                            <div class="col-12 col-md-2">
                                <a href="./konto/koszyk.php" class="btn btn-primary text-center w-100 mt-1" data-bs-target="_self">Koszyk</a>
                            </div>
                            <div class="col-4 d-sm-none d-sm-none d-md-block"></div>
                        </div>';
                }
                ?>
            </div>

            <div class="darkbg">
                <h1 class="text-center kategoria" id="sklep">
                    Wesprzyj serwer kupując w naszym sklepie
                </h1>
                <form method="post">
                    <input maxlength="64" placeholder="Nazwa" name="which-product" id="search">
                    <select name='sort' class="forminput">
                        <option value='' selected='' disabled=''>Sortowanie</option>
                        <option value=''>Domyślne</option>
                        <option value=' ORDER BY cena'>Wg. ceny ↑</option>
                        <option value=' ORDER BY cena DESC'>Wg. ceny ↓</option>
                        <option value=' ORDER BY nazwa'>Wg. nazwy A-Z</option>
                        <option value=' ORDER BY nazwa DESC'>Wg. nazwy Z-A</option>
                    </select>
                    <button class="btn btn-outline-primary search" type="submit" name="filter">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                        </svg>
                        Szukaj
                    </button>
                </form>
            </div>
            <div class="row">
            <?php
            try{
                $pdo = new PDO('mysql:host=' . $mysql_host . ';dbname=' . $database . ';port=' . $port, $username, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                if (isset($_POST['filter'])) {
                    $whichprod = $_POST['which-product'];
                    $sorting = $_POST['sort'];
                    $stmt = $pdo->query('SELECT * FROM produkty AS p INNER JOIN kategorie_prod AS k ON p.id_kategorii = k.id_kategorii WHERE nazwa LIKE "'.$whichprod.'%"'.$sorting.';');
                } else {
                    $stmt = $pdo->query('SELECT * FROM produkty AS p INNER JOIN kategorie_prod AS k ON p.id_kategorii = k.id_kategorii;');
                }

                foreach ($stmt as $row) {
                    echo '<div class="col-md-4 d-flex justify-content-center produkt">
                    <div class="card" style="width:400px;">
                        <img class="card-img-top produkt'.$row['id_produktu'].'" src="'.$row['obraz'].'" alt="Card image">
                        <div class="card-body">
                            <h3 class="card-title produkt'.$row['id_produktu'].'">'.$row['p.nazwa'].'</h3>
                            <p class="card-text produkt'.$row['id_produktu'].'" style="font-size:22px;">'.$row['cena'].' zł</p>
                            <input type="hidden" class="produkt'.$row['id_produktu'].'" value="'.$row['opis'].'">
                             <input type="hidden" class="produkt'.$row['id_produktu'].'" value="'.$row['typ'].'">
                            <a class="btn btn-outline-primary text-center" style="width:50%;margin: 0px auto;font-size:18px;" onclick="showProd('.$row['id_produktu'].')" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Wybierz</a>
                        </div>
                    </div>
                </div>';
                }
                $stmt->closeCursor();
            } catch(PDOException $e) {
                echo '😵';
            }
            ?>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="staticBackdropLabel">Zakup przedmiotu</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color:rgba(0, 255, 127, 0.75);"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" value="" id="prodid" name="prodid">
                    <div style="margin:auto;width:fit-content">
                        <img src="" style="width:250px;height:250px;" id="modalimg">
                    </div>
                    <h4 id="modaltitle"></h4>
                    <p id="modaldesc"></p>
                    <h3 id="modalprice"></h3>
                    <input class="mt-3 form-control" type="number" name="ilosc" id="prodilosc" min="1" max="100" value="1" onchange="updateCena()">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                    <button type="button" class="btn btn-primary">Dodaj do koszyka</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="separator"></div>
        </div>
    </div>
    <div class="row" style="margin-bottom:75px;">
        <div class="col-md-12">
            <h1 class="text-center kategoria" id="faq">
                FAQ
            </h1>
            <div class="faq">
                <h2>
                    1. Pytanie
                </h2>
                <p style="font-size:22px;">
                    Troche prawdy jest ale zobacz patrząc na to z perspektywy że chcesz raz tylko zrobic wyjątek bo chcesz sobie sport porobić to lepsze to niż jakby ci sie nie chciało albo jakbyśmy poszli robić coś nie zdrowego albo coś
                </p>
            </div>
            <div class="faq">
                <h2>
                    2. Pytanie
                </h2>
                <p style="font-size:22px;">
                    Troche prawdy jest ale zobacz patrząc na to z perspektywy że chcesz raz tylko zrobic wyjątek bo chcesz sobie sport porobić to lepsze to niż jakby ci sie nie chciało albo jakbyśmy poszli robić coś nie zdrowego albo coś
                </p>
            </div>
            <div class="faq">
                <h2>
                    3. Pytanie
                </h2>
                <p style="font-size:22px;">
                    Troche prawdy jest ale zobacz patrząc na to z perspektywy że chcesz raz tylko zrobic wyjątek bo chcesz sobie sport porobić to lepsze to niż jakby ci sie nie chciało albo jakbyśmy poszli robić coś nie zdrowego albo coś
                </p>
            </div>
            <div class="faq">
                <h2>
                    4. Pytanie
                </h2>
                <p style="font-size:22px;">
                    Troche prawdy jest ale zobacz patrząc na to z perspektywy że chcesz raz tylko zrobic wyjątek bo chcesz sobie sport porobić to lepsze to niż jakby ci sie nie chciało albo jakbyśmy poszli robić coś nie zdrowego albo coś
                </p>
            </div>
        </div>
    </div>
    <div style="text-align:center;color:white;">Wdrożenie - AM 2022</div>
</div>
<script>
    const formatter = new Intl.NumberFormat('pl-PL', {
        style: 'currency',
        currency: 'PLN',
    });
    var ogprice = 0;
    var price = document.getElementById("modalprice");
    var title = document.getElementById("modaltitle");
    var desc = document.getElementById("modaldesc")
    var img = document.getElementById("modalimg");
    var prodid = document.getElementById("prodid");
    var ilosc = document.getElementById("prodilosc");
    function showProd(id){
        img.src = document.getElementsByClassName("produkt"+id)[0].src;
        title.innerHTML = document.getElementsByClassName("produkt"+id)[1].innerText;
        price.innerText = document.getElementsByClassName("produkt"+id)[2].innerText;
        desc.innerText = document.getElementsByClassName("produkt"+id)[3].value;
        if(document.getElementsByClassName("produkt"+id)[4].value == 0){
            ilosc.value = 1;
            ilosc.style.display = "block";
            ilosc.disabled = false;
        } else {
            ilosc.style.display = "none";
            ilosc.disabled = true;
        }
        prodid.value = id;
        ogprice = Number(price.innerText.slice(0, -3));
    }
    function updateCena(){
        price.innerText = formatter.format((ogprice * ilosc.value));
    }
</script>
<script src="../resources/scroll.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
<?php
session_start();

require("../backrooms/bd-authorize.php"); //Autoryzacja dostępu do bazy danych

if(isset($_POST['add'])){
    $pdo = new PDO('mysql:host=' . $mysql_host . ';dbname=' . $database . ';port=' . $port, $username, $password);
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo -> query('SELECT cena FROM produkty WHERE id_produktu = '.$_POST['prodid'].';');
    foreach($stmt as $row){
        $cena = $row['cena'];
    }

    $x = false;
    if(isset($_SESSION['ilosci'])){ //sprawdza czy już istnieje w sesji zmienna ilosci i jeśli tak to przypisuje istniejącą tabelę do zmiennej lokalnej
        $ilosci = $_SESSION['ilosci'];
    }
    if(isset($_SESSION['ilosci'])){ //sprawdza czy już istnieje w sesji zmienna ilosci i jeśli tak to przypisuje istniejącą tabelę do zmiennej lokalnej
        $ceny = $_SESSION['ceny'];
    }
    if(isset($_SESSION['produkty'])){ //sprawdza czy już istnieje w sesji zmienna produkty i jeśli tak to przypisuje istniejącą tabelę do zmiennej lokalnej
        $produkty = $_SESSION['produkty'];
        foreach($produkty as $key => $val){
            if($val == $_POST['prodid']){
                if($_POST['prodtype'] == 0){
                    $ilosci[$key] += $_POST['ilosc']; //dopisuje do już istniejącej wartości w tablicy w sesji
                }
                $x = true;
            }
        }
    }
    if($x == false){
        $produkty[] = $_POST['prodid']; //dopisuje do zmiennej lokalnej
        $ceny[] = $cena;
        if($_POST['prodtype'] == 0){
            $ilosci[] = $_POST['ilosc']; //dopisuje do zmiennej lokalnej
        } else {
            $ilosci[] = 1; //dopisuje do zmiennej lokalnej
        }
    }
    $_SESSION['produkty'] = $produkty; //aktualizuje zmienną z sesji
    $_SESSION['ilosci'] = $ilosci; //aktualizuje zmienną z sesji
    $_SESSION['ceny'] = $ceny; //aktualizuje zmienną z sesji

    echo '<div class="alert alert-success d-flex align-items-center" role="alert" id="jupi">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-cart-check" viewBox="0 0 16 16">
                      <path d="M11.354 6.354a.5.5 0 0 0-.708-.708L8 8.293 6.854 7.146a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z"/>
                      <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                    </svg>
					<div>
						Pomyślnie dodano produkt do koszyka!
					</div>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" onClick="window.location.href=index.php; return false;"></button>
					</div>';
}
if(isset($_GET['x'])){
    if($_GET['x'] == 1){
        echo '<div class="alert alert-success d-flex align-items-center" role="alert" id="jupi">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-bag-heart-fill" viewBox="0 0 16 16">
              <path d="M11.5 4v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5ZM8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1Zm0 6.993c1.664-1.711 5.825 1.283 0 5.132-5.825-3.85-1.664-6.843 0-5.132Z"/>
            </svg>
            <div>
                    Zamówienie zostało złożone!
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" onClick="window.location.href=index.php; return false;"></button>
            </div>';
    } else if($_GET['x'] == 2){
        echo '<div class="alert alert-danger d-flex align-items-center" role="alert" id="jupi">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-question-octagon" viewBox="0 0 16 16">
              <path d="M4.54.146A.5.5 0 0 1 4.893 0h6.214a.5.5 0 0 1 .353.146l4.394 4.394a.5.5 0 0 1 .146.353v6.214a.5.5 0 0 1-.146.353l-4.394 4.394a.5.5 0 0 1-.353.146H4.893a.5.5 0 0 1-.353-.146L.146 11.46A.5.5 0 0 1 0 11.107V4.893a.5.5 0 0 1 .146-.353L4.54.146zM5.1 1 1 5.1v5.8L5.1 15h5.8l4.1-4.1V5.1L10.9 1H5.1z"/>
              <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z"/>
            </svg>
            <div>
                    Wystąpił problem z twoim zamówieniem.
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" onClick="window.location.href=index.php; return false;"></button>
            </div>';
    }
}
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
        .alert{
            color: black;
            margin-bottom: 0px !important;
        }
        .alert-success{
            background-color: #00FF7F;
            border-color: #00b359;
        }
        .alert svg{
            margin-right: 15px;
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
            <div class="darkbg" id="kontodiv">
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
                                <a href="koszyk.php" class="btn btn-primary text-center w-100 mt-1" data-bs-target="_self">Koszyk</a>
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
                    <?php
                    echo '<select name="kat" class="forminput">';
                    $pdo = new PDO('mysql:host=' . $mysql_host . ';dbname=' . $database . ';port=' . $port, $username, $password);
                    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stmt = $pdo -> query('SELECT id_kategorii, nazwa FROM kategorie_prod;');
                    echo '<option value="0" selected="" disabled>Kategoria</option>';
                    echo '<option value="0">Wszystkie</option>';
                    foreach($stmt as $row){
                        echo '<option value="'.$row['id_kategorii'].'">'.$row['nazwa'].'</option>';
                    }
                    $stmt -> closeCursor();
                    echo '</select>';
                    ?>
                    <select name="sort" class="forminput">
                        <option value='0' selected='' disabled=''>Sortowanie</option>
                        <option value='0'>Domyślne</option>
                        <option value='1'>Wg. ceny ↑</option>
                        <option value='2'>Wg. ceny ↓</option>
                        <option value='3'>Wg. nazwy A-Z</option>
                        <option value='4'>Wg. nazwy Z-A</option>
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
                $sortarr = ['',' ORDER BY cena',' ORDER BY cena DESC',' ORDER BY pname',' ORDER BY pname DESC'];
                $pdo = new PDO('mysql:host=' . $mysql_host . ';dbname=' . $database . ';port=' . $port, $username, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                if (isset($_POST['filter'])) {
                    $filter_cat = "";
                    $filter_sort = "";
                    $whichprod = $_POST['which-product'];
                    if(isset($_POST['kat'])){
                        if($_POST['kat'] != 0) {
                            $filter_cat = " AND pid = " . $_POST['kat'];
                        }
                    }
                    if(isset($_POST['sort'])){
                        $filter_sort = $sortarr[$_POST['sort']];
                    }
                    $stmt = $pdo->query('SELECT * FROM `Sklep` WHERE `pname` LIKE "'.$whichprod.'%"'.$filter_cat . $filter_sort.';');
                } else {
                    $stmt = $pdo->query('SELECT * FROM `Sklep`;');
                }

                foreach ($stmt as $row) {
                    echo '<div class="col-md-4 d-flex justify-content-center produkt">
                    <div class="card" style="width:400px;">
                        <img class="card-img-top produkt'.$row['id_produktu'].'" src="'.$row['obraz'].'" alt="Card image">
                        <div class="card-body">
                            <h3 class="card-title produkt'.$row['id_produktu'].'">'.$row['pname'].'</h3>
                            <p class="card-text produkt'.$row['id_produktu'].'" style="font-size:22px;">'.$row['cena'].' zł</p>
                            <input type="hidden" class="produkt'.$row['id_produktu'].'" value="'.$row['opis'].'">
                            <input type="hidden" class="produkt'.$row['id_produktu'].'" value="'.$row['typ'].'">
                            <input type="hidden" class="produkt'.$row['id_produktu'].'" value="'.$row['pid'].'">
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
                    <form method="post">
                    <input type="hidden" value="" id="prodid" name="prodid">
                        <input type="hidden" value="" id="prodtype" name="prodtype">
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
                    <?php
                    if(isset($_SESSION['user'])){
                        echo '<button type="submit" name="add" class="btn btn-primary">Dodaj do koszyka</button>';
                    } else {
                        echo '<a href="./konto" class="btn btn-primary">Zaloguj się</a>';
                    }
                    ?>
                    </form>
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
    var prodtyp = document.getElementById("prodtype");
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
        prodtyp.value = document.getElementsByClassName("produkt"+id)[4].value;
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
<?php
session_start();
ob_start();

if(!isset($_SESSION['user'])){
    header('location:index.php');
}

if(isset($_POST['logout'])){
    session_unset();
    session_destroy();
    header('location:./index.php');
}

require("../backrooms/bd-authorize.php");

if (isset($_POST['usun'])) {
    unset($_SESSION['produkty']);
    unset($_SESSION['ilosci']);
    unset($_SESSION['ceny']);
}
if (isset($_POST['usunindex'])) {
    unset($_SESSION['produkty'][$_POST['index']]);
    unset($_SESSION['ilosci'][$_POST['index']]);
    unset($_SESSION['ceny'][$_POST['index']]);
}
if (isset($_POST['zakup'])){
    $goforit = false;
    if(isset($_SESSION['user']) && !empty($_SESSION['produkty']) && !empty($_SESSION['ilosci']) && !empty($_SESSION['ceny']) && isset($_POST['nick']) && isset($_POST['email']) && isset($_POST['karta']) && isset($_POST['ccv']) && isset($_POST['wygasniecie2']) && isset($_POST['wygasniecie'])){ //czy dane zostały przesłane
        if(!empty($_POST['nick']) && !empty($_POST['email']) && !empty($_POST['karta']) && !empty($_POST['ccv']) && !empty($_POST['wygasniecie2']) && !empty($_POST['wygasniecie'])){ //czy wszystkie dane nie są puste
            if(ctype_digit($_POST['karta']) && ctype_digit($_POST['ccv']) && ctype_digit($_POST['wygasniecie2']) && ctype_digit($_POST['wygasniecie'])){ //czy dane karty, ccv i dat są numerami
                if(strlen($_POST['karta']) == 16 && strlen($_POST['ccv']) == 3 && strlen($_POST['wygasniecie']) == 2 && strlen($_POST['wygasniecie2']) == 4){ //czy zgadzają się długości danych
                    if($_POST['wygasniecie'] >= 1 && $_POST['wygasniecie'] <= 12){ //Czy poprawny miesiąc
                        if($_POST['wygasniecie2'] > intval(date("Y")) || $_POST['wygasniecie2'] == date("Y") && $_POST['wygasniecie'] > intval(date("m"))){ //Albo podany rok jeszcze nie nadszedł albo aktualny miesiąc jest przed wygaśnięciem
                            $goforit = true;
                        }
                    }
                }
            }
        }
    }
    try {
        $promocode = 1;
        $x = 2;
        $data = date("Y-m-d");
        $pdo = new PDO('mysql:host=' . $mysql_host . ';dbname=' . $database . ';port=' . $port, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $klient = $_SESSION['user'];
        if ($goforit == true) {
            if(isset($_POST['kodpromo'])){
                $stmt = $pdo->query('SELECT * FROM promocje WHERE kod LIKE "'.$_POST['kodpromo'].'";');
                foreach($stmt as $row){
                    if($row['czy_limitowany'] == 1){
                        if($row['ilosc'] > 0 && strtotime($row['od_kiedy']) <= strtotime($data) && strtotime($row['do_kiedy']) >= strtotime($data)){
                            if($row['znizka'] != 100){
                                $promocode = 1 - ($row['znizka'] / 100);
                            } else {
                                $promocode = 0;
                            }
                            $newamount = $row['ilosc'] - 1;
                            $stmt = $pdo->exec('UPDATE promocje SET ilosc = '. $newamount .' WHERE kod LIKE "'.$_POST['kodpromo'].'";');
                        } else {
                            $promocode = 1;
                        }
                    } else {
                        if(strtotime($row['od_kiedy']) <= strtotime($data) && strtotime($row['do_kiedy']) >= strtotime($data)){
                            if($row['znizka'] != 100){
                                $promocode = 1 - ($row['znizka'] / 100);
                            } else {
                                $promocode = 0;
                            }
                        } else {
                            $promocode = 1;
                        }
                    }
                }
            }

            $stmt = $pdo->exec('INSERT INTO transakcja (`id_klienta`, `data`, `realizacja`) VALUES ( ' . $klient . ',"' . $data . '",1)');
            $last_id = $pdo->lastInsertId();
            foreach($_SESSION['produkty'] as $key => $val){
                $foo = ($_SESSION['ilosci'][$key]*$_SESSION['ceny'][$key]) * $promocode;
                $stmt = $pdo->exec('INSERT INTO szczegoly_transakcji (`id_transakcji`, `id_produktu`, `ilosc`, `cena`) VALUES ( ' . $last_id . ',' . $val . ',' . $_SESSION['ilosci'][$key] . ',' . number_format((float)$foo, 2, '.', '') . ')');
            }
            unset($_SESSION['produkty']);
            unset($_SESSION['ilosci']);
            unset($_SESSION['ceny']);
            $x = 1;
        }
        header('location:index.php?x='.$x);
    } catch(PDOException $e) {
    echo '😵';
    $x = 2;
    header('location:index.php?x='.$x);
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
        h1, h2{
            font-family: 'Work Sans', sans-serif;
        }
        h2{
            height: 40px;
            text-align: center;
            margin-top: 50px;
        }
        .separator{
            margin: 25px 0;
            background-color: white;
            border: 0;
            height: 2px;
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
        .navbar-dark .navbar-nav .nav-link{
            font-family: 'Nunito', sans-serif;
            font-size: 22px;
            color: white;
        }
        .navbar-dark{
            background: repeat url("../resources/dirt.jpg");
        }
        .nav-item{
            margin-right:50px;
        }
        .scrolled-down{
            transform:translateY(-100%); transition: all 0.3s ease-in-out;
        }
        .scrolled-up{
            transform:translateY(0); transition: all 0.3s ease-in-out;
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
            width: 12%;
            font-size: 18px;
            min-width: fit-content;
        }
        .btn-primary:hover{
            background-color:#00b359;
            color:black;
            border: none;
        }
        .btn-primary:focus{
            background-color:#00b359;
        }
        .btn-secondary{
            background-color:#444;
            color:white;
            border: none;
        }
        .invis{
            background-color: rgba(0, 0, 0, 0);
            border: none;
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
        .big-btn{
            width: 200px;
            height: 200px;
            background-color: #42445A;
            border-radius: 4px;
            justify-content: center;
            display: grid;
            place-items: center;
            margin: auto;
        }
        .big-btn svg{
            color: #00FF7F;
        }
        .big-btn:hover svg{
            color:#00b359;
            width: 105px;
            height: 105px;
            transition: 0.3s;
        }
        .big-btn:active svg{
            color:#00b359;
            width: 95px;
            height: 95px;
            transition: 0.2s;
        }
        .box-shadow{
            -webkit-box-shadow: 5px 5px 0px 0px rgba(39, 39, 42, 1);
            -moz-box-shadow: 5px 5px 0px 0px rgba(39, 39, 42, 1);
            box-shadow: 5px 5px 0px 0px rgba(39, 39, 42, 1);
        }
        .panel-grid{
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            grid-gap: 20px;
            width: 45%;
            min-width: 420px;
            margin-top: 50px;
            margin-bottom: 50px;
            margin-left: auto;
            margin-right: auto;
        }
        .welcomediv{
            max-width: 50%;
            margin: auto;
        }
        .welcome{
            margin: 20px auto 20px auto;
            text-align: center;
            display: block;
        }
        table{
            text-align: center;
            width: 100%;
            margin-top: 10px;
        }
        td{
            min-width: fit-content;
            width: 20%;
        }
        td img{
            max-width: 100px;
        }
        tr:hover{
            background-color: #42445A;
            color: #00FF7F;
            transition: 0.3s;
        }
        .btn-close{
            background-color: rgba(0, 255, 127, 0.75);
        }
    </style>
    </style>

</head>
<body data-bs-spy="scroll" data-bs-target="#navigacja">
<div class="container-fluid">
    <nav class="navbar autohide fixed-top navbar-dark navbar-expand-md justify-content-center">
        <div class="container">
            <a href=".." class="navbar-brand d-flex w-50 me-auto"><img src="../resources/logo.png" style="height:50px;" /></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsingNavbar3">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse collapse w-100" id="collapsingNavbar3">
                <ul class="navbar-nav w-100 justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link" href="../sklep">Powrót</a>
                    </li>
                    <li class="nav-item">
                        <form method="post">
                            <button type="submit" name="logout" class="invis">
                                <a class="nav-link" >Wyloguj się</a>
                            </button>
                        </form>
                    </li>
                </ul>
                <div class="nav navbar-nav ms-auto w-100"></div>
            </div>
        </div>
    </nav>
    <div class="welcomediv">
        <?php
        include('../backrooms/welcome.php');
        ?>
    </div>
    <div class="separator"></div>
    <div class="container-fluid">
        <h1> Koszyk </h1>
        <?php
        try{
            $pdo = new PDO('mysql:host=' . $mysql_host . ';dbname=' . $database . ';port=' . $port, $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if (empty($_SESSION['produkty'])){
                echo '<h2>Koszyk jest pusty</h2>';
            }
            else {
                $lacznie = 0;
                echo'<table>
                <th class="d-none d-md-table-cell">
                    Obraz
                </th>
        <th> Nazwa produktu </th>
        <th> Cena (łącznie)</th>
        <th> Ilość </th>
        <th></th>';

                foreach ($_SESSION['produkty'] as $key => $val) {
                    $stmt = $pdo->query('SELECT nazwa, obraz FROM produkty WHERE id_produktu LIKE "'.$val.'"');
                    echo "<tr>";
                    foreach ($stmt as $row) {
                        echo "<td class='d-none d-md-table-cell'>";
                        if(!empty($row['obraz'])){
                            echo "<img src='".$row['obraz']."'>";
                        }
                        echo "</td>";
                        echo "<td>".$row['nazwa']."</td>";
                        echo "<td>".$_SESSION['ilosci'][$key] * $_SESSION['ceny'][$key]." zł</td>";
                        echo "<td>".$_SESSION['ilosci'][$key]."</td>";
                        $lacznie += $_SESSION['ilosci'][$key] * $_SESSION['ceny'][$key];
                    }
                    echo '<td><form method="post"><input type="hidden" value="'.$key.'" name="index"><button type="submit" name="usunindex" class="btn btn-primary text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-cart-dash" viewBox="0 0 16 16">
                              <path d="M6.5 7a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4z"/>
                              <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                            </svg>
                            Usuń
                            </button></td></form></tr>';
                }
                echo '</table><h2>Łącznie '.$lacznie.' zł</h2>';
            }
            echo'<form method="post">
                        <button type="submit" name="usun" value="usun" class="btn btn-primary text-center mt-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-cart-x" viewBox="0 0 16 16">
                          <path d="M7.354 5.646a.5.5 0 1 0-.708.708L7.793 7.5 6.646 8.646a.5.5 0 1 0 .708.708L8.5 8.207l1.146 1.147a.5.5 0 0 0 .708-.708L9.207 7.5l1.147-1.146a.5.5 0 0 0-.708-.708L8.5 6.793 7.354 5.646z"/>
                          <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                        </svg>
                            Wyczyść koszyk
                        </button>
                        <a class="btn btn-primary text-center mt-3" data-bs-toggle="modal" data-bs-target="#staticBackdrop3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-cash-coin" viewBox="0 0 16 16">
                          <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0z"/>
                          <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1h-.003zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195l.054.012z"/>
                          <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083c.058-.344.145-.678.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1H1z"/>
                          <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 5.982 5.982 0 0 1 3.13-1.567z"/>
                        </svg>
                            Przejdź do zapłaty
                        </a>
                </form>';
        } catch(PDOException $e) {
            echo '😵';
        }
        ?>

    </div>
</div>
<div class="modal fade" id="staticBackdrop3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle2">Dane do zapłaty</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <h3>Dane</h3>
                    <input class="form-control" type="text" maxlength="48" name="nick" id="userFormNick" placeholder="Nick" required>
                    <input class="form-control mt-3" type="email" maxlength="75" name="email" id="userFormEmail" placeholder="E-mail" required>
                    <input class="form-control mt-3" type="text" maxlength="16" name="kodpromo" id="promocode" placeholder="Kod promocyjny (jeśli jest)">
                    <h3 class="mt-3">Płatność</h3>
                    <input class="form-control" type="text" maxlength="16" name="karta" id="pay1" placeholder="Nr karty" required>
                    <div style="display: inline-flex " >
                        <input class="form-control m-3" type="text" maxlength="2" minlength="2" name="wygasniecie" id="pay2" placeholder="Miesiąc wygaśnięcia" required>
                        <input class="form-control m-3" type="text" maxlength="4" minlength="4" name="wygasniecie2" id="pay2" placeholder="Rok wygaśnięcia" required>
                    </div>
                    <input class="form-control" type="text" minlength="3" maxlength="3" name="ccv" id="pay3" placeholder="Numer CCV" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary text-center" name="zakup">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                            <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                        </svg>
                        Zatwierdź
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<div style="text-align:center;color:white;">Wdrożenie - AM 2022</div>
<script src="../resources/scroll.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>

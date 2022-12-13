<?php
session_start();
if(isset($_POST['logout'])){
    session_unset();
    session_destroy();
}
if(!isset($_SESSION['user'])){
    header('location:index.php');
}

require("bd-authorize.php"); //Autoryzacja dostępu do bazy danych

try{
    $pdo = new PDO('mysql:host=' . $mysql_host . ';dbname=' . $database . ';port=' . $port, $username, $password);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->query('SELECT id_klienta, admin FROM klienci');
    foreach ($stmt as $row) {
        if($row['id_klienta'] == $_SESSION['user']){
            if($row['admin'] != 1){
                session_unset();
                session_destroy();
                header('location:index.php');
            }
        }
    }
    $stmt->closeCursor();

    if(isset($_POST['add'])){
        $nick = $_POST['nick'];
        $email = $_POST['email'];
        $pwd = $_POST['pwd'];
        if(isset($_POST['status'])){
            $admin = 1;
        } else {
            $admin = 0;
        }
        if(!empty($nick) && !empty($email) && !empty($pwd)){
            $stmt = $pdo->exec('INSERT INTO klienci (`nick`, `email`, `haslo`, `admin`) VALUES ( "'.$nick.'","'.$email.'","'.hash('whirlpool',$pwd).'",'.$admin.')');
        }
        header('location:panel-users.php');
    } elseif(isset($_POST['edit'])){
        $userid = $_POST['ID'];
        $nick = $_POST['nick'];
        $email = $_POST['email'];
        if(isset($_POST['status'])){
            $admin = 1;
        } else {
            $admin = 0;
        }
        if(!empty($nick) && !empty($email) && !empty($userid)){
            $stmt = $pdo->exec('UPDATE klienci SET `nick` = "'.$nick.'", `email` = "'.$email.'", `admin` = "'.$admin.'" WHERE `id_klienta` LIKE '.$userid);
        }
        header('location:panel-users.php');
    } elseif(isset($_POST['remove'])){
        $userid = $_POST['ID'];
        if(!empty($userid)){
            $stmt = $pdo->query('SELECT id_klienta FROM transakcja WHERE id_klienta = '.$userid);
            if($stmt->rowCount() == 0){
                $stmt->closeCursor();
                $stmt = $pdo -> exec('DELETE FROM klienci WHERE `id_klienta` = '.$userid); // Jeśli klient nigdy niczego nie kupował to usuń go z bazy
            } else {
                $stmt->closeCursor();
                $stmt = $pdo->exec('UPDATE klienci SET `email` = "NULL", `haslo` = "NULL" WHERE `id_klienta` = '.$userid); // Usuwanie nie powinno całkowicie wymazywać użytkownika z bazy danych bo musi zostać w historii tranzakcji
            }
        }
        header('location:panel-users.php');
    }

} catch(PDOException $e) {
    echo '😵';
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <script>

        $(document).ready(function(){

            $(".rozwijane_kolumny").hide();

            $(".wyswietlane_kolumny").click(function(){
                var index = $(".wyswietlane_kolumny").index(this);
                $(".rozwijane_kolumny").eq(index).show("slow");
            });

            $(".wyswietlane_kolumny").dblclick(function(){
                var index = $(".wyswietlane_kolumny").index(this);
                $(".rozwijane_kolumny").eq(index).hide("slow");
            });
        });
    </script>

    <style>
        body{
            background: repeat url("../resources/bg2.png");
            color: white;
            position: relative;
        }
        h1, h5{
            font-family: 'Work Sans', sans-serif;
        }
        .separator{
            margin: 25px 0;
            background-color: white;
            border: 0;
            height: 2px;
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
        table{
            text-align: center;
            width: 100%;
            margin-top: 10px;
        }
        td{
            min-width: fit-content;
            width: 20%;
        }
        tr:hover{
            background-color: #42445A;
            color: #00FF7F;
            transition: 0.3s;
        }
        .searchpanel{
            margin: auto;
            display: block;
            width: 90%;
            text-align: center;
        }
        .searchpanel input{
            min-width: 150px;
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
                        <a class="nav-link" href="panel.php">Powrót</a>
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
        $time = date('H', time());
        try{
            $pdo = new PDO('mysql:host=' . $mysql_host . ';dbname=' . $database . ';port=' . $port, $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->query('SELECT nick FROM klienci WHERE id_klienta LIKE "'.$_SESSION['user'].'"');
            foreach ($stmt as $row) {
                if($time > 17 || $time < 5) {
                    echo "<h1 class='welcome'>Dobry wieczór, " . $row['nick'] . "</h1>";
                } else {
                    echo "<h1 class='welcome'>Dzień dobry, " . $row['nick'] . "</h1>";
                }
                echo "<img src='https://minotar.net/helm/".$row['nick']."/100.png' class='welcome box-shadow' />";
            }
            $stmt->closeCursor();
        } catch(PDOException $e) {
            echo '😵';
        }
        ?>
    </div>
    <div class="separator"></div>

    <div class="searchpanel">
        <form method="post">
            <input type="number" min="1" step="1" placeholder="Numer zamówienia" name="which-order">
            <button class="btn btn-outline-primary" type="submit" name="search">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                </svg>
                Szukaj
            </button>
        </form>
    </div>

    <div class="row">
        <div class="d-none d-lg-block col-lg-2"></div>
        <div class="col-12 col-lg-8">
            <?php
            try{

                $pdo = new PDO('mysql:host=' . $mysql_host . ';dbname=' . $database . ';port=' . $port, $username, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                if (isset($_POST['search'])) {
                    $whichorder = $_POST['which-order'];
                }

                if(!empty($whichorder)){
                    $stmt = $pdo->query('SELECT * FROM transakcja WHERE id_transakcji LIKE "'.$whichorder.'%";');
                    $stmt2 = $pdo->query('SELECT * FROM szczegoly_transakcji inner join transakcja on szczegoly_transakcji.id_transakcji=transakcja.id_transakcji inner join produkty on szczegoly_transakcji.id_produktu = produkty.id_produktu WHERE szczegoly_transakcji.id_transakcji LIKE "'.$whichorder.'%";');
                } else {
                    $stmt = $pdo->query('SELECT * FROM transakcja;');
                    $stmt2 = $pdo->query('SELECT * FROM szczegoly_transakcji inner join transakcja on szczegoly_transakcji.id_transakcji=transakcja.id_transakcji inner join produkty on szczegoly_transakcji.id_produktu = produkty.id_produktu ');
                }
                echo "<table><tr style='font-size: 120%'><th style=' width: 33%;'> Numer zamówienia </th>";
                echo "<th style=' width: 33%;'> Data </th>";
                echo "<th style=' width: 33%;'> Status</th>";
                echo "</tr>";
                echo "</table>";
                foreach ($stmt as $row) {
                    echo "<table><tr class='wyswietlane_kolumny' style='border: 3px solid;  font-size: 120%'><td >".$row['id_transakcji']."</td>";
                    echo "<td>".$row['data']."</td>";
                    echo "<td>";
                    if($row['realizacja']==1){
                        echo "Zrealizowano";
                    } else {
                        echo "Nie zrealizowano";
                    }
                    $stmt3 = $pdo->query('select produkty.nazwa, produkty.cena, szczegoly_transakcji.ilosc from produkty inner join szczegoly_transakcji on produkty.id_produktu=szczegoly_transakcji.id_produktu inner join transakcja on szczegoly_transakcji.id_transakcji = transakcja.id_transakcji where szczegoly_transakcji.id_transakcji LIKE "'.$row['id_transakcji'].'"');
                    echo "</td></tr></table>";
                    echo "<table class='rozwijane_kolumny' style=' border: 1px solid; border-color: gray;><tr style=' width: 100%;'><th>Produkt</th>";
                    echo "<th>Cena</th>";
                    echo "<th>Ilość</th></tr>";
                    $razem = 0.0;
                    foreach ($stmt3 as $row) {
                        echo "<tr style=' width: 100%;'><td>".$row['nazwa']."</td>";
                        echo "<td>".$row['cena']." zł</td>";
                        echo "<td>".$row['ilosc']."</td>";
                        $razem += $row['cena'] * $row['ilosc'];
                        echo "</tr>";
                    }

                    echo "<tr style='border: 1px solid; border-color: green; border-radius: 25px;'>";
                    echo "<td></td>";
                    echo" <td style='text-align: right'>Wartość zamówienia: ";
                    echo "<td>" .$razem." zł</td>";
                    echo "</tr>";
                    echo "</table>";
                }

                $stmt->closeCursor();
            } catch(PDOException $e) {
                echo '😵';
            }

            ?>


        </div>
        <div class="col-md-none col-lg-2"></div>
    </div>

</div>

<div style="text-align:center;color:white;">Wdrożenie - AM 2022</div>
</div>

<script src="../resources/scroll.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>

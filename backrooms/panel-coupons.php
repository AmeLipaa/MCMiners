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
        $nazwa = $_POST['name'];
        $kod = $_POST['code'];
        $znizka = $_POST['lower'];
        $odkiedy = $_POST['from'];
        $dokiedy = $_POST['to'];
        $limit = 0;
        $ilosc = 1;
        if(isset($_POST['limit'])){
            $limit = 1;
            $ilosc = $_POST['uses'];
        }
        if(!empty($nazwa) && !empty($kod) && !empty($odkiedy) && !empty($dokiedy) && !empty($znizka) &&  $znizka >= 1 && $znizka <= 100 && !empty($ilosc)){
            $stmt = $pdo->exec('INSERT INTO promocje (`kod`, `nazwa`, `znizka`, `od_kiedy`, `do_kiedy`, `czy_limitowany`, `ilosc`) VALUES ( "'.$kod.'","'.$nazwa.'",'.$znizka.',"'.$odkiedy.'","'.$dokiedy.'",'.$limit.','.$ilosc.');');
        }
        header('location:panel-coupons.php');
    } elseif(isset($_POST['edit'])){
        $saleid = $_POST['ID'];
        $nazwa = $_POST['name'];
        $kod = $_POST['code'];
        $znizka = $_POST['lower'];
        $odkiedy = $_POST['from'];
        $dokiedy = $_POST['to'];
        $limit = 0;
        $ilosc = 1;
        if(isset($_POST['limit'])){
            $limit = 1;
            $ilosc = $_POST['uses'];
        }
        if(!empty($nazwa) && !empty($kod) && !empty($odkiedy) && !empty($dokiedy) && !empty($znizka) &&  $znizka >= 1 && $znizka <= 100 && !empty($ilosc)){
            $stmt = $pdo->exec('UPDATE promocje SET `kod` = "'.$kod.'", `nazwa` = "'.$nazwa.'", `znizka` = '.$znizka.' , `od_kiedy` = "'.$odkiedy.'" , `do_kiedy` = "'.$dokiedy.'" , `czy_limitowany` = '.$limit.' , `ilosc` = '.$ilosc.' WHERE `id_promocji` = '.$saleid);
        }
        header('location:panel-coupons.php');
    } elseif(isset($_POST['remove'])){
        $saleid = $_POST['ID'];
        if(!empty($saleid)){
            $stmt = $pdo->exec('DELETE FROM promocje WHERE `id_promocji` LIKE '.$saleid);
        }
        header('location:panel-coupons.php');
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
            margin-top: 30px;
        }
        td{
            min-width: fit-content;
            width: 20%;
        }
        tr{
            height: 40px;
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
        .welcomediv{
            max-width: 50%;
            margin: auto;
        }
        .welcome{
            margin: 20px auto 20px auto;
            text-align: center;
            display: block;
        }
        .form-floating label{
            color: #42445A;
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
        include('welcome.php');
        ?>
    </div>
    <div class="separator"></div>

    <div class="searchpanel">
        <form method="post">
            <input class="forminput" maxlength="64" placeholder="Nazwa" name="whatname">
            <button class="btn btn-outline-primary" type="submit" name="search">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                </svg>
                Szukaj
            </button>
        </form>
        <button class="btn btn-outline-primary" onclick="addingMode()" data-bs-toggle="modal" data-bs-target="#couponForm">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus-circle-dotted" viewBox="0 0 16 16">
                <path d="M8 0c-.176 0-.35.006-.523.017l.064.998a7.117 7.117 0 0 1 .918 0l.064-.998A8.113 8.113 0 0 0 8 0zM6.44.152c-.346.069-.684.16-1.012.27l.321.948c.287-.098.582-.177.884-.237L6.44.153zm4.132.271a7.946 7.946 0 0 0-1.011-.27l-.194.98c.302.06.597.14.884.237l.321-.947zm1.873.925a8 8 0 0 0-.906-.524l-.443.896c.275.136.54.29.793.459l.556-.831zM4.46.824c-.314.155-.616.33-.905.524l.556.83a7.07 7.07 0 0 1 .793-.458L4.46.824zM2.725 1.985c-.262.23-.51.478-.74.74l.752.66c.202-.23.418-.446.648-.648l-.66-.752zm11.29.74a8.058 8.058 0 0 0-.74-.74l-.66.752c.23.202.447.418.648.648l.752-.66zm1.161 1.735a7.98 7.98 0 0 0-.524-.905l-.83.556c.169.253.322.518.458.793l.896-.443zM1.348 3.555c-.194.289-.37.591-.524.906l.896.443c.136-.275.29-.54.459-.793l-.831-.556zM.423 5.428a7.945 7.945 0 0 0-.27 1.011l.98.194c.06-.302.14-.597.237-.884l-.947-.321zM15.848 6.44a7.943 7.943 0 0 0-.27-1.012l-.948.321c.098.287.177.582.237.884l.98-.194zM.017 7.477a8.113 8.113 0 0 0 0 1.046l.998-.064a7.117 7.117 0 0 1 0-.918l-.998-.064zM16 8a8.1 8.1 0 0 0-.017-.523l-.998.064a7.11 7.11 0 0 1 0 .918l.998.064A8.1 8.1 0 0 0 16 8zM.152 9.56c.069.346.16.684.27 1.012l.948-.321a6.944 6.944 0 0 1-.237-.884l-.98.194zm15.425 1.012c.112-.328.202-.666.27-1.011l-.98-.194c-.06.302-.14.597-.237.884l.947.321zM.824 11.54a8 8 0 0 0 .524.905l.83-.556a6.999 6.999 0 0 1-.458-.793l-.896.443zm13.828.905c.194-.289.37-.591.524-.906l-.896-.443c-.136.275-.29.54-.459.793l.831.556zm-12.667.83c.23.262.478.51.74.74l.66-.752a7.047 7.047 0 0 1-.648-.648l-.752.66zm11.29.74c.262-.23.51-.478.74-.74l-.752-.66c-.201.23-.418.447-.648.648l.66.752zm-1.735 1.161c.314-.155.616-.33.905-.524l-.556-.83a7.07 7.07 0 0 1-.793.458l.443.896zm-7.985-.524c.289.194.591.37.906.524l.443-.896a6.998 6.998 0 0 1-.793-.459l-.556.831zm1.873.925c.328.112.666.202 1.011.27l.194-.98a6.953 6.953 0 0 1-.884-.237l-.321.947zm4.132.271a7.944 7.944 0 0 0 1.012-.27l-.321-.948a6.954 6.954 0 0 1-.884.237l.194.98zm-2.083.135a8.1 8.1 0 0 0 1.046 0l-.064-.998a7.11 7.11 0 0 1-.918 0l-.064.998zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
            </svg>
            Dodaj
        </button>
    </div>

    <div class="row">
        <div class="d-none d-lg-block col-lg-2"></div>
        <div class="col-12 col-lg-8">
            <table>
                <tr>
                    <th>
                        Nazwa
                    </th>
                    <th>
                        Kod
                    </th>
                    <th>
                        Zniżka (%)
                    </th>
                    <th>
                        Od
                    </th>
                    <th>
                        Do
                    </th>
                    <th>
                        Limitowany?
                    </th>
                    <th>
                        Użyć
                    </th>
                </tr>
                <?php
                try{
                    $pdo = new PDO('mysql:host=' . $mysql_host . ';dbname=' . $database . ';port=' . $port, $username, $password);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    if (isset($_POST['search'])) {
                        $whichname = $_POST['whatname'];
                    }

                    if(!empty($whichname)){
                        $stmt = $pdo->query('SELECT * FROM promocje WHERE nazwa LIKE "'.$whichname.'%";');
                    } else {
                        $stmt = $pdo->query('SELECT * FROM promocje;');
                    }
                    foreach ($stmt as $row) {
                        echo "<tr id='promo".$row['id_promocji']."' onclick='edit(".$row['id_promocji'].")' data-bs-toggle='modal' data-bs-target='#couponForm'>";
                        echo "<td>".$row['nazwa']."</td>";
                        echo "<td>".$row['kod']."</td>";
                        echo "<td>".$row['znizka']."</td>";
                        echo "<td>".$row['od_kiedy']."</td>";
                        echo "<td>".$row['do_kiedy']."</td>";
                        if($row['czy_limitowany'] == 1){
                            echo "<td>Tak</td>";
                            echo "<td>".$row['ilosc']."</td></tr>";
                        } else {
                            echo "<td>Nie</td>";
                            echo "<td>∞</td></tr>";
                        }
                    }
                    $stmt->closeCursor();
                } catch(PDOException $e) {
                    echo '😵';
                }
                ?>
            </table>
        </div>
        <div class="col-md-none col-lg-2"></div>
    </div>

    <!-- MODAL -->
    <div class="modal fade" id="couponForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Dodawanie kuponu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <input value="" type="hidden" name="ID" id="saleid">
                        <div class="form-floating mb-3">
                            <input class="form-control mt-3" type="text" maxlength="64" name="name" id="salename" required>
                            <label for="salename">Nazwa</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control mt-3" type="text" maxlength="16" name="code" id="salecode" required>
                            <label for="salecode">Kod</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control mt-3" type="number" maxlength="3" min="1" max="100" step="1" name="lower" id="salelower" required>
                            <label for="salelower">Zniżka (%)</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control mt-3" type="date" name="from" id="salefrom" required>
                            <label for="salefrom">Od kiedy</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control mt-3" type="date" name="to" id="saleto" required>
                            <label for="saleto">Do kiedy</label>
                        </div>
                        <input class="mt-3" type="checkbox" name="limit" id="salelimit" onchange="checkTheBox()" checked="false">
                        Limitowane użycia<br>
                        <div class="form-floating mb-3" style="display:none;">
                            <input class="form-control mt-3" type="number" min="1" name="uses" value="1" id="saleuses" required>
                            <label for="saleuses">Ilość użyć</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                        <button id="confirmAddNew" name="add" type="submit" class="btn btn-primary" style="display:block">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus-circle-dotted" viewBox="0 0 16 16">
                                <path d="M8 0c-.176 0-.35.006-.523.017l.064.998a7.117 7.117 0 0 1 .918 0l.064-.998A8.113 8.113 0 0 0 8 0zM6.44.152c-.346.069-.684.16-1.012.27l.321.948c.287-.098.582-.177.884-.237L6.44.153zm4.132.271a7.946 7.946 0 0 0-1.011-.27l-.194.98c.302.06.597.14.884.237l.321-.947zm1.873.925a8 8 0 0 0-.906-.524l-.443.896c.275.136.54.29.793.459l.556-.831zM4.46.824c-.314.155-.616.33-.905.524l.556.83a7.07 7.07 0 0 1 .793-.458L4.46.824zM2.725 1.985c-.262.23-.51.478-.74.74l.752.66c.202-.23.418-.446.648-.648l-.66-.752zm11.29.74a8.058 8.058 0 0 0-.74-.74l-.66.752c.23.202.447.418.648.648l.752-.66zm1.161 1.735a7.98 7.98 0 0 0-.524-.905l-.83.556c.169.253.322.518.458.793l.896-.443zM1.348 3.555c-.194.289-.37.591-.524.906l.896.443c.136-.275.29-.54.459-.793l-.831-.556zM.423 5.428a7.945 7.945 0 0 0-.27 1.011l.98.194c.06-.302.14-.597.237-.884l-.947-.321zM15.848 6.44a7.943 7.943 0 0 0-.27-1.012l-.948.321c.098.287.177.582.237.884l.98-.194zM.017 7.477a8.113 8.113 0 0 0 0 1.046l.998-.064a7.117 7.117 0 0 1 0-.918l-.998-.064zM16 8a8.1 8.1 0 0 0-.017-.523l-.998.064a7.11 7.11 0 0 1 0 .918l.998.064A8.1 8.1 0 0 0 16 8zM.152 9.56c.069.346.16.684.27 1.012l.948-.321a6.944 6.944 0 0 1-.237-.884l-.98.194zm15.425 1.012c.112-.328.202-.666.27-1.011l-.98-.194c-.06.302-.14.597-.237.884l.947.321zM.824 11.54a8 8 0 0 0 .524.905l.83-.556a6.999 6.999 0 0 1-.458-.793l-.896.443zm13.828.905c.194-.289.37-.591.524-.906l-.896-.443c-.136.275-.29.54-.459.793l.831.556zm-12.667.83c.23.262.478.51.74.74l.66-.752a7.047 7.047 0 0 1-.648-.648l-.752.66zm11.29.74c.262-.23.51-.478.74-.74l-.752-.66c-.201.23-.418.447-.648.648l.66.752zm-1.735 1.161c.314-.155.616-.33.905-.524l-.556-.83a7.07 7.07 0 0 1-.793.458l.443.896zm-7.985-.524c.289.194.591.37.906.524l.443-.896a6.998 6.998 0 0 1-.793-.459l-.556.831zm1.873.925c.328.112.666.202 1.011.27l.194-.98a6.953 6.953 0 0 1-.884-.237l-.321.947zm4.132.271a7.944 7.944 0 0 0 1.012-.27l-.321-.948a6.954 6.954 0 0 1-.884.237l.194.98zm-2.083.135a8.1 8.1 0 0 0 1.046 0l-.064-.998a7.11 7.11 0 0 1-.918 0l-.064.998zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                            </svg>
                            Dodaj
                        </button>
                        <button id="confirmRemove" name="remove" type="submit" class="btn btn-primary" style="display:none">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                <path d="M8.086 2.207a2 2 0 0 1 2.828 0l3.879 3.879a2 2 0 0 1 0 2.828l-5.5 5.5A2 2 0 0 1 7.879 15H5.12a2 2 0 0 1-1.414-.586l-2.5-2.5a2 2 0 0 1 0-2.828l6.879-6.879zm2.121.707a1 1 0 0 0-1.414 0L4.16 7.547l5.293 5.293 4.633-4.633a1 1 0 0 0 0-1.414l-3.879-3.879zM8.746 13.547 3.453 8.254 1.914 9.793a1 1 0 0 0 0 1.414l2.5 2.5a1 1 0 0 0 .707.293H7.88a1 1 0 0 0 .707-.293l.16-.16z"/>
                            </svg>
                            Usuń
                        </button>
                        <button id="confirmEdit" name="edit" type="submit" class="btn btn-primary" style="display:none">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                            </svg>
                            Zapisz
                        </button>
                </form>
            </div>
        </div>
    </div>
    </div>

    <div style="text-align:center;color:white;">Wdrożenie - AM 2022</div>
</div>
<script>
    var title = document.getElementById("modalTitle");
    var ID = document.getElementById("saleid");
    var nazwa = document.getElementById("salename");
    var kod = document.getElementById("salecode");
    var znizka = document.getElementById("salelower");
    var odkiedy = document.getElementById("salefrom");
    var dokiedy = document.getElementById("saleto");
    var limit = document.getElementById("salelimit");
    var ilosc = document.getElementById("saleuses");
    var addbutton = document.getElementById("confirmAddNew");
    var editbutton = document.getElementById("confirmEdit");
    var deletebutton = document.getElementById("confirmRemove");
    function checkTheBox(){
        if(limit.checked == false){
            ilosc.parentElement.style.display = "none";
        } else {
            ilosc.parentElement.style.display = "block";
        }
    }
    function addingMode(){
        title.innerText = "Dodawanie kuponu";
        ID.value = "";
        nazwa.value = "";
        kod.value = "";
        znizka.value = 1;
        odkiedy.value = "";
        dokiedy.value = "";
        limit.checked = false;
        ilosc.value = 1;
        checkTheBox();
        addbutton.style.display = "block";
        editbutton.style.display = "none";
        deletebutton.style.display = "none";
    }
    function edit(id){
        title.innerText = "Edycja kuponu";
        ID.value = id;
        nazwa.value = document.getElementById("promo"+id).children[0].innerText;
        kod.value = document.getElementById("promo"+id).children[1].innerText;
        znizka.value = document.getElementById("promo"+id).children[2].innerText;
        odkiedy.value = document.getElementById("promo"+id).children[3].innerText;
        dokiedy.value = document.getElementById("promo"+id).children[4].innerText;
        if(document.getElementById("promo"+id).children[5].innerText == "Tak"){
            limit.checked = true;
            ilosc.value = document.getElementById("promo"+id).children[6].innerText;
        } else {
            limit.checked = false;
            ilosc.value = 1;
        }
        addbutton.style.display = "none";
        editbutton.style.display = "block";
        deletebutton.style.display = "block";
        checkTheBox();
    }
</script>
<script src="../resources/scroll.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
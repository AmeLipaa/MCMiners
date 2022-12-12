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
    $stmt = $pdo->query('SELECT id_klienta, admin FROM klienci WHERE id_klienta = '.$_SESSION['user']);
    foreach ($stmt as $row) {
        if($row['admin'] != 1){
            session_unset();
            session_destroy();
            header('location:index.php');
        }
    }
    $stmt->closeCursor();

    if(isset($_POST['add'])){
        require("bd-authorize.php");
        if(isset($_POST['czypromo'])){
            $czydostepny = 1;
        } else {
            $czydostepny = 0;
        }
        $nazwa = $_POST['nazwa'];
        $cena = $_POST['cena'];
        $opis = $_POST['opis'];
        $kategoria = $_POST['katid'];
        $obraz = $_POST['obrazurl'];
        if(!empty($nazwa) && !empty($cena) && !empty($opis) && !empty($obraz) && !empty($kategoria)){
            $stmt = $pdo->exec('INSERT INTO produkty (`nazwa`,`obraz`, `cena`, `opis`,`czy_promocyjny`, `id_kategorii`) VALUES ( "'.$nazwa.'","'.$obraz.'",'.$cena.',"'.$opis.'",'.$czydostepny.','.$kategoria.')');
        }
        header('location:panel-products.php');
    } elseif(isset($_POST['edit'])){
        $productid = $_POST['productid'];
        $nazwa = $_POST['nazwa'];
        $cena = $_POST['cena'];
        $opis = $_POST['opis'];
        $kategoria = $_POST['katid'];
        $obraz = $_POST['obrazurl'];
        if(isset($_POST['czypromo'])){
            $dostepny = 1;
        } else {
            $dostepny = 0;
        }
        if(!empty($nazwa) && !empty($cena) && !empty($productid)){
            $stmt = $pdo->exec('UPDATE produkty SET `nazwa` = "'.$nazwa.'", `cena` = "'.$cena.'", `id_kategorii` = "'.$kategoria.'", `opis` = "'.$opis.'", `obraz` = "'.$obraz.'" , `czy_promocyjny` = "'.$dostepny.'" WHERE `id_produktu` = '.$productid);
        }
        header('location:panel-products.php');
    } elseif(isset($_POST['remove'])){
        $productuid = $_POST['productid'];
        if(!empty($productuid)){
            $stmt = $pdo->exec('DELETE FROM produkty WHERE `id_produktu` = '.$productuid);
        }
        header('location:panel-products.php');
    } elseif(isset($_POST['addCat'])){
        $catName = $_POST['nazwaKat'];
        $type = $_POST['rodzaj'];
        if(!empty($catName)){
            $stmt = $pdo->exec('INSERT INTO kategorie_prod (`nazwa`, `typ`) VALUES ("'.$catName.'",'.$type.');');
        }
        header('location:panel-products.php');
    } elseif(isset($_POST['editCat'])){
        $ID = $_POST['ktorakat'];
        $catName = $_POST['nazwaKat'];
        $typ = $_POST['rodzaj'];
        if(!empty($ID)){
            $stmt = $pdo->exec('UPDATE kategorie_prod SET `nazwa` = "'.$catName.'", `typ` = '.$typ.' WHERE `id_kategorii` LIKE '.$ID); // Usuwanie nie powinno całkowicie wymazywać użytkownika z bazy danych bo musi zostać w historii tranzakcji
        }
        header('location:panel-products.php');
    } elseif(isset($_POST['removeCat'])){
        $ID = $_POST['ktorakat'];
        if(!empty($ID)){
            $stmt = $pdo->exec('DELETE FROM kategorie_prod WHERE `id_kategorii` = '.$ID);
        }
        header('location:panel-products.php');
    }
    $stmt->closeCursor();
} catch(PDOException $e) {
    echo '<div class="alert alert-danger d-flex align-items-center" role="alert" id="jupi">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-question-octagon" viewBox="0 0 16 16">
                      <path d="M4.54.146A.5.5 0 0 1 4.893 0h6.214a.5.5 0 0 1 .353.146l4.394 4.394a.5.5 0 0 1 .146.353v6.214a.5.5 0 0 1-.146.353l-4.394 4.394a.5.5 0 0 1-.353.146H4.893a.5.5 0 0 1-.353-.146L.146 11.46A.5.5 0 0 1 0 11.107V4.893a.5.5 0 0 1 .146-.353L4.54.146zM5.1 1 1 5.1v5.8L5.1 15h5.8l4.1-4.1V5.1L10.9 1H5.1z"/>
                      <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z"/>
                    </svg>
                    <div>
                            Wystąpił problem z wykonaniem operacji.
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" onClick="window.location.href=index.php; return false;"></button>
                    </div>';
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
        td img{
            max-width: 100px;
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
        form a{
            color: #00FF7F;
        }
        form a:hover{
            color: #00b359;
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
            <input maxlength="48" placeholder="Nazwa" name="which-product">
            <button class="btn btn-outline-primary" type="submit" name="search">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                </svg>
                Szukaj
            </button>
        </form>
        <button class="btn btn-outline-primary" onclick="addingMode()" data-bs-toggle="modal" data-bs-target="#userForm1">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-fill-add" viewBox="0 0 16 16">
                <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zM9 5.5V7h1.5a.5.5 0 0 1 0 1H9v1.5a.5.5 0 0 1-1 0V8H6.5a.5.5 0 0 1 0-1H8V5.5a.5.5 0 0 1 1 0z"/>
            </svg>
            Dodaj produkt
        </button>
        <button class="btn btn-outline-primary" onclick="kategoriaUpdate()" data-bs-toggle="modal" data-bs-target="#userForm2">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-fill-add" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5zm6.5-11a.5.5 0 0 0-1 0V6H6a.5.5 0 0 0 0 1h1.5v1.5a.5.5 0 0 0 1 0V7H10a.5.5 0 0 0 0-1H8.5V4.5z"/>
            </svg>
            Dodaj/edytuj kategorię
        </button>
    </div>

    <div class="row">
        <div class="d-none d-lg-block col-lg-2"></div>
        <div class="col-12 col-lg-8">
            <table>
                <tr>
                    <th class="d-none d-md-table-cell">
                        Obraz
                    </th>
                    <th>
                        Nazwa produktu
                    </th>
                    <th>
                        Cena
                    </th>
                    <th class="d-none">
                        Opis
                    </th>
                    <th>
                        Promocyjny?
                    </th>
                    <th>
                        Kategoria
                    </th>
                </tr>
                <?php
                try{
                    $pdo = new PDO('mysql:host=' . $mysql_host . ';dbname=' . $database . ';port=' . $port, $username, $password);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    if (isset($_POST['search'])) {
                        $whichproduct = $_POST['which-product'];
                    }

                    if(!empty($whichproduct)){
                        $stmt = $pdo->query('SELECT produkty.nazwa as nazwa_p, id_produktu, obraz, cena, opis, czy_promocyjny, kategorie_prod.nazwa as nazwa_k FROM produkty inner join kategorie_prod on produkty.id_kategorii = kategorie_prod.id_kategorii WHERE produkty.nazwa LIKE "'.$whichproduct.'%";');
                    } else {
                        $stmt = $pdo->query('SELECT produkty.nazwa as nazwa_p, id_produktu, obraz, cena, opis, czy_promocyjny, kategorie_prod.nazwa as nazwa_k FROM produkty inner join kategorie_prod on produkty.id_kategorii = kategorie_prod.id_kategorii;');
                    }
                    foreach ($stmt as $row) {
                        echo "<tr id='productid".$row['id_produktu']."' onclick='edit(".$row['id_produktu'].")' data-bs-toggle='modal' data-bs-target='#userForm1'>";
                        echo "<td class='d-none d-md-table-cell'>";
                        if(!empty($row['obraz'])){
                            echo "<img src='".$row['obraz']."'>";
                        }
                        echo "</td>";
                        echo "<td>".$row['nazwa_p']."</td>";
                        echo "<td>".$row['cena']."</td>";
                        echo "<td class='d-none'>".$row['opis']."</td>";
                        echo "<td>";
                        if($row['czy_promocyjny'] == 1){
                            echo "Tak";
                        } else {
                            echo "Nie";
                        }
                        echo "</td>";
                        echo "<td>".$row['nazwa_k']."</td>";
                        echo "</tr>";
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
    <div class="modal fade" id="userForm1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle1">Dodawanie produktu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <input type="hidden" value="" name="productid" id="productFormID">
                        <input class="form-control mt-3" type="text" maxlength="64" name="nazwa" id="productFormNazwa" placeholder="Nazwa" required>
                        <input class="form-control mt-3" type="number" step="0.01" min="0" name="cena" value="0" id="productFormCena" placeholder="Cena (zł)" required>
                        <input class="form-control mt-3" type="text" name="opis" id="productFormOpis" maxlength="254" placeholder="Opis">
                        <select name='katid' class="form-control mt-3" id="productFormKat">
                            <option value='' selected='' disabled=''>Kategoria</option>
                            <?php
                            $pdo = new PDO('mysql:host=' . $mysql_host . ';dbname=' . $database . ';port=' . $port, $username, $password);
                            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $stmt = $pdo->query('SELECT * FROM kategorie_prod;');
                            foreach ($stmt as $row) {
                                echo "<option value='".$row['id_kategorii']."'>".$row['nazwa']."</option>";
                            }
                            ?>
                        </select>
                        <label for="link" class="form-label mt-3">Obraz produktu (Skalowany do 400x400)</label>
                        <br>
                        <a href="panel-images.php" target="popup" onclick="window.open('panel-images.php','popup','width=1000,height=800'); return false;">
                            Zobacz bibliotekę obrazów
                        </a>
                        <input class="form-control form-control-sm" type="file" name="obraz" id="productFormNewImg" accept="image/png,image/webp,image/gif" style="display:none;">
                        <input class="form-control" type="url" placeholder="Link do pliku z obrazem" name="obrazurl" id="productFormImgLink" style="display:block;">
                        <br>
                        <input type="checkbox" name="czypromo" id="productFormDostepnosc" checked="false" placeholder="Dostępny tylko na promocji">
                        <label for="productFormDostepnosc">Dostępny tylko na promocji</label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                        <button id="confirmAddNew1" name="add" type="submit" class="btn btn-primary" style="display:block">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                            </svg>
                            Dodaj
                        </button>
                        <button id="confirmRemove1" name="remove" type="submit" class="btn btn-primary" style="display:none">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                            </svg>
                            Usuń
                        </button>
                        <button id="confirmEdit1" name="edit" type="submit" class="btn btn-primary" style="display:none">
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

<!-- MODAL -->
<div class="modal fade" id="userForm2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle2">Dodawanie/edycja kategorii</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <select class='mt-3 form-control' id='kategorianame' name='ktorakat' onChange='kategoriaUpdate()'>
                        <option value='' selected='' id="addNewCat">Dodaj nową</option>
                        <?php
                        $pdo = new PDO('mysql:host=' . $mysql_host . ';dbname=' . $database . ';port=' . $port, $username, $password);
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $stmt = $pdo->query('SELECT * FROM kategorie_prod;');
                        foreach ($stmt as $row) {
                            echo "<option value='".$row['id_kategorii']."'>".$row['nazwa']."</option>";
                        }
                        ?>
                    </select>
                    <input class="form-control mt-3" type="text" maxlength="48" name="nazwaKat" id="prodFormNazwaKat" placeholder="Nazwa" required>
                    <select class="mt-3  form-control" id="rodzaj"  name="rodzaj" required>
                        <option value="" disabled="" selected="">Rodzaj zakupu</option>
                        <option value="0">Policzalny</option>
                        <option value="1">Niepoliczalny (jednorazowy)</option>
                        <option value="2">Na okres czasu</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                    <button id="confirmAddCat" name="addCat" type="submit" class="btn btn-primary" style="display:block">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                            <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                        </svg>
                        Dodaj
                    </button>
                    <button id="confirmRemoveCat" name="removeCat" type="submit" class="btn btn-primary" style="display:none">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                        </svg>
                        Usuń
                    </button>
                    <button id="confirmEditCat" name="editCat" type="submit" class="btn btn-primary" style="display:none">
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
<script>
    var typelist = [
        <?php
        $stmt = $pdo->query('SELECT typ FROM kategorie_prod;');
        foreach ($stmt as $row) {
            echo $row['typ'].",";
        }
        ?>
    ];
    var title = document.getElementById("modalTitle1");
    var productid = document.getElementById("productFormID");
    var categoryid = document.getElementById("userFormCategoryID");
    var Nazwa = document.getElementById("productFormNazwa");
    var NazwaKat = document.getElementById("prodFormNazwaKat");
    var Cena = document.getElementById("productFormCena");
    var Opis = document.getElementById("productFormOpis");
    var Dostepnosc = document.getElementById("productFormDostepnosc");
    var addbutton = document.getElementById("confirmAddNew1");
    var editbutton = document.getElementById("confirmEdit1");
    var deletebutton = document.getElementById("confirmRemove1");
    var addCat = document.getElementById("confirmAddCat");
    var editCat = document.getElementById("confirmEditCat");
    var deleteCat = document.getElementById("confirmRemoveCat");
    var selectedCat = document.getElementById('kategorianame');
    var Kategoria = document.getElementById("productFormKat");
    var rodzajkat = document.getElementById("rodzaj");
    var fileInput = document.getElementById("productFormNewImg");
    var imgUrl = document.getElementById("productFormImgLink");
    function kategoriaUpdate(){
        if(selectedCat.options[0].selected == true){
            NazwaKat.value = "";
            rodzajkat.value = "";
            addCat.style.display = "block";
            editCat.style.display = "none";
            deleteCat.style.display = "none";
        } else {
            NazwaKat.value = selectedCat.options[selectedCat.value].innerText;
            rodzajkat.value = typelist[selectedCat.selectedIndex-1];
            addCat.style.display = "none";
            editCat.style.display = "block";
            deleteCat.style.display = "block";
        }
    }
    function addingMode(){
        title.innerText = "Dodawanie produktu";
        addbutton.style.display = "block";
        editbutton.style.display = "none";
        deletebutton.style.display = "none";
        productid.value = "";
        productid.disabled = true;
        Nazwa.value = "";
        Cena.value = "";
        Opis.value = "";
        Kategoria.children[0].selected = true;
        Dostepnosc.checked = false;
        fileInput.value = "";
        imgUrl.value = "";
    }
    function edit(id){
        title.innerText = "Edycja produktu";
        productid.value = id;
        productid.disabled = false;
        if(document.getElementById("productid" + id).children[0].children.length > 0){
            imgUrl.value = document.getElementById("productid" + id).children[0].getElementsByTagName("img")[0].src;
        } else {
            imgUrl.value = "";
        }
        Nazwa.value = document.getElementById("productid" + id).children[1].innerText;
        Cena.value = document.getElementById("productid" + id).children[2].innerText;
        Opis.value = document.getElementById("productid" + id).children[3].innerText;
        if(document.getElementById("productid" + id).children[4].innerText == "Tak"){
            Dostepnosc.checked = true;
        } else {
            Dostepnosc.checked = false;
        }
        for(let i = 0; i < Kategoria.children.length; i++){
            if(Kategoria.children[i].innerText == document.getElementById("productid" + id).children[5].innerText){
                Kategoria.children[i].selected = true;
            }
        }
        addbutton.style.display = "none";
        deletebutton.style.display = "block";
        editbutton.style.display = "block";
    }
</script>
<script src="../resources/scroll.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>

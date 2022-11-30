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
        $nazwa = $_POST['nazwa'];
        $cena = $_POST['cena'];
        $opis = $_POST['opis'];
        if(isset($_POST['dostepnosc'])){
            $dostepnosc = 1;
        } else {
            $dostepnosc = 0;
        }
        $kategoria = $_POST['kategoria'];
        if(!empty($nazwa) && !empty($cena) && !empty($opis)){
            $stmt = $pdo->exec('INSERT INTO produkty (`nazwa`, `cena`, `opis`, `dostepnosc`) VALUES ( "'.$nazwa.'","'.$cena.'","'.$opis.'",'.$dostepnosc.')');
        }
        header('location:panel-products.php');
    } elseif(isset($_POST['edit'])){
        $productid = $_POST['productid'];
        $nazwa = $_POST['nazwa'];
        $cena = $_POST['cena'];
        $opis = $_POST['opis'];
        $kategoria = $_POST['kategoria'];
       
        if(!empty($nazwa) && !empty($cena) && !empty($productid)){
            $stmt = $pdo->exec('UPDATE produkty SET `nazwa` = "'.$nazwa.'", `cena` = "'.$cena.'", `admin` = "'.$admin.'" WHERE `productid` LIKE '.$productid);
        }
        header('location:panel-products.php');
    } elseif(isset($_POST['remove'])){
        $productid = $_POST['productid'];
        if(!empty($productid)){
            $stmt = $pdo->exec('UPDATE produkty SET `nazwa` = "NULL", `cena` = "NULL" WHERE `id_produktu` LIKE '.$productid); // Usuwanie nie powinno całkowicie wymazywać użytkownika z bazy danych bo musi zostać w historii tranzakcji
        }
        header('location:panel-products.php');
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
            <input maxlength="48" placeholder="Nazwa" name="which-product">
            <button class="btn btn-outline-primary" type="submit" name="search">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                </svg>
                Szukaj
            </button>
        </form>
        <button class="btn btn-outline-primary" onclick="addingMode1()" data-bs-toggle="modal" data-bs-target="#userForm1">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-fill-add" viewBox="0 0 16 16">
                <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                <path d="M2 13c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Z"/>
            </svg>
            Dodaj produkt
        </button>
        <button class="btn btn-outline-primary" onclick="addingMode2()" data-bs-toggle="modal" data-bs-target="#userForm2">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-fill-add" viewBox="0 0 16 16">
                <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Zm-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                <path d="M2 13c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Z"/>
            </svg>
            Dodaj kategorię
        </button>
    </div>

    <div class="row">
        <div class="d-none d-lg-block col-lg-2"></div>
        <div class="col-12 col-lg-8">
            <table>
                <tr>
                    <th>
                        Nazwa produktu
                    </th>
                    <th class="d-none d-md-table-cell">
                        Cena
                    </th>
                    <th>
                        Opis
                    </th>
                    <th>
                        Dostępność
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
                        $stmt = $pdo->query('SELECT produkty.nazwa as nazwa_p,produkty.cena,produkty.opis,produkty.dostepnosc, kategorie_prod.nazwa as nazwa_k FROM produkty inner join kategorie_prod on produkty.id_kategorii =kategorie_prod.id_kategorii WHERE produkty.nazwa LIKE "'.$whichproduct.'%";');
                    } else {
                        $stmt = $pdo->query('SELECT produkty.nazwa as nazwa_p,produkty.cena,produkty.opis,produkty.dostepnosc, kategorie_prod.nazwa as nazwa_k FROM produkty inner join kategorie_prod on produkty.id_kategorii =kategorie_prod.id_kategorii;');
                    }
                    foreach ($stmt as $row) {
                        echo "<tr id='productid".$row['nazwa_p']."' onclick='edit(".$row['nazwa_p'].")' data-bs-toggle='modal' data-bs-target='#userForm1'>";
                        echo "<td>".$row['nazwa_p']."</td>";
                        echo "<td>".$row['cena']."</td>";
                        echo "<td>".$row['opis']."</td>";
                        echo "<td>".$row['dostepnosc']."</td>";
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
                        <input value="" disabled="true" name="productid" id="userFormProductID" style="display:none">
                        <input class="form-control mt-3" type="text" maxlength="48" name="nazwa" id="userFormNazwa1" placeholder="Nazwa" required>
                        <input class="form-control mt-3" type="price" maxlength="64" name="cena" id="userFormCena" placeholder="Cena" required>
                        <input class="form-control mt-3" type="text" name="opis" id="userFormOpis1" maxlength="30" placeholder="Opis" required>
                        <input class="mt-3" type="checkbox" name="dostepnosc" id="userFormDostepnosc" checked="true" placeholder="Dostępność" required>
                        <br>
                        <label>Wybierz kategorię:</label>
                        <?php
                            $pdo = new PDO('mysql:host=' . $mysql_host . ';dbname=' . $database . ';port=' . $port, $username, $password);
                            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $stmt = $pdo->query('SELECT nazwa as nazwa_k FROM kategorie_prod;');
                                echo "<select>";
                                foreach ($stmt as $row) {
                                    echo "<option value='".$row['nazwa_k']."'>".$row['nazwa_k']."</option>";
                                }
                           
                                echo "</select>";
                            
                            ?>
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
                                <path d="M8.086 2.207a2 2 0 0 1 2.828 0l3.879 3.879a2 2 0 0 1 0 2.828l-5.5 5.5A2 2 0 0 1 7.879 15H5.12a2 2 0 0 1-1.414-.586l-2.5-2.5a2 2 0 0 1 0-2.828l6.879-6.879zm2.121.707a1 1 0 0 0-1.414 0L4.16 7.547l5.293 5.293 4.633-4.633a1 1 0 0 0 0-1.414l-3.879-3.879zM8.746 13.547 3.453 8.254 1.914 9.793a1 1 0 0 0 0 1.414l2.5 2.5a1 1 0 0 0 .707.293H7.88a1 1 0 0 0 .707-.293l.16-.16z"/>
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
                    <h5 class="modal-title" id="modalTitle2">Dodawanie kategorii</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <input value="" disabled="true" name="categoryid" id="userFormCategoryID" style="display:none">
                        <input class="form-control mt-3" type="text" maxlength="48" name="nazwa" id="userFormNazwa2" placeholder="Nazwa" required>
                        <input class="form-control mt-3" type="text" name="opis" id="userFormOpis2" maxlength="30" placeholder="Opis" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                        <button id="confirmAddNew2" name="add" type="submit" class="btn btn-primary" style="display:block">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                            </svg>
                            Dodaj
                        </button>
                        <button id="confirmRemove2" name="remove" type="submit" class="btn btn-primary" style="display:none">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                <path d="M8.086 2.207a2 2 0 0 1 2.828 0l3.879 3.879a2 2 0 0 1 0 2.828l-5.5 5.5A2 2 0 0 1 7.879 15H5.12a2 2 0 0 1-1.414-.586l-2.5-2.5a2 2 0 0 1 0-2.828l6.879-6.879zm2.121.707a1 1 0 0 0-1.414 0L4.16 7.547l5.293 5.293 4.633-4.633a1 1 0 0 0 0-1.414l-3.879-3.879zM8.746 13.547 3.453 8.254 1.914 9.793a1 1 0 0 0 0 1.414l2.5 2.5a1 1 0 0 0 .707.293H7.88a1 1 0 0 0 .707-.293l.16-.16z"/>
                            </svg>
                            Usuń
                        </button>
                        <button id="confirmEdit2" name="edit" type="submit" class="btn btn-primary" style="display:none">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                            </svg>
                            Zapisz
                        </button>
                </form>
            </div>
        </div>
    </div>
    


    <div style="text-align:center;color:white;">Wdrożenie - AM 2022</div>
</div>
<script>
    var title1 = document.getElementById("modalTitle1");
    var title2 = document.getElementById("modalTitle2");
    var productid = document.getElementById("userFormProductID");
    var categoryid = document.getElementById("userFormCategoryID");
    var Nazwa1 = document.getElementById("userFormNazwa1");
    var Nazwa2 = document.getElementById("userFormNazwa2");
    var Cena = document.getElementById("userFormCena");
    var Opis1 = document.getElementById("userFormOpis1");
    var Opis2 = document.getElementById("userFormOpis2");
    var Dostepnosc = document.getElementById("userFormDostepnosc");
    var addbutton1 = document.getElementById("confirmAddNew1");
    var editbutton1 = document.getElementById("confirmEdit1");
    var deletebutton1 = document.getElementById("confirmRemove1");
    var addbutton2 = document.getElementById("confirmAddNew2");
    var editbutton2 = document.getElementById("confirmEdit2");
    var deletebutton2 = document.getElementById("confirmRemove2");
    var Kategoria1 = document.getElementById("userFormNazwa1");
    var Kategoria2 = document.getElementById("userFormNazwa1");
    function addingMode1(){
        title1.innerText = "Dodawanie produktu";
        addbutton1.style.display = "block";
        editbutton1.style.display = "none";
        deletebutton1.style.display = "none";
        productid.value = "";
        productid.disabled = true;
        Nazwa1.value = "";
        Cena.value = "";
        Opis1.value = "";
        Kategoria1.value = "";
        Dostepnosc.checked = true;
    }
    function addingMode2(){
        title2.innerText = "Dodawanie kategorii";
        addbutton2.style.display = "block";
        editbutton2.style.display = "none";
        deletebutton2.style.display = "none";
        categoryid.value = "";
        categoryid.disabled = true;
        Nazwa2.value = "";
        Opis2.value = "";
    }
    function edit(productid){
        title1.innerText = "Edycja produktu";
        addbutton   .style.display = "none";
        productid.value = productid;
        productid.disabled = false;
        Nazwa1.value = document.getElementById("product" + productid).children[2].innerText;
        Cena.value = document.getElementById("user" + productid).children[3].innerText;
        Opis1.value = document.getElementById("user" + productid).children[4].innerText;
        if(document.getElementById("user" + id).children[4].innerText == "Admin"){
            isAdmin.checked = true;
            deletebutton.style.display = "none";
        } else {
            isAdmin.checked = false;
            deletebutton.style.display = "block";
        }
        if(document.getElementById("user" + id).children[3].innerText == "NULL"){
            editbutton.style.display = "none";
            deletebutton.style.display = "none";
        } else {
            editbutton.style.display = "block";
        }
    }
</script>
<script src="../resources/scroll.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
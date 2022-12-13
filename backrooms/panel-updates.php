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

    if(isset($_POST['confirm'])){
        $title = str_replace("'", "''", $_POST['title']); //dla bezpieczeństwa zamienia pojedyncze apostrofy na podwójne
        $text = str_replace("'", "''", $_POST['text']);
        $date = $_POST['date'];
        $author = $_SESSION['user'];
        if(!empty($title) && !empty($text) && !empty($date)){
            $stmt = $pdo->exec('INSERT INTO wpisy (`id_klienta`, `tytul`, `tresc`, `data`) VALUES ( "'.$author.'","'.$title.'","'.$text.'","'.$date.'")');
        }
        header('location:panel-updates.php');
    }
    if(isset($_POST['edit'])){
        $updateid = $_POST['ID'];
        $title = str_replace("'", "''", $_POST['title']); //dla bezpieczeństwa zamienia pojedyncze apostrofy na podwójne
        $text = str_replace("'", "''", $_POST['text']);
        $data = $_POST['date'];
        $author = $_SESSION['user'];
        if(!empty($title) && !empty($text) && !empty($data)){
            $stmt = $pdo->exec('UPDATE wpisy SET `id_klienta` = '.$author.', `tytul` = "'.$title.'", `tresc` = "'.$text.'", `data` = "'.$data.'" WHERE `id_wpisu` =  '.$updateid);
        }
        header('location:panel-updates.php');
    } elseif(isset($_POST['remove'])){
        $updateid = $_POST['ID'];
        if(!empty($updateid)){
            $stmt = $pdo -> exec('DELETE FROM wpisy WHERE `id_wpisu` = '.$updateid);
        }
        header('location:panel-updates.php');
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
        #confirm{
            display: block;
            text-align: center;
            margin-left: auto;
            margin-right: auto;
            min-width: 150px;
        }
        #date{
            max-width: 317px;
            text-align: center;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        .invis{
            background-color: rgba(0, 0, 0, 0);
            border: none;
        }
        .box-shadow{
            -webkit-box-shadow: 5px 5px 0px 0px rgba(39, 39, 42, 1);
            -moz-box-shadow: 5px 5px 0px 0px rgba(39, 39, 42, 1);
            box-shadow: 5px 5px 0px 0px rgba(39, 39, 42, 1);
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
        .searchpanel{
            margin: auto;
            display: block;
            width: 90%;
            text-align: center;
        }
        .searchpanel input{
            min-width: 150px;
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

    <form method="post" class="m-5">
            <input class="form-control mt-3" type="text" maxlength="128" name="title" id="title" placeholder="Tytuł" required>
            <textarea class="form-control mt-3" name="text" id="text" required></textarea>
            <input class="form-control mt-3" type="date" name="date" id="date" required>
            <button id="confirm" name="confirm" type="submit" class="btn btn-primary mt-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                    <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                </svg>
                Opublikuj
            </button>
    </form>

    <div class="row">
        <div class="col-md-12">
            <div class="separator"></div>
        </div>
    </div>

    <div class="searchpanel">
        <form method="post">
            <input maxlength="48" placeholder="Tytuł" name="which-update">
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
            <table>
                <tr>
                    <th>Autor</th>
                    <th>Tytuł</th>
                    <th>Data</th>
                </tr>
                <?php
                try{
                    $pdo = new PDO('mysql:host=' . $mysql_host . ';dbname=' . $database . ';port=' . $port, $username, $password);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    if (isset($_POST['search'])) {
                        $whichupdate = $_POST['which-update'];
                    }

                    if(!empty($whichupdate)){
                        $stmt = $pdo->query('SELECT id_wpisu, nick, tytul,tresc, `data` FROM wpisy inner join klienci on wpisy.id_klienta=klienci.id_klienta WHERE tytul LIKE "'.$whichupdate.'%" or nick LIKE "'.$whichupdate.'%";');
                    } else {
                        $stmt = $pdo->query('SELECT id_wpisu, nick, tytul,tresc, `data` FROM wpisy inner join klienci on wpisy.id_klienta=klienci.id_klienta;');
                    }
                    foreach ($stmt as $row) {
                        echo "<tr id='update" . $row['id_wpisu'] . "' onclick='edit(" . $row['id_wpisu'] . ")' data-bs-toggle='modal' data-bs-target='#updateForm'>";
                        echo "<td>" . $row['nick'] . "</td>";
                        echo "<td>" . $row['tytul'] . "</td>";
                        echo "<td style='display:none'>" . $row['tresc'] . "</td>";
                        echo "<td>" . $row['data'] . "</td>";
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
        <div class="modal fade" id="updateForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Edycja wpisu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post">
                    <div class="modal-body">
                        <input value="" type="hidden" name="ID" id="updateFormID">
                        <input class="form-control mt-3" type="text" maxlength="48" name="title" id="updateFormAutor" placeholder="Tytuł" required>
                        <input class="form-control mt-3" type="text" maxlength="48" name="author" id="updateFormTytul" placeholder="Autor" readonly>
                        <textarea class="form-control mt-3" style="white-space:normal;" name="text" id="updateFormTresc" placeholder="Treść" required></textarea>
                        <input class="form-control mt-3" type="date" name="date" id="updateFormDate" placeholder="Data" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                        <button id="confirmRemove" name="remove" type="submit" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                <path d="M8.086 2.207a2 2 0 0 1 2.828 0l3.879 3.879a2 2 0 0 1 0 2.828l-5.5 5.5A2 2 0 0 1 7.879 15H5.12a2 2 0 0 1-1.414-.586l-2.5-2.5a2 2 0 0 1 0-2.828l6.879-6.879zm2.121.707a1 1 0 0 0-1.414 0L4.16 7.547l5.293 5.293 4.633-4.633a1 1 0 0 0 0-1.414l-3.879-3.879zM8.746 13.547 3.453 8.254 1.914 9.793a1 1 0 0 0 0 1.414l2.5 2.5a1 1 0 0 0 .707.293H7.88a1 1 0 0 0 .707-.293l.16-.16z"/>
                            </svg>
                            Usuń
                        </button>
                        <button id="confirmEdit" name="edit" type="submit" class="btn btn-primary">
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
    var ID = document.getElementById("updateFormID");
    var Tytul = document.getElementById("updateFormTytul");
    var Autor = document.getElementById("updateFormAutor");
    var Tresc = document.getElementById("updateFormTresc");
    var Data = document.getElementById("updateFormDate");
    var editbutton = document.getElementById("confirmEdit");
    var deletebutton = document.getElementById("confirmRemove");

    function edit(id){
        title.innerText = "Edycja wpisu";
        ID.value = id;
        Tytul.value = document.getElementById("update" + id).children[0].innerText;
        Autor.value = document.getElementById("update" + id).children[1].innerText;
        Tresc.value = document.getElementById("update" + id).children[2].innerText;
        Data.value = document.getElementById("update" + id).children[3].innerText;
    }

</script>
<script src="../resources/scroll.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
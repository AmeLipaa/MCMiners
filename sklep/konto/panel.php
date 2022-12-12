<?php
session_start();
if(isset($_POST['logout'])){
    session_unset();
    session_destroy();
    header('location:./index.php');
}
require("../../backrooms/bd-authorize.php");

$pdo = new PDO('mysql:host=' . $mysql_host . ';dbname=' . $database . ';port=' . $port, $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if(!isset($_SESSION['user'])){
    header('location:index.php');
}
if(isset($_POST['edit'])){
    $userid = $_SESSION['user'];
    $nick = $_POST['nick'];
    $email = $_POST['email'];
    $switcharoo = false;
    if(!empty($nick) && !empty($email)){
		
		$stmt1 = $pdo->query('SELECT * FROM klienci WHERE id_klienta = '.$userid);
		foreach ($stmt1 as $row) {
			$stmtdos = $pdo -> query('SELECT nick, email FROM klienci');
            foreach ($stmtdos as $rowdos){
                if($rowdos['id_klienta'] != $userid){
                    if($rowdos['email'] == $email || $rowdos['nick'] == $nick){
                        $switcharoo = true;
                    }
                }
            }
            if($switcharoo == false){
                $stmt = $pdo->exec('UPDATE klienci SET `nick` = "'.$nick.'", `email` = "'.$email.'" WHERE `id_klienta` LIKE '.$userid);
            }
		}
		
		
       
    }
    header('location:panel.php');
	$stmt1->closeCursor();

}
if(isset($_POST['remove'])){
    $userid = $_POST['ID'];
    if(!empty($userid)){
        $stmt = $pdo->exec('UPDATE klienci SET `nick` = "'.$nick.'", `email` = "'.$email.'", `admin` = "'.$admin.'" WHERE `id_klienta` LIKE '.$userid); // Usuwanie nie powinno całkowicie wymazywać użytkownika z bazy danych bo musi zostać w historii tranzakcji
    }
	   session_unset();
    session_destroy();
    header('location:panel.php');


}
if(isset($_POST['editpwd'])){
	$oldpwd=$_POST['oldpwd'];
	$newpwd=$_POST['newpwd'];
    if(!empty($userid)){
		$stmt = $pdo->query('SELECT * FROM klienci WHERE id_klienta ='.$_SESSION['user']);
		foreach ($stmt as $row) {
			$checkpwd = hash('whirlpool',$oldpwd);
            if($checkpwd == $row['haslo']){
				$hashpwd = hash('whirlpool',$newpwd);
				$stmt2 = $pdo->exec('UPDATE klienci SET `haslo` = "'.$hashpwd.'" WHERE `id_klienta` LIKE '.$_SESSION['user']); 
			}
			else{
				echo'Niepoprawne hasło.';
			}
		}
	}
	 header('location:panel.php');
$stmt->closeCursor();
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>MinersMC</title>
    <link rel="icon" type="image/png" href="../../resources/logo.png">
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
            background: repeat url("../../resources/bg2.png");
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
            background: repeat url("../../resources/dirt.jpg");
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
        .btn:focus{
            box-shadow: 0 0 0 .25rem rgba(0, 179, 89,.5) !important;
        }
        .btn:active{
            background-color: #00b359;
            border-color: #00FF7F;
        }
        .invis{
            background-color: rgba(0, 0, 0, 0);
            border: none;
        }
        .modal-header{
            color: white;
            background: repeat url("../../resources/dirt.jpg");
        }
        .modal-body{
            color: white;
            background-color: #333;
        }
        .modal-footer{
            background: repeat url("../../resources/dirt.jpg");
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
            border-radius: 25px;
            text-align: center;
            margin-top: 10px;
        }
        th{
            min-width: fit-content;
            width: 20%;
        }
        td{
            min-width: fit-content;
            width: 20%;
        }
        tr{
            border-radius: 25px;
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
            <a href=".." class="navbar-brand d-flex w-50 me-auto"><img src="../../resources/logo.png" style="height:50px;" /></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsingNavbar3">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse collapse w-100" id="collapsingNavbar3">
                <ul class="navbar-nav w-100 justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link" href="..">Powrót</a>
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
        include('../../backrooms/welcome.php');
        ?>
    </div>
    <div class="separator"></div>
    <h2 id="gridtitle" class="d-none d-sm-block"></h2>

    <div class='panel-grid'>
                <a class='big-btn box-shadow' data-bs-toggle='modal' data-bs-target='#userForm'>
                <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor" class="bi bi-gear" viewBox="0 0 16 16">
                    <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z"/>
                    <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z"/>
                </svg>
        </a>
        <a class='big-btn box-shadow' data-bs-toggle='modal' data-bs-target='#userForm2'>
        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-card-checklist" viewBox="0 0 16 16" height="100" width="100">
                <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"></path>
                <path d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0zM7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0z"></path>
            </svg>
        </a>
        <a class="big-btn box-shadow" href="../koszyk.php">
        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor" class="bi bi-basket2-fill" viewBox="0 0 16 16">
            <path d="M5.929 1.757a.5.5 0 1 0-.858-.514L2.217 6H.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h.623l1.844 6.456A.75.75 0 0 0 3.69 15h8.622a.75.75 0 0 0 .722-.544L14.877 8h.623a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1.717L10.93 1.243a.5.5 0 1 0-.858.514L12.617 6H3.383L5.93 1.757zM4 10a1 1 0 0 1 2 0v2a1 1 0 1 1-2 0v-2zm3 0a1 1 0 0 1 2 0v2a1 1 0 1 1-2 0v-2zm4-1a1 1 0 0 1 1 1v2a1 1 0 1 1-2 0v-2a1 1 0 0 1 1-1z"/>
        </svg>
        </a>
            </div>
            <div class="modal fade" id="userForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Ustawienia konta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
               
                    <div class="modal-body">
					<button class="btn btn-primary mt-3" type="button" data-bs-toggle="collapse" data-bs-target="#nickemailzmiana" aria-expanded="false" aria-controls="collapseExample">
    Zmień nick lub e-mail</button>
	<div class="collapse" id="nickemailzmiana">
	 <form method="post">
                    <?php
                try{
                    $pdo = new PDO('mysql:host=' . $mysql_host . ';dbname=' . $database . ';port=' . $port, $username, $password);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stmt = $pdo->query('SELECT * FROM klienci WHERE id_klienta LIKE "'.$_SESSION['user'].'"');
                    foreach ($stmt as $row) {
                    echo "<input class='form-control mt-3' style='display:none' required name='ID' id='userFormID' value ='".$row['id_klienta']."'>";
                    echo "<input class='form-control mt-3' required type='text' maxlength='48' name='nick' id='userFormNick' placeholder='Nick' value ='".$row['nick']."'>";
                    echo "<input class='form-control mt-3' required type='email' maxlength='64' name='email' id='userFormEmail' placeholder='E-mail'value ='".$row['email']."'>";
                    }
                } catch(PDOException $e) {
                    echo '😵';
                }
                ?>
				
				 
                        <?php
                try{
                    $pdo = new PDO('mysql:host=' . $mysql_host . ';dbname=' . $database . ';port=' . $port, $username, $password);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stmt = $pdo->query('SELECT * FROM klienci WHERE id_klienta LIKE "'.$_SESSION['user'].'"');
                    foreach ($stmt as $row) {
                        echo "<button id='confirmEdit' onclick='edit(". $row['id_klienta'].")' name='edit' type='submit' class='btn btn-primary mt-3'>";
                    } }catch(PDOException $e) {
                        echo '😵';
                    }
                    ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                            </svg>
                            Zapisz
                        </button>
				
				  </form>
				</div>
				<br>
<button class="btn btn-primary mt-3" type="button" data-bs-toggle="collapse" data-bs-target="#zmianapwd" aria-expanded="false" aria-controls="collapseExample">
    Zmień hasło</button>
	<div class="collapse" id="zmianapwd">
	
	<form method="post">
	 <?php
                try{
                    $pdo = new PDO('mysql:host=' . $mysql_host . ';dbname=' . $database . ';port=' . $port, $username, $password);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stmt = $pdo->query('SELECT * FROM klienci WHERE id_klienta LIKE "'.$_SESSION['user'].'"');
                    foreach ($stmt as $row) {
                    echo "<input class='form-control mt-3' style='display:none' required name='ID' id='userFormID3' value ='".$row['id_klienta']."'>";
                    }
                } catch(PDOException $e) {
                    echo '😵';
                }
                ?>
				<input class='form-control mt-3' required type='password' maxlength='64' name='oldpwd' id='userFormOldPwd' placeholder='Stare hasło'>
				<input class='form-control mt-3' required type='password' maxlength='64' name='newpwd' id='userFormNewPwd' placeholder='Nowe hasło'>
				<button id="confirmpwd" name="editpwd" type="submit" class="btn btn-primary mt-3"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                            </svg>Zapisz zmiany
							</button>
</form>
				</div>
				<br>
				<button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#czyusunac">
  Chcę usunąć konto
</button>
<div class="modal fade" id="czyusunac" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Usuwanie konta</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Czy na pewno chcesz usunąć swoje konto? <strong>"na zawsze" to bardzo długo!</strong>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		<form method="post">
	   <?php
                try{
                    $pdo = new PDO('mysql:host=' . $mysql_host . ';dbname=' . $database . ';port=' . $port, $username, $password);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stmt = $pdo->query('SELECT * FROM klienci WHERE id_klienta LIKE "'.$_SESSION['user'].'"');
                    foreach ($stmt as $row) {
                    echo "<input class='form-control mt-3' style='display:none' required name='ID' id='userFormID2' value ='".$row['id_klienta']."'>";
                    }
                } catch(PDOException $e) {
                    echo '😵';
                }
                ?>
        <button id="confirmRemove" name="remove" type="submit" class="btn btn-primary">Usuń</button>
		</form>
      </div>
    </div>
  </div>
</div>
				
                 </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                      
	
              
            </div>
        </div>
    </div>
    </div>
      <div class='panel-grid'>

            </div>
            <div class="modal fade" id="userForm2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Historia transakcji</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                    <div class="modal-body">
                <?php
                try{
                    
                    $pdo = new PDO('mysql:host=' . $mysql_host . ';dbname=' . $database . ';port=' . $port, $username, $password);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stmt = $pdo->query('SELECT * FROM transakcja WHERE id_klienta LIKE "'.$_SESSION['user'].'"');
                    $stmt2 = $pdo->query('SELECT * FROM szczegoly_transakcji inner join transakcja on szczegoly_transakcji.id_transakcji=transakcja.id_transakcji inner join produkty on szczegoly_transakcji.id_produktu = produkty.id_produktu WHERE transakcja.id_klienta LIKE "'.$_SESSION['user'].'"');
                    echo "<table><tr style='font-size: 120%'><th> Numer zamówienia </th>";
                    echo "<div><th> Data </th>";
                    echo "<th> Status</th>";
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
                        $stmt3 = $pdo->query('select produkty.nazwa, produkty.cena, szczegoly_transakcji.ilosc from produkty inner join szczegoly_transakcji on produkty.id_produktu=szczegoly_transakcji.id_produktu inner join transakcja on szczegoly_transakcji.id_transakcji = transakcja.id_transakcji where szczegoly_transakcji.id_transakcji LIKE "'.$row['id_transakcji'].'" and transakcja.id_klienta LIKE "'.$_SESSION['user'].'"');    
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
                        echo "<tr style='border: 1px solid; border-color: green; border-radius: 25px;'><td style='text-align: right'>Wartość zamówienia: ";
                        echo "<td>" .$razem." zł</td>";
                        echo "<td></td></tr>";
                     echo "</table>";
                }
                
                    $stmt->closeCursor();
                } catch(PDOException $e) {
                    echo '😵';
                }

                ?>
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
            </div>
        </div>
    </div>
</div>

    <div style="text-align:center;color:white;">Wdrożenie - AM 2022</div>
</div>
<script>
    var title = document.getElementById("gridtitle");
    var names = ["Ustawienia konta","Historia transakcji","Koszyk"];
    var elements = document.getElementsByClassName("big-btn");
    var rozwijane_kolumny = document.getElementsByClassName("rozwijane_kolumny");
    var wyswietlane_kolumny = document.getElementsByClassName("wyswietlane_kolumny");

    for(let i = 0; i < elements.length; i++){
        elements[i].addEventListener('mouseenter', function(){
           title.innerText = names[i];
        });
        elements[i].addEventListener('mouseleave', function(){
            title.innerText = "";
        });
    }
</script>
<script src="../../resources/scroll.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>

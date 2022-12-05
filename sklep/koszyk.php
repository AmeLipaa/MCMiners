<?php
session_start();
ob_start();
if(isset($_POST['logout'])){
    session_unset();
    session_destroy();
    header('location:./index.php');
}


require("../backrooms/bd-authorize.php");

$pdo = new PDO('mysql:host=' . $mysql_host . ';dbname=' . $database . ';port=' . $port, $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if(!isset($_SESSION['user'])){
    header('location:index.php');
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
        tr:hover{
            background-color: #42445A;
            color: #00FF7F;
            transition: 0.3s;
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
        $time = time();
        try{
            $pdo = new PDO('mysql:host=' . $mysql_host . ';dbname=' . $database . ';port=' . $port, $username, $password);

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->query('SELECT nick FROM klienci WHERE id_klienta LIKE "'.$_SESSION['user'].'"');
            foreach ($stmt as $row) {
                if(date('H', $time) > 18 || date('H', $time) < 5) {
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
		
		<?php 
try{
    $pdo = new PDO('mysql:host=' . $mysql_host . ';dbname=' . $database . ';port=' . $port, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	if (isset($_POST['usun'])) {
		unset($_SESSION['produkty']);
		unset($_SESSION['ilosci']);

} 

			  		  
	} catch(PDOException $e) {
        echo '😵';}
?>
        
    </div>
    <div class="separator"></div>
    <div class="container-fluid">
    <h3> Koszyk </h3>
    
        <?php 
        try{
            $pdo = new PDO('mysql:host=' . $mysql_host . ';dbname=' . $database . ';port=' . $port, $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           
			
			if (empty($_SESSION['produkty'])){
				echo '<h2>Koszyk jest pusty. :^(</h2>';
			}
			else {
				echo'<table>
				<th> Nazwa produktu </th>
				<th> Cena </th>
				<th> Ilość </th>';
					 $ilosci=array();
				$y =0;
				foreach($_SESSION['ilosci'] as $i){
					$y++;
					$ilosci[$y]=$i;
				}
				$x =0;
				
				echo'<form method="post">';
				
				foreach ($_SESSION['produkty'] as $key) {
				
					
				
					$stmt = $pdo->query('SELECT nazwa,cena FROM produkty WHERE id_produktu LIKE "'.$key.'"');
					echo "<tr>";
					$x++;
					foreach ($stmt as $row) {
						echo "<td>".$row['nazwa']."</td>";
						echo "<td>".$row['cena']."</td>";
						echo "<td>".$ilosci[$x]."</td>";
					}
					echo '<td><button type="submit" name="'.$key.'" value="'.$key.'" class="btn btn-outline-primary text-center" style="width:30%;margin: 0px auto;font-size:18px;">Usuń produkt</button></td></tr>';
				
				 
				
				}
				echo'</form>';
				if (isset($_POST[$key])) {
		unset($_SESSION['produkty'][$key]);
		unset($_SESSION['ilosci'][$key]);

}
				
				echo'</table>
<form method="post">
<button type="submit" name="usun" value="usun" class="btn btn-outline-primary text-center" style="width:10%;margin: 0px auto;font-size:18px;">Wyczyść koszyk</button>
<a class="btn btn-outline-primary text-center" style="width:10%;margin: 0px auto;font-size:18px;" data-bs-toggle="modal" data-bs-target="#staticBackdrop3">Przejdź do transakcji</a>
</form>';
			}
                
        } catch(PDOException $e) {
            echo '😵';
        }
?>




</div>
<form method="post">
  <div class="modal fade" id="staticBackdrop3" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
      <h4 class="modal-title" id="staticBackdropLabel">Zakup przedmiotu</h4>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color:rgba(0, 255, 127, 0.75);"></button>
      </div>
      <div class="modal-body">
  <div class="col-75">
    <div class="container">
      <form action="/action_page.php">
        <div class="row">
          <div class="col-50">
            <h3>Dane</h3>
            <label for="fname"><i class="fa fa-user"></i> Imię i nazwisko</label>
            <input type="text" id="fname" name="firstname" placeholder=""><br>
            <label for="email"><i class="fa fa-envelope"></i> Email</label>
            <input type="text" id="email" name="email" placeholder=""><br>
            <label for="email"><i class="fa fa-envelope"></i> Nick</label>
            <input type="text" id="nick" name="nick" placeholder=""><br>
          </div>
          <div class="col-50">
            <h3>Płatność</h3>
            <label for="ccnum">Numer karty</label>
            <input type="text" id="ccnum" name="cardnumber" placeholder="1111-2222-3333-4444"><br>
            <label for="expmonth">Data wygaśnięcia</label>
            <input type="text" id="expmonth" name="expmonth" placeholder="MM/YY"><br>
            <label for="cvv">CVV</label>
            <input type="text" id="cvv" name="cvv" placeholder="***"><br>
            </div>
          </div>
        </div>
        <label>
          <input type="checkbox" checked="checked" name="sameadr"> Wyślij potwierdzenie zakupu na email
        </label><br>
        <button type="submit" class="btn btn-outline-primary text-center" style="width:25%;margin: 0px auto;font-size:18px;" name="zakup">Kup produkt</button>
      </form>
    </div>
  </div>
</div>
</div>
</div>
</form>
<script src="../resources/scroll.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
<?php
session_start();
ob_start();

require("../../backrooms/bd-authorize.php");

function Check(){
    if(isset($_SESSION['user'])) {
        header('location:panel.php');
    }
}
Check();
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


    <style>
        body{
            background: repeat url("../../resources/bg2.png");
            color: white;
            position: relative;
        }
        h1{
            font-family: 'Work Sans', sans-serif;
        }
        #title{
            font-family: 'Mukta', sans-serif;
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
        .navbar-dark .navbar-nav .nav-link{
            font-family: 'Nunito', sans-serif;
            font-size: 22px;
            color: white;
        }
        .navbar-dark{
            background: repeat url("../../resources/dirt.jpg");
        }
        .scrolled-down{
            transform:translateY(-100%); transition: all 0.3s ease-in-out;
        }
        .scrolled-up{
            transform:translateY(0); transition: all 0.3s ease-in-out;
        }
        footer{
            text-align:center;
            color:white;
            margin-top: auto;
        }
        .btn:focus{
            box-shadow: 0 0 0 .25rem rgba(0, 179, 89,.5) !important;
        }
        .btn-primary:active{
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
            text-align: center;
            margin: 0px auto 50px auto;
            display: block;
        }
        .alert{
            margin-bottom: 0 !important;
        }
        form{
            text-align: center;
            margin: 50px 50px 10px 50px;
        }
        a{
            text-decoration: none !important;
        }
        .animlogo {
            display: block;
            margin-left: auto;
            margin-right: auto;
            margin-top: 50px;
            width: 175px;
            -webkit-animation: pulse 5s linear infinite ;
            animation: pulse 5s linear infinite ;
        }
        @-webkit-keyframes pulse {
            from {
                -webkit-transform: scale(1);
                transform: scale(1);
                -webkit-transform-origin: center center;
                transform-origin: center center;
                -webkit-animation-timing-function: ease-out;
                animation-timing-function: ease-out;
            }
            25% {
                -webkit-transform: scale(0.91);
                transform: scale(0.91);
                -webkit-animation-timing-function: ease-in;
                animation-timing-function: ease-in;
            }
            50% {
                -webkit-transform: scale(0.98);
                transform: scale(0.98);
                -webkit-animation-timing-function: ease-out;
                animation-timing-function: ease-out;
            }
            75% {
                -webkit-transform: scale(0.87);
                transform: scale(0.87);
                -webkit-animation-timing-function: ease-in;
                animation-timing-function: ease-in;
            }
            100% {
                -webkit-transform: scale(1);
                transform: scale(1);
                -webkit-animation-timing-function: ease-out;
                animation-timing-function: ease-out;
            }
        }
        @keyframes pulse {
            from {
                -webkit-transform: scale(1);
                transform: scale(1);
                -webkit-transform-origin: center center;
                transform-origin: center center;
                -webkit-animation-timing-function: ease-out;
                animation-timing-function: ease-out;
            }
            25% {
                -webkit-transform: scale(0.91);
                transform: scale(0.91);
                -webkit-animation-timing-function: ease-in;
                animation-timing-function: ease-in;
            }
            50% {
                -webkit-transform: scale(0.98);
                transform: scale(0.98);
                -webkit-animation-timing-function: ease-out;
                animation-timing-function: ease-out;
            }
            75% {
                -webkit-transform: scale(0.87);
                transform: scale(0.87);
                -webkit-animation-timing-function: ease-in;
                animation-timing-function: ease-in;
            }
            100% {
                -webkit-transform: scale(1);
                transform: scale(1);
                -webkit-animation-timing-function: ease-out;
                animation-timing-function: ease-out;
            }
        }

    </style>

</head>
<body data-bs-spy="scroll" data-bs-target="#navigacja">
<?php
if (isset($_POST["signup"])) {

    $nick = $_POST['nick'];
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];
    $pwd2 = $_POST['pwd2'];

    try{
        $pdo = new PDO('mysql:host=' . $mysql_host . ';dbname=' . $database . ';port=' . $port, $username, $password);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->query('SELECT * FROM klienci');
        $kontrolka=0;
        foreach ($stmt as $row) {

            if($email == $row['email']){
                $kontrolka++;
                echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
				<strong>Ten adres e-mail jest już w użyciu</strong>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>';

            }
            else if ($nick == $row['nick']){
                $kontrolka++;
                echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
				<strong>Ten nick jest już w użyciu</strong>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>';
            }

        }
        $stmt->closeCursor();

        if(strlen($pwd)<6 || strlen($pwd)>30){
            $kontrolka++;
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
				<strong>Hasło musi mieć od 6 do 30 znaków</strong>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>';
        }
        else if ($pwd!=$pwd2){
            $kontrolka++;
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
				<strong>Podane hasła muszą być identyczne</strong>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>';
        }
        else if($kontrolka==0){
            $checkpwd = hash('whirlpool',$pwd);
            $stmta = $pdo->query('INSERT INTO klienci(nick,email,haslo,admin) VALUES ("'.$nick.'","'.$email.'","'.$checkpwd.'",0);');
            echo '<div class="alert alert-success d-flex align-items-center" role="alert" id="jupi">
					<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
					<div>
							Witaj na pokładzie, '.$nick.'!
					</div>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" onClick="window.location.href=window.location.href; return false;"></button>
					</div>';
            $stmta->closeCursor();
        }


        Check();
    } catch(PDOException $e) {
        echo '??';
    }
}
?>

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
                </ul>
                <div class="nav navbar-nav ms-auto w-100"></div>
            </div>
        </div>
    </nav>

    <div class="row justify-content-center">
        <div class="col-12" style="background: linear-gradient(180deg, rgba(0,0,0,0.5046219171262255) 0%, rgba(0,0,0,0.5) 90%, rgba(0,0,0,0) 100%);">
            <img src="../../resources/logo.png" class="animlogo">
            <form method="post">
                <input class="mb-2" type="text" name="nick" maxlength="48" placeholder="Nick w grze" required><br>
                <input class="mb-2" type="email" name="email" maxlength="75" placeholder="E-mail" required><br>
                <input class="mb-2" type="password" name="pwd" maxlength="30" minlength="6" placeholder="Hasło" required><br>
                <input class="mb-2" type="password" name="pwd2" maxlength="30" minlength="6" placeholder="Powtórz hasło" required><br>
                <button class="btn btn-primary" type="submit" name="signup">Zarejestruj się</button>
            </form>
            <a href="."><button class="btn btn-secondary">Mam już konto</button></a>
        </div>
    </div>

    <footer>Wdrożenie - AM 2022</footer>
</div>
<script>
    var myAlert = document.getElementById('jupi');
    if (myAlert!==null){

        myAlert.addEventListener('closed.bs.alert', function () {
            document.location.reload(true);
        })
    }
</script>
<script src="../../resources/scroll.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
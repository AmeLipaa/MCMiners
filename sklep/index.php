<?php
session_start();
ob_start();

require("../backrooms/bd-authorize.php"); //autoryzacja dostępu do bazy danych

function Check(){
    if(isset($_SESSION['user'])) {
		
		require("../backrooms/bd-authorize.php"); //autoryzacja dostępu do bazy danych
			echo'<div class="welcomediv">';
        
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
        
    echo'</div>
	<br>
	 <a href="./konto/panel.php" class="btn btn-outline-primary text-center" style="width:15%;margin: 0px auto; padding-right:10px;" data-bs-target="_self">Panel użytkownika</a>
            <a href="./konto/register.php" class="btn btn-outline-primary text-center" style="width:15%;margin: 0px auto; data-bs-target="_self">Koszyk</a>';
		
    }
	else{
		echo ' Zaloguj się lub stwórz konto <br><br>
		 <a href="./konto/index.php" class="btn btn-outline-primary text-center" style="width:15%;margin: 0px auto; padding-right:10px;" data-bs-target="_self">Zaloguj</a>
            <a href="./konto/register.php" class="btn btn-outline-primary text-center" style="width:15%;margin: 0px auto; data-bs-target="_self">Utwórz konto</a>';
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
    .row {
  display: -ms-flexbox; /* IE10 */
  display: flex;
  -ms-flex-wrap: wrap; /* IE10 */
  flex-wrap: wrap;
  margin: 0 -16px;
}

.col-25 {
  -ms-flex: 25%; /* IE10 */
  flex: 25%;
}

.col-50 {
  -ms-flex: 50%; /* IE10 */
  flex: 50%;
}

.col-75 {
  -ms-flex: 75%; /* IE10 */
  flex: 75%;
}

.col-25,
.col-50,
.col-75 {
  padding: 0 16px;
}

input[type=text] {
  width: 100%;
  margin-bottom: 20px;
  padding: 12px;
  border-radius: 3px;
}

label {
  margin-bottom: 10px;
  display: block;
}

.icon-container {
  margin-bottom: 20px;
  padding: 7px 0;
  font-size: 24px;
}

.btn {
  background-color: #04AA6D;
  color: white;
  padding: 12px;
  margin: 10px 0;
  border: none;
  width: 100%;
  border-radius: 3px;
  cursor: pointer;
  font-size: 17px;
}

.btn:hover {
  background-color: #45a049;
}

span.price {
  float: right;
  color: grey;
}

@media (max-width: 800px) {
  .row {
    flex-direction: column-reverse;
  }
  .col-25 {
    margin-bottom: 20px;
  }
}
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
    .card-title{
      font-family: 'Nunito', sans-serif;
    }
    .card{
      border-width: 0px;
    }
    .kategoria{
      padding: 40px 0;
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
  #slider{
    width:  560px;
    height:  560px;
    background-color:  rgba(0, 255, 0, 0.25);
    margin: 50px auto;
  }
  .arrow{
    position:  relative;
    top:  40%;
    width:  30px;
    height:  100px;
    background-color:  rgba(0, 0, 0, 0.35);
    color:  white;
    font-size:  26px;
    text-align:  center;
    line-height: 100px;
    user-select:  none;
  }
  #prev{
    float:  left;
    margin-left:  25px;
  }
  #next{
    float:  right;
    margin-right:  25px;
  }
  #back{
    position:  absolute;
    width:  560px;
    height:  560px;
    background-image:  url(../resources/vip.png);
    background-position:  center;
  }
  #front{
    position:  absolute;
    width:  560px;
    height:  560px;
    background-image:  url(../resources/vip.png);
    background-position:  center;
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
       <h1 class="text-center kategoria d-none d-sm-block" id="sklep" style="background-color: rgba(0, 0, 0, 0.6);">
       
	   <?php
	   
Check();
	   ?>
	   
	   
      </h1>
	              

     
      <h1 class="text-center kategoria" id="sklep" style="background-color: rgba(0, 0, 0, 0.6);">
        Wesprzyj serwer kupując w naszym sklepie
      </h1>
      <div class="row">
        <div class="col-md-4 d-flex justify-content-center produkt">
          <div class="card" style="width:400px;">
            <img class="card-img-top" src="../resources/vip.png" alt="Card image">
            <div class="card-body">
            <h3 class="card-title">Ranga VIP</h3>
            <p class="card-text" style="font-size:22px;">3.99zł/miesiąc</p>
            <a class="btn btn-outline-primary text-center" style="width:50%;margin: 0px auto;font-size:18px;" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Wybierz</a>
            </div>
          </div>
        </div>
        <div class="col-md-4 d-flex justify-content-center produkt">
          <div class="card" style="width:400px;h">
            <img class="card-img-top" src="../resources/wedit.png" alt="Card image">
            <div class="card-body">
            <h3 class="card-title">WorldEdit na Creative</h3>
            <p class="card-text" style="font-size:22px;">0.99zł/miesiąc</p>
            <a class="btn btn-outline-primary text-center" style="width:50%;margin: 0px auto;font-size:18px;" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Wybierz</a>
            </div>
          </div>
        </div>
        <div class="col-md-4 d-flex justify-content-center produkt">
          <div class="card" style="width:400px;">
            <img class="card-img-top" src="../resources/unban.png" alt="Card image">
            <div class="card-body">
            <h3 class="card-title" >Unban</h3>
            <p class="card-text" style="font-size:22px;">35.00zł/jednorazowo</p>
            <a class="btn btn-outline-primary text-center" style="width:50%;margin: 0px auto;font-size:18px;" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Wybierz</a>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4 d-flex justify-content-center produkt">
          <div class="card" style="width:400px;">
            <img class="card-img-top" src="../resources/skin.png" alt="Card image">
            <div class="card-body">
            <h3 class="card-title">Dostęp do komendy /skin</h3>
            <p class="card-text" style="font-size:22px;">0.99zł/jednorazowo</p>
            <a class="btn btn-outline-primary text-center" style="width:50%;margin: 0px auto;font-size:18px;" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Wybierz</a>
            </div>
          </div>
        </div>
        <div class="col-md-4 d-flex justify-content-center produkt">
          <div class="card" style="width:400px;">
            <img class="card-img-top" src="../resources/beta.png" alt="Card image">
            <div class="card-body">
            <h3 class="card-title">Ranga Beta Tester</h3>
            <p class="card-text" style="font-size:22px;">15.00zł/jednorazowo</p>
            <a class="btn btn-outline-primary text-center" style="width:50%;margin: 0px auto;font-size:18px;" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Wybierz</a>
            </div>
          </div>
        </div>
        <div class="col-md-4 d-flex justify-content-center produkt">
          <div class="card" style="width:400px;">
            <img class="card-img-top" src="../resources/card.png" alt="Card image">
            <div class="card-body">
            <h3 class="card-title">TBD</h3>
            <p class="card-text" style="font-size:22px;">00.00zł/miesiąc</p>
            <a class="btn btn-outline-primary text-center" style="width:50%;margin: 0px auto;font-size:18px;" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Wybierz</a>
            </div>
          </div>
        </div>
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
        
          <div class="container-fluid">
              <div class="row gx-4 gx-lg-5 align-items-center">
                  <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="https://dummyimage.com/600x700/dee2e6/6c757d.jpg" alt="..." /></div>
                  <div class="col-md-6">
                      <div class="small mb-1">Kategoria: </div> 
                      <h2 class="display-5 fw-bolder">Nazwa produktu</h1>
                      <div class="fs-5">
                          <span class="text-decoration-line-through">45.00</span>
                          <span>40.00</span>
                      </div>
                      <p class="lead">Lorem ipsum dolor sit amet consectetur adipisicing elit.  </p>
          
                      <a class="btn btn-outline-primary text-center" style="width:100%;margin: 0px auto;font-size:18px;" data-bs-toggle="modal" data-bs-target="#staticBackdrop2" class="btn btn-secondary" data-bs-dismiss="modal">Dodaj do koszyka</a>
                       
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
  <div class="modal fade" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
      <h4 class="modal-title" id="staticBackdropLabel">Zakup przedmiotu</h4>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color:rgba(0, 255, 127, 0.75);"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-75">
            <div class="container">
              <form action="/action_page.php">
                <div class="row">
                  <div class="col-50">
                    <h3>Dane</h3>
                    <label for="fname"><i class="fa fa-user"></i> Imię i nazwisko</label>
                    <input type="text" id="fname" name="firstname" placeholder="">
                    <label for="email"><i class="fa fa-envelope"></i> Email</label>
                    <input type="text" id="email" name="email" placeholder="">
                    <label for="email"><i class="fa fa-envelope"></i> Nick</label>
                    <input type="text" id="nick" name="nick" placeholder="">
                  </div>
                  <div class="col-50">
                    <h3>Płatność</h3>
                    <label for="ccnum">Numer karty</label>
                    <input type="text" id="ccnum" name="cardnumber" placeholder="1111-2222-3333-4444">
                    <label for="expmonth">Data wygaśnięcia</label>
                    <input type="text" id="expmonth" name="expmonth" placeholder="MM/YY">
                    <label for="cvv">CVV</label>
                    <input type="text" id="cvv" name="cvv" placeholder="***">
                    </div>
                  </div>
                </div>
                <label>
                  <input type="checkbox" checked="checked" name="sameadr"> Wyślij potwierdzenie zakupou na email
                </label>
                <input type="submit" value="Kup produkt" class="btn">
              </form>
            </div>
          </div>
        
          <div class="col-25">
            <div class="container">
              <h4>Koszyk
                <span class="price" style="color: lightgrey">
                  <i class="fa fa-shopping-cart"></i>
                  <b>4</b>
                </span>
              </h4>
              <p><a href="#">Produkt 1</a> <span class="price">$15</span></p>
              <p><a href="#">Produkt 2</a> <span class="price">$5</span></p>
              <p><a href="#">Produkt 3</a> <span class="price">$8</span></p>
              <hr>
              <p>Razem <span class="price" style="color:lightgray"><b>$30</b></span></p>
            </div>
          </div>
        </div>
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
  <script src="../resources/scroll.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script>
        var x = ["url(../resources/vip.png)","url(../resources/wedit.png)","url(../resources/unban.png)"];
        var y = 0; //kontrolka stop/start
        var z = 0; //aktualny obraz
        var zz = 2; //poprzedni obraz
        
        
        function strzalki(){
          if(z < 0){
            z = 2;
          }
          if(z == 3){
            z = 0;
          }
          if(zz < 0){
            zz = 2;
          }
          if(zz == 3){
            zz = 0;
          }  
          $('#front').css('background-image', x[zz]);
          $('#front').css('display', 'block');
          $('#front').fadeOut();
          $('#back').css('background-image', x[z]);
          zz = z;
          z++;
        }
        
        function zmiana(){
          if(y == 0){ //sprawdza czy kursor jest na sliderze
            strzalki();
          }
          setTimeout(zmiana, 5000);
        }
        
        
        $(document).ready(function() {
          $("#slider").mouseenter(function() {
            y = 1;
            })
          .mouseleave(function() {
            y = 0;
            });
          $("#prev").on('click',function() {
            z = z - 2;
            strzalki();
          });
          $("#next").on('click',function() {
            strzalki();
          });
        });
        zmiana();
    </script>
  </body>
</html>
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
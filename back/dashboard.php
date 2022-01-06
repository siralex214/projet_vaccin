<?php

require_once "../inclu/pdo.php";


if (!isset($_SESSION['role']) || $_SESSION['role'] === "role_USER") {
    header("Location : ../index.php");
    die();
}






?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Admin</title>
</head>

<body class="background_dashboard">
<header>
    <section class="left_header">
        <img src="../assets/img/background/mario.png" alt="logo">
    </section>
    <section class="right_header">
        <div>
            <a href="../index.php"><i class="fas fa-home"></i> Accueil</a>
            <a href="./dashboard.php"><i class="fas fa-tools"></i> Admin</a>
        </div>
    </section>
</header>
  
    <div class="wrap_dashboard">

        <div class="card1">
            <a href="users.php"><i id="icones"class="fas fa-user fa-10x "></i><p>Utilisateurs</p></a>
           
    </div>
        <div class="card2">
            <a href="vaccins.php"><i id="icones"class="fas fa-syringe fa-10x"></i> <p>Vaccins</p></a>
           
        </div>
        <div class="card3">
            <a href=""><i id="icones"class="fas fa-chart-bar fa-10x"></i><p>Statistiques</p></a>
            
        </div>
       
    </div>


</body>

</html>
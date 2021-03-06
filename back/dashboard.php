<?php

require_once "../inclu/pdo.php";


if (!isset($_SESSION['role']) || $_SESSION['role'] === "role_USER") {
    echo "<script> window.location.href = '../index.php'</script>"; /* lorsque header ("location: " ...) beug */
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
          integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <title>SOS-Vaccin | Dashboard |</title>
</head>

<body class="background_dashboard">
<header class="header_admin">
    <section class="left_header">
        <img src="../assets/img/background/mario.png" alt="logo">
    </section>
    <section class="right_header">
        <div id="">
            <nav class="nav_burger">

                <input type="checkbox" id="check">
                <label for="check" class="checkbtn">
                    <i class="fas fa-bars"></i>
                </label>

                <ul class="burger">
                    <li><a href="../index.php"><i class="fas fa-home"></i> Accueil</a></li>

                    <li><a href="../user/accueil_user.php"><i class="fas fa-book"></i>Carnet</a></li>

                    <li><a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>


                </ul>
            </nav>
        </div>
    </section>
</header>

<div class="wrap_dashboard">

    <div class="card1">
        <a href="users.php"><i id="icones" class="fas fa-user fa-10x "></i>
            <p>Utilisateurs</p></a>

    </div>
    <div class="card2">
        <a href="vaccins.php"><i id="icones" class="fas fa-syringe fa-10x"></i>
            <p>Vaccins</p></a>

    </div>
    <div class="card3">
        <a href="./Statistiques.php"><i id="icones" class="fas fa-chart-bar fa-10x"></i>
            <p>Statistiques</p></a>

    </div>

</div>


</body>

</html>
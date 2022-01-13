<?php
include('../inclu/pdo.php');

if(!isset($_SESSION['role']) || $_SESSION['role'] === "role_USER" ) {
    header("Location : ../index.php");
}


if (!empty($_GET["id"])) {
    $id = $_GET["id"];

    $requestUser = $pdo->prepare(
        "SELECT * FROM vaccins WHERE id = $id;"
    );
    $requestUser->execute();
    $vaccin = $requestUser->fetch();
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
    <title>SOS-Vaccin | Show vaccin |</title>
</head>
<body>
<header>
    <section class="left_header">
        <img src="../assets/img/background/mario.png" alt="logo">
    </section>
    <section class="right_header">
        <div>
            <a href="../index.php"><i class="fas fa-home"></i> Accueil</a>
        </div>
    </section>
</header>

        <div class="wrap_show">
                <div class="users2">
                    <h1>Profil de l'utilisateur</h1>
                    <h2><a class="retour" href="vaccins.php">Retour</a></h2>
                    <div class="contenu">
                        <p class="text_user">Id : <?php echo $vaccin['id'] ?></p>
                        <p class="prix">Utilisateur : <?php echo $vaccin['id_user'] ?> </p>
                        <p class="prix"> Nom du vaccin : <?php echo $vaccin['nom_du_vaccin'] ?></p>
                        <p class="prix">Date d'injection : <?php echo $vaccin['date_injection'] ?> </p>
                        <p class="ville">Type de vaccin : <?php echo $vaccin['type_vaccin'] ?></p>
                    </div>
                </div>
        
        </div>
</body>
</html>
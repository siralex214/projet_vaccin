<?php
require_once "inclu/function.php";
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./assets/css/style.css">
    <script src="assets/js/script.js" defer></script>
    <title>SOS-vaccin | Page d'accueil |</title>
</head>
<body>
<header>
    <section class="left_header">
        <img src="" alt="logo">
    </section>
    <section class="right_header">
        <div>
            <a href="">accueil</a>
            <a href="">Inscriptions</a>
            <a href="">Page 3</a>
            <a href="">Page 4</a>
        </div>
    </section>
</header>
<main class="wrap">
    <section class="partie_left">
        <h1>Bienvenue sur SOS-Vaccin.</h1>
        <p>SOS-Vaccin est un site qui vous permet de gérer votre carnet de vaccination. Avec SOS-Vaccin vous n'oublierez jamais d'aller vous faire vacciner. Facile d'utilisation et totalement gratuit, penchez pour la simplicité grace a SOS-Vaccin! </p>
    </section>
    <section class="partie_right">
        <form action="" method="post" enctype="multipart/form-data" class="formulaire_connexion">
            <div class="form_input">
                <label for="email">email</label>
                <input type="text" name="email" id="email">
            </div>
            <div class="form_input">
                <label for="password">mot de passe</label>
                <input type="text" name="password" id="password">
                <a class="password_forgot force_droite" href="">Mot de passe oublié?</a>
            </div>
            <input class="input_submit" type="submit" value="connexion" name="submitted">
            <div class="inscription force_droite">
                <span>Pas encore inscrit? <a href="">Cliquez ici</a></span>
            </div>
        </form>
    </section>
</main>
<footer>
    <div>
        <a href="">Contact</a>
        <a href="./mentions.php">Mentions légales</a>
        <a href="">Les vaccins</a>
        <a href="">FAQ</a>
    </div>
</footer>
</body>
</html>
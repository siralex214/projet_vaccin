<?php
require_once  "../inclu/pdo.php";
require_once "../inclu/function.php";
if (empty($_SESSION)) {
    header("location: ../index.php");
    die();
}
if (empty($_GET['id'])) {
    header("location: ./accueil_user.php?id=" . $_SESSION['id']);
    die();
}
if ($_SESSION['id'] != $_GET['id']) {
    header("location: ./accueil_user.php?id=" . $_SESSION['id']);
    die();
}

$info_user = $pdo->prepare("SELECT * FROM users where id =". $_SESSION['id']);
$info_user->execute();
$info_user = $info_user->fetch();
debug($info_user);
$date = new DateTime($info_user['date_de_naissance']);
$date = $date->format("d-m-Y");

  $dateNaissance = $info_user['date_de_naissance'];
  $aujourdhui = date("Y-m-d");
  $diff = date_diff(date_create($dateNaissance), date_create($aujourdhui));
  $age = $diff->format('%y');

  $id = $_SESSION['id'];
  $last_vaccin = $pdo->prepare("SELECT * FROM vaccins WHERE id_user = $id ORDER BY date_injection DESC LIMIT 3");
  $last_vaccin->execute();
  $last_vaccin = $last_vaccin->fetchAll();
  debug($last_vaccin);
?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../assets/js/script.js" defer></script>
    <title>SOS-vaccin | Mon carnet |</title>
</head>

<body>
    <?php include_once "./inclu/header.php"; ?>
    <main class="main_accueil_user">
    <section class="wrap_accueil_user">
        <div class="all_button">
            <button id="button1">Accueil</button>
            <button id="button2">Mes informations</button>
            <button id="button3">Mon carnet de vaccination</button>
        </div>
        <p id="coucou"></p>
        <div>
            <div id="block1" class="one_box d_on">
                <div class="last_vaccin">
                    <h2>Bonjour <?php if ($info_user['sexe'] == "femme") {echo "Madame";} else {echo "Monsieur";} echo " " . ucfirst($info_user['nom'])?></h2>
                    <h3 style="margin-bottom: 0.5rem">Mes derniers vaccins</h3>
                    <ul>
                        <?php foreach ($last_vaccin as $vaccin) :
                            $date = new DateTime($vaccin['date_injection']);
                            $vaccin['date_injection'] = $date->format("d-m-Y"); ?>
                            <li style="margin-bottom: 0.5rem;">Vaccinné contre: <span style="color: white"><?= $vaccin['nom_du_vaccin']?></span>. Le <span style="color: white"><?= $vaccin['date_injection'] ?></span></li>
                        <?php endforeach; ?>
                        <li ><a style="color: blue; text-decoration: underline black" href="">Voir tous mes vaccins</a></li>
                    </ul>
                </div>
            </div>
            <div id="block2" class="one_box cacher">
                <h2>Mes informations personelles</h2>
                <div style="display: flex;flex-direction: column;justify-content: space-around;align-items: center">
                    <p>Nom: <?= ucfirst($info_user['nom']) ?></p>
                    <p>Prénom: <?= ucfirst($info_user['prenom']) ?></p>
                    <p>Age: <?= $info_user['date_de_naissance'] ?> (<?= $age ?> ans)</p>
                    <p>Email: <?= $info_user['email']?></p>
                </div>
            </div>
            <div id="block3" class="one_box cacher">3</div>
        </div>
    </section>
    </main>
    <?php include_once "./inclu/footer.php"; ?>
</body>

</html>
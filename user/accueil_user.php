<?php
require_once "../inclu/pdo.php";
require_once "../inclu/function.php";


if (empty($_SESSION['connecter'])) {
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

$info_user = $pdo->prepare("SELECT * FROM users where id =" . $_SESSION['id']);
$info_user->execute();
$info_user = $info_user->fetch();
$date = new DateTime($info_user['date_de_naissance']);
$date_naissance = $date->format("d-m-Y");

$dateNaissance = $info_user['date_de_naissance'];
$aujourdhui = date("Y-m-d");
$diff = date_diff(date_create($dateNaissance), date_create($aujourdhui));
$age = $diff->format('%y-%m-%d');

$id = $_SESSION['id'];
$last_vaccin = $pdo->prepare("SELECT * FROM vaccins WHERE id_user = $id ORDER BY date_injection asc LIMIT 3");
$last_vaccin->execute();
$last_vaccin = $last_vaccin->fetchAll();
?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
          integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
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
                    <h2>Bonjour <?php if ($info_user['sexe'] == "femme") {
                            echo "Madame";
                        } else {
                            echo "Monsieur";
                        }
                        echo " " . ucfirst($info_user['nom']) ?></h2>
                    <h3 class="titre_3">Mes derniers vaccins</h3>
                    <ul>
                        <?php foreach ($last_vaccin as $vaccin) :
                            $date = new DateTime($vaccin['date_injection']);
                            $vaccin['date_injection'] = $date->format("d-m-Y"); ?>
                            <li style="margin-bottom: 0.5rem;">Vaccinné contre: <span
                                        style="color: white"><?= $vaccin['nom_du_vaccin'] ?></span>. Le <span
                                        style="color: white"><?= $vaccin['date_injection'] ?></span></li>
                        <?php endforeach; ?>
                        <li><a style="color: blue; text-decoration: underline black"
                               href="<?php echo "./show_all_vaccin.php?id=" . $_SESSION['id'] ?>">Voir tous mes
                                vaccins</a></li>
                    </ul>
                </div>
                <div class="prochain_vaccins">
                    <h3 class="titre_3">Mes prochaines vaccinations:</h3>
                    <ul>
                        <?php foreach ($last_vaccin as $vaccin) :
                            $date_injection = new DateTime($vaccin['date_injection']);

                            $date_injection->add(new DateInterval('P10M'));               //Où 'P10M' indique 'Période de 10 Mois'

                            $date_rappel = $date_injection->format('d-m-Y');               // date du prochain vaccin

                            $date_injection->sub(new DateInterval('P20D'));               // supprime 20 jours pour permettre de faire un rappel par mail

                            $limite_rappel = $date_injection->format('d-m-Y');             //stockage du jour du jour du rappel de vaccination

                            $aujourdhui_format_fr = date("d-m-Y");                         // récupere la date d'aujourd'hui au format FR

                            $aujourdhui_format_fr = strtotime($aujourdhui_format_fr);             // transforme le jour en timestamp


                            $limite_rappel = strtotime($limite_rappel);                            // transforme le jour en timestamp

                            if ($aujourdhui_format_fr >= $limite_rappel) {

                                $dest = "sosvaccin@gmail.com";
                                $sujet = "Rappel de vaccination";
                                $corp = "Bonjour,
                                Ceci est un mail automatique, merci de ne pas répondre.
                                
                                    Vous êtes éligible pour effectuer une nouvelle dose de vaccin contre: ". $vaccin['type_vaccin']."
                                    Rendez vous sur: http://localhost/projet_vaccin/index.php pour plus d'information.";
                                $headers = "From: sosvaccin@gmail.com";
                                if (mail($dest, $sujet, $corp, $headers)) {
                                    echo "Email envoyé avec succès à $dest ...";
                                } else {
                                    echo "Échec de l'envoi de l'email...";
                                }
                            }
                            ?>
                            <li style="margin-bottom: 0.5rem">Prochaine vaccination le: <span
                                        style="color: white"> <?= $date_rappel ?></span> contre: <span
                                        style="color: white"><?= $vaccin ['type_vaccin'] ?></span></li>
                        <?php endforeach; ?>
                        <li><a style="color: blue; text-decoration: underline black" href="">Voir tous mes rappels de
                                vaccinations.</a></li>
                    </ul>
                </div>
            </div>
            <div id="block2" class="one_box cacher">
                <h2>Mes informations personelles</h2>
                <div style="display: flex;flex-direction: column;justify-content: space-around;align-items: center">
                    <p>Nom: <?= ucfirst($info_user['nom']) ?></p>
                    <p>Prénom: <?= ucfirst($info_user['prenom']) ?></p>
                    <p>Age: <?= $date_naissance ?> (<?= $age ?> ans)</p>
                    <p>Email: <?= $info_user['email'] ?></p>
                    <p style="font-size:1rem ;margin-top: 0.5rem"><a
                                style="color: blue; text-decoration: underline black" href="">Modifier les informations
                            personnelles.</a></p>
                </div>
            </div>
            <div id="block3" class="one_box cacher">3</div>
        </div>
    </section>
</main>
<?php include_once "./inclu/footer.php"; ?>
</body>

</html>
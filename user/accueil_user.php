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
$age = $diff->format('%y');

$id = $_SESSION['id'];
$last_vaccin = $pdo->prepare("SELECT * FROM vaccins WHERE id_user = $id ORDER BY date_injection asc LIMIT 3");
$last_vaccin->execute();
$last_vaccin = $last_vaccin->fetchAll();

if (!empty($_POST['submitted'])) {
    debug($_POST);
    foreach ($_POST as $key => $value) {
        $_POST[$key] = xss($value);
    }
// gestion des erreurs
    $errors = [];
    $errors = validText($errors, $_POST['type_vaccin'], 'nom', 1, 100);
    $errors = validText($errors, $_POST['nom_vaccin'], 'prenom', 1, 100);
    $errors = verif_empty("date_injection", $errors);

    if (count($errors) === 0) {
// traitement pdo
        $id_user = ($_SESSION['id']);
        $sql = "INSERT INTO `vaccins`(`id_user`, `nom_du_vaccin`, `date_injection`, `type_vaccin`) VALUES (:id_user,:nom_vaccin,:date_injection,:type_vaccin)";
        $query = $pdo->prepare($sql);
        $query->bindValue(':type_vaccin', $_POST['type_vaccin'], PDO::PARAM_STR);
        $query->bindValue(':nom_vaccin', $_POST['nom_vaccin'], PDO::PARAM_STR);
        $query->bindValue(':date_injection', $_POST['date_injection']);
        $query->bindValue(":id_user",$id_user,PDO::PARAM_STR);
        $query->execute();
        header("location: show_all_vaccin.php");
    }
}

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
            <button id="button3">Ajouter un Vaccin</button>
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
                        <?php if (!$last_vaccin){ ?>
                            <p style="color: white">Aucun vaccin enregistré</p>
                        <?php } ?>
                        <?php foreach ($last_vaccin as $vaccin) :
                            $date = new DateTime($vaccin['date_injection']);
                            $vaccin['date_injection'] = $date->format("d-m-Y"); ?>
                            <li style="margin-bottom: 0.5rem;">Vaccinné contre: <span
                                        style="color: white"><?= $vaccin['nom_du_vaccin'] ?></span>. Le <span
                                        style="color: white"><?= $vaccin['date_injection'] ?></span></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="prochain_vaccins">
                    <h3 class="titre_3">Mes prochaines vaccinations:</h3>
                    <ul>
                        <?php if (!$last_vaccin){ ?>
                            <p style="color: white">Aucun vaccin enregistré</p>
                       <?php } ?>
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
//                                if (mail($dest, $sujet, $corp, $headers)) {
//                                } else {
//                                }
                            }
                            ?>
                            <li style="margin-bottom: 0.5rem">Prochaine vaccination le: <span
                                        style="color: white"> <?= $date_rappel ?></span> contre: <span
                                        style="color: white"><?= $vaccin ['type_vaccin'] ?></span></li>
                        <?php endforeach; ?>
                        <li><a style="color: blue; text-decoration: underline black"
                               href="./show_all_vaccin.php">Voir tous mes vaccins</a></li>
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
                                style="color: blue; text-decoration: underline black" href="./update_info_user.php">Modifier mes informations
                            personnelles.</a></p>
                </div>
            </div>
            <div id="block3" class="one_box cacher">
                <section class="wrap_page_inscription">
                    <form action="" method="post">
                        <div class="form_input">
                            <label for="type_vaccin">Type du vaccin</label>
                            <select name="type_vaccin" id="type_vaccin">
                                <option <?php if ($vaccin['type_vaccin'] == "la diphtérie") {echo "selected";} ?> value="la diphtérie">la diphtérie</option>
                                <option <?php if ($vaccin['type_vaccin'] == "le tétanos") {echo "selected";} ?> value="le tétanos">le tétanos</option>
                                <option <?php if ($vaccin['type_vaccin'] == "la poliomyélite") {echo "selected";} ?> value="la poliomyélite">la poliomyélite</option>
                                <option <?php if ($vaccin['type_vaccin'] == "COVID 19") {echo "selected";} ?> value="COVID 19">COVID 19</option>
                                <option <?php if ($vaccin['type_vaccin'] == "coqueluche") {echo "selected";} ?> value="coqueluche">coqueluche</option>
                                <option <?php if ($vaccin['type_vaccin'] == "Fièvre jaune") {echo "selected";} ?> value="Fièvre jaune">Fièvre jaune</option>
                                <option <?php if ($vaccin['type_vaccin'] == "Fièvre typhoïde") {echo "selected";} ?> value="Fièvre typhoïde">Fièvre typhoïde</option>
                                <option <?php if ($vaccin['type_vaccin'] == "Grippe (influenza)") {echo "selected";} ?> value="Grippe (influenza)">Grippe (influenza)</option>
                                <option <?php if ($vaccin['type_vaccin'] == "Haemophilus influenzae b") {echo "selected";} ?> value="Haemophilus influenzae b">Haemophilus influenzae b</option>
                                <option <?php if ($vaccin['type_vaccin'] == "Hépatite A") {echo "selected";} ?> value="Hépatite A">Hépatite A</option>
                                <option <?php if ($vaccin['type_vaccin'] == "Hépatite B") {echo "selected";} ?> value="Hépatite B">Hépatite B</option>
                                <option <?php if ($vaccin['type_vaccin'] == "HPV – virus du papillome humain") {echo "selected";} ?> value="HPV – virus du papillome humain">HPV – virus du papillome humain</option>
                                <option <?php if ($vaccin['type_vaccin'] == "Méningo-encéphalite à tiques") {echo "selected";} ?> value="Méningo-encéphalite à tiques">Méningo-encéphalite à tiques</option>
                                <option <?php if ($vaccin['type_vaccin'] == "Méningocoques") {echo "selected";} ?> value="Méningocoques">Méningocoques</option>
                                <option <?php if ($vaccin['type_vaccin'] == "Oreillons") {echo "selected";} ?> value="Oreillons">Oreillons</option>
                                <option <?php if ($vaccin['type_vaccin'] == "Pneumocoques") {echo "selected";} ?> value="Pneumocoques">Pneumocoques</option>
                                <option <?php if ($vaccin['type_vaccin'] == "Poliomyélite") {echo "selected";} ?> value="Poliomyélite">Poliomyélite</option>
                                <option <?php if ($vaccin['type_vaccin'] == "Rage") {echo "selected";} ?> value="Rage">Rage</option>
                                <option <?php if ($vaccin['type_vaccin'] == "Rotavirus") {echo "selected";} ?> value="Rotavirus">Rotavirus</option>
                                <option <?php if ($vaccin['type_vaccin'] == "Rougeole") {echo "selected";} ?> value="Rougeole">Rougeole</option>
                                <option <?php if ($vaccin['type_vaccin'] == "Rubéole") {echo "selected";} ?> value="Rubéole">Rubéole</option>
                                <option <?php if ($vaccin['type_vaccin'] == "Tuberculose") {echo "selected";} ?> value="Tuberculose">Tuberculose</option>
                                <option <?php if ($vaccin['type_vaccin'] == "Varicelle") {echo "selected";} ?> value="Varicelle">Varicelle</option>
                                <option <?php if ($vaccin['type_vaccin'] == "Zona (herpès zoster)") {echo "selected";} ?> value="Zona (herpès zoster)">Zona (herpès zoster)</option>
                            </select>
                        </div>
                        <div class="form_input">
                            <label for="nom_vaccin">Nom du vaccin</label>
                            <select name="nom_vaccin" id="nom_vaccin">
                                <option <?php if ($vaccin['nom_du_vaccin'] == "Boostrixtetra®"){echo "selected";} ?> value="Boostrixtetra®">Boostrixtetra®</option>
                                <option <?php if ($vaccin['nom_du_vaccin'] == "Pfizer"){echo "selected";} ?> value="Pfizer">Pfizer</option>
                                <option <?php if ($vaccin['nom_du_vaccin'] == "Moderna"){echo "selected";} ?> value="Moderna">Moderna</option>
                                <option <?php if ($vaccin['nom_du_vaccin'] == "Johnson & Johnson"){echo "selected";} ?> value="Johnson & Johnson">Johnson & Johnson</option>
                                <option <?php if ($vaccin['nom_du_vaccin'] == "Havrix 1440®"){echo "selected";} ?> value="Havrix 1440®">Havrix 1440®</option>
                                <option <?php if ($vaccin['nom_du_vaccin'] == "Havrix 720®"){echo "selected";} ?> value="Havrix 720®">Havrix 720®</option>
                                <option <?php if ($vaccin['nom_du_vaccin'] == "Efluelda®"){echo "selected";} ?> value="Efluelda®">Efluelda®</option>
                                <option <?php if ($vaccin['nom_du_vaccin'] == "Act-Hib®"){echo "selected";} ?> value="Act-Hib®">Act-Hib®</option>
                                <option <?php if ($vaccin['nom_du_vaccin'] == "Avaxim 160®"){echo "selected";} ?> value="Avaxim 160®">Avaxim 160®</option>
                                <option <?php if ($vaccin['nom_du_vaccin'] == "Avaxim 80®"){echo "selected";} ?> value="Avaxim 80®">Avaxim 80®</option>
                                <option <?php if ($vaccin['nom_du_vaccin'] == "Engerix B 10®"){echo "selected";} ?> value="Engerix B 10®">Engerix B 10®</option>
                                <option <?php if ($vaccin['nom_du_vaccin'] == "Engerix B 20®"){echo "selected";} ?> value="Engerix B 20®">Engerix B 20®</option>
                                <option <?php if ($vaccin['nom_du_vaccin'] == "Engerix B 20®"){echo "selected";} ?> value="HBVAXPRO 10®">Engerix B 20®</option>
                                <option <?php if ($vaccin['nom_du_vaccin'] == "Engerix B 20®"){echo "selected";} ?> value="HBVAXPRO 5®">Engerix B 20®</option>
                                <option <?php if ($vaccin['nom_du_vaccin'] == "Cervarix®"){echo "selected";} ?> value="Cervarix®">Cervarix®</option>
                                <option <?php if ($vaccin['nom_du_vaccin'] == "Gardasil 9®"){echo "selected";} ?> value="Gardasil 9®">Gardasil 9®</option>
                                <option <?php if ($vaccin['nom_du_vaccin'] == "Encepur 0,5 ml®"){echo "selected";} ?> value="Encepur 0,5 ml®">Encepur 0,5 ml®</option>
                                <option <?php if ($vaccin['nom_du_vaccin'] == "Hexyon®"){echo "selected";} ?> value="Hexyon®">Hexyon®</option>
                                <option <?php if ($vaccin['nom_du_vaccin'] == "Imovax Polio®"){echo "selected";} ?> value="Imovax Polio®">Imovax Polio®</option>
                                <option <?php if ($vaccin['nom_du_vaccin'] == "M-M-RVaxpro®"){echo "selected";} ?> value="M-M-RVaxpro®">M-M-RVaxpro®</option>
                                <option <?php if ($vaccin['nom_du_vaccin'] == "Pentavac®"){echo "selected";} ?> value="Pentavac®">Pentavac®</option>
                                <option <?php if ($vaccin['nom_du_vaccin'] == "Rabipur®"){echo "selected";} ?> value="Rabipur®">Rabipur®</option>
                                <option <?php if ($vaccin['nom_du_vaccin'] == "Rotarix®"){echo "selected";} ?> value="Rotarix®">Rotarix®</option>
                                <option <?php if ($vaccin['nom_du_vaccin'] == "Rotateq®"){echo "selected";} ?> value="Rotateq®">Rotateq®</option>
                                <option <?php if ($vaccin['nom_du_vaccin'] == "Stamaril®"){echo "selected";} ?> value="Stamaril®">Stamaril®</option>
                                <option <?php if ($vaccin['nom_du_vaccin'] == "Varilrix®"){echo "selected";} ?> value="Varilrix®">Varilrix®</option>
                                <option <?php if ($vaccin['nom_du_vaccin'] == "Zostavax®"){echo "selected";} ?> value="Zostavax®">Zostavax®</option>
                            </select>
                        </div>
                        <div class="form_input">
                            <label for="date_injection">Date d'injection</label>
                            <input type="datetime-local" name="date_injection" id="date_injection">
                        </div>
                        <div class="form_input">
                            <input class="input_submit submit_registration" type="submit" value="Ajouter" name="submitted">
                        </div>
                    </form>
            </div>
        </div>
    </section>
</main>
<?php include_once "./inclu/footer.php"; ?>
</body>

</html>
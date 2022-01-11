<?php
require_once "../inclu/function.php";
require_once "../inclu/pdo.php";
if (empty($_SESSION['connecter'])) {
    header("location: ../index.php");
    die();
}

// récupérer le nombre d'enregistrements
$count = $pdo->prepare("SELECT count(id) as cpt from vaccins WHERE id_user= :id");
$count->bindValue(":id", $_SESSION['id'], PDO::PARAM_INT) .
$count->execute();
$tcount = $count->fetchAll();
// pagination
@$page = $_GET['page'];
if (empty($page)) {
    $page = 1;
}
$nbre_element_par_page = 8;
$nbre_de_page = ceil($tcount[0]['cpt'] / $nbre_element_par_page);
$debut = ($page - 1) * $nbre_element_par_page;

// fin pagination


$recup_all_vaccin = $pdo->prepare("SELECT * FROM vaccins WHERE id_user = :id ORDER BY date_injection ASC limit $debut, $nbre_element_par_page");
$recup_all_vaccin->bindValue(":id", $_SESSION['id'], PDO::PARAM_INT) .
$recup_all_vaccin->execute();
$vaccins = $recup_all_vaccin->fetchAll();
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
    <title>SOS-vaccin | tous mes vaccins |</title>
</head>
<body>
<?php include_once "./inclu/header.php"; ?>
<main>

    <section class="wrap_show_vaccin">
        <a style="color: black" href="accueil_user.php"><i class="fas fa-undo"></i> retour</a>
        <div class="sous_wrap_vaccin">

            <?php foreach ($vaccins as $vaccin) :?>
            <?php $date_traitement = new DateTime($vaccin['date_injection']);
            $date_injection = $date_traitement->format("d-m-Y");
            $date_traitement->add(new DateInterval('P10M'));
            $date_rappel = $date_traitement->format("d-m-Y");?>
                <div class="one_show">
                    <h4>Nom du vaccin: <span style="color: white"><?= $vaccin['nom_du_vaccin'] ?></span></h4>
                    <p>Date d'injection: <span style="color: white"><?= $date_injection ?> </span> </p>
                    <p>Prochaine vaccination le: <span style="color: white"><?= $date_rappel ?> </span> </p>
                    <div style="font-size: 1.8rem;display: flex; justify-content: space-around;margin-top: 1rem">
                        <a style="color: red" href="./delete_vaccin.php?id=<?= $vaccin['id'] ?>"><i class="fas fa-trash-alt"></i></a>
                        <a style="color: black" href="./update_vaccin?id=<?= $vaccin['id'] ?>"><i class="far fa-edit"></i></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
            <div class="pagination">
                <?php
                if ($nbre_de_page === 1) {
                    echo 'rien';
                    die;
                } else {
                    for ($i = 1; $i <= $nbre_de_page; $i++) {
                        if ($page != $i) {
                            echo ' <a class="bouton_pagination" href="?page=' . $i . '">' . $i . '</a> ';
                        } else {
                            echo ' <a class="bouton_clicker">' . $i . '</a> ';
                        }
                    }
                }
                ?>
            </div>
    </section>


</main>
<?php include_once "./inclu/footer.php"; ?>
</body>
</html>

<?php
require_once "../inclu/function.php";
require_once "../inclu/pdo.php";
$id = $_SESSION['id'];
$sup = false;
$verif_exist = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$verif_exist->bindValue(":id", $id, PDO::PARAM_INT);
$verif_exist->execute();
$user = $verif_exist->fetch();
if (!$user) {
    header("location: ./accueil_user.php");
    die();
}
if (!empty($_GET['sup']) == "true") {
    $sup = true;
}

if ($sup == true) {
    $delete_vaccin = $pdo->prepare("DELETE FROM vaccins WHERE id_user = :id");
    $delete_vaccin->bindValue(":id", $id, PDO::PARAM_INT);
    $delete_vaccin->execute();
    $delete_user = $pdo->prepare("DELETE FROM users WHERE id = :id");;
    $delete_user->bindValue(":id", $id, PDO::PARAM_INT);
    $delete_user->execute();
    $sup = false;
    session_unset();
    header("location: ../index.php");
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
    <title>SOS-vaccin | Supprimer mon compte |</title>
</head>
<body>
<?php include_once "./inclu/header.php";
if ($sup == false) { ?>
    <main style="text-align: center">
        <h2>Voulez vous vraiment supprimer votre compte?</h2>
        <div style="color: black; margin-top: 1rem">
            <a style="color: blue; text-decoration: underline black; margin-right: 1rem"
               href="./delete_user.php?sup=true">OUI</a>
            <a style="color: blue; text-decoration: underline black;" href="./delete_user.php?sup=false">NON</a>
        </div>
    </main>
<?php } else { ?>
    <main style="text-align: center">
        <h2>Votre compte à bien été supprimer.</h2>
    </main>

    <?php
}
include_once "./inclu/footer.php"; ?>
</body>
</html>

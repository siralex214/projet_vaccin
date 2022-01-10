<?php
require_once "../inclu/function.php";
require_once "../inclu/pdo.php";
if (empty($_SESSION['connecter'])) {
    header("location: ../index.php");
    die();
}
if (empty($_GET['id'])) {
    header("location: ./show_all_vaccin.php?id=" . $_SESSION['id']);
    die();
}
if ($_SESSION['id'] != $_GET['id']) {
    header("location: ./show_all_vaccin.php?id=" . $_SESSION['id']);
    die();
}

$recup_all_vaccin = $pdo->prepare("SELECT * FROM vaccins WHERE id_user = :id");
$recup_all_vaccin->bindValue(":id",$_SESSION['id'],PDO::PARAM_INT).
$recup_all_vaccin->execute();
$vaccins = $recup_all_vaccin->fetchAll();
debug($vaccins);
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>SOS-vaccin | tous mes vaccins |</title>
</head>
<body>
<?php include_once "./inclu/header.php"; ?>
<main></main>
<?php include_once "./inclu/footer.php"; ?>
</body>
</html>

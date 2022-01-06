<?php
require_once  "../inclu/pdo.php";
require_once "../inclu/function.php";
if (empty($_SESSION)) {
    header("location: ../index.php");
    die();
}
if (empty($_GET['id'])){
    header("location: ./accueil_user.php?id=".$_SESSION['id']);
    die();
}
if ($_SESSION['id'] != $_GET['id']) {
    header("location: ./accueil_user.php?id=".$_SESSION['id']);
    die();
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>SOS-vaccin | Mon carnet |</title>
</head>
<body>
<?php include_once "./inclu/header.php"; ?>
<main></main>
<?php include_once "./inclu/footer.php"; ?>
</body>
</html>

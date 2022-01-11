<?php
require_once "../inclu/pdo.php";
require_once "../inclu/function.php";
$verif = $pdo->prepare("SELECT * FROM vaccins WHERE id_user = :id_user AND id= :id");
$verif->bindValue(":id_user",$_SESSION['id'],PDO::PARAM_STR);
$verif->bindValue(":id",$_GET['id'],PDO::PARAM_STR);
$verif->execute();
$verif = $verif->fetch();

if (!empty($verif)){
$suppression = $pdo->prepare("DELETE FROM vaccins WHERE id_user = :id_user AND id= :id");
$suppression->bindValue(":id_user",$_SESSION['id'],PDO::PARAM_INT);
$suppression->bindValue(":id",$_GET['id'],PDO::PARAM_INT);
$suppression->execute();
header("location: ./show_all_vaccin.php");

} else {
    echo "<h2 style='font-size: 3rem'> erreur lors de la suppression!</h2>
<a href='./show_all_vaccin.php'>Retour</a>";
}
?>
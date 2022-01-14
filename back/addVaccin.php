<?php

require_once "../inclu/pdo.php";
require_once "../inclu/function.php";



if(!isset($_SESSION['role']) || $_SESSION['role'] === "ROLE_USER"){
    header("Location : ../index.php");
}
if (
    empty($_POST["nom_du_vaccin"]) || empty($_POST["date"])
    || empty($_POST["type_vaccin"])
) {
    $error = true;
} else {
    //$session_id = $_SESSION["id"];
        $user = $_POST["id_user"];
        $nomVaccin = $_POST["nom_du_vaccin"];
        $date = $_POST["date"];
        $typeVaccin = $_POST["type_vaccin"];
      
        $requestCreation = $pdo->prepare(

        "INSERT INTO `vaccins`(`id_user`,`nom_du_vaccin`, `date_injection`, `type_vaccin` ) 
            VALUES ($user,'$nomVaccin', '$date','$typeVaccin')"
    );
    if ($requestCreation->execute()) {
        header('Location: vaccins.php');
    } else {
        echo "Erreur Execution Requête";
    }
}






    
    $query = $pdo->prepare("SELECT id, nom, prenom FROM users");
    $query->execute();
    $users = $query->fetchAll();
  




?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>SOS-Vaccin | Ajout vaccin |</title>
</head>

<body>


<header class="header_admin">
    <section class="left_header">
        <img src="../assets/img/background/mario.png" alt="logo">
    </section>
    <section class="right_header">
        <div>
            <a href="../index.php"><i class="fas fa-home"></i> Accueil</a>
        </div>
    </section>
</header>
    <div class="wrap_bloc">
        <div class="wrap_contact">
        <h2 class="back_button"><a class="" href="vaccins.php">Retour</a></h2>
            <h2>Ajout des vaccins</h2>
            <form action="" method="post" id="formulaire_general" class="form_admin">



                <label for="">ID Utilisateur</label>
                            <select name="id_user" id="">
                            <?php foreach ($users as $user) { ?>

                            <option value="<?= $user['id'] ?>"><?php echo $user['nom']. ' ' . $user['prenom']?></option>
                        
                            <?php } ?>
                        </select> 





                 <label for="">Nom du virus</label>
                <select name="nom_du_vaccin" id="">
                <option value="">Choisir une option</option>
                <option value="Covid">Covid</option>
                <option value="Grippe">Grippe</option>
                <option value="Tétanos">Tétanos</option>
                <option value="Diphtérie"> Diphtérie</option>
                <option value="Poliomyélite"> Poliomyélite</option>
                </select>

                <label for="date_injection">Date d'injection</label>
                <input type="date" name="date" id="date">

                <label for="">Nom du laboratoire</label>
                <select name="type_vaccin" id="">
                <option value="">Choisir une option</option>
                <option value="Pfizer">Pfizer</option>
                <option value="Moderna">Moderna</option>
                <option value="Sanofi Pasteur">Sanofi Pasteur</option>
                <option value="Johnson & Johnson">Johnson & Johnson</option>
                <option value="BioNTech"> BioNTech</option>
                </select>
               


              
                <input class="bouton" type="submit" value="Envoyer" name="submit">
            </div>

        </form>
    </div>


</body>

</html>
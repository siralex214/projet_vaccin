<?php

require_once "../inclu/pdo.php";



if(!isset($_SESSION['role']) || $_SESSION['role'] === "ROLE_USER"){
    header("Location : ../index.php");
}
if (
    empty($_POST["role"]) || empty($_POST["nom"])
    || empty($_POST["prenom"]) || empty($_POST["date_de_naissance"])
    || empty($_POST["email"]) || empty($_POST["pwd"]) 
) {
    $error = true;
} else {
    //$session_id = $_SESSION["id"];
        $role = $_POST["role"];
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $date = $_POST["date_de_naissance"];
        $email = $_POST["email"];
        $pwd = $_POST["pwd"];
        $requestCreation = $pdo->prepare(

        "INSERT INTO `users`(`role`, `nom`, `prenom`, `date_de_naissance`, `email`, `pwd` ) 
            VALUES ('$role', '$nom','$prenom','$date','$email','$pwd')"
    );
    if ($requestCreation->execute()) {
        header('Location: users.php');
    } else {
        echo "Erreur Execution Requête";
    }
}



?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>SOS-Vaccin | Ajout utilisateur |</title>
</head>

<body>


<header>
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
        <h2 class="back_button"><a class="" href="users.php">Retour</a></h2>
            <h2>Ajout d'utilisateurs</h2>
            <form action="#" method="post" id="formulaire_general">

                 <label for="">Role</label>
                <select name="role" id="">
                <option value="">Choisir une option</option>
                <option value="role_USER">Utilisateur</option>
                <option value="role_ ADMIN">Admin</option>
                </select>

                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom">
                <span class="error"><?php if($error) { echo "Veuillez renseigner ce champ";}?></span>

                <label for="prenom">Prenom</label>
                <input type="text" name="prenom" id="prenom">

                <label for="date">Date</label>
                <input type="date" name="date_de_naissance" id="date">

                
                <label for="email">Email</label>
                <input type="email" name="email" id="email">

                
                <label for="pwd">Mot de passe</label>
                <input type="password" name="pwd" id="pwd">

              
                <input class="bouton" type="submit" value="Envoyer" name="submit">
            </div>

        </form>
    </div>


</body>

</html>
<?php 

/* session_start();
if (!isset($_SESSION['id']))
{
    header("Location: index.php");
    die();
} */  

include('../inclu/pdo.php');

if(isset($_GET['id'])) {

    $id = $_GET['id'];
    
    $query = $pdo->prepare("SELECT * FROM users WHERE id = $id");
    $query->execute();
    $users = $query->fetch();
}


if (!empty($_POST)) {
    if (
        empty($_POST["nom"]) || empty($_POST["prenom"])
        || empty($_POST["date_de_naissance"]) || empty($_POST["email"])
        
    ) {
        $error = true;
    } else {

        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $date = $_POST["date_de_naissance"];
        $email = $_POST["email"];

        $requestCreation = $pdo->prepare(
            "UPDATE users SET nom= '$nom', prenom = '$prenom', date_de_naissance = '$date', email = '$email'  WHERE id = $id"
        ); 

        // UPDATE `users` SET `nom`='[test]',`prenom`='[Marcus]',`email`='[marcus27@gmail.com]',`pwd`='[marcus1234]' WHERE id = 2
        if ($requestCreation->execute()) {
            header('Location: dashboard.php');
        } else {
            echo "Erreur Execution Requête";
        }
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
    <title>Document</title>
</head>

<body>

<header>
    <section class="left_header">
        <img src="" alt="logo">
    </section>
    <section class="right_header">
        <div>
            <a href="../index.php">accueil</a>
            <a href="">Inscriptions</a>
            <a href="">Page 3</a>
            <a href="./dashboard.php">Admin</a>
        </div>
    </section>
</header>

    <div class="wrap_update">
        <form action="#" method="post">
            <div class="range">

            <h2><a class="retour" href="dashboard.php">Retour</a></h2>
                <label for="nom">Nom</label>
                <input step="any" name="nom" id="nom" value=" <?php if(!empty($users['nom']))  { echo $users['nom']; }  ?>">

                <label for="prenom">Prenom</label>
                <input type="text" name="prenom" id="prenom" value=" <?php if(!empty($users['prenom']))  { echo $users['prenom']; }  ?>">

                <label for="date_de_naissance">Date de naissance</label>
                <input type="date" name="date_de_naissance" id="date_de_naissance" value="<?php if(!empty($users['date_de_naissance']))  { echo $users['date_de_naissance']; }  ?>">

                <label for="email">Email</label>
                <input type="text" name="email" id="email" value="<?php if(!empty($users['email']))  { echo $users['email']; }  ?>">
                
            </div>

            <input class="bouton" type="submit" value="Envoyer" name="submit">
        
        </form>
    </div>

    
   
</body>

</html>
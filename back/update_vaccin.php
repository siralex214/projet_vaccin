<?php 

/* session_start();
if (!isset($_SESSION['id']))
{
    header("Location: index.php");
    die();
} */  

include('../inclu/pdo.php');


if(!isset($_SESSION['role']) || $_SESSION['role'] === "role_USER" ) {
    header("Location : ../index.php");
}


if(isset($_GET['id'])) {

    $id = $_GET['id'];
    
    $query = $pdo->prepare("SELECT * FROM vaccins WHERE id = $id");
    $query->execute();
    $vaccins = $query->fetch();
}


if (!empty($_POST)) {
    if (
        empty($_POST["nom_du_vaccin"]) || empty($_POST["date_injection"])
        || empty($_POST["type_vaccin"]) 
        
    ) {
        $error = true;
    } else {

        $nom = $_POST["nom_du_vaccin"];
        $date = $_POST["date_injection"];
        $type = $_POST["type_vaccin"];
        

        $requestCreation = $pdo->prepare(
            "UPDATE vaccins SET nom_du_vaccin= '$nom', date_injection = '$date',  type_vaccin = '$type'  WHERE id = $id"
        ); 

        
        if ($requestCreation->execute()) {
            header('Location: vaccins.php.');
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
    <title>SOS-Vaccin | Update vaccin |</title>
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

    <div class="wrap_update">
        <form action="#" method="post" id="formulaire_general">
            <div class="range">
        <h1>Modification du profil</h1>
            <h2><a class="retour" href="vaccins.php">Retour</a></h2>
                <label for="nom_du_vaccin">Nom</label>
                <input step="any" name="nom_du_vaccin" id="nom_du_vaccin" value=" <?php if(!empty($vaccins['nom_du_vaccin']))  { echo $vaccins['nom_du_vaccin']; }  ?>">

                <label for="date_injection">Date d'injection</label>
                <input type="date" name="date_injection" id="date_injection" value=" <?php if(!empty($vaccins['date_injection']))  { echo $vaccins['date_injection']; }  ?>">

                <label for="type_vaccin">Type de vaccin</label>
                <input type="text" name="type_vaccin" id="type_vaccin" value="<?php if(!empty($vaccins['type_vaccin']))  { echo $vaccins['type_vaccin']; }  ?>">

                
            </div>

            <input class="bouton" type="submit" value="Envoyer" name="submit">
        
        </form>
    </div>

    
   
</body>

</html>
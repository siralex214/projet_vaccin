<?php 

/* session_start();
if (!isset($_SESSION['id']))
{
    header("Location: index.php");
    die();
} */  

include('../inclu/pdo.php');
include('../inclu/function.php');


if(!isset($_SESSION['role']) || $_SESSION['role'] === "role_USER" ) {
    header("Location : ../index.php");
}


if(isset($_GET['id'])) {

    $id = $_GET['id'];
    
    $query = $pdo->prepare("SELECT * FROM vaccins WHERE id = $id");
    $query->execute();
    $vaccin = $query->fetch();
}




if (!empty($_POST)) {
    debug($_POST);
    if (
        empty($_POST["nom_vaccin"]) || empty($_POST["date_injection"])
        || empty($_POST["type_vaccin"]) 
        
    ) {
        $error = true;
    } else {
        $nom = $_POST["nom_vaccin"];
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
                
                

                <label for="date_injection">Date d'injection</label>
                <input type="date" name="date_injection" id="date_injection" value=" <?php if(!empty($vaccins['date_injection']))  { echo $vaccins['date_injection']; }  ?>">

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

            <input class="bouton" type="submit" value="Envoyer" name="submit">
        
        </form>
    </div>

    
   
</body>

</html>
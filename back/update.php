<?php 

// TEST
require_once "../inclu/pdo.php";
require_once "../inclu/function.php";
if (!empty($_SESSION['connecter'])){
    //header('location: index.php');
}
if(isset($_GET['id'])) {

    $id = $_GET['id'];
    
    $query = $pdo->prepare("SELECT * FROM users WHERE id = $id");
    $query->execute();
    $users = $query->fetch();
}

$registration = false ;
if (!empty($_POST['submit'])) {
    foreach ($_POST as $key => $value) {
        $_POST[$key] = xss($value);
    }

    
// gestion des erreurs
    $errors = [];
    $errors = validText($errors, $_POST['nom'], 'nom', 1, 100);
    $errors = validText($errors, $_POST['prenom'], 'prenom', 1, 100);
    $errors = verif_empty('date_de_naissance',$errors,"date de naissance");
    $errors = verif_empty('sexe',$errors);
    $errors = validEmail($errors, $_POST['email'], 'email');


// detection d'un mail dejà présent dans la table
    $query = $pdo->prepare("SELECT email FROM users WHERE email = :email");
    $query->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch();
    if ($result) {
        $errors['double_mail'] = "Cet mail est déjà enregistré";
    }



  
    if (count($errors) === 0) {

// traitement pdo
        $role = $_POST["role"];
        $sexe = $_POST["sexe"];
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $date = $_POST["date_de_naissance"];
        $email = $_POST["email"];
        

        $requestCreation = $pdo->prepare(
            "UPDATE users SET   role='$role', sexe='$sexe',  nom= '$nom', prenom = '$prenom', date_de_naissance = '$date', email = '$email'  WHERE id = $id"
        ); 
        if ($requestCreation->execute()) {
            header('Location: users.php');
        } else {
            echo "Erreur Execution Requête";
        }

       
    }
}

// TEST


/* 
 include('../inclu/pdo.php');


if(!isset($_SESSION['role']) || $_SESSION['role'] === "role_USER" ) {
    header("Location : ../index.php");
}


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
            header('Location: users.php');
        } else {
            echo "Erreur Execution Requête";
        }
    }
} 
 */


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
            <h2><a class="retour" href="users.php">Retour</a></h2>

            
            <label for="">Role</label>
                <select name="role" id="">
                <option value="">Choisir une option</option>
                <option value="role_USER">Utilisateur</option>
                <option value="role_ ADMIN">Admin</option>
                </select>

                <label for="">Sexe</label>
                <select name="sexe" id="">
                <option value="">Choisir une option</option>
                <option value="Homme">Homme</option>
                <option value="Femme">Femme</option>
                <option value="Autre">Autre</option>
                <?php if (isset($errors['sexe'])) { ?>
                    <span class="error"><?php viewError($errors,'sexe')?></span>
                <?php } else { ?>
                    <span style="height: 20px"></span>
                <?php } ?>
                </select>

                <label for="nom">Nom</label>
                <input step="any" name="nom" id="nom" value=" <?php if(!empty($users['nom']))  { echo $users['nom']; }  ?>">
                <?php if (isset($errors['nom'])) { ?>
                <span class="error"><?php viewError($errors,'nom')?></span>
                <?php } else { ?>
                    <span style="height: 20px"></span>
                <?php } ?>

                <label for="prenom">Prenom</label>
                <input type="text" name="prenom" id="prenom" value=" <?php if(!empty($users['prenom']))  { echo $users['prenom']; }  ?>">
                <?php if (isset($errors['prenom'])) { ?>
                    <span class="error"><?php viewError($errors,'prenom')?></span>
                <?php } else { ?>
                    <span style="height: 20px"></span>
                <?php } ?>

                <label for="date_de_naissance">Date de naissance</label>
                <input type="date" name="date_de_naissance" id="date_de_naissance" value="<?php if(!empty($users['date_de_naissance']))  { echo $users['date_de_naissance']; }  ?>">
                <?php if (isset($errors['date_de_naissance'])) { ?>
                    <span class="error"><?php viewError($errors,'date_de_naissance')?></span>
                <?php } else { ?>
                    <span style="height: 20px"></span>
                <?php } ?>


                <label for="email">Email</label>
                <input type="text" name="email" id="email" value="<?php if(!empty($users['email']))  { echo $users['email']; }  ?>">
                <?php if (isset($errors['email'])) { ?>
                        <span class="error"><?php viewError($errors, 'email') ?></span>
                   
                    <?php } else { ?>
                        <span style="height: 20px"></span>
                    <?php } ?>
                

              

                
            </div>

            <input class="bouton" type="submit" value="Envoyer" name="submit">
        
        </form>
    </div>

    
   
</body>

</html>
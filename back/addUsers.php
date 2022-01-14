<?php


// TEST

require_once "../inclu/pdo.php";
require_once "../inclu/function.php";
if (!empty($_SESSION['connecter'])){
    //header('location: index.php');
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


//regex mdp
// var_dump($_POST['mdp']);
    $pattern = "#(?=^.{8,}$)((?=.*\d)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$#";
    if (!preg_match($pattern, $_POST['password'])) {
        $errors['password'] = "Mot de passe non réglementaire.";
    }
    if (count($errors) === 0) {
//hash password
        $mdp = password_hash($_POST['password'], PASSWORD_ARGON2I);
// traitement pdo
        $sql = "INSERT INTO `users`(`role`, `nom`, `prenom`, `date_de_naissance`, `email`, `pwd`,`sexe`) VALUES (:role, :nom, :prenom, :date_de_naissance, :mail ,:mdp, :sexe) ";
        $query = $pdo->prepare($sql);
        $query->bindValue(':role', "role_USER", PDO::PARAM_STR);
        $query->bindValue(':nom', $_POST['nom'], PDO::PARAM_STR);
        $query->bindValue(':prenom', $_POST['prenom'], PDO::PARAM_STR);
        $query->bindValue(':date_de_naissance', $_POST['date_de_naissance'], PDO::PARAM_STR);
        $query->bindValue(':mail', $_POST['email'], PDO::PARAM_STR);
        $query->bindValue(':mdp', $mdp, PDO::PARAM_STR);
        $query->bindValue(':sexe', $_POST['sexe'], PDO::PARAM_STR);
        $query->execute();
        $registration = true;

        header('location: users.php');
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
        <h2 class="back_button"><a class="" href="users.php">Retour</a></h2>
            <h2>Ajout d'utilisateurs</h2>
            <form action="#" method="post" id="formulaire_general" class="form_admin">

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
                <input type="text" name="nom" id="nom" value="<?php if (!empty($_POST['nom'])){ echo $_POST['nom'];} ?>">
                <?php if (isset($errors['nom'])) { ?>
                <span class="error"><?php viewError($errors,'nom')?></span>
                <?php } else { ?>
                    <span style="height: 20px"></span>
                <?php } ?>
             

                <label for="prenom">Prenom</label>
                <input type="text" name="prenom" id="prenom" value="<?php if (!empty($_POST['prenom'])){ echo $_POST['prenom'];} ?>">
                <?php if (isset($errors['prenom'])) { ?>
                    <span class="error"><?php viewError($errors,'prenom')?></span>
                <?php } else { ?>
                    <span style="height: 20px"></span>
                <?php } ?>


                <label for="date">Date</label>
                <input type="date" name="date_de_naissance" id="date" value="<?php if (!empty($_POST['date_de_naissance'])){ echo $_POST['date_de_naissance'];} ?>">
                <?php if (isset($errors['date_de_naissance'])) { ?>
                    <span class="error"><?php viewError($errors,'date_de_naissance')?></span>
                <?php } else { ?>
                    <span style="height: 20px"></span>
                <?php } ?>

                
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="<?php if (!empty($_POST['email'])){ echo $_POST['email'];} ?>">
                <?php if (isset($errors['email'])) { ?>
                    <span class="error"><?php viewError($errors,'email')?></span>
                <?php } elseif (isset($errors['double_mail'])) { ?>
                    <span class="error"><?php viewError($errors,'double_mail')?></span>
                <?php } else { ?>
                    <span style="height: 20px"></span>
                <?php } ?>

                
                <label for="pwd">Mot de passe</label>
                <input type="password" name="password" id="pwd">
                <?php if (isset($errors['password'])) { ?>
                    <span class="error"><?php viewError($errors,'password')?></span>
                <?php } else { ?>
                    <span style="height: 20px"></span>
                <?php } ?>

              
                <input class="bouton" type="submit" value="Envoyer" name="submit">
            </div>

        </form>
    </div>


</body>

</html>
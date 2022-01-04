<?php
require_once "./inclu/pdo.php";
require_once "./inclu/function.php";
debug($_POST);

if (!empty($_POST['submitted'])) {
    foreach ($_POST as $key => $value) {
        $_POST[$key] = xss($value);
    }

// gestion des erreurs
    $errors = [];
    $errors = validText($errors, $_POST['nom'], 'nom', 3, 100);
    $errors = validText($errors, $_POST['prenom'], 'prenom', 3, 100);
    $errors = validEmail($errors, $_POST['email'], 'email');
    $errors = verif_empty('date_de_naissance',$errors,"date de naissance");


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
    if (!isset($_POST['cgu'])) {
        $errors['cgu'] = "Veuillez accepter les conditions général d'utilisation.";
    }
    debug($errors);
    if (count($errors) === 0) {
//hash password
        $mdp = password_hash($_POST['password'], PASSWORD_ARGON2I);
// traitement pdo
        $sql = "";
        $query = $pdo->prepare($sql);
        $query->bindValue(':nom', $_POST['nom'], PDO::PARAM_STR);
        $query->bindValue(':prenom', $_POST['prenom'], PDO::PARAM_STR);
        $query->bindValue(':date_de_naissance', $_POST['date_de_naissance'], PDO::PARAM_STR);
        $query->bindValue(':mail', $_POST['email'], PDO::PARAM_STR);
        $query->bindValue(':mdp', $mdp, PDO::PARAM_STR);
        $query->bindValue(':cgu', $_POST['cgu'], PDO::PARAM_BOOL);
        $query->bindValue(':role', "role_USER", PDO::PARAM_STR);
        $query->execute();
    }
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <script src="assets/js/script.js" defer></script>
    <title>SOS-Vaccin | Page d'inscription |</title>
</head>
<body>
<?php include_once "./inclu/header.php"?>
<main>
    <section class="wrap_page_inscription">
        <a style="color: black" href="index.php"><i class="fas fa-undo"></i> retour</a>
        <form  id="formulaire_inscription" class="formulaire_connexion" action="" method="post" enctype="multipart/form-data">
            <div class="form_input">
                <label for="nom">nom</label>
                <input type="text" name="nom" id="nom" value="<?php if (!empty($_POST['nom'])){ echo $_POST['nom'];} ?>">
                <?php if (isset($errors['nom'])) { ?>
                <span class="error"><?php viewError($errors,'nom')?></span>
                <?php } else { ?>
                    <span style="height: 20px"></span>
                <?php } ?>
            </div>
            <div class="form_input">
                <label for="prenom">prénom</label>
                <input type="text" name="prenom" id="prenom" value="<?php if (!empty($_POST['prenom'])){ echo $_POST['prenom'];} ?>">
                <?php if (isset($errors['prenom'])) { ?>
                    <span class="error"><?php viewError($errors,'prenom')?></span>
                <?php } else { ?>
                    <span style="height: 20px"></span>
                <?php } ?>
            </div>
            <div class="form_input">
                <label for="date_de_naissance">date de naissance</label>
                <input type="date" name="date_de_naissance" id="date_de_naissance">
                <?php if (isset($errors['date_de_naissance'])) { ?>
                    <span class="error"><?php viewError($errors,'date_de_naissance')?></span>
                <?php } else { ?>
                    <span style="height: 20px"></span>
                <?php } ?>
            </div>
            <div class="form_input">
                <label for="email">email</label>
                <input type="email" name="email" id="email" value="<?php if (!empty($_POST['email'])){ echo $_POST['email'];} ?>">
                <?php if (isset($errors['email'])) { ?>
                    <span class="error"><?php viewError($errors,'email')?></span>
                <?php } elseif (isset($errors['double_mail'])) { ?>
                    <span class="error"><?php viewError($errors,'double_mail')?></span>
                    <?php } else { ?>
                    <span style="height: 20px"></span>
                <?php } ?>
            </div>
            <div class="form_input">
                <label for="password">mot de passe</label>
                <input autofocus autocomplete="new-password" type="password" name="password" id="password">
                <?php if (isset($errors['password'])) { ?>
                    <span class="error"><?php viewError($errors,'password')?></span>
                <?php } else { ?>
                    <span style="height: 20px"></span>
                <?php } ?>
            </div>
            <div id="pop_up_mdp" class="cacher">
                <p>le mot de passe doit contenir:</p>
                <p>-8 caractères min</p>
                <p>-1 Majuscule</p>
                <p>-1 chiffre</p>
                <p>-1 un symbole</p>
                <p>-20 caractères max</p>
            </div>
            <div class="form_input perso_input">
                <input value="true" type="checkbox" name="cgu" id="cgu">
                <label class="cgu" for="cgu"> J'accepte les conditions général d'utilisation</label>
            </div>
                <span class="error">erreur</span>
            <div class="form_input">
                <input class="submit_registration" type="submit" value="inscription" name="submitted">
                <span class="error">erreur</span>
            </div>
        </form>
    </section>
</main>
<?php include_once "./inclu/footer.php"?>
</body>
</html>

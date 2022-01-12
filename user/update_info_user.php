<?php
require_once "../inclu/function.php";
require_once "../inclu/pdo.php";
$update = false;
if (!empty($_POST['submitted'])) {
    debug($_SESSION);
    debug($_POST);
    foreach ($_POST as $key => $value) {
        $_POST[$key] = xss($value);
    }
// gestion des erreurs
    $errors = [];
    $errors = validText($errors, $_POST['nom'], 'nom', 1, 100);
    $errors = validText($errors, $_POST['prenom'], 'prenom', 1, 100);
    $errors = validEmail($errors, $_POST['email'], 'email');
    $errors = verif_empty('date_de_naissance', $errors, "date de naissance");
    $errors = verif_empty('sexe', $errors);


// detection d'un mail dejà présent dans la table
    $query = $pdo->prepare("SELECT count(id) FROM users WHERE email = :email");
    $query->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch();

    if ($_POST['email'] === $_SESSION['email']) {
        // Aucun changement dans le mail
    } elseif ($result) {
        // le mail existe déjà pour un autre utilisateur
        $errors['double_mail'] = "Cet mail est déjà enregistré";
    };

//regex mdp
// var_dump($_POST['mdp']);
    $pattern = "#(?=^.{8,}$)((?=.*\d)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$#";
    if (strlen($_POST['password']) >= 20) {
        $errors['password'] = "Le mot de passe contient trop de caractères.";
    } elseif (!preg_match($pattern, $_POST['password'])) {
        $errors['password'] = "Mot de passe non réglementaire.";
    }
    debug($errors);
    if (count($errors) === 0) {
//hash password
        $mdp = password_hash($_POST['password'], PASSWORD_ARGON2I);
// traitement pdo
        $id = intval($_SESSION['id']);
        $sql = "UPDATE `users` SET sexe=:sexe,nom=:nom,prenom=:prenom,date_de_naissance=:date_de_naissance,email=:mail,pwd=:mdp WHERE id = :id";
        $query = $pdo->prepare($sql);
        $query->bindValue(':nom', $_POST['nom'], PDO::PARAM_STR);
        $query->bindValue(':prenom', $_POST['prenom'], PDO::PARAM_STR);
        $query->bindValue(':date_de_naissance', $_POST['date_de_naissance'], PDO::PARAM_STR);
        $query->bindValue(':mail', $_POST['email'], PDO::PARAM_STR);
        $query->bindValue(':mdp', $mdp, PDO::PARAM_STR);
        $query->bindValue(':sexe', $_POST['sexe'], PDO::PARAM_STR);
        $query->bindValue(":id", $id, PDO::PARAM_INT);
        $query->execute();
        $update = true;
        // mise a jour du $_SESSION
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['sexe'] = $_POST['sexe'];
        $_SESSION['nom'] = $_POST['nom'];
        $_SESSION['prenom'] = $_POST['prenom'];
        $_SESSION['date_de_naissance'] = $_POST['date_de_naissance'];
        $_SESSION['connecter'] = 'oui';
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
          integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../assets/js/script.js" defer></script>
    <title>SOS-vaccin | Modifier mes informations |</title>
</head>
<body>
<?php include_once "./inclu/header.php" ?>
<main>
    <section class="wrap_page_inscription">
        <?php if ($update == false) { ?>
            <a style="color: black" href="./accueil_user.php"><i class="fas fa-undo"></i> retour</a>
            <form id="formulaire_inscription" class="formulaire_connexion" action="" method="post"
                  enctype="multipart/form-data">
                <?php if ($_SESSION['sexe'] == "homme") { ?>
                    <div style="margin: 0 auto" class="">
                        <label for="homme">Homme</label>
                        <input checked style="margin-right: 3rem; margin-bottom: 2rem" type="radio" name="sexe"
                               id="homme" value="homme">
                        <label for="femme">Femme</label>
                        <input type="radio" name="sexe" id="femme" value="femme">
                        <?php if (isset($errors['sexe'])) { ?>
                            <span class="error"><?php viewError($errors, 'sexe') ?></span>
                        <?php } else { ?>
                            <span style="height: 20px"></span>
                        <?php } ?>
                    </div>
                <?php } else { ?>
                    <div style="margin: 0 auto" class="">
                        <label for="homme">Homme</label>
                        <input style="margin-right: 3rem; margin-bottom: 2rem" type="radio" name="sexe" id="homme"
                               value="homme">
                        <label for="femme">Femme</label>
                        <input checked type="radio" name="sexe" id="femme" value="femme">
                        <?php if (isset($errors['sexe'])) { ?>
                            <span class="error"><?php viewError($errors, 'sexe') ?></span>
                        <?php } else { ?>
                            <span style="height: 20px"></span>
                        <?php } ?>
                    </div>
                <?php } ?>
                <div class="form_input">
                    <label for="nom">nom</label>
                    <input autofocus type="text" name="nom" id="nom" value="<?php if (empty($_POST['nom'])) {
                        echo $_SESSION['nom'];
                    } else {
                        echo $_POST['nom'];
                    } ?>">
                    <?php if (isset($errors['nom'])) { ?>
                        <span class="error"><?php viewError($errors, 'nom') ?></span>
                    <?php } else { ?>
                        <span style="height: 20px"></span>
                    <?php } ?>
                </div>
                <div class="form_input">
                    <label for="prenom">prénom</label>
                    <input type="text" name="prenom" id="prenom" value="<?php if (empty($_POST['prenom'])) {
                        echo $_SESSION['prenom'];
                    } else {
                        echo $_POST['prenom'];
                    } ?>">
                    <?php if (isset($errors['prenom'])) { ?>
                        <span class="error"><?php viewError($errors, 'prenom') ?></span>
                    <?php } else { ?>
                        <span style="height: 20px"></span>
                    <?php } ?>
                </div>
                <div class="form_input">
                    <label for="date_de_naissance">date de naissance</label>
                    <input type="date" name="date_de_naissance" id="date_de_naissance"
                           value="<?php if (empty($_POST['date_de_naissance'])) {
                               echo $_SESSION['date_de_naissance'];
                           } else {
                               echo $_POST['date_de_naissance'];
                           } ?>">
                    <?php if (isset($errors['date_de_naissance'])) { ?>
                        <span class="error"><?php viewError($errors, 'date_de_naissance') ?></span>
                    <?php } else { ?>
                        <span style="height: 20px"></span>
                    <?php } ?>
                </div>
                <div class="form_input">
                    <label for="email">email</label>
                    <input type="text" name="email" id="email" value="<?php if (empty($_POST['email'])) {
                        echo $_SESSION['email'];
                    } else {
                        echo $_POST['email'];
                    } ?>">
                    <?php if (isset($errors['email'])) { ?>
                        <span class="error"><?php viewError($errors, 'email') ?></span>
                    <?php } elseif (isset($errors['double_mail'])) { ?>
                        <span class="error"><?php viewError($errors, 'double_mail') ?></span>
                    <?php } else { ?>
                        <span style="height: 20px"></span>
                    <?php } ?>
                </div>
                <div id="password" class="form_input">
                    <label for="password">mot de passe</label>
                    <input autocomplete="new-password" type="password" name="password">
                    <?php if (isset($errors['password'])) { ?>
                        <span class="error"><?php viewError($errors, 'password') ?></span>
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
                <div class="form_input">
                    <input class="submit_registration" type="submit" value="Modifier" name="submitted">
                </div>
            </form>
        <?php } elseif ($update == true) { ?>
            <h2>Modification terminé.</h2>
            <a style="color: blue; text-decoration: underline black" href="./accueil_user.php">Retour</a>
        <?php } ?>
    </section>
</main>
<?php include_once "./inclu/footer.php" ?>
</body>
</html>

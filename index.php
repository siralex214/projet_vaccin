<?php
require_once "inclu/function.php";
require_once "./inclu/pdo.php";
if (!empty($_SESSION['connecter']) && $_SESSION['connecter'] == "oui") {
    if (!isset($_SESSION['role']) || $_SESSION['role'] === "role_ADMIN") {
        echo "<script> window.location.href = './back/dashboard.php' </script>"; /* lorsque header ("location: " ...) beug */
        die();
    } else {
        echo "<script> window.location.href = './user/accueil_user.php?id='" . $_SESSION["id"] . "' </script>"; /* lorsque header ("location: " ...) beug */
        die();
    }
}
$errors = [];
debug($_SESSION);
if (!empty($_POST['submitted'])) {

    foreach ($_POST as $key => $value) {
        $_POST[$key] = xss($value);
    }
    $errors = validEmail($errors, $_POST['email'], "email");
    $errors = validText($errors, $_POST['password'], 'password', 4, 20);

    $query = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $query->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch();
    //condition pour verifier si le mail et le mot de passe sont dans la base de données
    if ($result) {
        $user = $result;
        if (!password_verify($_POST['password'], $user['pwd'])) {
            $errors['invalid'] = "Votre email ou votre pwd sont incorrects!";
        }
    } else {
        $errors['invalid'] = "Votre email ou votre pwd sont incorrects!";
    }
    if (count($errors) === 0) {
        // tout c'est bien passé
        $_SESSION['id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['nom'] = $user['nom'];
        $_SESSION['prenom'] = $user['prenom'];
        $_SESSION['date_de_naissance'] = $user['date_de_naissance'];
        $_SESSION['connecter'] = 'oui';
        //condition qui n'autorise la connexion qu'au personne avec un role défini
        if ($_SESSION['role'] === 'role_ADMIN') {
            header('location: ./back/dashboard.php');
        } elseif ($_SESSION['role'] == 'role_USER') {
            header("location: ./user/accueil_user.php?id=" . $_SESSION['id']);
        }
    }
}
?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>SOS-Vaccin | Page d'accueil |</title>
</head>

<body>
    <?php include_once "./inclu/header.php"; ?>
    <main class="main_connexion">
        <section class="wrap_page_connexion">
            <section class="partie_left">
                <div class="contenue_left">
                    <h1>Bienvenue sur SOS-Vaccin.</h1>
                    <p>SOS-Vaccin est un site qui vous permet de gérer votre carnet de vaccination. Avec SOS-Vaccin vous n'oublierez jamais d'aller vous faire vacciner. Facile d'utilisation et totalement gratuit, penchez pour la simplicité grace a SOS-Vaccin! </p>
                </div>
            </section>
            <section class="partie_right">
                <form action="" method="post" enctype="multipart/form-data" class="formulaire_connexion">
                    <div class="form_input">
                        <label for="email">email</label>
                        <input type="text" name="email" id="email">
                        <?php
                        if (isset($errors['email'])) { ?>
                            <span class="error"><?php viewError($errors, 'email'); ?></span>
                        <?php } else { ?>
                            <span style="height: 20px"></span>
                        <?php } ?>
                    </div>
                    <div class="form_input">
                        <label for="password">mot de passe</label>
                        <input type="password" name="password" id="password">
                        <?php
                        if (isset($errors['password'])) { ?>
                            <span class="error"> <?php viewError($errors, 'password'); ?></span>
                        <?php } else { ?>
                            <span style="height: 20px"></span>
                        <?php } ?>
                        <a class="password_forgot force_droite" href="">Mot de passe oublié?</a>
                    </div>
                    <input class="input_submit" type="submit" value="connexion" name="submitted">
                    <?php
                    if (isset($errors['invalid'])) { ?>
                        <span class="error perso_error_submit"> <?php viewError($errors, 'invalid'); ?></span>
                    <?php } else { ?>
                        <span style="height: 20px"></span>
                    <?php } ?>
                    <div class="force_droite">
                        <a class="password_forgot" href="">Mot de passe oublié?</a>
                    </div>
                    </div>
                    <input class="input_submit" type="submit" value="connexion" name="submitted">
                    <?php
                    if (isset($errors['invalid'])) { ?>
                        <span class="error perso_error_submit"> <?php viewError($errors, 'invalid'); ?></span>
                    <?php } else { ?>
                        <span style="height: 20px"></span>
                    <?php } ?>
                    <div class="inscription force_droite">
                        <span>Pas encore inscrit? <a href="registration.php">Cliquez ici</a></span>
                    </div>
                </form>
            </section>
    </main>
    <?php include_once "./inclu/footer.php"; ?>
</body>

</html>
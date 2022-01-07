<?php
require_once "./inclu/function.php";
require_once "./inclu/pdo.php";
$errors = [];
$etat = 0;
if (!empty($_POST['submitted'])) {
    if ($etat == 0) {
        foreach ($_POST as $key => $value) {
            $_POST[$key] = xss($value);
        }
        debug($_POST);
        $verif_mail = $pdo->prepare("SELECT COUNT(email) FROM `users` WHERE email = :email");
        $verif_mail->bindValue(":email",$_POST['email'], PDO::PARAM_STR);
        $verif_mail->execute();
        $verif_mail = $verif_mail->fetchColumn();
        if ($verif_mail == 1) {
            $etat = 1;
        }
        debug($verif_mail);
        if (count($errors) == 0) {
            $errors['email'] = "Email inconnue";

        }
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>SOS-vaccin | mot de passe oublié |</title>
</head>
<body>
<?php include_once "./inclu/header.php"; ?>
<main>
    <?php if ($etat == 0) { ?>
        <section class="wrap_forgot_mdp">
            <form action="" method="post">
                <div id="forgot_mdp" class="form_input">
                    <label for="email">Email:</label>
                    <input type="text" name="email" id="email" placeholder="Vérifier votre adresse email">
                    <span class="error"><?php viewError($errors,"email") ?></span>
                </div>
                <div class="form_input">
                    <input type="submit" value="envoyer" name="submitted">
                </div>
            </form>
        </section>
    <?php } elseif ($etat == 1) { ?>
        <section class="wrap_forgot_mdp">
            <?php
            $dest = "sosvaccin@gmail.com";
            $sujet = "Email de test";
            $corp = "Salut ceci est un email de test envoyer par un script PHP";
            $headers = "From: sosvaccin@gmail.com";
            if (mail($dest, $sujet, $corp, $headers)) {
                echo "Email envoyé avec succès à $dest ...";
            } else {
                echo "Échec de l'envoi de l'email...";
            }

            ?>


        </section>

    <?php } ?>
</main>
<?php include_once "./inclu/footer.php"; ?>
</body>
</html>

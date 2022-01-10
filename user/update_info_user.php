<?php
require_once "../inclu/function.php";
require_once "../inclu/pdo.php";
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
    <title>SOS-vaccin | Modifier mes informations |</title>
</head>
<body>
<?php include_once "./inclu/header.php" ?>
<main>
    <section class="wrap_page_inscription">
        <a style="color: black" href="./accueil_user.php"><i class="fas fa-undo"></i> retour</a>
        <form  id="formulaire_inscription" class="formulaire_connexion" action="" method="post" enctype="multipart/form-data">
            <div class="form_input">
                <label for="nom">Nom du vaccin:</label>
                <input autofocus type="text" name="nom" id="nom" value="<?php if (!empty($_POST['nom'])){ echo $_POST['nom'];} ?>">
                <?php if (isset($errors['nom'])) { ?>
                    <span class="error"><?php viewError($errors,'nom')?></span>
                <?php } else { ?>
                    <span style="height: 20px"></span>
                <?php } ?>
            </div>
        </form>
    </section>
</main>
<?php include_once "./inclu/footer.php" ?>
</body>
</html>

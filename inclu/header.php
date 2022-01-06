
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title></title>
</head>






<header>
    <section class="left_header">
        <img src="./assets/img/background/mario.png" alt="logo">
    </section>
    <section class="right_header">
        <div>
            <a href="index.php"> <i class="fas fa-home"></i> Accueil</a>
            <?php if (empty($_SESSION)){ ?>
                <a href="registration.php"><i class="fas fa-sign-in-alt"></i> Inscription</a>
            <?php } else { ?>
                <a href="./logout.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
            <?php } ?>
            <a href="./back/dashboard.php"><i class="fas fa-tools"></i> Admin</a>
        </div>
    </section>
</header>



<header>
    <section class="left_header">
        <img src="./assets/img/background/mario.png" alt="logo">
    </section>
    <section class="right_header">
        <div>
            <a href="index.php"> <i class="fas fa-home"></i> Accueil</a>
            <?php if (empty($_SESSION['connecter'])){ ?>
                <a href="registration.php"><i class="fas fa-sign-in-alt"></i> Inscription</a>
            <?php } else { ?>
                <a href="./logout.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
            <?php } ?>
            <a href="./back/dashboard.php"><i class="fas fa-tools"></i> Admin</a>
        </div>
    </section>
</header>

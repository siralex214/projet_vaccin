<?php
?>
<header>
    <section class="left_header">
        <img src="" alt="logo">
    </section>
    <section class="right_header">
        <div>
            <a href="../index.php">accueil</a>
            <?php if (empty($_SESSION)){ ?>
            <a href="registration.php">Inscription</a>
            <?php } else { ?>
            <a href="../logout.php">Déconnexion</a>
            <?php } ?>
            <a href="">Page 3</a>
            <a href="../back/dashboard.php">Admin</a>
        </div>
    </section>
</header>

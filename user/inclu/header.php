<?php
?>
<header>
    <section class="left_header">
        <img src="../assets/img/background/mario.png" alt="logo">
    </section>
    <section class="right_header">
        <div id="">
            <nav class="nav_burger">

                <input type="checkbox" id="check">
                <label for="check" class="checkbtn">
                    <i class="fas fa-bars"></i>
                </label>

                <ul class="burger">
                    <li><a href="../index.php"> <i class="fas fa-home"></i> Accueil</a></li>
                    <?php if (empty($_SESSION['connecter'])){ ?>
                        <li><a href="../registration.php"><i class="fas fa-sign-in-alt"></i> Inscription</a></li>
                    <?php } else { ?>
                        <li><a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
                    <?php } ?>
                    <li><a href="../back/dashboard.php"><i class="fas fa-tools"></i> Admin</a></li>
                </ul>
            </nav>
        </div>
    </section>
</header>
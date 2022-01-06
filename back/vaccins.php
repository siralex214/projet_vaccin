<?php

require_once "../inclu/pdo.php";


if(!isset($_SESSION['role']) || $_SESSION['role'] === "role_USER" ) {
    header("Location : ../index.php");
}


$request = $pdo->prepare("SELECT * FROM vaccins"); //Préparer
$request->execute(); //Executer 
$vaccins = $request->fetchAll(); // Tout Récupérer



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Admin</title>
</head>

<body>
<header>
    <section class="left_header">
        <img src="" alt="logo">
    </section>
    <section class="right_header">
        <div>
            <a href="../index.php"><i class="fas fa-home"></i> Accueil</a>
            <a href="./dashboard.php"><i class="fas fa-tools"></i> Admin</a>
        </div>
    </section>
</header>
    <div class="wrap_users">
        <div class="vaccins">
        <h1>Liste des vaccins</h1>
        <h2><a class="retour" href="dashboard.php">Retour</a></h2>

        <table>
            <thead>
                <th>ID</th>
                <th>ID utilisateur</th>
                <th>Nom</th>
                <th>Date d'injection</th>
                <th>Type de vaccin</th>
                <th>Show</th>
                <th>Update</th>
                <th>Delete</th>
            </thead>
            <?php foreach ($vaccins as $vaccin) { ?>
                <div class="users">
                    <div class="">
                        <tbody>
                            <tr>
                                <td><?php echo $vaccin['id'] ?></td>
                                <td><?php echo $vaccin['id_user'] ?></td>
                                <td><?php echo $vaccin['nom_du_vaccin'] ?></td>
                                <td><?php echo date("d/m/Y", strtotime($vaccin['date_injection'])) ?></td>
                                <td><?php echo $vaccin['type_vaccin'] ?></td>
                                <td><a href="show_vaccin.php?id=<?= $vaccin['id'] ?>"><i class="fas fa-eye"></i></a></td>
                                <td><a href="update_vaccin.php?id=<?= $vaccin['id'] ?>"><i class="fas fa-edit"></i></a></td>
                                <td><a href="delete_vaccin.php?id=<?= $vaccin['id'] ?>"><i class="fas fa-trash-alt"></i></a></td>
                            </tr>
                        </tbody>

                        <?php
                        ?>

                    </div>
                </div>
    </div>
    </div>
<?php } ?>
</table>
</div>



</body>

</html>
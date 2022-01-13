<?php

require_once "../inclu/pdo.php";


if(!isset($_SESSION['role']) || $_SESSION['role'] === "role_USER" ) {
    header("Location : ../index.php");
}


$request = $pdo->prepare("SELECT * FROM users"); //Préparer
$request->execute(); //Executer 
$users = $request->fetchAll(); // Tout Récupérer



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>SOS-Vaccin | Utilisateurs |</title>
</head>

<body>
<header>
    <section class="left_header">
        <img src="../assets/img/background/mario.png" alt="logo">
    </section>
    <section class="right_header">
        <div>
            <a href="../index.php"><i class="fas fa-home"></i> Accueil</a>
        </div>
    </section>
</header>
    <div class="wrap_users">
        <h1>Liste des utilisateurs</h1>
      
        <div class="okay">
            <h2><a class="retour" href="addUsers.php">Ajouter un utilisateur</a></h2>
            <h2 class="retour"><a class="" href="dashboard.php">Retour</a>
        </div>

        <table>
            <thead>
                <th>ID </th>
                <th>Nom </th>
                <th>Prenom</th>
                <th>Date de naissance</th>
                <th>Email</th>
                <th>Show</th>
                <th>Update</th>
                <th>Delete</th>
            </thead>
            <?php foreach ($users as $user) { ?>
                <div class="users">
                    <div class="">
                        <tbody>
                            <tr>
                                <td><?php echo $user['id'] ?></td>
                                <td><?php echo $user['nom'] ?></td>
                                <td><?php echo $user['prenom'] ?></td>
                                <td><?php echo date("d/m/Y", strtotime($user['date_de_naissance'])) ?></td>
                                <td><?php echo $user['email'] ?></td>
                                <td><a href="show.php?id=<?= $user['id'] ?>"><i class="fas fa-eye"></i></a></td>
                                <td><a href="update.php?id=<?= $user['id'] ?>"><i class="fas fa-edit"></i></a></td>
                                <td><a href="delete.php?id=<?= $user['id'] ?>"><i class="fas fa-trash-alt"></i></a></td>
                            </tr>
                        </tbody>

                        <?php
                        ?>

                    </div>
                </div>
    </div>
<?php } ?>
</table>
</div>



</body>

</html>
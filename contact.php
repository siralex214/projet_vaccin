<?php 
require_once "inclu/function.php";
require_once "./inclu/pdo.php";


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>Nous contacter</title>
</head>
<body class="background_contact">
<?php include_once "./inclu/header.php"; ?>
<div class="wrap_bloc">
    <div class="wrap_contact">
        <form action="" method="post" id="formulaire_general">
            <h2>Nous contacter</h2>
            <div class="formulaire">
                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom" value="" >

                <label for="email">Email</label>
                <input type="text" name="email" id="email">

               
                <textarea name="message" id="" cols="30" rows="10" placeholder="Votre message..."></textarea>
                
            </div>

            <input class="bouton" type="submit" value="Envoyer" name="submit">
        </form>
      
    </div>
  
</div>



    <?php include_once "./inclu/footer.php"; ?>
</body>
</html>
<?php 



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
<body>

    <div class="wrap_contact">
        <form action="" method="post">
            <h3>Nous contacter</h3>
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



</body>
</html>
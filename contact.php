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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Nous contacter</title>
</head>
<body class="background_contact">
<?php include_once "./inclu/header.php"; ?>
<div class="wrap_bloc">
    <div class="wrap_contact">
        <form action="" method="post" id="formulaire_general">
            <h2>Nous contacter</h2>
            <div class="formulaire">
                <label for="nom"><i class="far fa-user"></i> Nom</label>
                <input type="text" name="nom" id="nom" value="" >

                <label for="email"><i class="far fa-paper-plane"></i> Email</label>
                <input type="text" name="email" id="email">

                <label for="message"><i class="far fa-comment-dots"></i>Votre Message</label>
               <textarea name="message" id="" cols="30" rows="5" placeholder=""></textarea>
                
            </div>

            <input class="bouton" type="submit" value="Envoyer" name="submit">
        </form>
      
    </div>
  
</div>



    <?php include_once "./inclu/footer.php"; ?>
</body>

</html>
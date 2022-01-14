<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);
// phpinfo();

// content="text/plain; charset=utf-8"
require_once('jpgraph/jpgraph.php');
require_once('jpgraph/jpgraph_pie.php');
include('../inclu/function.php');
require_once "../inclu/pdo.php";
if (!isset($_SESSION['role']) || $_SESSION['role'] === "role_USER") {
    echo "<script> window.location.href = '../index.php'</script>"; /* lorsque header ("location: " ...) beug */
    die();
}

function console_log($data)
{
    echo '<script>';
    echo 'console.log(' . json_encode($data) . ')';
    echo '</script>';
}

try {
    // run your code here
    $table = [10, 2, 35];
    // debug($table);
    // debug([10, 2, 35]);
    // console_log('debut');
} catch (Exception $e) {
    echo $e->getMessage();
} catch (InvalidArgumentException $e) {
    echo $e->getMessage();
}

// Some data
// $data = array(30, 20, 50); //Tableau de données ; prednre les informations dans la base de données mysql
$data = array(4, 4, 4, 8);


// if (extension_loaded ('PDO')) {
//   echo 'PDO OK'; 
//   } else {
//   echo 'PDO KO'; 
//   }
$query = $pdo->query("SELECT id_user, nom_du_vaccin, COUNT(*) nbfois FROM vaccins GROUP BY id_user, nom_du_vaccin"); // Initialisation de la requête ,Mettre des données préliminaires
$resultat = $query->fetchAll();
// print_r($resultat);
$tableau_nb_vac = [];
foreach ($resultat as $vcourant) {
    array_push($tableau_nb_vac, $vcourant['nbfois']);
}

// print_r($tableau_nb_vac);
$data = $tableau_nb_vac;

$tableau_nomvac = [];
foreach ($resultat as $vcourant) {
    array_push($tableau_nomvac, $vcourant['nom_du_vaccin']);
}

// print_r($tableau_nomvac);
$data_nomvac = $tableau_nomvac;


// Create the Pie Graph. 
// $graph = new PieGraph(350, 250);

// $theme_class = "DefaultTheme";
// //$graph->SetTheme(new $theme_class());

// // Set A title for the plot
// $graph->title->Set("titre"); // "->" on LIT une propriété (title) de l'objet. Et ensuite on INVOQUE la méthode de la propriété (Set)
// $graph->SetBox(true);

// // Create
// $p1 = new PiePlot($data);
// $graph->Add($p1);

// $p1->ShowBorder();
// $p1->SetColor('black');
// $p1->SetSliceColors(array('#1E90FF', '#2E8B57', '#ADFF2F', '#DC143C', '#BA55D3'));
// $graph->Stroke();


?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SOS-vaccin | Statistiques |</title>
    <link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>
<header class="header_admin">
    <section class="left_header">
        <img src="../assets/img/background/mario.png" alt="logo">
    </section>
    <section class="right_header">
        <div>
            <a href="../index.php"><i class="fas fa-home"></i> Accueil</a>
            <a href="../user/accueil_user.php"><i class="fas fa-book"></i>Carnet</a>
            <a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
            <a href="./dashboard.php"><i class="fas fa-tools"></i> Admin</a>
        </div>
    </section>
</header>

<div style="text-align: center">
    <?php
    // Create the Pie Graph. 
    $graph = new PieGraph(350, 250);

    $theme_class = "DefaultTheme";
    // $graph->SetTheme(new $theme_class());
    // $graph->graph_theme = null;

    // Set A title for the plot
    $graph->title->Set("Nombres de vaccinés par vaccins"); // "->" on LIT une propriété (title) de l'objet. Et ensuite on INVOQUE la méthode de la propriété (Set)
    $graph->SetBox(true);

    // // Create
    $p1 = new PiePlot($data);
    $size = 0.13;

    // $p1->SetLegends(array("grippe","3","covid 19","Efluelda"));
    $p1->SetLegends($data_nomvac);

    $p1->SetSize($size);
    $p1->SetCenter(0.50, 0.75);
    $p1->value->SetFont(FF_FONT0);
    //$p1->title->Set("Nombres de vaccinés par vaccins");
    $graph->Add($p1);

    $p1->ShowBorder();
    $p1->SetColor('black');
    $p1->SetSliceColors(array('#1E90FF', '#2E8B57', '#ADFF2F', '#DC143C', '#BA55D3'));
    // $graph->Stroke();
    // print '<img src="data:image/png;base64,'.base64_encode($graph->Stroke()).'" />';
    $img = $graph->Stroke(_IMG_HANDLER);

    ob_start();
    imagepng($img);
    $imageData = ob_get_contents();
    ob_end_clean();
    ?>



    <img class="stat" src="data:image/png;base64,<?= base64_encode($imageData) ?>"/>
</div>


</body>

</html>
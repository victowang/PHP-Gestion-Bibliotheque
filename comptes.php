<head>
    <meta charset="utf-8">
    <title> BE PHP </title>
</head>

<?php
include("config.php");
session_start();
?>

<link rel="stylesheet" type="text/css" href="style.css">
<?php include "navbar.php";?>

<body>
    <?php if($_SESSION['is_libraire']!== '1'){ ?>
        <?php http_response_code(403) ?>
        <p>Vous n'avez pas accès à cette page. <a href="index.php">Retour à l'accueil</a></p>
        <!--TODO: ajouter l'image d'un lapin triste.-->
    <?php } else {?>
            <h1>Liste des clients</h1>

            <table>
                <tr>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Adresse</th>
                </tr>    
                <?php
                    include("config.php");
                    session_start();
                    $status = "";
                    $requete = "SELECT nom, prenom, adresse FROM `personnes` WHERE libraire = 0";
                    $statement = $pdo->query($requete);
                    $arrayResultat = $statement->fetchAll();
                    foreach ($arrayResultat as $personne){
                        echo '<tr>';
                        echo '<td>'.$personne['nom'].'</td>';
                        echo '<td>'.$personne['prenom'].'</td>';
                        echo '<td>'.$personne['adresse'].'</td>';                
                        echo '</tr>';
                    }
                ?>
            </table>

            
    <?php } ?>
</body>
<?php include "footer.html";?>
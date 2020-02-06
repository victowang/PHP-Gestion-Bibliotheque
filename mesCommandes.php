<head>
    <meta charset="utf-8">
    <title> BE PHP </title>
</head>

<link rel="stylesheet" type="text/css" href="style.css">
<?php include "navbar.php";?>

<body>
    <?php if($_SESSION['is_libraire']!== '0'){ ?>
        <?php http_response_code(403) ?>
        <p>Vous n'avez pas accès à cette page. <a href="index.php">Retour à l'accueil</a></p>
        <!--TODO: ajouter l'image d'un lapin triste.-->
    <?php } else {?>
            <h1>Mon panier</h1>
            <?php if(is_null($_SESSION['user_id'])){ ?>
        <?php http_response_code(403) ?>
        <p>Vous n'avez pas accès à cette page. <a href="index.php">Retour à l'accueil</a></p>
        <!--TODO: ajouter l'image d'un lapin triste.-->
    <?php } else {?>

    <h1>Mon Panier</h1>

    <table>
        <tr>
            <th>Titre</th>
            <th>Auteur</th>
            <th>Quantité</th>
            <th>Prix</th>
        </tr>    
        <?php
            include("config.php");
            session_start();
            $status = "";
            $requete = "SELECT titre, auteur, prix, qte FROM (SELECT idouvrage, qte FROM `commandes` JOIN `lignescmd` ON commandes.idcmd=lignescmd.idcmd WHERE idpersonne=".$_SESSION['user_id'].") AS maCommande JOIN `ouvrages`ON maCommande.idouvrage=ouvrages.idouvrage;";
            $statement = $pdo->query($requete);
            $arrayResultat = $statement->fetchAll();
            foreach ($arrayResultat as $livre){
                echo '<tr>';
                echo '<td>'.$livre['titre'].'</td>';
                echo '<td>'.$livre['auteur'].'</td>';
                echo '<td>'.$livre['prix'].'</td>';
                echo '<td>'.$livre['qte'].'</td>';
                echo '</tr>';
            }
        ?>
            </table>
    <?php } ?>




    <?php } ?>
</body>
<?php include "footer.html";?>
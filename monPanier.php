<head>
    <meta charset="utf-8">
    <title> BE PHP </title>
</head>

<?php
include("config.php");
session_start();

if (($_SERVER["REQUEST_METHOD"] === "POST") and $_POST['Valider']==="Valider la commande") {
    $requete = "UPDATE `commandes` SET validee=1 WHERE idpersonne=2 AND validee=0";
    $statement = $pdo->query($requete);
}
?>


<link rel="stylesheet" type="text/css" href="style.css">
<?php include "navbar.php";?>


<body>
<?php if($_SESSION['is_libraire']!== '0'){ ?>
        <?php http_response_code(403) ?>
        <p>Vous n'avez pas accès à cette page. <a href="index.php">Retour à l'accueil</a></p>
        <!--TODO: ajouter l'image d'un lapin triste.-->
    <?php } else {?>
        <h1>Mon Panier</h1>
        <?php

            $requete = "SELECT titre, auteur, prix, qte FROM (SELECT idouvrage, qte FROM `commandes` JOIN `lignescmd` ON commandes.idcmd=lignescmd.idcmd WHERE idpersonne=".$_SESSION['user_id']." AND commandes.validee=0) AS maCommande JOIN `ouvrages`ON maCommande.idouvrage=ouvrages.idouvrage;";
            $statement = $pdo->query($requete);
            $arrayResultat = $statement->fetchAll();
            if (!empty($arrayResultat)) {
        ?>
            <table>
                <tr>
                    <th>Titre</th>
                    <th>Auteur</th>
                    <th>Quantité</th>
                    <th>Prix</th>
                </tr>  

            <?php
            
                $prixTotal = 0;
                foreach ($arrayResultat as $livre){
                    echo '<tr>';
                    echo '<td>'.$livre['titre'].'</td>';
                    echo '<td>'.$livre['auteur'].'</td>';
                    echo '<td>'.$livre['qte'].'</td>';
                    echo '<td>'.$livre['qte']*$livre['prix'].'€</td>';
                    echo '</tr>';
                    $prixTotal += $livre['qte']*$livre['prix'];
                } 
                
            ?>

            </table>
            <p>Prix total : <?php echo $prixTotal; ?>€ </p>
            <form method="POST" action="">
                <input type="submit" name="Valider" value="Valider la commande" />
            </form>
            <?php
            } else {
            ?>
                Votre panier est vide.
                <div>
                    <img src="https://loulaa.e-monsite.com/medias/album/images/87072467chien-au-courses-jpg.jpg" alt="Chien avec un caddie vide."/>
                </div>
                
            <?php } ?>
    <?php } ?>

 
    




</body>
<?php include "footer.html";?>
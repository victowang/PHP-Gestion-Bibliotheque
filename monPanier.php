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
<?php if($_SESSION['is_libraire']!== '0'){ ?>
        <?php http_response_code(403) ?>
        <p>Vous n'avez pas accès à cette page. <a href="index.php">Retour à l'accueil</a></p>
        <!--TODO: ajouter l'image d'un lapin triste.-->
    <?php
        } 
        else 
        {   
            //TODO : Faire fonctionner ça
            if (($_SERVER["REQUEST_METHOD"] === "POST") and $_POST['Panier']==="Valider la commande") {
                $requete = "UPDATE `commandes` SET validee=1 WHERE idpersonne=".$_SESSION['user_id']." AND validee=0";
                print_r($requete);
                $statement = $pdo->query($requete);
            } elseif (($_SERVER["REQUEST_METHOD"] === "POST") and $_POST['Panier']==="Supprimer cette commande") {
                $requete = "SELECT idcmd FROM `commandes` WHERE idpersonne=".$_SESSION['user_id']." AND validee=0";
                $statement = $pdo->query($requete);
                $idCommande = $statement->fetch()['idcmd'];
                print_r($idCommande);
                $requete = "DELETE FROM `lignescmd` WHERE idcmd='$idCommande'; DELETE FROM `commandes` WHERE idcmd='$idCommande'";
                $statement = $pdo->query($requete);
            }
        ?>
        <h1>Mon Panier</h1>
        <?php
            $requete = "SELECT titre, auteur, prix, qte, idcmd FROM (SELECT idouvrage, qte, commandes.idcmd FROM `commandes` JOIN `lignescmd` ON commandes.idcmd=lignescmd.idcmd WHERE idpersonne=".$_SESSION['user_id']." AND commandes.validee=0) AS maCommande JOIN `ouvrages`ON maCommande.idouvrage=ouvrages.idouvrage;";
            $statement = $pdo->query($requete);
            $arrayResultat = $statement->fetchAll();
            if (!empty($arrayResultat)) {
        ?>
            <table class="fermee">
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
                <input type="submit" name="Panier" value="Valider la commande" />
                <input type="submit" name="Panier" value="Supprimer cette commande" />
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
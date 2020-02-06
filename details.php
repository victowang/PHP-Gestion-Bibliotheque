<head>
    <meta charset="utf-8">
    <title> BE PHP </title>
</head>

<?php
include("config.php");
session_start();

if (($_SERVER["REQUEST_METHOD"] === "GET") and isset($_GET['idcmd'])) {
    $idCommande = $_GET['idcmd'];
}
?>


<link rel="stylesheet" type="text/css" href="style.css">
<?php include "navbar.php";?>


<body>
<?php if($_SESSION['is_libraire']!== '1'){ ?>
        <?php http_response_code(403) ?>
        <p>Vous n'avez pas accès à cette page. <a href="index.php">Retour à l'accueil</a></p>
        <!--TODO: ajouter l'image d'un lapin triste.-->
    <?php } else {?>
        <h1>Détails de la commande <?php echo $idCommande ?></h1>
        <?php
            $requete = "SELECT titre, auteur, prix, qte FROM `ouvrages` JOIN (SELECT idouvrage, qte FROM `lignescmd` WHERE idcmd=".$idCommande.") AS maCommande ON maCommande.idouvrage=ouvrages.idouvrage";
            $statement = $pdo->query($requete);
            $arrayLivres = $statement->fetchAll();

            if (!empty($arrayLivres)) {
                $requete = "SELECT nom, prenom, adresse, date, validee FROM `personnes` JOIN (SELECT idpersonne, date, validee FROM `commandes` WHERE idcmd=".$idCommande.") AS maPersonne ON maPersonne.idpersonne=personnes.idpersonne;";
                $statement = $pdo->query($requete);
                $arrayInfos = $statement->fetchAll()[0];
            
        ?>
            <table class="fermee">
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Date</th>
                    <th>Adresse</th>
                    <th>Validée ?</th>
                </tr>
                <tr>
                    <td><?php echo $arrayInfos['nom']; ?></td>
                    <td><?php echo $arrayInfos['prenom']; ?></td>
                    <td><?php echo $arrayInfos['date']; ?></td>
                    <td><?php echo $arrayInfos['adresse']; ?></td>
                    <td>
                        <?php
                            if ($arrayInfos['validee']==='1') {
                                echo "Oui";
                            }
                            else {
                                echo "Non";
                            }
                        ?>
                    </td>
                </tr>
            </table>
            
            <table class="fermee">
                <tr>
                    <th>Titre</th>
                    <th>Auteur</th>
                    <th>Quantité</th>
                    <th>Prix</th>
                </tr>  

            <?php
            
                $prixTotal = 0;
                foreach ($arrayLivres as $livre){
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
            <?php
            } else {
            ?>
                Cette commande n'existe pas.
                
            <?php } ?>
    <?php } ?>

</body>
<?php include "footer.html";?>
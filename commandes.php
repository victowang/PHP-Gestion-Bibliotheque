<head>
    <meta charset="utf-8">
    <title> BE PHP </title>
</head>



<link rel="stylesheet" type="text/css" href="style.css">
<?php 
    include("config.php");
    session_start();
    include "navbar.php";
?>

<body>
    <?php if($_SESSION['is_libraire']!== '1'){ ?>
        <?php http_response_code(403) ?>
        <p>Vous n'avez pas accès à cette page. <a href="index.php">Retour à l'accueil</a></p>
        <!--TODO: ajouter l'image d'un lapin triste.-->
    <?php } else {?>
            <h1>Liste des commandes</h1>
            <?php

                if (($_SERVER["REQUEST_METHOD"] === "POST") and $_POST['delete']==="Supprimer") {
                    $idCommande = $_POST['idcmd'];
                    $requete = "DELETE FROM `lignescmd` WHERE idcmd='$idCommande'; DELETE FROM `commandes` WHERE idcmd='$idCommande';";
                    $statement = $pdo->query($requete);
                    print_r("Commande supprimée");
                    header("Refresh:0");
                    exit();
                }

                $requete = "SELECT idcmd, nom, prenom, validee FROM `commandes` JOIN `personnes` ON commandes.idpersonne=personnes.idpersonne";
                $statement = $pdo->query($requete);
                $arrayResultat = $statement->fetchAll();
                if (!empty($arrayResultat)) {
            ?>
                <table class="fermee">
                    <tr>
                        <th>Numéro de commande</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Validée ?</th>
                        <th>Détails de la commande</th>
                        <th></th>
                        <th></th>
                    </tr>  

                <?php
                
                    $prixTotal = 0;
                    foreach ($arrayResultat as $commande){
                        echo '<tr>';
                        echo '<td>'.$commande['idcmd'].'</td>';
                        echo '<td>'.$commande['nom'].'</td>';
                        echo '<td>'.$commande['prenom'].'</td>';
                        if ($commande['validee']==='1') {
                            echo '<td>Oui</td>';
                        }
                        else {
                            echo '<td>Non</td>';
                        }
                        echo '<td><a href="details.php?idcmd='.$commande['idcmd'].'">Voir les détails</a></td>';
                        echo '<td> <form method = "POST" action = "">
                                        <input type = "hidden" name="idcmd" value="'.$commande["idcmd"].'">
                                        <input type = "submit" name = "delete" value = "Supprimer"> 
                                    </form>
                            </td>';
                        echo '</tr>';
                    } 
                    
                ?>

                </table>
                
                <?php
                } else {
                ?>
                    Il n'y a pas de commandes.
                    <div>
                        <img src="https://loulaa.e-monsite.com/medias/album/images/87072467chien-au-courses-jpg.jpg" alt="Chien avec un caddie vide."/>
                    </div>
                    
                <?php } ?>
    <?php } ?>
</body>
<?php include "footer.html";?>
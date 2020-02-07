<head>
    <meta charset="utf-8">
    <title> BE PHP </title>
</head>

<link rel="stylesheet" type="text/css" href="style.css">

<?php include "navbar.php";?>


<body>
    <?php if($_SESSION['is_libraire'] !== '0'){ ?>
        <?php http_response_code(403) ?>
        <p>Vous n'avez pas accès à cette page. <a href="index.php">Retour à l'accueil</a></p>
        <!--TODO: ajouter l'image d'un lapin triste.-->
    <?php } else {?>

    <h1>Liste des livres</h1>

    <table class = "fermee">
        <tr>
            <th>Titre</th>
            <th>Auteur</th>
            <th>Prix</th>
            <th></th>
        </tr>    
        <?php
            include("config.php");
            session_start();

            if (($_SERVER["REQUEST_METHOD"] === "POST") and $_POST['add']==="Ajouter au panier") {
                $idCommande = $_POST['idcmd'];
                $idOuvrage = $_POST['idOuvrage'];
                $quantite = $_POST['qte'];
                $requete = "SELECT COUNT(*) FROM `lignescmd` WHERE idcmd = '$idCommande' AND idouvrage='$idOuvrage'"; // on verifie s'il y a plus d'une ligne correspondant a cet ouvrage et cette commande
                $statement = $pdo->query($requete);
                $count = $statement->fetch()['COUNT(*)'];
                if ($count === '0') {
                    $requete = "INSERT INTO `lignescmd` (idcmd, idouvrage, qte) VALUES ('$idCommande', '$idOuvrage', '$quantite');";
                    $statement = $pdo->query($requete);
                } 
                elseif ($count === '1') {
                    $requete = "UPDATE `lignescmd` SET qte = qte + '$quantite' WHERE idcmd = '$idCommande' AND idouvrage='$idOuvrage'";
                    $statement = $pdo->query($requete);
                }
                else {
                    $requete = "SELECT SUM(qte) FROM `lignescmd` WHERE idcmd = '$idCommande' AND idouvrage='$idOuvrage'";
                    $statement = $pdo->query($requete);
                    $total = $statement->fetch()['SUM(qte)'] + $quantite;
                    $requete = "DELETE FROM `lignescmd` WHERE idcmd = '$idCommande' AND idouvrage='$idOuvrage';";
                    print_r($requete);
                    $statement = $pdo->query($requete);
                    print_r($statement);
                    $requete = "INSERT INTO `lignescmd` (idcmd, idouvrage, qte) VALUES ('$idCommande', '$idOuvrage', '$total');";
                    $statement = $pdo->query($requete);
                }

            }

            $status = "";
            $requete = "SELECT * FROM `ouvrages`";
            $statement = $pdo->query($requete);
            $arrayResultat = $statement->fetchAll();
            /*
            if (!isset($Quantities)){
                $requete = "SELECT SUM(qte) as qte, maCommande.idouvrage as idouvrage FROM (SELECT idouvrage, qte, commandes.idcmd FROM `commandes` JOIN `lignescmd` ON commandes.idcmd=lignescmd.idcmd WHERE idpersonne=".$_SESSION["user_id"]." AND commandes.validee=0) AS maCommande JOIN `ouvrages`ON maCommande.idouvrage=ouvrages.idouvrage GROUP BY titre, auteur, prix, idouvrage, idcmd;";
                $statement = $pdo->query($requete);
                $Commande = $statement->fetchAll();
                print_r($Commande);
                $Quantities = array();
            }
            */
            $requete = "SELECT (EXISTS (SELECT idcmd FROM `commandes` WHERE idpersonne=".$_SESSION['user_id']." AND validee='0'))";
            $statement = $pdo->query($requete);
            $commande = $statement->fetch()[0];
            if ($commande === '0') {
                $insertion = "INSERT INTO `commandes` (idpersonne, date, validee) VALUES (".$_SESSION['user_id'].", CURDATE(), '0')";
                $statement = $pdo->query($insertion);
            }
            $requete = "SELECT idcmd FROM `commandes` WHERE idpersonne=".$_SESSION['user_id']." AND validee='0'";
            $statement = $pdo->query($requete);
            $idCommande = $statement->fetch()['idcmd'];

            foreach ($arrayResultat as $livre){
                //array_push($Quantities, [$livre['idouvrage'] > 0]);
                echo '<tr>';
                echo '<td>'.$livre['titre'].'</td>';
                echo '<td>'.$livre['auteur'].'</td>';
                echo '<td>'.$livre['prix'].'€</td>';
                echo '<td>
                        <form method="POST">
                            <input type = "hidden" name="idcmd" value="'.$idCommande.'">
                            <input type = "hidden" name="idOuvrage" value="'.$livre['idouvrage'].'">
                            <input type="number" step="1" name="qte" min="1" required/>
                            <input type="submit" name = "add" value = "Ajouter au panier">
                        </form>
                    </td>';
                echo '</tr>';
            }
        ?>
    </table>
    <?php } ?>
</body>
<?php include "footer.html";?>
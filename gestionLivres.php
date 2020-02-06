<head>
    <meta charset="utf-8">
    <title> BE PHP </title>
</head>

<?php
include("config.php");
session_start();

if (($_SERVER["REQUEST_METHOD"] === "POST") and !empty($_POST)) {
    $requete = 'INSERT INTO `ouvrages` (titre, auteur, prix) VALUES ('.'"'.$_POST['titre'].'"'.', '.'"'.$_POST['auteur'].'"'.', '.'"'.$_POST['prix'].'"'.')';
    $statement = $pdo->query($requete);
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
            <h1>Gestion des livres</h1>

            <table class = "fermee">
        <tr>
            <th>Titre</th>
            <th>Auteur</th>
            <th>Prix</th>
        </tr>    
        <?php
            include("config.php");
            session_start();
            $status = "";
            $requete = "SELECT * FROM `ouvrages`";
            $statement = $pdo->query($requete);
            $arrayResultat = $statement->fetchAll();
            foreach ($arrayResultat as $livre){
                echo '<tr>';
                echo '<td>'.$livre['titre'].'</td>';
                echo '<td>'.$livre['auteur'].'</td>';
                echo '<td>'.$livre['prix'].'</td>';
                echo '</tr>';
            }
        ?>
    </table>

    <form method="POST" action="">
        <table>
            <tr>
                <th>Titre</th>
                <th>Auteur</th>
                <th>Prix</th>
                <th></th>
            </tr>
            <tr>
                <td><input type="text" name="titre" required/></td>
                <td><input type="text" name="auteur" required/></td>
                <td><input type="number" step="0.01" name="prix" min="0.01" required/></td>
                <td><input type="submit" value = "Ajouter"></td>
            </tr>
        </table>
    </form>

    <?php } ?>
</body>
<?php include "footer.html";?>
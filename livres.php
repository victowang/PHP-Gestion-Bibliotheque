<head>
    <meta charset="utf-8">
    <title> BE PHP </title>
</head>

<link rel="stylesheet" type="text/css" href="style.css">

<?php include "navbar.php";?>


<body>
    <?php if(is_null($_SESSION['user_id'])){ ?>
        <?php http_response_code(403) ?>
        <p>Vous n'avez pas accès à cette page. <a href="index.php">Retour à l'accueil</a></p>
        <!--TODO: ajouter l'image d'un lapin triste.-->
    <?php } else {?>

    <h1>Liste des livres</h1>

    <table>
        <tr>
            <th>Id</th>
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
                echo '<td>'.$livre['idouvrage'].'</td>';
                echo '<td>'.$livre['titre'].'</td>';
                echo '<td>'.$livre['auteur'].'</td>';
                echo '<td>'.$livre['prix'].'</td>';
                echo '</tr>';
            }
        ?>
            </table>
    <?php } ?>
</body>
<?php include "footer.html";?>
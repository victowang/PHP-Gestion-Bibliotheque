<head>
    <meta charset="utf-8">
    <title> BE PHP </title>
</head>

<link rel="stylesheet" type="text/css" href="style.css">
<?php include "navbar.php";?>

<body>
    <?php if($_SESSION['is_libraire']!== '1'){ ?>
        <?php http_response_code(403) ?>
        <p>Vous n'avez pas accès à cette page. <a href="index.php">Retour à l'accueil</a></p>
        <!--TODO: ajouter l'image d'un lapin triste.-->
    <?php } else {?>
            <h1>Liste des commandes</h1>
    <?php } ?>
</body>
<?php include "footer.html";?>
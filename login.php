<head>
    <meta charset="utf-8">
    <title> BE PHP </title>
</head>

<?php
    include("config.php");
    session_start();
    $status = "";
    if (($_SERVER["REQUEST_METHOD"] == "POST") and ($_POST["lastName"] !== "") and ($_POST["password"] !== "")) {
        // username and password sent from form 

        $mylastname = $_POST['lastName'];
        $mypassword = $_POST['password'];
        $requete = "SELECT idpersonne, libraire, prenom FROM `personnes` WHERE nom='$mylastname' AND password='$mypassword'";
        $statement = $pdo->query($requete);
        $arrayResultat = $statement->fetch();
        if (empty($arrayResultat)){
            $status = "Your Login Name or Password is invalid";
        }
        else {
            $_SESSION['user_id'] = $arrayResultat['idpersonne'];
            $_SESSION['is_libraire'] = $arrayResultat['libraire'];
            $_SESSION['prenom'] = $arrayResultat['prenom'];
            $status = "Connecté";
            header('Location: index.php');
            exit();
        }
    }
?>

<link rel="stylesheet" type="text/css" href="style.css">
<?php include "navbar.php"; ?>
<body>
    <?php if($_SESSION['user_id']) { ?>
        <?php http_response_code(403) ?>
        <p>Vous êtes déjà connecté... <a href="index.php">Retour à l'accueil</a></p>
        <!--TODO: ajouter l'image d'un lapin sceptique.-->
    <?php } else {?>
    <h1>Connexion</h1>

    <form method="POST" action="">
        <h4>Nom de famille</h4>
        <input type="text" name="lastName" required/>
        <h4>Mot de passe</h4>
        <input type="text" name="password" required/>
        <div></div>
        <input type="submit" value="Se connecter" />
    </form>

    <div> 
        <?php echo $status;?>
    </div>
    <?php } ?>
</body>
<?php include "footer.html"; ?>

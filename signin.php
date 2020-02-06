<head>
    <meta charset="utf-8">
    <title> BE PHP </title>
</head>

<link rel="stylesheet" type="text/css" href="style.css">

<?php
include("config.php");
session_start();
$status = "";
if (($_SERVER["REQUEST_METHOD"] == "POST") and ($_POST["username"] !== "") and ($_POST["username"] !== "")) {
    // username and password sent from form 

    $mylastname = $_POST['lastName'];
    $myfirstname = $_POST['firstName'];
    $myaddress = $_POST['address'];
    $mypassword = $_POST['password'];
    $requete = "SELECT idpersonne FROM `personnes` WHERE nom = '$mylastname' AND prenom = '$myfirstname'";
    $statement = $pdo->query($requete);
    $arrayResultat = $statement->fetch();
    
    if (empty($arrayResultat)){
        $requete = "INSERT INTO `personnes` (nom, prenom, adresse, password) VALUES ('$mylastname', '$myfirstname', '$myaddress', '$mypassword')";
        $statement = $pdo->query($requete);
        $status = "Compte créé";
        // On suppose que l'insertion se passe sans soucis
    }
    else {
        $status = "Ces nom et prénom sont déja pris";
    }
    

    /*
    $arrayResultat = $statement->fetch();
    if (empty($arrayResultat)){
        $status = "Your Login Name or Password is invalid";
    }
    else {
        $_SESSION['user_id'] = $arrayResultat['idpersonne'];
        $_SESSION['is_libraire'] = $arrayResultat['libraire'];
        $status = "Connecté";
        
    }
    */
}
?>
<?php include "navbar.php";?>

<body>
    <?php if($_SESSION['user_id']) { ?>
        <?php http_response_code(403) ?>
        <p>Vous êtes déjà connecté... <a href="index.php">Retour à l'accueil</a></p>
        <!--TODO: ajouter l'image d'un lapin sceptique.-->
    <?php } else {?>
    <h1>Créer un compte</h1>
    <form method = "POST" action="">
        <h4>Nom</h4>
        <input type="text" name="lastName" required/>
        <h4>Prénom</h4>
        <input type="text" name="firstName" required/>
        <h4>Adresse</h4>
        <input type="text" name="address" required/>
        <h4>Mot de passe</h4>
        <input type="text" name="password" required/>
        <div></div>
        <input type="submit" value = "Créer un compte"/>
    </form>

    <div>
        <?php 
            echo $status;
        ?>
    </div>
    <?php } ?>
</body>
<?php include "footer.html";?>

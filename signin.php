<head>
    <meta charset="utf-8">
    <title> BE PHP </title>
</head>

<link rel="stylesheet" type="text/css" href="style.css">

<body>
    <h1 id="titre"> Bienvenue ! </h1>
    <?php include "navbar.php";?>
    <h1>Créer un compte</h1>
    <form method = "POST">
        <h4>Nom</h4>
        <input type="text" name="lastName" />
        <h4>Prénom</h4>
        <input type="text" name="firstName" />
        <h4>Adresse</h4>
        <input type="text" name="address" />
        <h4>Nom d'utilisateur</h4>
        <input type="text" name="userName" />
        <h4>Mot de passe</h4>
        <input type="text" name="password" />
        <div></div>
        <input type="submit" value = "Créer un compte"/>
    </form>
    <?php include "footer.html";?>
</body>
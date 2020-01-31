<?php
    session_start(); //to ensure you are using same session
?>

<nav>
<!--
        <a href="comptes.php" class="libraire">Comptes</a>
        <a href="commandes.php" class="libraire">Commandes</a>

        <a href="mesLivres.php" class="client">Mes livres</a>
        <a href="login.php" class="not_logged">Se connecter</a>
        <a href="signin.php" class="not_logged">Créer un compte</a>
        <a href="logout.php" class="logged_in">Se déconnecter</a>
-->
        <?php if(is_null($_SESSION['user_id'])) { ?>
                <a href="login.php">Se connecter</a>
                <a href="signin.php">Créer un compte</a>
        <?php } else { ?> 
                <h3>Bienvenue <?php echo $_SESSION['prenom'] ?> !</h3>
                <a href="livres.php">Liste des livres</a>
                <?php if($_SESSiON['is_libraire'] === 1) { ?>
                        <a href="comptes.php">Comptes</a>
                        <a href="commandes.php">Commandes</a>                        
                <?php } else { ?>
                        <a href="mesCommandes.php">Mes commandes</a>
                <?php } ?>
                <a href="logout.php">Se déconnecter</a>
        <?php } ?>
</nav>
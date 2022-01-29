
<!-- Partie code par Charlotte le 19/01/2022 -->
<header>
        <nav>
            <h3 class='btn-nav'><?php echo "Utilisateur : ".$_SESSION['LOGGED_USER']; ?> </h3>
            <a class="btn-nav" href="index.php">Accueil</a>
            <!-- TO DO <a href="view/expedition.php">Expédition</a>
            <a href="view/sav.php">SAV</a> -->
            <?php
            // sofiane 27/01/2022
            if($_SESSION['type_user'] === 'Technicien SAV') {
                echo "<a class='btn-nav' href='search.php'>Recherche des dossiers</a>";
            }
            ?>
            <a class='btn-nav' href="logout.php">Deconnexion </a>
            <img class="logo headLogo" src="img\MenuizMan_logo.png" alt="logo">
        </nav>
</header
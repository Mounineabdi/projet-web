<header>
    <a href="boutique.php">Boutique</a>
    <a href="panier.php">Panier (<span id="cart-counter"><?= isset($_SESSION['panier']) ? array_sum($_SESSION['panier']) : 0 ?></span>)</a>
    <?php if (isset($_SESSION['utilisateur'])): ?>
        <a href="logout.php">Déconnexion</a>
    <?php else: ?>
        <a href="index.php">Connexion</a>
    <?php endif; ?>
</header>

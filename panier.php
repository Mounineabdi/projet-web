<?php
require 'config.php';
require 'panierController.php';


// Get cart items
$panier = obtenirPanier($pdo);

// Handle cart actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['supprimerDuPanier'])) {
        supprimerDuPanier($_POST['produit_id']);
    }
    if (isset($_POST['viderPanier'])) {
        viderPanier();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'header.php'; ?>

    <main>
        <h1>Votre Panier</h1>
        <div class="container">
            <?php if (empty($panier)): ?>
                <p>Votre panier est vide.</p>
            <?php else: ?>
                <?php foreach ($panier as $produit): ?>
                    <div class="items">
                        <img src="assets/images/<?= htmlspecialchars($produit['image']) ?>"
                            alt="<?= htmlspecialchars($produit['nom']) ?>">
                        <h3><?= htmlspecialchars($produit['nom']) ?></h3>
                        <p>Quantité : <?= htmlspecialchars($produit['quantite']) ?></p>
                        <p>Prix Total : <?= htmlspecialchars($produit['total']) ?> MRU</p>
                        <form action="panier.php" method="POST">
                            <input type="hidden" name="produit_id" value="<?= $produit['id'] ?>">
                            <button type="submit" name="supprimerDuPanier">Retirer</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <?php if (!empty($panier)): ?>
            <form action="lancer_commande.php" method="POST">
                <button type="submit" class="btn">Passer la Commande</button>
            </form>
        <?php endif; ?>
        <form action="panier.php" method="POST">
            <button type="submit" name="viderPanier">Vider le Panier</button>
        </form>
    </main>

    <?php include 'footer.php'; ?>
</body>

</html>
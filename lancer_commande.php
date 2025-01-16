<?php
require 'config.php';
require 'panierController.php';
require 'commandeController.php';


// Check if the cart is empty
$panier = obtenirPanier($pdo);
if (empty($panier)) {
    die("Votre panier est vide. Ajoutez des produits avant de passer une commande.");
}

// Handle order confirmation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmerCommande'])) {
    $utilisateur_id = $_SESSION['utilisateur']['id'];

    // Calculate the total price
    $total = array_sum(array_column($panier, 'total'));

    // Create the order in the database
    $commande_id = ajouterCommande($pdo, $utilisateur_id, $total);

    // Add each product from the cart to the order
    foreach ($panier as $produit) {
        ajouterArticleCommande($pdo, $commande_id, $produit['id'], $produit['quantite'], $produit['prix']);
    }

    // Clear the cart
    viderPanier();

    // Redirect to confirmation page
    header('Location: confirmation.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lancer une Commande</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <main>
        <h1>Passer une Commande</h1>

        <!-- Display cart products -->
        <section class="order-summary">
            <h2>Résumé du Panier</h2>
            <table>
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Quantité</th>
                        <th>Prix Unitaire</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($panier as $produit): ?>
                        <tr>
                            <td><?= htmlspecialchars($produit['nom']) ?></td>
                            <td><?= htmlspecialchars($produit['quantite']) ?></td>
                            <td><?= htmlspecialchars($produit['prix']) ?> MRU</td>
                            <td><?= htmlspecialchars($produit['total']) ?> MRU</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p><strong>Total : <?= array_sum(array_column($panier, 'total')) ?> MRU</strong></p>
        </section>

        <!-- Order confirmation form -->
        <section class="order-actions">
            <form method="POST">
                <button type="submit" name="confirmerCommande">Confirmer et Passer la Commande</button>
            </form>
        </section>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>

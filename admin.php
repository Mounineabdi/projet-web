<?php
require 'config.php';
require 'produitController.php';

// Start session and check if user is an admin
session_start();
if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['role'] !== 'admin') {
    header('Location: index.php');
    exit("Accès refusé. Vous devez être administrateur.");
}

// Handle product actions
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['ajouterProduit'])) {
        $nom = trim($_POST['nom']);
        $description = trim($_POST['description']);
        $prix = floatval($_POST['prix']);
        $stock = intval($_POST['stock']);
        $image = $_FILES['image']['name'];

        // Validate inputs
        if (!empty($nom) && !empty($description) && $prix > 0 && $stock >= 0 && !empty($image)) {
            // Upload image to `assets/images/`
            $uploadDir = 'assets/images/';
            $uploadFile = $uploadDir . basename($image);

            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                ajouterProduit($pdo, $nom, $description, $prix, $stock, $image);
                $message = "Produit ajouté avec succès !";
            } else {
                $message = "Erreur lors du téléchargement de l'image.";
            }
        } else {
            $message = "Veuillez remplir tous les champs correctement.";
        }
    }

    if (isset($_POST['supprimerProduit'])) {
        $produit_id = intval($_POST['produit_id']);
        if ($produit_id > 0) {
            supprimerProduit($pdo, $produit_id);
            $message = "Produit supprimé avec succès.";
        } else {
            $message = "Identifiant de produit invalide.";
        }
    }
}

// Get all products
$produits = obtenirProduits($pdo);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gestion des Produits</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <?php if (isset($_SESSION['utilisateur'])): ?>
            <a href="logout.php">Déconnexion</a>
        <?php else: ?>
            <a href="index.php">Connexion</a>
        <?php endif; ?>
    </header>

    <main>
        <h1>Gestion des Produits</h1>

        <!-- Display messages -->
        <?php if (!empty($message)): ?>
            <p class="message"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <!-- Form to add a product -->
        <section>
            <h2>Ajouter un Produit</h2>
            <form action="admin.php" method="POST" enctype="multipart/form-data">
                <input type="text" name="nom" placeholder="Nom du produit" required>
                <textarea name="description" placeholder="Description du produit" required></textarea>
                <input type="number" name="prix" placeholder="Prix" step="0.01" required>
                <input type="number" name="stock" placeholder="Quantité en stock" required>
                <input type="file" name="image" accept="image/*" required>
                <button type="submit" name="ajouterProduit">Ajouter</button>
            </form>
        </section>

        <!-- List of products -->
        <section>
            <h2>Produits existants</h2>
            <div class="container">
                <?php foreach ($produits as $produit): ?>
                    <div class="items">
                        <img src="assets/images/<?= htmlspecialchars($produit['image']) ?>"
                            alt="<?= htmlspecialchars($produit['nom']) ?>">
                        <h3><?= htmlspecialchars($produit['nom']) ?></h3>
                        <p>Prix : <?= htmlspecialchars($produit['prix']) ?> MRU</p>
                        <p>Stock : <?= htmlspecialchars($produit['stock']) ?></p>
                        <form action="admin.php" method="POST">
                            <input type="hidden" name="produit_id" value="<?= $produit['id'] ?>">
                            <button type="submit" name="supprimerProduit">Supprimer</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <?php include 'footer.php'; ?>
    <script src="script.js"></script>
</body>

</html>
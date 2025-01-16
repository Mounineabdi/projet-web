<?php
require 'config.php';
require 'produitController.php';
require 'panierController.php';



// Get all products
$produits = obtenirTousLesProduits($pdo);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boutique</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <?php include 'header.php'; ?>

    <main>
        <h1>Nos Produits</h1>
        <div class="container">
            <?php foreach ($produits as $produit): ?>
                <div class="items">
                    <img src="assets/images/<?= htmlspecialchars($produit['image']) ?>"
                        alt="<?= htmlspecialchars($produit['nom']) ?>">
                    <h3><?= htmlspecialchars($produit['nom']) ?></h3>
                    <p>Prix : <?= htmlspecialchars($produit['prix']) ?> MRU</p>
                    <p>Stock : <?= htmlspecialchars($produit['stock']) ?></p>
                    <form class="add-to-cart-form" action="panier.php" method="POST">
                        <input type="hidden" name="produit_id" value="<?= $produit['id'] ?>">
                        <input type="number" name="quantite" value="1" min="1">
                        <button type="submit" name="ajouterAuPanier" class="add-to-cart-btn">Ajouter au Panier</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
    <script>
        $(document).ready(function () {
            $(".add-to-cart-btn").on("click", function (e) {
                e.preventDefault(); // Prevent form submission

                const form = $(this).closest(".add-to-cart-form");
                const formData = form.serialize(); // Serialize form data

                // Send AJAX request to add product to the cart
                $.ajax({
                    url: "panierController.php", // Adjust the path if necessary
                    type: "POST",
                    data: formData + "&action=add_to_cart",
                    success: function (response) {
                        alert("Produit ajouté au panier !");
                        updateCartCounter();
                    },
                    error: function () {
                        alert("Erreur lors de l'ajout au panier.");
                    }
                });
            });

            // Update cart counter
            function updateCartCounter() {
                $.ajax({
                    url: "panierController.php",
                    type: "POST",
                    data: { action: "get_cart_count" },
                    success: function (response) {
                        $("#cart-counter").text(response); // Update cart counter in header
                    }
                });
            }
        });
    </script>
    <?php include 'footer.php'; ?>
    <script src="script.js"></script>
</body>

</html>
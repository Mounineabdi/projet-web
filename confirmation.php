<?php
session_start();
if (!isset($_SESSION['utilisateur'])) {
    header('Location: index.php');
    exit("Accès non autorisé.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de Commande</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <main>
        <h1>Commande Réussie</h1>
        <p>Merci pour votre commande ! Elle est en cours de traitement.</p>
        <a href="mes_commandes.php" class="btn">Voir Mes Commandes</a>
        <a href="boutique.php" class="btn">Continuer mes achats</a>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>

<?php
session_start();
if (isset($_SESSION['utilisateur'])) {
    header('Location: boutique.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Authentification</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <h1>Bienvenue sur notre boutique</h1>
        <div class="auth-container">
            <div>
                <h2>Connexion</h2>
                <form action="login.php" method="POST">
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
                    <button type="submit" name="login">Se connecter</button>
                </form>
            </div>
            <div>
                <h2>Inscription</h2>
                <form action="register.php" method="POST">
                    <input type="text" name="nom" placeholder="Nom" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
                    <button type="submit" name="register">S'inscrire</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>

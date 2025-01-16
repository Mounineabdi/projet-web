<?php
require_once 'config.php';

// Ajouter un utilisateur
function ajouterUtilisateur($pdo, $nom, $email, $mot_de_passe, $role = 'client') {
    $mot_de_passe_hache = password_hash($mot_de_passe, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, email, mot_de_passe, role) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nom, $email, $mot_de_passe_hache, $role]);
}

// Authentifier un utilisateur
function authentifierUtilisateur($pdo, $email, $mot_de_passe) {
    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
    $stmt->execute([$email]);
    $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($utilisateur && password_verify($mot_de_passe, $utilisateur['mot_de_passe'])) {
        return $utilisateur;
    }
    return false;
}
?>

<?php
require_once 'config.php';

// Ajouter une commande
function ajouterCommande($pdo, $utilisateur_id, $total)
{
    $stmt = $pdo->prepare("INSERT INTO commandes (utilisateur_id, total) VALUES (?, ?)");
    $stmt->execute([$utilisateur_id, $total]);
    return $pdo->lastInsertId();
}

// Ajouter des articles à une commande
function ajouterArticleCommande($pdo, $commande_id, $produit_id, $quantite, $prix)
{
    $stmt = $pdo->prepare("INSERT INTO articles_commande (commande_id, produit_id, quantite, prix) VALUES (?, ?, ?, ?)");
    $stmt->execute([$commande_id, $produit_id, $quantite, $prix]);
}

// Obtenir les commandes d'un utilisateur
function obtenirCommandesUtilisateur($pdo, $utilisateur_id)
{
    $stmt = $pdo->prepare("SELECT * FROM commandes WHERE utilisateur_id = ?");
    $stmt->execute([$utilisateur_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>
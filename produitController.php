<?php
require_once 'config.php';

// Obtenir tous les produits
function obtenirTousLesProduits($pdo) {
    $stmt = $pdo->query("SELECT * FROM produits");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function obtenirProduits($pdo) {
    $stmt = $pdo->query("SELECT * FROM produits");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Ajouter un produit
function ajouterProduit($pdo, $nom, $description, $prix, $stock, $image) {
    $stmt = $pdo->prepare("INSERT INTO produits (nom, description, prix, stock, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nom, $description, $prix, $stock, $image]);
}

// Supprimer un produit
function supprimerProduit($pdo, $id) {
    $stmt = $pdo->prepare("DELETE FROM produits WHERE id = ?");
    $stmt->execute([$id]);
}
?>

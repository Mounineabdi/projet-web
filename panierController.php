<?php
session_start();

// Ajouter un produit au panier
function ajouterAuPanier($produit_id, $quantite) {
    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = [];
    }

    if (isset($_SESSION['panier'][$produit_id])) {
        $_SESSION['panier'][$produit_id] += $quantite;
    } else {
        $_SESSION['panier'][$produit_id] = $quantite;
    }
}
if (isset($_POST['action']) && $_POST['action'] === 'add_to_cart') {
    $produit_id = intval($_POST['produit_id']);
    $quantite = intval($_POST['quantite']);

    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = [];
    }

    if (isset($_SESSION['panier'][$produit_id])) {
        $_SESSION['panier'][$produit_id] += $quantite;
    } else {
        $_SESSION['panier'][$produit_id] = $quantite;
    }

    echo json_encode(["success" => true]);
    exit;
}
if (isset($_POST['action']) && $_POST['action'] === 'get_cart_count') {
    $count = isset($_SESSION['panier']) ? array_sum($_SESSION['panier']) : 0;
    echo $count;
    exit;
}
// Obtenir les produits du panier
function obtenirPanier($pdo) {
    if (!isset($_SESSION['panier']) || empty($_SESSION['panier'])) {
        return [];
    }

    $produit_ids = array_keys($_SESSION['panier']);
    $placeholders = implode(',', array_fill(0, count($produit_ids), '?'));
    $stmt = $pdo->prepare("SELECT * FROM produits WHERE id IN ($placeholders)");
    $stmt->execute($produit_ids);
    $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($produits as &$produit) {
        $produit['quantite'] = $_SESSION['panier'][$produit['id']];
        $produit['total'] = $produit['prix'] * $produit['quantite'];
    }

    return $produits;
}

// Supprimer un produit du panier
function supprimerDuPanier($produit_id) {
    if (isset($_SESSION['panier'][$produit_id])) {
        unset($_SESSION['panier'][$produit_id]);
    }
}

// Vider le panier
function viderPanier() {
    unset($_SESSION['panier']);
}
?>

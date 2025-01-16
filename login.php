<?php
require 'config.php'; // Include database connection
session_start(); // Start the session

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the login form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['mot_de_passe']);

    // Validate inputs
    if (empty($email) || empty($password)) {
        $error = "Veuillez remplir tous les champs.";
    } else {
        // Fetch user from database
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Verify password
            if (password_verify($password, $user['mot_de_passe'])) {
                // Set session variables
                $_SESSION['utilisateur'] = [
                    'id' => $user['id'],
                    'nom' => $user['nom'],
                    'email' => $user['email'],
                    'role' => $user['role']
                ];

                // Redirect based on role
                if ($user['role'] === 'admin') {
                    header('Location: admin.php'); // Redirect to admin dashboard
                } else {
                    header('Location: boutique.php'); // Redirect to client dashboard
                }
                exit;
            } else {
                $error = "Mot de passe incorrect.";
            }
        } else {
            $error = "Utilisateur introuvable.";
        }
    }
}
?>
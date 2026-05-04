<?php
session_start();
include('db.php');

// Sécurité : Seuls les admins
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // On peut aussi récupérer l'image pour la supprimer du dossier serveur si on le souhaite
    try {
        $stmt = $pdo->prepare("DELETE FROM properties WHERE id = :id");
        $stmt->execute(['id' => $id]);
        
        // Redirection avec un message de succès
        header("Location: admin-dashboard.php?msg=deleted");
        exit;
    } catch (PDOException $e) {
        die("Erreur lors de la suppression : " . $e->getMessage());
    }
} else {
    header("Location: admin-dashboard.php");
    exit;
}
?>

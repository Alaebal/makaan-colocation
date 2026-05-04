<?php
// Fichier: db.php
// Ce fichier gère la connexion à la base de données MySQL via PDO

$host = 'localhost';
$dbname = 'makaan_db';
$username = 'root'; // L'utilisateur par défaut sous XAMPP est 'root'
$password = ''; // Pas de mot de passe par défaut sous XAMPP

try {
    // Création de l'objet PDO pour se connecter
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    
    // Configurer PDO pour qu'il affiche des erreurs claires en cas de problème
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Si on arrive ici, la connexion a réussi !
} catch (PDOException $e) {
    // Si la connexion échoue, on arrête tout et on affiche l'erreur
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>

<?php
include('includes/header.php');
include('db.php');

$message = '';
$error = '';

// Création de la table users si elle n'existe pas
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS `users` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `name` varchar(100) NOT NULL,
      `email` varchar(100) NOT NULL UNIQUE,
      `password` varchar(255) NOT NULL,
      `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
} catch (PDOException $e) {
    $error = "Erreur de base de données : " . $e->getMessage();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($name) && !empty($email) && !empty($password)) {
        // Hachage du mot de passe pour la sécurité
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
            $stmt->execute([
                'name' => $name,
                'email' => $email,
                'password' => $hashed_password
            ]);
            $message = "Compte créé avec succès ! Vous pouvez maintenant vous connecter.";
        } catch (PDOException $e) {
            // L'erreur 23000 correspond souvent à une contrainte UNIQUE (email déjà utilisé)
            if ($e->getCode() == 23000) {
                $error = "Cet email est déjà utilisé. Veuillez vous connecter.";
            } else {
                $error = "Erreur lors de l'inscription : " . $e->getMessage();
            }
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}
?>

<!-- Header Start -->
<div class="container-fluid header bg-white p-0">
    <div class="row g-0 align-items-center flex-column-reverse flex-md-row">
        <div class="col-md-6 p-5 mt-lg-5">
            <h1 class="display-5 animated fadeIn mb-4">Créer un Compte</h1> 
                <nav aria-label="breadcrumb animated fadeIn">
                <ol class="breadcrumb text-uppercase">
                    <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
                    <li class="breadcrumb-item text-body active" aria-current="page">Inscription</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 animated fadeIn">
            <img class="img-fluid" src="img/header.jpg" alt="">
        </div>
    </div>
</div>
<!-- Header End -->

<div class="container-xxl py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="bg-light rounded p-5">
                    <div class="text-center mb-4">
                        <h2 class="mb-3">Inscription</h2>
                        <p>Créez votre compte pour pouvoir publier des annonces immobilières.</p>
                    </div>

                    <?php if (!empty($message)): ?>
                        <div class="alert alert-success"><?php echo $message; ?> <br><a href="login.php"><strong>Se connecter ici</strong></a></div>
                    <?php endif; ?>
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form action="register.php" method="POST">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Votre Nom Complet" required>
                                    <label for="name">Votre Nom Complet</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Votre Email" required>
                                    <label for="email">Votre Email</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Mot de passe" required>
                                    <label for="password">Mot de passe</label>
                                </div>
                            </div>
                            <div class="col-12 mt-4">
                                <button class="btn btn-primary w-100 py-3" type="submit">S'inscrire</button>
                            </div>
                            <div class="col-12 text-center mt-3">
                                <p>Déjà inscrit ? <a href="login.php">Connectez-vous</a></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>

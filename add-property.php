<?php
include('includes/header.php');

// Vérification de sécurité : Seuls les admins peuvent ajouter une annonce
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

include('db.php');
$error = '';
$message = '';

// Si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $title = $_POST['title'] ?? '';
    $price = $_POST['price'] ?? 0;
    $address = $_POST['address'] ?? '';
    $property_type = $_POST['property_type'] ?? '';
    $status = $_POST['status'] ?? '';
    $area_sqft = $_POST['area_sqft'] ?? 0;
    $bedrooms = $_POST['bedrooms'] ?? 0;
    $bathrooms = $_POST['bathrooms'] ?? 0;
    
    // Gestion de l'image
    $image_url = 'img/property-1.jpg'; // Image par défaut
    
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $upload_dir = 'img/';
        // Nettoyer le nom du fichier
        $filename = basename($_FILES['image']['name']);
        $filename = preg_replace('/[^a-zA-Z0-9.\-_]/', '', $filename);
        $target_file = $upload_dir . time() . '_' . $filename; // Ajouter le timestamp pour éviter les doublons
        
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        if (in_array($file_type, $allowed_types)) {
            // Déplacer le fichier téléchargé
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image_url = $target_file;
            } else {
                $error = "Désolé, une erreur s'est produite lors du téléchargement de l'image.";
            }
        } else {
            $error = "Désolé, seuls les fichiers JPG, JPEG, PNG, WEBP et GIF sont autorisés.";
        }
    }

    // Si pas d'erreur avec l'image, on insère dans la base
    if (empty($error)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO properties (title, price, address, property_type, status, area_sqft, bedrooms, bathrooms, image_url) VALUES (:title, :price, :address, :property_type, :status, :area_sqft, :bedrooms, :bathrooms, :image_url)");
            
            $stmt->execute([
                'title' => $title,
                'price' => $price,
                'address' => $address,
                'property_type' => $property_type,
                'status' => $status,
                'area_sqft' => $area_sqft,
                'bedrooms' => $bedrooms,
                'bathrooms' => $bathrooms,
                'image_url' => $image_url
            ]);
            
            $message = "Super ! L'annonce a été ajoutée avec succès.";
        } catch (PDOException $e) {
            $error = "Erreur lors de l'ajout : " . $e->getMessage();
        }
    }
}
?>

<!-- Header Start -->
<div class="container-fluid header bg-white p-0">
    <div class="row g-0 align-items-center flex-column-reverse flex-md-row">
        <div class="col-md-6 p-5 mt-lg-5">
            <h1 class="display-5 animated fadeIn mb-4">Ajouter une Annonce</h1> 
                <nav aria-label="breadcrumb animated fadeIn">
                <ol class="breadcrumb text-uppercase">
                    <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
                    <li class="breadcrumb-item text-body active" aria-current="page">Ajouter</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 animated fadeIn">
            <img class="img-fluid" src="img/header.jpg" alt="">
        </div>
    </div>
</div>
<!-- Header End -->

<!-- Add Property Form Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 wow fadeInUp" data-wow-delay="0.1s">
                <div class="bg-light rounded p-5">
                    <div class="text-center mb-4">
                        <h2 class="mb-3">Créer une nouvelle propriété</h2>
                        <p>Remplissez le formulaire ci-dessous pour publier votre annonce sur la plateforme.</p>
                    </div>

                    <?php if (!empty($message)): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo $message; ?>
                            <a href="index.php" class="alert-link">Voir l'annonce sur l'accueil</a>.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo $error; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form action="add-property.php" method="POST" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Titre de l'annonce</label>
                                <input type="text" name="title" class="form-control border-0 py-3" placeholder="Ex: Magnifique Villa avec piscine" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Prix (DT)</label>
                                <input type="number" name="price" class="form-control border-0 py-3" placeholder="Ex: 250000" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Adresse Complète</label>
                                <input type="text" name="address" class="form-control border-0 py-3" placeholder="Ex: Les Berges du Lac, Tunis" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Type de bien</label>
                                <select name="property_type" class="form-select border-0 py-3" required>
                                    <option value="Appartment">Appartement</option>
                                    <option value="Villa">Villa</option>
                                    <option value="Home">Maison</option>
                                    <option value="Office">Bureau</option>
                                    <option value="Building">Immeuble</option>
                                    <option value="Shop">Local Commercial</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Statut</label>
                                <select name="status" class="form-select border-0 py-3" required>
                                    <option value="For Sell">À Vendre</option>
                                    <option value="For Rent">À Louer</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Surface (m²)</label>
                                <input type="number" name="area_sqft" class="form-control border-0 py-3" placeholder="Ex: 120" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Chambres</label>
                                <input type="number" name="bedrooms" class="form-control border-0 py-3" placeholder="Ex: 3" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Salles de bain</label>
                                <input type="number" name="bathrooms" class="form-control border-0 py-3" placeholder="Ex: 2" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Image de la propriété</label>
                                <input type="file" name="image" class="form-control border-0 bg-white" accept="image/*" required>
                            </div>
                            <div class="col-12 mt-4">
                                <button class="btn btn-primary w-100 py-3" type="submit">Publier l'annonce</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Add Property Form End -->

<?php include('includes/footer.php'); ?>

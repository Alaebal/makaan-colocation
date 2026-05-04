<?php
include('includes/header.php');

// Sécurité : Seuls les admins
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

include('db.php');

$message = '';
$error = '';
$property = null;

// Vérifier si on a bien l'ID
if (!isset($_GET['id']) && $_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: admin-dashboard.php");
    exit;
}

$id = $_GET['id'] ?? $_POST['id'] ?? null;

// Charger les données actuelles de l'annonce
if ($id) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM properties WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $property = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$property) {
            header("Location: admin-dashboard.php");
            exit;
        }
    } catch (PDOException $e) {
        $error = "Erreur de base de données : " . $e->getMessage();
    }
}

// Si le formulaire de mise à jour a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'] ?? '';
    $price = $_POST['price'] ?? 0;
    $address = $_POST['address'] ?? '';
    $property_type = $_POST['property_type'] ?? '';
    $status = $_POST['status'] ?? '';
    $area_sqft = $_POST['area_sqft'] ?? 0;
    $bedrooms = $_POST['bedrooms'] ?? 0;
    $bathrooms = $_POST['bathrooms'] ?? 0;
    
    // Garder l'ancienne image par défaut
    $image_url = $property['image_url'];
    
    // Gestion de la nouvelle image si elle est uploadée
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $upload_dir = 'img/';
        $filename = basename($_FILES['image']['name']);
        $filename = preg_replace('/[^a-zA-Z0-9.\-_]/', '', $filename);
        $target_file = $upload_dir . time() . '_' . $filename;
        
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        if (in_array($file_type, $allowed_types)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image_url = $target_file; // On utilise la nouvelle image
            } else {
                $error = "Erreur lors du téléchargement de la nouvelle image.";
            }
        } else {
            $error = "Seuls les fichiers JPG, JPEG, PNG, WEBP et GIF sont autorisés.";
        }
    }

    // Mise à jour de la base de données
    if (empty($error)) {
        try {
            $stmt = $pdo->prepare("UPDATE properties SET title=:title, price=:price, address=:address, property_type=:property_type, status=:status, area_sqft=:area_sqft, bedrooms=:bedrooms, bathrooms=:bathrooms, image_url=:image_url WHERE id=:id");
            
            $stmt->execute([
                'title' => $title,
                'price' => $price,
                'address' => $address,
                'property_type' => $property_type,
                'status' => $status,
                'area_sqft' => $area_sqft,
                'bedrooms' => $bedrooms,
                'bathrooms' => $bathrooms,
                'image_url' => $image_url,
                'id' => $id
            ]);
            
            header("Location: admin-dashboard.php?msg=updated");
            exit;
        } catch (PDOException $e) {
            $error = "Erreur lors de la modification : " . $e->getMessage();
        }
    }
}
?>

<!-- Header Start -->
<div class="container-fluid header bg-white p-0">
    <div class="row g-0 align-items-center flex-column-reverse flex-md-row">
        <div class="col-md-6 p-5 mt-lg-5">
            <h1 class="display-5 animated fadeIn mb-4">Modifier Annonce</h1> 
                <nav aria-label="breadcrumb animated fadeIn">
                <ol class="breadcrumb text-uppercase">
                    <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
                    <li class="breadcrumb-item"><a href="admin-dashboard.php">Admin</a></li>
                    <li class="breadcrumb-item text-body active" aria-current="page">Modifier</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 animated fadeIn">
            <img class="img-fluid" src="img/header.jpg" alt="">
        </div>
    </div>
</div>
<!-- Header End -->

<!-- Edit Property Form Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 wow fadeInUp" data-wow-delay="0.1s">
                <div class="bg-light rounded p-5">
                    <div class="text-center mb-4">
                        <h2 class="mb-3">Mise à jour de la propriété</h2>
                        <p>Modifiez les informations ci-dessous.</p>
                    </div>

                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo $error; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if($property): ?>
                    <form action="edit-property.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Titre de l'annonce</label>
                                <input type="text" name="title" class="form-control border-0 py-3" value="<?php echo htmlspecialchars($property['title']); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Prix (DT)</label>
                                <input type="number" name="price" class="form-control border-0 py-3" value="<?php echo htmlspecialchars($property['price']); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Adresse Complète</label>
                                <input type="text" name="address" class="form-control border-0 py-3" value="<?php echo htmlspecialchars($property['address']); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Type de bien</label>
                                <select name="property_type" class="form-select border-0 py-3" required>
                                    <option value="Appartment" <?php echo ($property['property_type'] == 'Appartment') ? 'selected' : ''; ?>>Appartement</option>
                                    <option value="Villa" <?php echo ($property['property_type'] == 'Villa') ? 'selected' : ''; ?>>Villa</option>
                                    <option value="Home" <?php echo ($property['property_type'] == 'Home') ? 'selected' : ''; ?>>Maison</option>
                                    <option value="Office" <?php echo ($property['property_type'] == 'Office') ? 'selected' : ''; ?>>Bureau</option>
                                    <option value="Building" <?php echo ($property['property_type'] == 'Building') ? 'selected' : ''; ?>>Immeuble</option>
                                    <option value="Shop" <?php echo ($property['property_type'] == 'Shop') ? 'selected' : ''; ?>>Local Commercial</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Statut</label>
                                <select name="status" class="form-select border-0 py-3" required>
                                    <option value="For Sell" <?php echo ($property['status'] == 'For Sell') ? 'selected' : ''; ?>>À Vendre</option>
                                    <option value="For Rent" <?php echo ($property['status'] == 'For Rent') ? 'selected' : ''; ?>>À Louer</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Surface (m²)</label>
                                <input type="number" name="area_sqft" class="form-control border-0 py-3" value="<?php echo htmlspecialchars($property['area_sqft']); ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Chambres</label>
                                <input type="number" name="bedrooms" class="form-control border-0 py-3" value="<?php echo htmlspecialchars($property['bedrooms']); ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Salles de bain</label>
                                <input type="number" name="bathrooms" class="form-control border-0 py-3" value="<?php echo htmlspecialchars($property['bathrooms']); ?>" required>
                            </div>
                            <div class="col-12 mt-3">
                                <label class="form-label">Image actuelle</label>
                                <div><img src="<?php echo htmlspecialchars($property['image_url']); ?>" alt="Actuelle" style="max-height: 150px; border-radius: 5px;"></div>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Remplacer l'image (optionnel)</label>
                                <input type="file" name="image" class="form-control border-0 bg-white" accept="image/*">
                            </div>
                            <div class="col-12 mt-4">
                                <button class="btn btn-primary w-100 py-3" type="submit">Enregistrer les modifications</button>
                            </div>
                        </div>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Edit Property Form End -->

<?php include('includes/footer.php'); ?>

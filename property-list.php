<?php
include('includes/header.php');
include('db.php');
?>

<!-- Header Start -->
<div class="container-fluid header bg-white p-0">
    <div class="row g-0 align-items-center flex-column-reverse flex-md-row">
        <div class="col-md-6 p-5 mt-lg-5">
            <h1 class="display-5 animated fadeIn mb-4">Liste des Propriétés</h1> 
                <nav aria-label="breadcrumb animated fadeIn">
                <ol class="breadcrumb text-uppercase">
                    <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
                    <li class="breadcrumb-item text-body active" aria-current="page">Propriétés</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 animated fadeIn">
            <img class="img-fluid" src="img/header.jpg" alt="">
        </div>
    </div>
</div>
<!-- Header End -->

<!-- Search Start -->
<div class="container-fluid bg-primary mb-5 wow fadeIn" data-wow-delay="0.1s" style="padding: 35px;">
    <div class="container">
        <form action="property-list.php" method="GET">
            <div class="row g-2">
                <div class="col-md-10">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <input type="text" name="keyword" class="form-control border-0 py-3" placeholder="Mot-clé (titre...)" value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>">
                        </div>
                        <div class="col-md-4">
                            <select name="type" class="form-select border-0 py-3">
                                <option value="">Type de bien</option>
                                <option value="Appartment" <?php echo (isset($_GET['type']) && $_GET['type'] == 'Appartment') ? 'selected' : ''; ?>>Appartement</option>
                                <option value="Villa" <?php echo (isset($_GET['type']) && $_GET['type'] == 'Villa') ? 'selected' : ''; ?>>Villa</option>
                                <option value="Home" <?php echo (isset($_GET['type']) && $_GET['type'] == 'Home') ? 'selected' : ''; ?>>Maison</option>
                                <option value="Office" <?php echo (isset($_GET['type']) && $_GET['type'] == 'Office') ? 'selected' : ''; ?>>Bureau</option>
                                <option value="Shop" <?php echo (isset($_GET['type']) && $_GET['type'] == 'Shop') ? 'selected' : ''; ?>>Local Commercial</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select name="location" class="form-select border-0 py-3">
                                <option value="">Localisation</option>
                                <option value="Tunis" <?php echo (isset($_GET['location']) && $_GET['location'] == 'Tunis') ? 'selected' : ''; ?>>Tunis</option>
                                <option value="Marsa" <?php echo (isset($_GET['location']) && $_GET['location'] == 'Marsa') ? 'selected' : ''; ?>>La Marsa</option>
                                <option value="Ariana" <?php echo (isset($_GET['location']) && $_GET['location'] == 'Ariana') ? 'selected' : ''; ?>>Ariana</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-dark border-0 w-100 py-3">Rechercher</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Search End -->

<!-- Property List Start -->
<div class="container-fluid py-5">
    <div class="container">
        <div class="row g-0 gx-5 align-items-end">
            <div class="col-lg-6">
                <div class="text-start mx-auto mb-5 wow slideInLeft" data-wow-delay="0.1s">
                    <h1 class="mb-3">Toutes nos Annonces</h1>
                    <p>Découvrez notre catalogue complet de propriétés immobilières disponibles.</p>
                </div>
            </div>
        </div>
        <div class="tab-content">
            <div id="tab-1" class="tab-pane fade show p-0 active">
                <div class="row g-4">
                    <?php
                    // Requête SQL dynamique pour gérer la recherche
                    try {
                        $query = "SELECT * FROM properties WHERE 1=1";
                        $params = [];

                        if (!empty($_GET['keyword'])) {
                            $query .= " AND title LIKE :keyword";
                            $params['keyword'] = '%' . $_GET['keyword'] . '%';
                        }
                        
                        if (!empty($_GET['type'])) {
                            $query .= " AND property_type = :type";
                            $params['type'] = $_GET['type'];
                        }
                        
                        if (!empty($_GET['location'])) {
                            $query .= " AND address LIKE :location";
                            $params['location'] = '%' . $_GET['location'] . '%';
                        }
                        
                        if (!empty($_GET['status'])) {
                            $query .= " AND status = :status";
                            $params['status'] = $_GET['status'];
                        }
                        
                        $limit = 6;
                        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
                        $offset = ($page - 1) * $limit;

                        // Compter le total pour la pagination
                        $countQuery = str_replace("SELECT *", "SELECT COUNT(*) as total", $query);
                        $countStmt = $pdo->prepare($countQuery);
                        $countStmt->execute($params);
                        $totalRows = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
                        $totalPages = ceil($totalRows / $limit);

                        // Ajouter la limite à la requête
                        $query .= " ORDER BY id DESC LIMIT $limit OFFSET $offset";
                        
                        $stmt = $pdo->prepare($query);
                        $stmt->execute($params);
                        
                        if ($stmt->rowCount() > 0) {
                            while ($property = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                                    <div class="property-item rounded overflow-hidden">
                                        <div class="position-relative overflow-hidden">
                                            <a href="property-detail.php?id=<?php echo $property['id']; ?>"><img class="img-fluid" src="<?php echo htmlspecialchars($property['image_url']); ?>" alt="" style="height:250px; object-fit:cover; width:100%;"></a>
                                            <div class="bg-primary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3"><?php echo htmlspecialchars($property['status']); ?></div>
                                            <div class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3"><?php echo htmlspecialchars($property['property_type']); ?></div>
                                        </div>
                                        <div class="p-4 pb-0">
                                            <h5 class="text-primary mb-3"><?php echo number_format($property['price'], 0, ',', ' '); ?> DT</h5>
                                            <a class="d-block h5 mb-2" href="property-detail.php?id=<?php echo $property['id']; ?>"><?php echo htmlspecialchars($property['title']); ?></a>
                                            <p><i class="fa fa-map-marker-alt text-primary me-2"></i><?php echo htmlspecialchars($property['address']); ?></p>
                                        </div>
                                        <div class="d-flex border-top">
                                            <small class="flex-fill text-center border-end py-2"><i class="fa fa-ruler-combined text-primary me-2"></i><?php echo htmlspecialchars($property['area_sqft']); ?> m²</small>
                                            <small class="flex-fill text-center border-end py-2"><i class="fa fa-bed text-primary me-2"></i><?php echo htmlspecialchars($property['bedrooms']); ?> Ch</small>
                                            <small class="flex-fill text-center py-2"><i class="fa fa-bath text-primary me-2"></i><?php echo htmlspecialchars($property['bathrooms']); ?> SdB</small>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            // Affichage des boutons de pagination
                            if ($totalPages > 1) {
                                ?>
                                <div class="col-12 text-center mt-5 wow fadeInUp" data-wow-delay="0.1s">
                                    <nav>
                                        <ul class="pagination justify-content-center mb-0">
                                            <?php for($i=1; $i<=$totalPages; $i++): ?>
                                                <?php 
                                                    $qs = $_GET; 
                                                    $qs['page'] = $i; 
                                                    $link = '?' . http_build_query($qs); 
                                                ?>
                                                <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                                    <a class="page-link" href="<?php echo $link; ?>"><?php echo $i; ?></a>
                                                </li>
                                            <?php endfor; ?>
                                        </ul>
                                    </nav>
                                </div>
                                <?php
                            }
                        } else {
                            echo '<div class="col-12 text-center"><p class="alert alert-warning">Aucune annonce trouvée avec ces critères.</p></div>';
                        }
                    } catch(PDOException $e) {
                        echo '<div class="col-12 text-center"><p class="alert alert-danger">Erreur de connexion à la base de données.</p></div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Property List End -->

<?php include('includes/footer.php'); ?>

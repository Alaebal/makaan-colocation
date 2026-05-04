<?php
include('includes/header.php');
include('db.php');

// Récupérer l'ID passé dans l'URL (ex: property-detail.php?id=1)
// On utilise (int) pour s'assurer que c'est bien un nombre pour la sécurité
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// On prépare la requête pour éviter les failles de sécurité (injections SQL)
$stmt = $pdo->prepare("SELECT * FROM properties WHERE id = :id");
$stmt->execute(['id' => $id]);
$property = $stmt->fetch(PDO::FETCH_ASSOC);

// Si la propriété n'existe pas dans la base de données
if (!$property) {
    echo '<div class="container-fluid py-5"><div class="container text-center">';
    echo '<h1>Annonce introuvable</h1>';
    echo '<p class="mt-3">Cette propriété n\'existe pas ou a été supprimée.</p>';
    echo '<a href="index.php" class="btn btn-primary mt-3">Retour à l\'accueil</a>';
    echo '</div></div>';
} else {
    // Si la propriété existe, on l'affiche
?>

<!-- Header Start -->
<div class="container-fluid header bg-white p-0">
    <div class="row g-0 align-items-center flex-column-reverse flex-md-row">
        <div class="col-md-6 p-5 mt-lg-5">
            <h1 class="display-5 animated fadeIn mb-4"><?php echo htmlspecialchars($property['title']); ?></h1> 
                <nav aria-label="breadcrumb animated fadeIn">
                <ol class="breadcrumb text-uppercase">
                    <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
                    <li class="breadcrumb-item text-body active" aria-current="page">Détails de l'annonce</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 animated fadeIn">
            <img class="img-fluid w-100" src="<?php echo htmlspecialchars($property['image_url']); ?>" alt="" style="height: 500px; object-fit: cover;">
        </div>
    </div>
</div>
<!-- Header End -->

<!-- Property Detail Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-8">
                <div class="mb-5 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="d-flex align-items-center mb-4">
                        <span class="badge bg-primary text-white fs-5 px-3 py-2 me-3"><?php echo htmlspecialchars($property['status']); ?></span>
                        <span class="badge border border-primary text-primary fs-5 px-3 py-2"><?php echo htmlspecialchars($property['property_type']); ?></span>
                    </div>
                    <h2 class="mb-3"><?php echo htmlspecialchars($property['title']); ?></h2>
                    <p class="text-primary fs-3 fw-bold mb-4"><?php echo number_format($property['price'], 0, ',', ' '); ?> DT</p>
                    <p><i class="fa fa-map-marker-alt text-primary me-2"></i><?php echo htmlspecialchars($property['address']); ?></p>
                </div>
                
                <div class="mb-5 wow fadeInUp" data-wow-delay="0.2s">
                    <h4 class="mb-3">Caractéristiques Principales</h4>
                    <div class="row g-3">
                        <div class="col-sm-4">
                            <div class="border rounded p-3 text-center bg-light">
                                <i class="fa fa-ruler-combined text-primary fs-2 mb-2"></i>
                                <h5 class="mb-0"><?php echo htmlspecialchars($property['area_sqft']); ?> m²</h5>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="border rounded p-3 text-center bg-light">
                                <i class="fa fa-bed text-primary fs-2 mb-2"></i>
                                <h5 class="mb-0"><?php echo htmlspecialchars($property['bedrooms']); ?> Lits</h5>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="border rounded p-3 text-center bg-light">
                                <i class="fa fa-bath text-primary fs-2 mb-2"></i>
                                <h5 class="mb-0"><?php echo htmlspecialchars($property['bathrooms']); ?> Bains</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-5 wow fadeInUp" data-wow-delay="0.3s">
                    <h4 class="mb-3">Description du bien</h4>
                    <p>Cette magnifique propriété de type <strong><?php echo strtolower(htmlspecialchars($property['property_type'])); ?></strong> est située à <strong><?php echo htmlspecialchars($property['address']); ?></strong>. Elle offre une surface généreuse de <?php echo htmlspecialchars($property['area_sqft']); ?> m² comprenant <?php echo htmlspecialchars($property['bedrooms']); ?> chambre(s) et <?php echo htmlspecialchars($property['bathrooms']); ?> salle(s) de bain.</p>
                    <p>Idéalement située, cette annonce (actuellement proposée : <em><?php echo htmlspecialchars($property['status']); ?></em>) est parfaite pour ceux qui recherchent le confort et la tranquillité tout en restant proche des commodités essentielles de la ville.</p>
                    <p>N'hésitez pas à contacter notre agent immobilier via le formulaire pour obtenir plus de détails ou pour organiser une visite dans les plus brefs délais !</p>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="bg-light rounded p-4 mb-5 wow fadeInUp" data-wow-delay="0.4s">
                    <h4 class="mb-4">Contacter l'Agent</h4>
                    <form>
                        <div class="row g-3">
                            <div class="col-12">
                                <input type="text" class="form-control bg-white border-0 py-3" placeholder="Votre Nom Complet">
                            </div>
                            <div class="col-12">
                                <input type="email" class="form-control bg-white border-0 py-3" placeholder="Votre Adresse Email">
                            </div>
                            <div class="col-12">
                                <input type="text" class="form-control bg-white border-0 py-3" placeholder="Votre Numéro de Téléphone">
                            </div>
                            <div class="col-12">
                                <textarea class="form-control bg-white border-0 py-3" rows="5" placeholder="Message">Bonjour, je suis intéressé(e) par votre annonce : <?php echo htmlspecialchars($property['title']); ?>. Merci de me recontacter.</textarea>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100 py-3" type="button">Envoyer la demande</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Property Detail End -->

<?php
} // Fin de la condition if/else

// Inclusion du pied de page commun
include('includes/footer.php');
?>

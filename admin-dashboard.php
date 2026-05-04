<?php
include('includes/header.php');

// Sécurité : Seuls les admins
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

include('db.php');

// Récupérer toutes les annonces
try {
    $stmtProperties = $pdo->query("SELECT * FROM properties ORDER BY id DESC");
    $properties = $stmtProperties->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $properties = [];
}

// Récupérer tous les messages (si la table existe)
try {
    $stmtMessages = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC");
    $messages = $stmtMessages->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $messages = [];
}
?>

<!-- Header Start -->
<div class="container-fluid header bg-white p-0">
    <div class="row g-0 align-items-center flex-column-reverse flex-md-row">
        <div class="col-md-6 p-5 mt-lg-5">
            <h1 class="display-5 animated fadeIn mb-4">Tableau de Bord</h1> 
                <nav aria-label="breadcrumb animated fadeIn">
                <ol class="breadcrumb text-uppercase">
                    <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
                    <li class="breadcrumb-item text-body active" aria-current="page">Admin</li>
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
        
        <?php if(isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                L'annonce a bien été supprimée.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if(isset($_GET['msg']) && $_GET['msg'] == 'updated'): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                L'annonce a bien été mise à jour.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row mb-5">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Gérer mes annonces</h2>
                    <a href="add-property.php" class="btn btn-primary"><i class="fa fa-plus me-2"></i>Nouvelle annonce</a>
                </div>
                <div class="bg-light rounded p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Titre</th>
                                    <th>Prix</th>
                                    <th>Type</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($properties) > 0): ?>
                                    <?php foreach ($properties as $prop): ?>
                                        <tr>
                                            <td><?php echo $prop['id']; ?></td>
                                            <td><img src="<?php echo htmlspecialchars($prop['image_url']); ?>" alt="Image" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;"></td>
                                            <td><?php echo htmlspecialchars($prop['title']); ?></td>
                                            <td><?php echo number_format($prop['price'], 0, ',', ' '); ?> DT</td>
                                            <td><?php echo htmlspecialchars($prop['property_type']); ?></td>
                                            <td><span class="badge bg-primary"><?php echo htmlspecialchars($prop['status']); ?></span></td>
                                            <td>
                                                <a href="edit-property.php?id=<?php echo $prop['id']; ?>" class="btn btn-sm btn-outline-primary"><i class="fa fa-edit"></i> Modifier</a>
                                                <a href="delete-property.php?id=<?php echo $prop['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?');"><i class="fa fa-trash"></i> Supprimer</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Aucune annonce pour le moment.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h2 class="mb-4">Messages reçus</h2>
                <div class="bg-light rounded p-4">
                    <div class="row g-4">
                        <?php if (count($messages) > 0): ?>
                            <?php foreach ($messages as $msg): ?>
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo htmlspecialchars($msg['subject']); ?></h5>
                                            <h6 class="card-subtitle mb-2 text-muted">De: <?php echo htmlspecialchars($msg['name']); ?> (<?php echo htmlspecialchars($msg['email']); ?>)</h6>
                                            <p class="card-text"><?php echo nl2br(htmlspecialchars($msg['message'])); ?></p>
                                            <div class="text-muted small">Reçu le : <?php echo date('d/m/Y H:i', strtotime($msg['created_at'])); ?></div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12 text-center">
                                <p>Aucun message reçu pour le moment.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

<?php include('includes/footer.php'); ?>

<?php include('includes/header.php'); ?>

<!-- Header Start -->
<div class="container-fluid header bg-white p-0">
    <div class="row g-0 align-items-center flex-column-reverse flex-md-row">
        <div class="col-md-6 p-5 mt-lg-5">
            <h1 class="display-5 animated fadeIn mb-4">Types de Propriétés</h1> 
                <nav aria-label="breadcrumb animated fadeIn">
                <ol class="breadcrumb text-uppercase">
                    <li class="breadcrumb-item"><a href="index.php">Accueil</a></li>
                    <li class="breadcrumb-item text-body active" aria-current="page">Types</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 animated fadeIn">
            <img class="img-fluid" src="img/header.jpg" alt="">
        </div>
    </div>
</div>
<!-- Header End -->

<!-- Category Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h1 class="mb-3">Types de Propriétés</h1>
            <p>Parcourez nos annonces par catégorie pour trouver exactement le type de bien que vous recherchez.</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                <a class="cat-item d-block bg-light text-center rounded p-3" href="property-list.php?type=Appartment">
                    <div class="rounded p-4">
                        <div class="icon mb-3">
                            <img class="img-fluid" src="img/icon-apartment.png" alt="Icon">
                        </div>
                        <h6>Appartement</h6>
                        <span>Voir les annonces</span>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                <a class="cat-item d-block bg-light text-center rounded p-3" href="property-list.php?type=Villa">
                    <div class="rounded p-4">
                        <div class="icon mb-3">
                            <img class="img-fluid" src="img/icon-villa.png" alt="Icon">
                        </div>
                        <h6>Villa</h6>
                        <span>Voir les annonces</span>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                <a class="cat-item d-block bg-light text-center rounded p-3" href="property-list.php?type=Home">
                    <div class="rounded p-4">
                        <div class="icon mb-3">
                            <img class="img-fluid" src="img/icon-house.png" alt="Icon">
                        </div>
                        <h6>Maison</h6>
                        <span>Voir les annonces</span>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                <a class="cat-item d-block bg-light text-center rounded p-3" href="property-list.php?type=Office">
                    <div class="rounded p-4">
                        <div class="icon mb-3">
                            <img class="img-fluid" src="img/icon-housing.png" alt="Icon">
                        </div>
                        <h6>Bureau</h6>
                        <span>Voir les annonces</span>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                <a class="cat-item d-block bg-light text-center rounded p-3" href="property-list.php?type=Building">
                    <div class="rounded p-4">
                        <div class="icon mb-3">
                            <img class="img-fluid" src="img/icon-building.png" alt="Icon">
                        </div>
                        <h6>Immeuble</h6>
                        <span>Voir les annonces</span>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                <a class="cat-item d-block bg-light text-center rounded p-3" href="property-list.php?type=Shop">
                    <div class="rounded p-4">
                        <div class="icon mb-3">
                            <img class="img-fluid" src="img/icon-neighborhood.png" alt="Icon">
                        </div>
                        <h6>Local Commercial</h6>
                        <span>Voir les annonces</span>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                <a class="cat-item d-block bg-light text-center rounded p-3" href="property-list.php?status=For+Rent">
                    <div class="rounded p-4">
                        <div class="icon mb-3">
                            <img class="img-fluid" src="img/icon-condominium.png" alt="Icon">
                        </div>
                        <h6>À Louer</h6>
                        <span>Voir les annonces</span>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                <a class="cat-item d-block bg-light text-center rounded p-3" href="property-list.php?status=For+Sell">
                    <div class="rounded p-4">
                        <div class="icon mb-3">
                            <img class="img-fluid" src="img/icon-luxury.png" alt="Icon">
                        </div>
                        <h6>À Vendre</h6>
                        <span>Voir les annonces</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
<!-- Category End -->

<?php include('includes/footer.php'); ?>

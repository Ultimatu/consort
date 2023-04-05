<div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img class="bd-placeholder-img" width="100%" height="100%" aria-hidden="true" src="
                ./assets/images/carousel/lab.jpg" alt="">

            <div class="container">
                <div class="carousel-caption text-start">
                    <h1>La meilleure entreprise qui pense à vous.</h1>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <img class="bd-placeholder-img" width="100%" height="100%" aria-hidden="true" src="
                ./assets/images/carousel/lab-2.jpg" alt="">

            <div class="container">
                <div class="carousel-caption">
                    <h1>
                        Consort organisation

                    </h1>
                    <p> Consort est une entreprise qui a su s'imposer dans le domaine de la recherche et de l'innovation.</p>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <img class="bd-placeholder-img" width="100%" height="100%" aria-hidden="true" src="
                ./assets/images/carousel/lab3.jpg" alt="">

            <div class="container">
                <div class="carousel-caption text-end">
                    <h1>
                        La qualité existe chez consort
                    </h1>
                    <p>

                    </p>
                </div>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<!-- Bannières publicitaires -->
<div class="container" id="labo">
    <h2>Dernières nouvelles</h2>
    <div class="row">
        <?php
        if (isset($res_pub) && !empty($res_pub)){
            foreach($res_pub as $respro){
                echo '<div class="col-md-4">
                <div class="card mb-4 box-shadow">
                    <img class="card-img-top" src="assets/images/product/'.$respro["photo_produit"]. '" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Nouvel arrivage de produit : ' . $respro["nom_produit"] . '</h5>
                        <p class="card-text">' . $respro["description"] . '</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">Publié le ' . $respro["date"] . '</small>
                        </div>
                    </div>
                </div>
            </div>';
            }

        }
        ?>
    </div>
</div>

<div id="testimonials-carousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active text-center bg-danger">
            <div class="d-flex justify-content-center">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="testimonial-img">
                                <img src="./assets/images/admin/<?php echo $res_ad[0]["admin_photo"] ?>" alt="">
                            </div>
                            <h5 class="card-title equipier"><?php echo $res_ad[0]["nom"] . " " . $res_ad[0]["prenom"] ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted">CEO de consort</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel-item text-center">
            <div class="d-flex justify-content-center">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="testimonial-img">
                                <img src="./assets/images/delegue/<?php echo $res_del[0]["photo"] ?>" alt="">
                            </div>
                            <h5 class="card-title equipier"><?php echo $res_del[0]["nom"] . " " . $res_del[0]["prenom"] ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted">Délégué charger de promotion</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel-item text-center">
            <div class="d-flex justify-content-center">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="testimonial-img">
                                <img src="./assets/images/delegue/<?php echo $res_del[1]["photo"] ?>" alt="">
                            </div>
                            <h5 class="card-title equipier"><?php echo $res_del[1]["nom"] . " " . $res_del[1]["prenom"] ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted">Délégué charger de promotion </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#testimonials-carousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Précédent</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#testimonials-carousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Suivant</span>
    </button>
</div>


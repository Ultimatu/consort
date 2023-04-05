<!-- navbar avec bootstrap -->
<nav class="navbar navbar-expand-lg navbar-dark bg-danger sticky-top">
    <div class="container-fluid">

        <img src="./assets/images/logo/logo.png" width="80" height="40" alt="" class="navbar-brand img-fluid logo">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item an">
                    <a class="nav-link" href="index.php">
                        <i class="fa fa-home"></i> Accueil
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-industry"></i> Labo partenaires
                    </a>
                    <div class="dropdown-menu cursor-pointer animated--fade-out" aria-labelledby="navbarDropdownMenuLink1">
                        <?php
                        if ($req->rowCount() > 0) {
                            //afficher les donnees
                            while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
                                echo "<a class='dropdown-item' href='labInfo.php?labo=true&id=" . $row["id_laboratoire"] . "'>" . $row["nom"] . "</a>";
                            }
                        } else {
                            echo "Aucun laboratoire n'a ete enregistre";
                        }
                        ?>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about-us.php">
                        <i class="fa fa-info-circle"></i>
                        Savoir plus
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="#">
                        <i class="fa fa-envelope"></i> Contact
                    </a>
                </li>
            </ul>
            <form class="d-flex justify-content-between ml-auto my-lg-0">
                <input class="form-control mr-sm-2 serchBar" type="search" placeholder="Rechercher" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><i class="fas fa-search"></i> </button>
            </form>
            <ul class="navbar-nav me-lg-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-user"></i>
                    </a>
                    <div class="dropdown-menu  dropdown-menu-xxl-start" aria-labelledby="navbarDropdownMenuLink">
                        <div>
                            <a href="login.php?login=delegue" class="btn btn-outline-light btn-lg dropdown-item">Délégue</a>
                        </div>
                        <div>
                            <a href="login.php?login=admin" class="btn btn-outline-light btn-lg dropdown-item">Admin</a>
                        </div>
                    </div>
                </li>
            </ul>

        </div>
    </div>
</nav>
<main class="page contact-us-page">
    <section class="clean-block clean-form dark">
        <div class="container">
            <div class="block-heading">
                <h2 class="text-info">Contact Us</h2>
                <p>Vous recevrez une réponse dans les 24 h.</p>
            </div>
            <form class="form-control" method="post" action="user.manager.php?provider=contact-us">
                <div class="mb-3"><label class="form-label" for="name">Nom</label><input class="form-control" type="text" id="name" name="name"></div>
                <div class="mb-3"><label class="form-label" for="subject">Sujet</label><input class="form-control" type="text" id="subject" name="subject"></div>
                <div class="mb-3"><label class="form-label" for="email">Email</label><input class="form-control" type="email" id="email" name="email"></div>
                <div class="mb-3"><label class="form-label" for="message">Message</label><textarea class="form-control" id="message" name="message"></textarea></div>
                <div class="mb-3"><button class="btn btn-primary" type="submit" name="submitContact">Envoyez</button></div>
            </form>
        </div>
    </section>
    <section class="container-fluid" id="position">
        <h2 class="title">Position</h2>
        <div class="mapouter">
            <div class="gmap_canvas">
                <iframe class="gmap_iframe" width="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=600&amp;height=400&amp;hl=en&amp;q=cocody&amp;t=h&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
            </div>

        </div>
    </section>
</main>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Il y'a un message pour vous!!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php



                ?>
                <div class="alert-dismissible alert alert-<?php echo $color ?>">
                    <?php echo $message ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>


<div class="container">
    <footer class="py-5">
        <div class="row">
            <div class="col-2">
                <h5>Pages</h5>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Accueil</a></li>
                    <li class="nav-item mb-2 dropdown">
                        <a class="nav-link p-0 text-muted dropdown-toggle" href="#" id="navbarDropdownMenuLink2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Se connecter
                        </a>
                        <div class="dropdown-menu  dropdown-menu-xxl-start" aria-labelledby="navbarDropdownMenuLink2">
                            <div>
                                <a href="login.php?login=delegue" class="btn btn-outline-light btn-lg dropdown-item">Délégue</a>
                            </div>
                            <div>
                                <a href="login.php?login=admin" class="btn btn-outline-light btn-lg dropdown-item">Admin</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="col-2">
                <h5>Supprort</h5>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">FAQs</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">A propos</a></li>
                </ul>
            </div>

            <div class="col-2">
                <h5>Mentions légales</h5>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted" data-bs-toggle="modal" data-bs-target="#termsModal">Conditions d'utilisations</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted" data-bs-toggle="modal" data-bs-target="#policyModal">Politiques d'utilisations</a></li>
                </ul>
            </div>

            <div class="col-4 offset-1">
                <form method="post" action="user.manager.php?provider=contact-us">
                    <h5>Abonnement</h5>
                    <p class="text-muted">Vous recevrez des nouvelles de nous chaque mois.</p>
                    <div class="d-flex w-100 gap-2">
                        <input id="newsletter1" type="email" class="form-control" placeholder="Email address" name="email" required>
                        <button class="btn btn-outline-success" type="submit" name="submitSouscriber" id="sendNewsletter">Souscrire</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="d-flex justify-content-between py-4 my-4 border-top">
            <p>&copy; 2023 Company, Consort. Tout droit Réservé.</p>
            <ul class="list-unstyled d-flex">
                <li class="ms-3"><a class="link-dark" href="https://www.facebook.com"><i class="fab
                    fa-facebook"></i></a></li>
                <li class="ms-3"><a class="link-dark" href="https://instagram.com"><i class="fab
                    fa-instagram"></i></a></li>
                <li class="ms-3"><a class="link-dark" href="https://twitter.com"><i class="fab
                    fa-twitter"></i></a></li>
                <li class="ms-3"><a class="link-dark" href="https://linkedin.com"><i class="fab
                    fa-linkedin"></i></a></li>
                <li class="ms-3"><a class="link-dark" href="https://whatsapp.com"><i class="fab
                    fa-whatsapp"></i></a></li>

            </ul>
        </div>
    </footer>
</div>



<!-- Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termsModalLabel">Termes d'usage</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>CONSORT : nom de l'entreprise qui souhaite mettre en place un système informatique pour gérer ses activités liées à la promotion de médicaments pharmaceutiques.</p>
                <p>Partenaires : firmes nationales et internationales avec lesquelles CONSORT travaille pour importer des produits pharmaceutiques.</p>
                <p>Délégués médicaux : les employés de CONSORT qui font la promotion des produits auprès des médecins et des pharmaciens.</p>
                <p>Gamme de produits : un ensemble de produits pharmaceutiques liés par leur utilisation et leur public cible.</p>
                <p>Zone d'affectation : région géographique à laquelle est affecté un délégué médical pour la promotion des produits de CONSORT.</p>
                <p>Stock de médicaments : quantité de médicaments disponibles pour la vente et la promotion.</p>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="policyModal" tabindex="-1" role="dialog" aria-labelledby="policyModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="policyModalLabel">Politique d'utilisation</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p>Texte de la politique d'utilisation ici.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
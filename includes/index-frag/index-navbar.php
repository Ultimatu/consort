    <nav class="navbar navbar-expand-lg navbar-dark bg-danger sticky-top">
        <div class="container-fluid">

            <img src="./assets/images/logo/logo.png" width="80" height="40" alt="" class="navbar-brand img-fluid logo">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav mx-auto">
                    <li class="nav-item an">
                        <a class="nav-link active" href="#">
                            <i class="fa fa-home"></i> Accueil
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#drp" id="navbarDropdownMenuLink1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                        <a class="nav-link" href="contact-us.php">
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
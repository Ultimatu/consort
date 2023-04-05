<?php
if (isset($_GET["task"])) {
    require_once "../includes/db.connect.php";
    if (!isset($db)) {
        header("Location: ../index.php");
        exit;
    }

    switch ($_GET["task"]) {

        case "labo":
            $who = "labo";
            $image = "labo.gif";
            //afficher le formulaire de creation de laboratoire
            $formulaire = '<form class="user" method="post" action="sender.php?id=labo">
                                <div class="row mb-3">
                                    <input class="form-control form-control-user" type="text" id="exampleFirstName" placeholder="Nom du labo" name="nom">
                                </div>
                                <div class="row mb-3">
                                    <input class="form-control form-control-user" type="text" id="exampleLastName" placeholder="Adresse" name="adresse">
                                </div>
                                <div class="row mb-3">
                                   <input class="form-control form-control-user" type="text" id="exampleLastName" placeholder="Pays" name="pays">
                                </div>
                                
                                <button class="btn btn-primary d-block btn-user w-100" type="submit" name="submit">Créer</button>
                               
                            </form>';
            break;
        case "zone":
            $who  = "zone";
            $image = "zone1.gif";
            //afficher le formulaire de creation de zone qui prend seulement le district
            $formulaire = '<form class="user" method="post" action="sender.php?id=zone">
                                <div class="row mb-3">
                                    <input class="form-control form-control-user" type="text" id="exampleLastName" placeholder="District" name="district">
                                </div>
                                <button class="btn btn-primary d-block btn-user w-100" type="submit" name="submit">Créer</button>
                               
                            </form>';
            break;
        case "delegue":
            $who = "delegue";
            $image = "new_user.gif";
            //afficher le formulaire d'ajout de delegue qui prends nom, prenom, email, matricule, telephone, fonction, bagde, date_arrivee, date_depart, photo.
            $formulaire = '<form class="user" method="post" action="sender.php?id=delegue">
                                <div class="row mb-3">
                                    <div class="col-sm-6 mb-3 mb-sm-0"><input class="form-control form-control-user" type="text" id="exampleFirstName" placeholder="Nom" name="nom"></div>
                                    <div class="col-sm-6"><input class="form-control form-control-user" type="text" id="exampleLastName" placeholder="Prenom" name="prenom"></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-6 mb-3 mb-sm-0"><input class="form-control form-control-user" type="email" id="exampleFirstName" placeholder="Email" name="email"></div>
                                    <div class="col-sm-6"><input class="form-control form-control-user" type="text" id="exampleMat" placeholder="Matricule" name="matricule" disabled></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-6 mb-3 mb-sm-0"><input class="form-control form-control-user" type="text" id="exampleTel" placeholder="Telephone" name="telephone"></div>
                                    <div class="col-sm-6"><input class="form-control form-control-user" type="text" id="exampleFunction" placeholder="Fonction" name="fonction"></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-6 mb-3 mb-sm-0"><input class="form-control form-control-user" type="text" id="exampleBadge" placeholder="adresse" name="adresse"></div>
                                    <div class="col-sm-6"><input class="form-control form-control-user" type="date" id="exampleDate" placeholder="Date d\'arrivée" name="date_arrivee"></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                     <a class="btn btn-info  btn-user w-100" id="geneA">Générer matricule automatique</a>
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                     <a class="btn btn-warning btn-user  w-100" id="geneM">Générer manuellement</a>
                                    </div>
                                </div>
                                <button class="btn btn-primary d-block btn-user w-100" type="submit" name="submit">Crée</button>

                                ';
            break;
        case  "new_product":
            $who = "produit";
            $image = "product.gif";
            //Select all gamme_produit disponibles and display on select
            try {
                //faire une requette jointe qui selectionne toutes les gammes et utilise le id_lab pour selectionner tous les labos et eviter les doublons
                $sql_prod = "SELECT * FROM gamme_produit";
                $req_prod = $db->prepare($sql_prod);
                $req_prod->execute();
                $gamme = $req_prod->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo $e->getMessage();
            }

            $formulaire = '<form class="user" method="post" action="sender.php?id=prod" enctype="multipart/form-data">
                                <div class="row mb-3">
                                    <input class="form-control form-control-user" type="text" id="exampleFirstName" placeholder="Nom du produit" name="nomProduit">
                                </div>
                                <div class="row mb-3">
                                    <select class="form-control form-control-user" name="produit" id="produit">
                                        <option name="game" class="text-muted">--Choisir une gamme--</option>';
            foreach ($gamme as $key => $value) {
                $formulaire .=  '<option class="form-control form-control-user" value="' . $value["id_gamme"] . '">' . $value["categorie"] . '</option>';
            }
            $formulaire .= '</select>
                                </div>
                                <div class="row mb-3">
                                    <input class="form-control form-control-user" type="text" id="exampleFirstName" placeholder="Description du produit" name="description">
                                </div>
                                
                                <div class="row mb-3">
                                    <input class="form-control form-control-user" type="file" id="exampleFirstName" placeholder="Photo" name="photo">
                                </div>
                                <button class="btn btn-primary d-block btn-user w-100" type="submit" name="submit">Créer</button>
                               
                            </form>';
            break;
        case "new_gamme":
            $who = "une gamme de produit";
            $image = "gamme.gif";
            $req_gamme = $db->prepare("SELECT * FROM laboratoire");
            $req_gamme->execute();
            $labo = $req_gamme->fetchAll(PDO::FETCH_ASSOC);

            $form = '<form class="user" method="post" action="sender.php?id=gamme">
                                <div class="row mb-3">
                                    <input class="form-control form-control-user" type="text" id="exampleFirstName" placeholder="Nom de la gamme" name="nomGamme">
                                </div>
                                <div class="row mb-3">
                                    <select class="form-control form-control-user" name="laboGamme" id="exampleFirstName">
                                        <option name="game" class="text-disabled">--Choisir un laboratoire--</option>';
            foreach ($labo as $key => $value) {
                $form .=  '<option class="form-control form-control-user" value="' . $value["id_laboratoire"] . '">' . $value["nom"] . '</option>';
            }
            $form .= '</select>
                                </div>
                                <button class="btn btn-primary d-block btn-user w-100" type="submit" name="submit">Créer</button>
                               
                            </form>';
            $formulaire = $form;
            break;
        case "affect":
            $who = "une affectation";
            $image = "affectation.png";
            //Lier un delege a un produit et a une zone
            try {
                //requuette pour produit
                $sql_prod = "SELECT * FROM produit ";
                $req_prod = $db->prepare($sql_prod);
                $req_prod->execute();
                $prod = $req_prod->fetchAll(PDO::FETCH_ASSOC);
                //requette pour zone
                $sql_zone = "SELECT * FROM zone ";
                $req_zone = $db->prepare($sql_zone);
                $req_zone->execute();
                $zone = $req_zone->fetchAll(PDO::FETCH_ASSOC);
                //requette pour delege
                $sql_delege = "SELECT * FROM delegue WHERE date_depart IS NULL";
                $req_delege = $db->prepare($sql_delege);
                $req_delege->execute();
                $delege = $req_delege->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo $e->getMessage();
            }

            $form = '<form class="user" method="post" action="sender.php?id=affect">
                                <div class="row mb-3">
                                    <select class="form-control form-control-user" name="produit" id="exampleFirstName">
                                        <option name="notEnable" class="text-muted">--Choisir un produit--</option>';
            foreach ($prod as $key => $value) {
                $form .=  '<option class="form-control form-control-user" value="' . $value["id_produit"] . '">' . $value["nom_produit"] . '</option>';
            }
            $form .= '</select>
                                </div>
                                <div class="row mb-3">
                                    <select class="form-control form-control-user" name="zone" id="exampleFirstName">
                                        <option name="notEnable" class="text-muted">--Choisir une zone--</option>';
            foreach ($zone as $key => $value) {
                $form .=  '<option class="form-control text-dark form-control-user" value="'
                    . $value["id_zone"] . '">' . $value["district"] . '</option>';
            }
            $form .= '</select>
                                </div>
                                <div class="row mb-3">
                                    <select class="form-control form-control-user" name="delegue" id="exampleFirstName">
                                        <option name="notEnable" class="text-muted">--Choisir un délégué--</option>';
            foreach ($delege as $key => $value) {
                $form .=  '<option class="form-control form-control-user" value="'
                    . $value["id_delegue"] . '">' . $value["nom"] . '</option>';
            }
            $form .= '</select>
                                </div>
                                <button class="btn btn-primary d-block btn-user w-100" type="submit" name="submit">Créer</button>
                               
                            </form>';
            if (!empty($prod) && !empty($zone) && !empty($delege)) {
                $formulaire = $form;
            } else if (!empty($prod) && !empty($zone) && empty($delege)) {
                $formulaire = '<div class="alert animate__animated alert-danger" role="alert">Aucun délégué n\'est enregistré, veuillez d\'abord enregistré un délégué puis ressayer l\'affectation </div>';
            } else if (!empty($prod) && empty($zone) && !empty($delege)) {
                $formulaire = '<div class="alert animate__animated alert-danger" role="alert">Aucune zone n\'est enregistrée, veuillez d\'abord enregistré une zone puis ressayer l\'affectation </div>';
            } else if (empty($prod) && !empty($zone) && !empty($delege)) {
                $formulaire = '<div class="alert animate__animated alert-danger" role="alert">Aucun produit n\'est enregistré, veuillez d\'abord enregistré un produit puis ressayer l\'affectation </div>';
            } else if (empty($prod) && empty($zone) && !empty($delege)) {
                $formulaire = '<div class="alert animate__animated alert-danger" role="alert">Aucun produit et aucune zone ne sont enregistrés</div>';
            } else if (empty($prod) && !empty($zone) && empty($delege)) {
                $formulaire = '<div class="alert animate__animated alert-danger" role="alert">Aucun produit et aucun délégué n\'est enregistré</div>';
            } else if (!empty($prod) && empty($zone) && empty($delege)) {
                $formulaire = '<div class="alert animate__animated alert-danger" role="alert">Aucune zone et aucun délégué n\'est enregistré</div>';
            } else {
                $formulaire = '<div class="alert animate__animated alert-danger" role="alert">Aucun produit, aucune zone et aucun délégué n\'est enregistré</div>';
            }

            break;
        default:
            $formulaire = "Taches non définies";
            break;
    }
}
//message de success ou d'erreur
if (isset($_GET["success"])) {
    switch ($_GET["success"]) {
        case 1:
            $msg = '<div class="alert animate__bounceIn alert-success" role="alert">Opération effectuée avec succès</div>';
            break;
        case "error":
            $msg = '<div class="alert animate__bounceIn alert-danger" role="alert">Une erreur est survenue</div>';
            break;
        case 0:
            $msg = '<div class="alert animate__bounceIn alert-danger" role="alert">Veuillez remplir  tout les champs</div>';
            break;
        case 2:
            $msg = '<div class="alert animate__bounceIn alert-danger" role="alert">Ce délégue existe déjà!</div>';
            break;
        case 3:
            $msg = '<div class="alert animate__bounceIn alert-danger" role="alert">Ce labo existe déjà!</div>';
            break;
        case 4:
            $msg = '<div class="alert animate__bounceIn alert-danger" role="alert">Ce produit existe déjà!</div>';
            break;
        case 5:
            $msg = '<div class="alert animate__bounceIn alert-danger" role="alert">Cette zone existe déjà!</div>';
            break;
        case 6:
            $msg = '<div class="alert animate__bounceIn alert-danger" role="alert">La photo est trop volumineuse!</div>';
            break;
        case 7:
            $msg = '<div class="alert animate__bounceIn alert-danger" role="alert">Cette gamme de produit existe deja !</div>';
            break;
        case 8:
            $msg = '<div class="alert animate__bounceIn alert-danger" role="alert"> Le format de la photo n\'est pas valide!</div>';
            break;
        case 9:
            $msg = '<div class="alert animate__bounceIn alert-danger" role="alert">Erreur lors de l\'insertion de la photo!</div>';
            break;
        case 10:
            $msg = '<div class="alert animate__bounceIn alert-danger" role="alert">Ce délégué est déjà affecté à cette zone avec le même produit!</div>';
            break;
        case 11:
            $msg = '<div class="alert animate__bounceIn alert-danger" role="alert">Ce délégué était suspendu de ses fonctions et viens d\'être remis en service!</div>';
            break;

        default:
            $msg =
                '<div class="alert animate__bounceIn alert-danger" role="alert">Une erreur est survénue!</div>';
            break;
    }
}

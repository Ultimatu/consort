<?php
//afficher les erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//verifier la session
session_start();
if (!isset($_SESSION["adminWantToLogin"]) || $_SESSION["adminWantToLogin"] == false) {
    header("Location: ../index.php");
    exit;
}
include_once "../includes/db.connect.php";
//verifier un id est passé en parametre
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    //verifier selectionner le labo avec l'id passé en parametre et selectionner les gamme de ce labo dans la table gamme
    $sql = "SELECT * FROM laboratoire WHERE id_laboratoire = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $labo = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $sql = "SELECT * FROM gamme_produit WHERE id_laboratoire = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $gammes = $stmt->fetchAll();
}
//recuperer le id de la gamme et selectionner ses données dans la table gamme
if (isset($_GET['id_gamme']) && !empty($_GET['id_gamme'])) {
    $id_gamme = $_GET['id_gamme'];
    $sql = "SELECT * FROM gamme_produit WHERE id_gamme = :id_gamme";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(":id_gamme", $id_gamme);
    $stmt->execute();
    $gamme_req = $stmt->fetchAll(PDO::FETCH_ASSOC);
    print_r($gamme_req);

    //selectionner tous les laboratoires
    $sql = "SELECT * FROM laboratoire";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $laboratoires = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>
<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Détails laboratoire</title>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="assets/css/index-style.css">
    <link rel="stylesheet" href="../assets/css/style-lab.css">

</head>

<body>
    <header>
        <a href="index.php" class="btn btn-primary"><i class="fas fa-arrow-left"></i></a>
        <h1>Labo viewer</h1>

    </header>
    <div class="container" width="500">
        <h1> Détails du labo</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo $labo[0]['nom'] ?></h5>
                <p class="card-text"><?php echo $labo[0]['adresse'] ?></p>
                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Modifier</a>
                <a href="deleteLab.php?id=<?php echo $labo[0]['id_laboratoire'] ?>" class="btn btn-danger">Supprimer</a>
            </div>
        </div>
        <h1>Les gammes de ce labo</h1>
        <?php
        foreach ($gammes as $gamme) {
        ?>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $gamme['categorie'] ?></h5>
                    <a href="infoLab.php?id=<?php echo $id ?>&id_gamme=<?php echo $gamme['id_gamme'] ?>" class="btn btn-primary">Modifier</a>
                    <a href="deleteGamme.php?id=<?php echo $gamme['id_gamme'] ?>" class="btn btn-danger">Supprimer</a>
                </div>
            </div>
        <?php

        }

        ?>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modifier le laboratoire</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom</label>
                                <input type="text" class="form-control" id="nom" name="nom" value="<?php echo $labo[0]['nom'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="adresse" class="form-label">Adresse</label>
                                <input type="text" class="form-control" id="adresse" name="adresse" value="<?php echo $labo[0]['adresse'] ?>">
                            </div>
                            <input type="hidden" name="id" value="<?php echo $labo[0]['id_laboratoire'] ?>">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-primary">Enregistrer</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modifier le gamme</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <select name="laboratoire" id="laboratoire">
                                    <?php
                                    //selectionner le labo actuel
                                    foreach ($laboratoires as $labo) {
                                        if ($labo['id_laboratoire'] == $gamme_req['id_laboratoire']) {
                                            $select = "selected";
                                        } else {
                                            $select = "";
                                        }
                                    ?>
                                        <option value="<?php echo $labo['id_laboratoire'] ?>" <?php echo $select ?>><?php echo $labo['nom'] ?></option>
                                    <?php
                                    }
                                    ?>


                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="categorie" class="form-label">Nom</label>
                                <input type="text" class="form-control" id="categorie" name="categorie" value="<?php echo $gamme_req['categorie'] ?>">

                            </div>
                                <input type="hidden" name="id" value="<?php echo $gamme_req["id_gamme"] ?>">
                            <div>
                                <button type="button" class="btn btn-primary" name="gameSubmit">Enregistrer</button>
                            </div>
                                    
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-primary" name="gameSubmit">Enregistrer</button>
                    </div>
                </div>
            </div>
        </div>



    </div>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jquery min local -->
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script>
        //afficher le modal si on a un id_gamme dans l'url
        $(document).ready(function() {
            var id_gamme = <?php echo $id_gamme ?>;
            if (id_gamme != 0) {
                $('#exampleModal2').modal('show');
            }
        });
    </script>
</body>

</html>
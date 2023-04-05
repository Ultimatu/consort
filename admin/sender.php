<?php   
//traiter les demandes des formulaires
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
if (!isset($_SESSION["passed_by_creater"]) || $_SESSION["passed_by_creater"] != "true")
{
    header("Location: ../index.php");
    exit;
}
if (!isset($_POST["submit"]) || !isset($_GET["id"])){
    header("Location: creater.php");
    exit;
}
require "../connect.db.php";
require "../includes/db.connect.php";
if (!isset($db) || !isset($conn)){
    header("Location: creater.php?success");
    exit;
}
if (isset($_POST["submit"]) && $_GET["id"]=="delegue"){
   foreach ($_POST as $key => $value) {
        ${$key} = $value;
        if (empty($value) && $key != "matricule" && $key != "submit") {
           header("Location: creater.php?task=delegue&success=0&$key");
           break;
        }
   }
   //verifier si le matricule est vide ou pas
    if (empty($matricule)) {
        $matricule = generateMatricule($nom, $prenom, $date_entree);

    }

    $isValid = true;
    while ($isValid) {
        //verifier si le matricule existe deja
        $sql = "SELECT * FROM delegue WHERE matDelegue = :matricule";
        $result =  $conn->prepare($sql);
        $result->bindParam(":matricule", $matricule);
        $result->execute();
        $count = $result->rowCount();
        if ($count > 0) {
            //verifier si c'est le meme delegue
            $sql1 = "SELECT * FROM delegue WHERE matDelegue = :matricule AND nom = :nom AND prenom = :prenom AND date_entree = :date_entree";
            $result1 = $conn->prepare($sql1);
            $result1->bindParam(":matricule", $matricule);
            $result1->bindParam(":nom", $nom);
            $result1->bindParam(":prenom", $prenom);
            $result1->bindParam(":date_entree", $date_entree);
            $result1->execute();
            $count1 = $result1->rowCount();
            $fetch = $result1->fetch();
            if ($count1 > 0) {
                //Verifier si est suspendu et le reactiver
                if ($fetch["date_depart"] != NULL){
                    $sql = "UPDATE delegue SET date_depart = NULL WHERE matDelegue =:matDelegue ";
                    $result1 = $conn->prepare($sql);
                    $result1->bindParam(":matDelegue", $matricule);
                    $result1->execute();
                    header("Location: creater.php?success=11&task=delegue");
                    exit;
                }
                else{
                    header("Location: creater.php?success=2&task=delegue");
                    exit;
                }
              
            } else {
                $matricule = generateMatricule($prenom, $nom, $date_entree);
            }
        } else {
            $isValid = false;
        }
    }
    //inserer les donnees dans la base de donnees
    try{
        $sql = "INSERT INTO delegue (matDelegue,nom, prenom, adresse, email, telephone,fonction, date_entree) VALUES (?,?,?,?,?,?,?,?)";
        $result = $conn->prepare($sql);
        $result->execute([
            $matricule,
            $nom,
            $prenom,
            $adresse,
            $email,
            $telephone,
            $fonction,
            $date_arrivee
        ]);
        //retourner sur la page d'ajouter avec un message d'ajout reussi
        header("Location: creater.php?success=1&task=delegue");
        exit;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit;
    }
    
    
}
//Gérer la creation de labo
if (isset($_POST["submit"]) && $_GET["id"] == "labo") {
    foreach ($_POST as $key => $value) {
        ${$key} = $value;
        if (empty($value) && $key != "submit") {
            header("Location: creater.php?task=labo&success=0&$key");
            break;
        }
    }


    //verifier si le labo existe deja
    try {
        $sql = "SELECT * FROM laboratoire WHERE nom = :nom AND pays = :pays AND adresse = :adresse";
        $result = $db->prepare($sql);
        $result->bindParam(":nom", $nom);
        $result->bindParam(":pays", $pays);
        $result->bindParam(":adresse", $adresse);
        $result->execute();
        $count = $result->rowCount();
        if (!$result) {
            echo "Query failed: " . $db->errorInfo()[2];
            exit;
        }

    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit;
    }
    if ($count > 0) {
        header("Location: creater.php?task=labo&success=3");
        exit;
    }
    //inserer les donnees dans la base de donnees
    try {
        $sql = "INSERT INTO laboratoire (nom, adresse, pays) VALUES (?,?,?)";
        $result = $conn->prepare($sql);
        $result->execute([
            $nom,
            $adresse,
            $pays
        ]);
        //retourner sur la page d'ajouter avec un message d'ajout réussi
        header("Location: creater.php?success=1&task=labo");
        if (headers_sent()) {
            echo "Headers already sent.";
        } else {
            header("Location: creater.php?success=1&task=labo");
        }
        exit;

    } catch (PDOException $e) {
        header("Location: creater.php?task=no&success");
        exit;
    }
}
//Gérer la creation de zone
if (isset($_POST["submit"]) && $_GET["id"] == "zone") {
    if (empty($_POST["district"])){
        header("Location: creater.php?task=zone&success=0");
        exit;
    }
    $district = $_POST["district"];
    //verifier si la zone existe deja
    try {
        $sql = "SELECT * FROM zone WHERE district = :district";
        $result = $db->prepare($sql);
        $result->bindParam(":district", $district);
        $result->execute();
        $count = $result->rowCount();
        if ($count > 0) {
            header("Location: creater.php?task=zone&success=5");
            exit;
        }
        else {
            $sql = "INSERT INTO zone (district) VALUES (?)";
            $result = $db->prepare($sql);
            $result->execute([$district]);
            header("Location: creater.php?task=zone&success=1");
            exit;
        }
    } catch (PDOException $e) {
        header("Location: creater.php?task=no&success");
        exit;
    }
}
//Gérer l'ajout de produit, qui prend aussi une photo
if (isset($_POST["submit"]) && $_GET["id"] == "prod") {
    foreach ($_POST as $key => $value) {
        ${$key} = $value;
        if (empty($value) && $key != "submit" && $key != "photo") {
            header("Location: creater.php?task=new_produit&success=0&$key");
            break;
        }
    }
    //afficher le tableau des valeurs pour le debug
   

    //verifier si le produit existe deja

    try {
        $try_tof = $_FILES["photo"]["name"] ?? "product_avatar.jpg";
        $sql = "SELECT * FROM produit WHERE nom_produit = :nomProduit AND id_gamme = :produit AND photo_produit = :try_tof";
        $result = $db->prepare($sql);
        $result->bindParam(":nomProduit", $nomProduit);
        $result->bindParam(":gamme", $gamme);
        $result->bindParam(":try_toff", $try_tof);
        $result->execute();
        $count = $result->rowCount();
        echo $count;
        if ($count > 0) {
            header("Location: creater.php?task=new_produit&success=3");
            exit;
        }
        else {
            //verifier si la photo a été envoyée sinon utiliser la valeur par default
            if (isset($_FILES["photo"]) && !empty($_FILES["photo"]["tmp_name"])){
                $photo = $_FILES["photo"];
                $photoName = $photo["name"];
                $photoTmpName = $photo["tmp_name"];
                $photoSize = $photo["size"];
                $photoError = $photo["error"];
                $photoType = $photo["type"];
                $photoExt = explode(".", $photoName);
                $photoActualExt = strtolower(end($photoExt));
                $allowed = array("jpg", "jpeg", "png", "webp", "gif", "svg");
                $accept = false;
                if (in_array($photoActualExt, $allowed)) {
                    if ($photoSize < 1000000) {
                        //creer le dossier s'il n'existe pas
                        if (!file_exists("../assets/images/product")) {
                            mkdir("../assets/images/product", 0777, true);
                        }
                        //clee unique pour le nom de la photo
                        $photoNameNew = uniqid('', true).".".$photoActualExt;
                        $photoDestination = "../assets/images/product/".$photoNameNew;
                        move_uploaded_file($photoTmpName, $photoDestination);
                        $accept = true;


                    } else {
                        header("Location: creater.php?task=new_product&success=6");
                        exit;
                    }
                } else {
                    header("Location: creater.php?task=new_product&success=8");
                    exit;
                }
            } else {
                $photoNameNew = "product_avatar.jpg";
                $accept = true;
            }
            if ($accept){
                //inserer les donnees dans la base de donnees
                $insertion = "INSERT INTO produit (nom_produit, id_gamme, description, photo_produit) VALUES (?,?,?,?)";
                $result = $db->prepare($insertion);
                $result->execute([
                    $nomProduit,
                    $produit,
                    $description,
                    $photoNameNew
                ]);
                if ($result) {
                    //inserer une nouvelle dans ta table news pour notifier les utilisateurs
                    $insertion = "INSERT INTO news (id_admin, nouvelle, cle) VALUES (?,?,?)";
                    $result = $db->prepare($insertion);
                    $result->execute([
                        $_SESSION["id"],
                        "Un nouveau produit a été ajouté: $nomProduit",
                        $photoNameNew
                    ]);
                    //retourner sur la page d'ajouter avec un message d'ajout réussi
                    header("Location: creater.php?task=new_product&success=1");
                    if (headers_sent()) {
                        echo "Headers already sent.";
                    } else {
                        header("Location: creater.php?task=new_product&success=1");
                    }
                    exit;
                }
               
            }
            else {
                header("Location: creater.php?task=new_product&success=9");
                exit;
            }
            

        }

    } catch (PDOException $e) {
        header("Location: creater.php?task=no&success");
        exit;
    }
}
//Gérer la creation de gamme
if (isset($_POST["submit"]) && $_GET["id"] == "gamme") {
    if (empty($_POST["nomGamme"]) || empty($_POST["laboGamme"]) || $_POST["laboGamme"] == "--Choisir un laboratoire--") {
        header("Location: creater.php?task=new_gamme&success=0");
        exit;
    }
    $nomGamme = $_POST["nomGamme"];
    $laboratoire = $_POST["laboGamme"];
    //verifier si la gamme existe deja
    try {
        //verifier si la gamme existe deja
        $sql = "SELECT * FROM gamme_produit WHERE categorie = :nomGamme AND id_laboratoire = :labo";
        $result  = $db->prepare($sql);
        $result->bindParam(":nomGamme", $nomGamme);
        $result->bindParam(":laboratoire", $laboratoire);
        $result->execute();
        //si la requête échoue
        if (!$result) {
            echo "Error: " . $sql . "<br>" . $db->errorInfo()[2];
            exit;
        }
        $count = $result->rowCount();

        //si la gamme existe deja
        if ($count > 0) {
            header("Location: creater.php?task=new_gamme&success=7");
        }
        else {
            $sql = "INSERT INTO gamme_produit (categorie, id_laboratoire) VALUES (?,?)";
            $result = $db->prepare($sql);
            $result->execute([$nomGamme, $laboratoire]);
            header("Location: creater.php?task=new_gamme&success=1");
            if (headers_sent()) {
                echo "Headers already sent.";
            } else {
                header("Location: creater.php?task=new_gamme&success=1");
            }
            exit;
        }
        exit;
    } catch (PDOException $e) {
        header("Location: creater.php?task=no&success");
        exit;
    }
}
//gerer l'affectation de delegue zone produit
if (isset($_POST["submit"]) && $_GET["id"] == "affect"){
    foreach ($_POST as $key => $value) {
        ${$key} = $value;
        if (empty($value) && $key != "submit") {
            header("Location: creater.php?task=affect&success=0");
            break;
        }

    }
    //verfier si le delegue a deja une affectation dans la zone avec le produit
    try {
        $sql = "SELECT * FROM delegue_zone_produit WHERE id_delegue = :delegue AND id_zone = :zone AND id_produit = :produit";
        $result  = $db->prepare($sql);
        $result->bindParam(":delegue", $delegue);
        $result->bindParam(":zone", $zone);
        $result->bindParam(":produit", $produit);


        $result->execute();
        //si la requête échoue
        if (!$result) {
            header("Location: creater.php?task=affect&success=error");
        }
        $count = $result->rowCount();
        //si la gamme existe deja
        if ($count > 0) {
            header("Location: creater.php?task=affect&success=10");
            exit;
        }
    } catch (PDOException $e) {
        header("Location: creater.php?task=affect&success=error");
        exit;
    }
    //insertion dans la base de donnees de la table delegue_zone_produit
    try {
        $sql = "INSERT INTO delegue_zone_produit (id_delegue, id_zone, id_produit) VALUES (?,?,?)";
        $result = $db->prepare($sql);
        $result->execute([$delegue, $zone, $produit]);
        header("Location: creater.php?task=affect&success=1");
        if (headers_sent()) {
            echo "Headers already sent.";
        } else {
            header("Location: creater.php?task=affect&success=1");
        }
        exit;
    } catch (PDOException $e) {
        header("Location: creater.php?task=no&success");
        exit;
    }
}
//generate le matricule avec 10 elements, 4lettres, 6 chiffres du nom et prénom et date d'arrivée
function generateMatricule($nom, $prenom, $date_arrivee): string
{
    $matricule = "";
    $nom = strtolower($nom);
    $prenom = strtolower($prenom);
    $date_arrivee = date("Y-m-d", strtotime($date_arrivee));
    $date_arrivee = str_replace("-", "", $date_arrivee);
    $matricule .= substr($nom, 0, 2);
    $matricule .= substr($prenom, 0, 2);
    $matricule .= substr($date_arrivee, 2, 8);
    return $matricule;
}

<?php
 include "include/data.php";
if(!isset($_SESSION)){
    session_start();
}

$cat = $pdo->query("SELECT * FROM categorys")->fetchAll(); // on récupère toutes les catégories existante dans la bdd pour le mettre dans le formulaire


// on récupère toutes les informations des photos du photographe qu'il a mis en ligne, par la suite on utilise ses informations dans une carte
// pour afficher le nombre de photos mis en ligne, en vente et vendu
$imgTotal = $pdo->prepare("SELECT * FROM products WHERE owner = ?");
$imgTotal->bindParam(1, $_SESSION["auth"]->id_utilisateurs);
$imgTotal->execute();

$imgSelled = $pdo->prepare("SELECT * FROM products WHERE owner = ? AND buyed = ?");
$imgSelled->bindParam(1, $_SESSION["auth"]->id_utilisateurs);
$imgSelled->bindValue(2, 1);
$imgSelled->execute();

$imgToSell = $pdo->prepare("SELECT * FROM products WHERE owner = ? AND buyed = ?");
$imgToSell->bindParam(1, $_SESSION["auth"]->id_utilisateurs);
$imgToSell->bindValue(2, 0);
$imgToSell->execute();



 if(!empty($_POST)){

     $title = htmlspecialchars($_POST["title"]);
     $category = intval($_POST["category"]);
     $price = intval($_POST["price"]);

     $target_dir = "files/";
     $target_file = $target_dir . date("Y-mm-dd") . basename($_FILES["img"]["name"]);
     $uploadOk = 1;
     $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // On vérifie si l'image existe
     if (file_exists($target_file)) {
         echo "Désolé image existante";
         $uploadOk = 0;
     }

    // On vérifie sa taille
     if ($_FILES["img"]["size"] > 500000) {
         echo "Fichier trop volumineux";
         $uploadOk = 0;
     }

    // On vérifie son format
     if (!in_array($imageFileType, ['png', 'jpg', 'jpeg'])){
         echo "Désolé, veuillez utiliser seulement des fichiers JPG, JPEG, PNG";
         $uploadOk = 0;
     }

     // On vérifie si l'upload est pas set à 0 par erreur donc est-ce que l'upload a fonctionné
     if ($uploadOk == 1) {
         if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) { // on envois l'image sélectionner dans le formulaire vers le liens pour la stocker
            // tmp_name est un fichier temporaires de $_files qui permet de récupérer le nom de l'image

             $filename = "http://127.0.0.6/files/" .  date("Y-mm-dd") .  basename($_FILES["img"]["name"]);
             // liens qu'on stock dans le bdd pour retrouver l'image

             $owner = intval($_SESSION["auth"]->id_utilisateurs);
             // on récupère l'id utilisateur pour la mettre dans la table products en tant que propriétaire ce qui permet de lui donner les coins quand on achète ses images

             $s = getimagesize($filename); // on récupère la taille de l'image
             $size = "(" . $s[0] . "x" . $s[1] . ")";

             $request = $pdo->prepare("INSERT INTO products (owner, price, name, category, link, size) VALUES (?, ?, ?, ?, ?, ?)");
             $request->bindParam(1, $owner);
             $request->bindParam(2, $price);
             $request->bindParam(3, $title);
             $request->bindParam(4, $category);
             $request->bindParam(5, $filename);
             $request->bindParam(6, $size);

             $request->execute();

             $_SESSION["flash_success"] = "Produit mis en ligne !";
             header("Location: espace-photographe.php");
             exit();

         } else {
             $_SESSION["flash_error"] = "Une erreur est survenue !";
             header("Location: espace-photographe.php");
             exit();
         }
     }else{
         $_SESSION["flash_error"] = "Une erreur est survenue !";
         header("Location: espace-photographe.php");
         exit();
     }
 }
include ("include/entete.inc.php");

?>

<!DOCTYPE html>
<html>
<head>
	<title>PhotoForYou</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Liaison au fichier css de Bootstrap -->
	<link href="Bootstrap/css/bootstrap.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1 class="text-center" style="padding-bottom: 30px">Espace Photographe</h1>
        <div class="row">
            <div class="col-md-4">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">Infos</h5> <!-- on fait apparaître une carte avec les informations de l'utilisateurs à l'intérieur -->
                        <h6 class="card-subtitle mb-2 text-muted"><?= $_SESSION["auth"]->pseudo; ?></h6>
                        <p class="card-text"><?= $_SESSION["auth"]->prenom; ?> <?= $_SESSION["auth"]->nom; ?></p>
                        <p class="card-text"><?= $_SESSION["auth"]->email; ?></p>
                        <p class="card-text">Nombre de coins : <?= $_SESSION["auth"]->coins; ?></p>
                    </div>
                </div>
                <br>
                    <div class="card" style="width: 18rem;">
                        <div class="card-body"> <!-- on affiche le nbr de photo mise en ligne, en vente et aussi celle qui sont vendu -->
                            <h6 class="card-title">Photos mise en ligne : <?= Count($imgTotal->fetchAll()) ?></h6>
                            <h6 class="card-title">Photos vendu : <?= Count($imgSelled->fetchAll()) ?></h6>
                            <h6 class="card-title">Photos en vente : <?= Count($imgToSell->fetchAll()) ?></h6>
                        </div>
                    </div>
            </div>

            <div class="col-md-8 card"> <!-- message de mise en ligne d'une image -->
                <?php if(isset($_SESSION["flash_success"])){ ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Félicitations !</strong> <?= $_SESSION["flash_success"] ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php unset($_SESSION["flash_success"]); } ?>
                <?php if(isset($_SESSION["flash_error"])){ ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Attention !</strong> <?= $_SESSION["flash_error"] ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php unset($_SESSION["flash_error"]); } ?>
                <form method="post" enctype="multipart/form-data">
                    <h4 class="text-center">Publier une image</h4>
                    <div class="form-group">
                        <label>Titre de l'image</label>
                        <input type="text" class="form-control" placeholder="Titre..." name="title">
                    </div>
                    <div class="form-group">
                        <label>Catégorie de l'image</label>
                        <select class="form-control" name="category">
                            <?php
                                foreach ($cat as $c){ // on recherche toutes les catégories et on les affiche dans le formulaire
                                    echo '<option value="' . $c->id  . '">' . $c->name . '</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Prix de l'image (En coins)</label>
                        <input type="number" class="form-control" placeholder="Prix" min="1" step="1" name="price">
                    </div>
                    <div class="form-group">
                        <label>Fichier (PNG, JPG, JPEG)</label>
                        <input type="file" class="form-control-file" id="img" name="img">
                    </div>
                    <img src="#" alt="Prévisualisation..." class="img-fluid" id="previ">
                    <button type="submit" class="btn btn-success btn-block">Soumettre</button>
                </form>
            </div>

        </div>
    </div>

    <?php // Footer
include ("include/footer.inc.php");
?>
<script>
    function readURL(input) { // prévisiulation de l'image, elle affiche le liens de l'image temporaire (tmp_name)
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#previ').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#img").change(function() {
        readURL(this);
    });
</script>
</body>


</html>
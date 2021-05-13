<?php
include ("include/entete.inc.php");
?>

<div class="container">
    <h1 class="text-center" style="padding-bottom: 30px">Espace Client</h1>
    <div class="row">
        <div class="col-md-4">
            <div class="card" style="width: 18rem;">
                <div class="card-body"> <!-- on fait apparaître une carte avec les informations de l'utilisateurs à l'intérieur -->
                    <h5 class="card-title">Infos</h5>
                    <h6 class="card-subtitle mb-2 text-muted"><?= $_SESSION["auth"]->pseudo; ?></h6>
                    <p class="card-text"><?= $_SESSION["auth"]->prenom; ?> <?= $_SESSION["auth"]->nom; ?></p>
                    <p class="card-text"><?= $_SESSION["auth"]->email; ?></p>
                    <p class="card-text">Nombre de coins : <?= $_SESSION["auth"]->coins; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-4"> <!-- on affiche tout les produits qu'il a acheter -->
                    <?php
                        $imgs = $pdo->prepare("SELECT * FROM products WHERE buyer = ?");
                        $imgs->bindParam(1, $_SESSION["auth"]->id_utilisateurs);
                        $imgs->execute();
                        foreach($imgs->fetchAll() as $img){
                            echo '<a href="' . $img->link . '"><img src="' . $img->link . '" class="img-fluid"></a>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>


<?php // Footer
include ("include/footer.inc.php");
?>

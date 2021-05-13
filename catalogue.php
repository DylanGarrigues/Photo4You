<?php
include ("include/entete.inc.php");
include "include/data.php";

$allProducts = $pdo->query("SELECT * FROM products WHERE buyed = 0")->fetchAll();
// on affiche tout les produits dnas le catalogue qui n'ont pas était achetés
?>
<div class="align-content-center">
<div class="container-fluid row">
    <?php foreach ($allProducts as $p){ ?>
        <div class="col-md-3 card">
            <img class="img-fluid" src="<?= $p->link ?>" style="max-height: 3em; max-width: 5em;"> <!-- on utilise le lien stocker dans la bdd pour afficher l'image -->
            <h4 class="text-center"><?= $p->name ?></h4> <!-- on affiche également le nom, le prix et la taille de l'image -->
            <h6 class="text-center">Prix : <?= $p->price ?> coins</h6>
            <h6 class="text-center">Taille de l'image : <?= $p->size ?>px</h6>
            <button class="btn btn-block btn-info cart-add" data-product="<?= $p->id ?>">Ajouter au Panier</button>
        </div>
    <?php } ?>
</div>
</div>

<?php
include("include/footer.inc.php");
?>
<script>
    $(".cart-add").click(function(){ // si click active le script addToCart.php
        _product = $(this).attr('data-product');
        _user = <?= $_SESSION["auth"]->id_utilisateurs ?>;

        //Envoie d'une requête post via Jquery à la page addToCart.php
        $.post( "addToCart.php", { product_id: _product, user: _user });
        window.location.href = "catalogue.php"; // refresh la page en renvoyant sur catalogue

    });
</script>

<?php
include "include/entete.inc.php";
include "include/data.php";

// on récupère toutes les données de l'utilisateur
$req = $pdo->prepare("SELECT * FROM utilisateurs WHERE id_utilisateurs = ?");
$req->bindParam(1, $_SESSION["auth"]->id_utilisateurs);
$req->execute();

$_SESSION["cart"] = json_decode($req->fetch()->cart); // on récupère également son panier
?>
<div class="container-fluid">
    <div id="report"></div>
    <div class="align-content-center">
        <?php // affiche du panier
        $total = 0;
        if(isset($_SESSION["cart"])){
        $articles = $_SESSION["cart"];
        foreach($articles as $a) {
            $as = $pdo->prepare("SELECT * FROM products WHERE id = ?");
            $as->bindParam(1, $a);
            $as->execute();

            $as = $as->fetch();
            if (!$as) continue;
            $total += $as->price; // calcul du total à payer de tout les items
        ?>
            <li class="list-group-item">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="<?= $as->link ?>" class="img-fluid" style="max-height: 5em; max-width: 50%">
                        </div>
                        <div class="col-md-8">
                            <h4><?= $as->name ?></h4>
                            <span class="float-right"><?= $as->price ?> Coins</span>
                            <br>
                            <button data-product="<?= $as->id ?>" class="btn btn-danger remove-cart float-right">Supprimer</button>
                        </div>
                    </div>
                </div>
            </li>
            <?php
        }
        }
        ?>
        </ul>
        <p></p>
        <p class="text-right font-weight-bold">Total : <span class="font-weight-light"><?= $total ?> Coins</span> </p>
    </div>
    <button class="float-right btn btn-primary paiement">Payer</button> <br>
    </div>
</div>

<?php
include "include/footer.inc.php";
?>
<script>
    $(".paiement").click(function(){
        _total = <?= $total ?>; // on récupère le total du panier
        _user = <?= $_SESSION["auth"]->id_utilisateurs ?>; // récupe id_utilisateur
        //activation du script proccesPaiement.php via Jquery
        $.post( "processPaiement.php", { total: _total, user: _user }).done(function( data ) {
            $("#report").html(data);
        });
        setTimeout(refresh, 10000); // refresh de la page au bout de 10 sec


    });

    function refresh(){
        window.location.href = window.location.href; // function pour refresh la page
    }
</script>
<?php
  // Permet de savoir s'il y a une session. 
  // C'est-à-dire si un utilisateur s'est connecté au site
  if(!isset($_SESSION)){
    session_start(); 
  }
?>

<head>
       <meta charset="utf-8">
       <title>PhotoForYou</title>
        <link href="image/header.png" rel="icon">
            <!-- CSS -->
            <link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
            <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

            <!-- JS, Popper.js, et jQuery -->
        <script src="/js/jquery.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
        <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    </head>
    
    <body>
                            <!--Barre de Navigation -->

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="index.php">PhotoForYou</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                </ul>
                <ul class="navbar-nav">
                  <?php if(!isset($_SESSION["auth"])){ ?> <!-- si aucun compte connecter on affiche : -->
                    <li class="nav-item">
                        <a class="nav-link" href="inscription.php">S'inscrire</a>
                      </li>

                    <li class="nav-item">
                        <a class="nav-link" href="connexion.php">S'identifier</a>
                      </li>
                  <?php }else{ ?> <!-- sinon on affiche ça : -->
                    <li class="nav-item"><p class="nav-link">Bonjour
                            <?= $_SESSION["auth"]->pseudo; //affiche pour tout les roles bonjour + leur pseudo ?></p></li>
                    <?php if(intval($_SESSION["auth"]->role) == 1){ ?> <!-- on vérifie son role, 1 = photographe -->
                      <!-- C'est un photographe donc on affiche ça : -->
                      <li class="nav-item">
                        <a class="nav-link" href="espace-photographe.php">Mon espace</a>
                      </li>
                    <?php }else{ ?>
                    <!-- C'est un client donc on affiche ça : -->
                          <li class="nav-item">
                              <a class="nav-link" href="espace-client.php">Mon espace</a>
                          </li>
                      <li class="nav-item">
                        <a class="nav-link" href="catalogue.php">Catalogue</a>
                      </li>
                          <li class="nav-item">
                              <a class="nav-link" href="" data-toggle="modal" data-target="#modal">Mon Panier</a>
                          </li>
                    <?php } ?> <!-- Quand un compte connecté on affiche également le bouton deconnexion pour tous  -->
                    <li class="nav-item">
                        <a class="nav-link" href="deconnexion.php">Déconnexion</a>
                    </li>
                  <?php } ?>
                </ul>
            </div>
        </nav>

        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document"> <!-- on configure le panier -->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Mon Panier</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul class="list-group">
                            <?php // on va calculer le prix total à payer des images stocker dans le cart
                                $total = 0; // on déclare une variable total à 0 pour savoir le total à payer
                                if(isset($_SESSION["cart"])){
                                    include_once "data.php";   //connexion à la BDD
                                    $articles = $_SESSION["cart"];
                                    foreach($articles as $a){ // pour chaque articles dans on fait ça
                                        $as = $pdo->prepare("SELECT * FROM products WHERE id = ?"); // on récupère toute les infos des images
                                        $as->bindParam(1, $a);
                                        $as->execute();

                                        $as = $as->fetch();
                                        if(!$as) continue;
                                        $total += $as->price; // on calcul le prix total de tout les articles accumulés
                            ?>
                                <li class="list-group-item">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <img src="<?= $as->link ?>" class="img-fluid"> <!-- on affiche l'image -->
                                            </div>
                                            <div class="col-md-8">
                                                <h4><?= $as->name ?></h4> <!--  son nom -->
                                                <span class="float-right"><?= $as->price ?> Coins</span> <!--  son prix -->
                                                <br>
                                                <button data-product="<?= $as->id ?>" class="btn btn-danger remove-cart float-right">Supprimer</button> <!-- bouton pour supprimer -->
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
                        <p class="text-right font-weight-bold">Total : <span class="font-weight-light"><?= $total ?> Coins</span> </p> <!-- on affiche le total à payer -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                        <a type="button" class="btn btn-primary" href="payout.php">Payer</a>
                    </div>
                </div>
            </div>
        </div>
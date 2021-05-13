<html>
    <head>
       <meta charset="utf-8">
       <title>PhotoForYou</title>
            <!-- CSS -->
              <link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
              <link rel="stylesheet" href="css/style.css" type="text/css" />

            <!-- JS, Popper.js, et jQuery -->
              <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
              <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
              <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    </head>
    
    <body>
            <?php // Barre de nav
                include ("include/entete.inc.php");
            ?>
                <!-- début de page -->
            <header>
                <div class="container text-center">
                    <img src="image/logo.png">
                </br>
                    <h1>PhotoForYou</h1>
                    <h3>Des pros au service des professionnels de la communication</h3>
                </div>
            </header>
        </br>
                 <!-- Carrousel -->
            <div class="container text-center">
             <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img class="d-block w-100" src="image/carrousel1.png" alt="First slide">
                  </div>
                  <div class="carousel-item">
                    <img class="d-block w-100" src="image/carrousel2.png" alt="Second slide">
                  </div>
                  <div class="carousel-item">
                    <img class="d-block w-100" src="image/carrousel3.jpg" alt="Third slide">
                  </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Précédent</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Suivant</span>
                </a>
              </div>
              <div class="jumbotron jumbotron-fluid">
                <div class="textJumbotron">
                  <p class="lead">Moins de temps à chercher. Plus de résultats. Découvrez les images qui vous aideront à vous démarquer.</p>
                  <p class="lead">
                    <a class="btn btn-primary btn-lg" href="../PhotoForYou2019/inscription.php" role="button">Incrivez-vous !</a>
                  </p>
                </div>

            </div>


                
    <?php // Footer
        include ("include/footer.inc.php");
    ?>

    </body>
</html>

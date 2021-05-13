<!-- Footer -->

<footer class="pt-4 my-md-5 pt-md-5 border-top container">
    <div class="row">
        <div class="col-12 col-md">
            <img class="mb-2" src="image/logo.png" alt="" width="100" height="50">
            <small class="d-block mb-3 text-muted">&copy; 2021 - PhotoForYou</small>
        </div>
                          
        <div class="col-6 col-md">
            <h5>Liens</h5>
            <ul class="list-unstyled text-small">
                    <li><a class="text-muted" href="#">Notre charte qualité</a></li>
            </ul>
        </div>
                          
            <div class="col-6 col-md">
                <h5>Nous contacter</h5>
                    <ul class="list-unstyled text-small">
                        <li><a class="text-muted" href="#">Formulaire de contact</a></li>
                        <li><a class="text-muted" href="#">xx xx xx xx xx</a></li>
                </ul>
            </div>
                
            <dv class="col-6 col-md">
                <h5>Nous connaitre</h5>
                    <ul class="list-unstyled text-small">
                        <li><a class="text-muted" href="#">Nos informations</a></li>
                    </ul>
            </div>
            
    </div>

    <script> // fonction pour supprimer un items d'un panier ou de la page de paiement
        $(".remove-cart").click(function(){
            _product = $(this).attr('data-product');
            _user = <?= $_SESSION["auth"]->id_utilisateurs ?>;
            $.post( "removeToCart.php", { product_id: _product, user: _user });
            window.location.href = window.location.href;
        });
    </script>
</footer>
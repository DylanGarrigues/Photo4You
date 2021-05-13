<?php
    include "include/data.php";
    session_start();

    $user = intval($_POST["user"]);
    $total = intval($_POST["total"]);

    $req = $pdo->prepare("SELECT * FROM utilisateurs WHERE id_utilisateurs = ?");
    $req->bindParam(1, $user); // on récupère les données de l'utilisateur
    $req->execute();

    $user = $req->fetch();

    if($total <= 0){
        echo "Votre panier est vide !";
        return;
    }

    if ($user->coins < $total) {
        echo "Désolé ! Vous n'avez pas assez de coins !";
        return;
    }

    $cart = json_decode($user->cart); // on récupère le cart de l'utilisateur
    $alreadyBuyed = array();

    foreach ($cart as $c) {
        $product = $pdo->prepare("SELECT * FROM products WHERE id = ?");
        $product->bindParam(1, $c);
        $product->execute();

        $product = $product->fetch();
        if($product->buyed == 1){
            array_push($alreadyBuyed, $c);
            continue;
        }

        $stay = $user->coins - $product->price; //on retire les coins à l'utilisateur
        $updateUser = $pdo->prepare("UPDATE utilisateurs SET coins = ? WHERE id_utilisateurs = ?");
        $updateUser->bindParam(1, $stay);
        $updateUser->bindParam(2, $user->id_utilisateurs);
        $updateUser->execute();

        $seller = $pdo->prepare("SELECT * FROM utilisateurs WHERE id_utilisateurs = ?"); //on récupère le vendeur de chaque image
        $seller->bindParam(1, $product->owner);
        $seller->execute();
        $seller = $seller->fetch();

        $toCredit = $seller->coins + $product->price; // on lui donne les coins des images qu'il a vendu
        $updateSeller = $pdo->prepare("UPDATE utilisateurs SET coins = ? WHERE id_utilisateurs = ?");
        $updateSeller->bindParam(1, $toCredit);
        $updateSeller->bindParam(2, $seller->id_utilisateurs);
        $updateSeller->execute();

        $updateProduct = $pdo->prepare("UPDATE products SET buyed = ?, buyer = ? WHERE id = ?");
        $updateProduct->bindValue(1, 1); // on met l'image en vendu pour pas que quelqu'un d'autre ne l'achète
        $updateProduct->bindParam(2, $user->id_utilisateurs); // c'est à dire qu'il n'apparait plus dans le catalogue
        $updateProduct->bindParam(3, $c);
        $updateProduct->execute();
    }

    if(!empty($alreadyBuyed)){ // on vérifie s'il y a des objets déjà achetés et si oui on indique lesquels et on ne fait pas la transaction
                              // donc il n'aura pas les images déjà achetés
        echo "Les produits suivants sont déjà achetés :";
        foreach ($alreadyBuyed as $buyed){
            $product = $pdo->prepare("SELECT * FROM products WHERE id = ?");
            $product->bindParam(1, $c);
            $product->execute();

            $product = $product->fetch();
            echo "<br>- " . $product->name;
        }
        echo "<br>Les articles non disponnibles cité précedemment n'ont donc pas été débité";
    }

    $_SESSION["cart"] = array(); // on vide le panier
    $cart = json_encode($_SESSION["cart"]);
    $req = $pdo->prepare("UPDATE utilisateurs SET cart = ? WHERE id_utilisateurs = ?");
    $req->bindParam(1, $cart);
    $req->bindParam(2, $user->id_utilisateurs);

    $req->execute();
    echo "<br>Vos achats ont bien été effectués";
?>
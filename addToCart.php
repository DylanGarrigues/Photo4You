<?php
// script pour ajouter les items dans les paniers
    $product_id = intval($_POST["product_id"]);
    $user = intval($_POST["user"]);

    session_start();

    if(!isset($_SESSION["cart"])){ // on vérifie si le cart existe, et si non on le créer vide
        $_SESSION["cart"] = array();
        }

    $array = $_SESSION["cart"]; // on utilise array pour stocker le panier dans le bdd dans la table utilisateurs
    if(in_array($product_id, $array)){ // on récupère seulement l'id de l'item s'électionner
        return;
    }
    array_push($array, $product_id);
    array_unique($array); // on insère les id dans le bdd
    $_SESSION["cart"] = $array; // mise à jour du cart dans le bdd

    include "include/data.php";

    $cart = json_encode($array); // permet de faire l'ajout en json pour que ça soit "interactif"

    $req = $pdo->prepare("UPDATE utilisateurs SET cart = ? WHERE id_utilisateurs = ?");
    $req->bindParam(1, $cart);
    $req->bindParam(2, $user); // ça ajoute les items du panier dans la bdd en format [idItems, idItems, ...]

    $req->execute();

?>
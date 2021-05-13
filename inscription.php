<?php
$errors = array();
if(!empty($_POST)){
  
    //  -> htmlspecialchars évite l'injection de code dans le formulaire
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = htmlspecialchars($_POST['mail']);
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $password = htmlspecialchars($_POST['mdp']);
    $password_confirm = htmlspecialchars($_POST['mdp_confirm']);
    $role = isset($_POST['role']);

    if($email == null || $pseudo == null || $password == null || $password_confirm == null || $nom == null || $prenom == null){
        $errors["missingfields"] = "Un champs est manquant !";
    }

    if($password != $password_confirm){
        $errors["pass_not_match"] = "Les mots de passe ne correspondent pas !";
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors['email_format'] = "Le format de votre email est incorrect";
    }

    $role_id = 0;
    if($role){       // le role est automatiquement set à 0 qui est le role client, et si on clique pour choisir photographe, ça passe sur 1
      $role_id = 1;
    }

    // Les verifications ont été effectués maintenant on insère les données dans la DB

    if(empty($errors)){

//connecter à la DB

require "include/data.php";

//
      $req = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
      $req->bindParam(1, $email);

      $req->execute();
      $account = $req->fetch();

      if($account){
        //on vérifie si le compte existe déjà
        $errors["erreurs"] = "L'adresse mail est déjà utilisée !";
      }
      else{
        //require dba_close
        $hash_pass = password_hash($password, PASSWORD_BCRYPT); // sert à cripter le mdp dans la db
        $request = $pdo->prepare("INSERT INTO utilisateurs ( email, pseudo, motdepasse, role, nom, prenom) VALUES (?, ?, ?, ?, ?, ?)");
        $request->bindParam(1, $email);
        $request->bindParam(2, $pseudo);
        $request->bindParam(3, $hash_pass);
        $request->bindParam(4, $role_id);
        $request->bindParam(5, $nom);
        $request->bindParam(6, $prenom);


        $r = $request->execute(); //recupere if ok

        if($r) {
            //redirection vers Login
            session_start();
            $_SESSION["flash"] = "Inscription réussie !";
            header("Location: connexion.php");
            exit();
        }
      }

    }
 

}
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
  <?php // Barre de nav
  include ("include/entete.inc.php");
  ?>

  <div class="container">
    <div class="jumbotron">
      <h1 class="display-4">Inscription</h1>
      <p class="lead">Merci de remplir ce formulaire d'inscription.</p>
      <hr class="my-4">
      <p>Vous ferez bientôt parti de nos membres.</p>
      <p>Vous avez fait le bon choix ;-)</p>
    </div>

    <?php if(!empty($errors)){ ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Attention !</strong> Une ou plusieurs erreurs sont surevenues :
          <ul>
          <?php foreach($errors as $e){ echo '<li>' . $e . '</li>'; } ?>
          </ul>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
    <?php } ?>

    <form method = "POST">

      <div class="form-row">

      <div class="form-group col-md-6">
          <label>Nom</label>
          <input type="text" class="form-control" name="nom" maxlength="25" required>
        </div>

        <div class="form-group col-md-6">
          <label>Prénom</label>
          <input type="text" class="form-control" name="prenom" maxlength="25" required>
        </div>


        <div class="form-group col-md-6">
          <label>Adresse mail</label>
          <input type="email" class="form-control" name="mail" required>
        </div>

        <div class="form-group col-md-6">
          <label>Pseudo</label>
          <input type="text" class="form-control" name="pseudo" required>
        </div>
        
        <div class="form-group col-md-6">
          <label>Mot de passe</label>
          <input type="password" class="form-control" name="mdp" required>
        </div>
        
        <div class="form-group col-md-6">
          <label>Confirmation du mot de passe</label>
          <input type="password" class="form-control" name="mdp_confirm" required>
        </div>
        
      </div>

<!-- Choix entre client et photographe -->
      <input type="checkbox" name="role" checked data-toggle="toggle"
             data-on="Photographe" data-off="Client" data-onstyle="danger" data-offstyle="info">
<!-- -->      

    <button type="submit" style="margin-top: 20px" class="btn btn-success btn-block">Je m'inscris !</button>

  </form>

</div>

<?php // Footer
include ("include/footer.inc.php");
?>
</body>
</html>
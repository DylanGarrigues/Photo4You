<?php
$errors = array();
if(!empty($_POST)) {
  $email = htmlspecialchars($_POST["email"]);
  $motdepasse = htmlspecialchars($_POST["mdp"]);
  require "include/data.php";
  $req = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
  $req->bindParam(1, $email);

  $req->execute();
  $account = $req->fetch();

  if($account){
    //on vérifie si le compte existe déjà
    if(password_verify( $motdepasse , $account->motdepasse)) {
      session_start();
      $_SESSION["auth"] = $account;
      $_SESSION["cart"] = json_decode($account->cart);
      header("Location: index.php");
      exit();
    }
    else{
      $errors["erreurs"] = "Le mot de passe est incorrect !";
    }

  }
} 
include ("include/entete.inc.php");


?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Liaison au fichier css de Bootstrap -->
	<link href="Bootstrap/css/bootstrap.css" rel="stylesheet">
</head>

<body>
	<div class="container">
    <div class="jumbotron">

<!-- Message d'alerte inscription réussie -->
<?php if(isset($_SESSION["flash"])){ ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Bienvenue !</strong> Votre inscription est un succès !
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<?php unset($_SESSION["flash"]); } ?>
<!-- END -->

      <h1 class="display-4">Connexion</h1>
      <hr class="my-4">
      <p class="lead">Merci de vous identifier</p>
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

<!-- zone de connexion -->
<form method = "POST">

<div class="form-row">

  <div class="form-group col-md-6">
    <label>Email</label>
    <input type="text" class="form-control" name="email" required>
  </div>
  
  <div class="form-group col-md-6">
    <label>Mot de passe</label>
    <input type="password" class="form-control" name="mdp" required>
  </div>

<button type="submit" style="margin-top: 20px" class="btn btn-success btn-block">Connexion</button>

</form>

</div>
  <?php
    include ("include/footer.inc.php");
  ?>
</body>
</html>
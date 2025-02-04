<?php
include 'config.php';

$prenom = "";
$nom = "";
$username = "";
$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $prenom = $_POST['prenom'];
  $nom = $_POST['nom'];
  $username = $_POST['username'];
  $passwd = $_POST['mdp'];
  $passwdConfirm = $_POST['mdpconfirm'];

  if ($prenom && $nom && $username && $passwd && $passwdConfirm) {
    $users = getUsers();

    for ($i = 0; $i < count($users); $i++) {
      if ($users[$i]['username'] == $username) {
        $errorMessage = "Ce username est déjà pris.";
      }
    }

    if (strlen($passwd) < 8) {
      $errorMessage = "Le mot de passe doit avoir au moins 8 caractères.";
    }

    if ($passwd !== $passwdConfirm) {
      $errorMessage = "Les mots de passes ne sont pas pareils.";
    }
  } else {
    $errorMessage = "Ne laissez pas des champs vide.";
  }

  if ($errorMessage == "") {
    $sql = "INSERT INTO users (`first_name`, `last_name`, `username`, `password`) 
        VALUES (:first_name, :last_name, :username, :password)";
    $req = $conn->prepare($sql);
    $req->bindParam(':first_name', $prenom);
    $req->bindParam(':last_name', $nom);
    $req->bindParam(':username', $username);
    $req->bindParam(':password', $passwd);
    $req->execute();
    header('Location: login.php');
    die();
  }
  /*
  En cas d’erreur, affichez un message et pré-remplissez les champs
  (sauf le mot de passe). Si toutes les conditions sont remplies, créez le compte dans
  la base et redirigez l’utilisateur vers login.php.*/
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="register.css">
  <script defer src="main.js"></script>
  <script defer src="registerHandler.js"></script>

</head>

<body>

  <!--HEADER-->
  <header>
    <h1>
      <img src="./assets/icon.png" alt="icon" width="25" class="logo">
      DynamiQ
    </h1>

    <div class="hamburger-menu">
      <input id="burger_toggle" type="checkbox" />
      <label class="burger_btn" for="burger_toggle">
        <span></span>
      </label>
      <ul class="burger_opened">
        <li><button class="burger_item btn-vers-main">Principale</button></li>
        <li><button class="burger_item btn-vers-liste">Activités</button></li>
        <li><button class="burger_item btn-vers-formulaire">Formulaire</button></li>
        <li><button class="burger_item btn-vers-login">Login</button></li>
      </ul>
    </div>
  </header>

  <main>
    <div id="register-form">
      <h2>S'enregistrer</h2>
      <form method="post">
        <label for="prenom">Prénom:</label><br>
        <input type="text" name="prenom" id="register-prenom" value="<?php echo htmlspecialchars($prenom); ?>"><br><br>

        <label for="nom">Nom:</label><br>
        <input type="text" name="nom" id="register-nom" value="<?php echo htmlspecialchars($nom); ?>"></input><br><br>

        <label for="username">Nom d'utilisateur:</label><br>
        <input type="username" name="username" id="register-username"
          value="<?php echo htmlspecialchars($username); ?>"></input><br><br>

        <label for="mdp">Mot de passe:</label><br>
        <input type="password" name="mdp" id="register-password"></input><br><br>

        <label for="mdpconfirm">Confirmer le mot de passe:</label><br>
        <input type="password" name="mdpconfirm" id="register-password-confirm"></input><br><br>

        <p name="errorMessage"><?php echo htmlspecialchars($errorMessage); ?></p>

        <div>
          <button type="submit" name="submitBtn" id="register-button">Créer le compte</button>
        </div>

        <h3>Vous avez déjà un compte?</h3><br>
        <a href="login.php">Se connecter</em></a>

      </form>
    </div>
  </main>

  <!--FOOTER-->
  <footer>
    <table class="flex-centered">
      <thead>
        <tr>
          <th>Nous contacter</th>
          <th>Proposez un cours chez nous</th>
          <th>Suivez nous</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Adresse : 123 Rue du Sport, Montréal, QC</td>
          <td>
            Joignez notre équipe et contribuez à inspirer le bien-être à travers vos compétences sportives.
          </td>
          <td>
            <table>
              <tbody>
                <tr>
                  <td><img src="./assets/social-media-icons/tile000.png" alt="instagram" width="50"></td>
                  <td><img src="./assets/social-media-icons/tile001.png" alt="facebook" width="50"></td>
                  <td><img src="./assets/social-media-icons/tile007.png" alt="linkedin" width="50"></td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table>
    <p class="grey-text flex-centered">
      <small>&copy; 2025 Le centre sportif, tous droits réservés.</small>
    </p>
  </footer>

</body>

</html>
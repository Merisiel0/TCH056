<?php
include 'config.php';

// Récupération des listes
$coaches = getCoaches();
$niveaux = getNiveaux();
$lieux = getLieux();
$activities = getActivities();

$joursDeLaSemaine = ['Tous', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];

/**
 * On récupère les valeurs sélectionnées dans le formulaire.
 * Si aucune valeur n'a été envoyée, on utilise 0 par défaut (qui correspond à "Tous").
 */
$selectedNiveau = isset($_GET['level']) ? intval($_GET['level']) : 0;
$selectedLieu   = isset($_GET['place']) ? intval($_GET['place']) : 0;
$selectedCoach  = isset($_GET['coach']) ? intval($_GET['coach']) : 0;
$selectedJour   = isset($_GET['schedule']) ? intval($_GET['schedule']) : 0;

$filteredActivities = [];


foreach ($activities as $activity) {
    $correspond = true;

    // Filtre par niveau (si selectedNiveau != 0, on compare le name correspondant)
    if ($selectedNiveau !== 0) {
        $niveauName = $niveaux[$selectedNiveau]['name']; 
        if ($activity['level'] !== $niveauName) {
            $correspond = false;
        }
    }

    // Filtre par lieu
    if ($selectedLieu !== 0) {
        $lieuName = $lieux[$selectedLieu]['name'];
        if ($activity['location'] !== $lieuName) {
            $correspond = false;
        }
    }

    // Filtre par coach
    if ($selectedCoach !== 0) {
        $coachName = $coaches[$selectedCoach]['name'];
        if ($activity['coach'] !== $coachName) {
            $correspond = false;
        }
    }

    // Filtre par jour de la semaine
    if ($selectedJour !== 0) {
        $jourName = $joursDeLaSemaine[$selectedJour];
        if ($activity['schedule_day'] !== $jourName) {
            $correspond = false;
        }
    }

    // Si l'activité correspond à tous les filtres, on l'ajoute au tableau final
    if ($correspond) {
        $filteredActivities[] = $activity;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Projet-de-Session</title>
  <link rel="stylesheet" href="liste-activite.css" />
  <script defer src="main.js"></script>
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
        <li><button class="burger_item btn-vers-formulaire">Formulaire</button></li>
        <li><button class="burger_item btn-vers-login">Login</button></li>
        <li><button class="burger_item btn-vers-register">S'enregistrer</button></li>
      </ul>
    </div>
  </header>

  <!--MAIN SECTION-->
  <main>
    <div class="filtre">
      <h2>Filtrer les activités</h2>
      <form method="GET" action="">
        <table>
          <thead>
            <tr>
              <th>
                <label for="level">Niveau :</label>
                <select name="level" id="level">
                  <option value="0">Tous</option>
                  <?php
                  // On boucle sur tous les niveaux pour remplir le select
                  for ($i = 1; $i < count($niveaux); $i++) {
                    $str = $niveaux[$i]['name'];
                    $selected = ($selectedNiveau === $i) ? "selected" : "";
                    echo "<option value='$i' $selected>$str</option>";
                  }
                  ?>
                </select>
              </th>

              <th>
                <label for="place">Lieu :</label>
                <select name="place" id="location">
                  <option value="0">Tous</option>
                  <?php
                  for ($i = 1; $i < count($lieux); $i++) {
                    $str = $lieux[$i]['name'];
                    $selected = ($selectedLieu === $i) ? "selected" : "";
                    echo "<option value='$i' $selected>$str</option>";
                  }
                  ?>
                </select>
              </th>

              <th>
                <label for="coach">Coach :</label>
                <select name="coach" id="coach">
                  <option value="0">Tous</option>
                  <?php
                  for ($i = 1; $i < count($coaches); $i++) {
                    $str = $coaches[$i]['name'];
                    $selected = ($selectedCoach === $i) ? "selected" : "";
                    echo "<option value='$i' $selected>$str</option>";
                  }
                  ?>
                </select>
              </th>

              <th>
                <label for="schedule">Horaire :</label>
                <select name="schedule" id="day">
                  <?php
                  foreach ($joursDeLaSemaine as $index => $jour) {
                    $selected = ($selectedJour === $index) ? "selected" : "";
                    echo "<option value='$index' $selected>$jour</option>";
                  }
                  ?>
                </select>
              </th>

              <th>
                <button type="submit">Appliquer</button>
              </th>
            </tr>
          </thead>
        </table>
      </form>
    </div>

    <br>

    <!-- Liste des activités-->
    <div class="sports-container" id="sports-liste">
      <?php
      foreach ($filteredActivities as $activity):
        $image        = $activity['image'];
        $name         = $activity['name'];
        $description  = $activity['description'];
        $level        = $activity['level'];
        $schedule_day = $activity['schedule_day'];
        $coach        = $activity['coach'];
        $location     = $activity['location'];

        $className = strtolower(str_replace(' ', '-', $name));
      ?>
        <div class="<?php echo $className; ?>">
          <article>
            <img src="<?php echo $image; ?>" alt="<?php echo $name; ?>" width="150"><br>
            <h3><?php echo $name; ?></h3>
            <button class="modifier btn-vers-formulaire">Modifier</button>
            <p><?php echo $description; ?></p><br>
            <p>Horaire : <?php echo $schedule_day; ?></p><br>
            <p>Niveau : <?php echo $level; ?></p><br>
            <p>Entraîneur : <?php echo $coach; ?></p><br>
            <p>Lieu : <?php echo $location; ?></p><br>
          </article>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="ajouter-container">
      <button id="ajouter" class="btn-vers-formulaire">
        Ajouter une activité
      </button>
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
          <td>
            Adresse : 123 Rue du Sport, Montréal, QC
          </td>
          <td>
            Joignez notre équipe et contribuez à inspirer le bien-être à
            travers vos compétences sportives.
          </td>
          <td>
            <table>
              <tbody>
                <tr>
                  <td>
                    <img src="./assets/social-media-icons/tile000.png" alt="instagram" width="50">
                  </td>
                  <td>
                    <img src="./assets/social-media-icons/tile001.png" alt="facebook" width="50">
                  </td>
                  <td>
                    <img src="./assets/social-media-icons/tile007.png" alt="linkedin" width="50">
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table>
    <p class="grey-text flex-centered">
      <small>
        &copy; 2025 Le centre sportif, tous droits réservés.
      </small>
    </p>
  </footer>
</body>
</html>

<?php

require '../constants.php';
error_reporting(SHOW_ERROR);
ini_set('display_errors', SHOW_ERROR);

include_once '../templates/header.php';

require_once '../services/AthletesService.php';
require_once '../models/Athlete.php';
require_once '../services/DatabaseService.php';
require_once '../services/DisciplinesService.php';

class AthletesView {
 
  private $_athletesService = null;
  private $_disciplinesService = null;

  private $_athletes = array();
  private $_incrementNumber = 1;

  private $_showInfoThatAthletesNotExist = false;

  public function __construct() {
    $this->_athletesService = new AthletesService();
    $this->_disciplinesService = new DisciplinesService();

    $this->_athletes = $this->_athletesService->getAll();
    if (count($this->_athletes) == 0) $this->_showInfoThatAthletesNotExist = true;
    
    $this->deleteAthlete();

    $this->render();
  }

  private function deleteAthlete(): void {
    if (isset($_POST["deleteAthlete"])) {
      $athleteId = $_POST["athleteId"];
      $disciplineId = $_POST["disciplineId"];
      $result = $this->_athletesService->delete($athleteId, $disciplineId);
      ?>
      <script>
        location.href = 'http://localhost/pawel-relinski-ranking/views/athletesview.php';
      </script>
      <?php
    }
  }

  private function getDisciplineName(int $disciplineId): string {
    $discipline = $this->_disciplinesService->getById($disciplineId);
    return $discipline->getName();
  }

  private function render(): void {
    ?>
    <h1>Sportowcy</h1>
    <a class="btn btn-success mb-2 mt-3" href="./AddAthleteView.php">
      Dodaj sportowca
    </a>
    <?php if ($this->_showInfoThatAthletesNotExist): ?>
    <div class="alert alert-warning mt-4" role="alert">
      Brak sportowców
    </div>
    <?php else: ?>
    <table class="table table-striped">
    <thead>
        <tr>
          <th>#</th>
          <th>Imię</th>
          <th>Nazwisko</th>
          <th>Dyscyplina</th>
          <th>Szczegóły</th>
          <th>Edytuj</th>
          <th>Usuń</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($this->_athletes as $athlete): ?>
      <tr>
        <td class="align-middle"><?php echo $this->_incrementNumber;  ?></td>
        <td class="align-middle"><?php echo $athlete->getFirstName();  ?></td>
        <td class="align-middle"><?php echo $athlete->getLastName();  ?></td>
        <td class="align-middle"><?php echo $this->getDisciplineName((int)$athlete->getDisciplineId()); ?></td>
        <td class="align-middle">
          <form action="./AthleteDetailsView.php" method="get">
            <input type="submit" class="btn btn-primary" value="Szczegóły">
            <input type="hidden" name="athleteId" value="<?php echo $athlete->getId(); ?>">
          </form>
        </td>
        <td class="align-middle">
          <form action="./editathleteview.php" method="get">
            <input type="submit" class="btn btn-warning" value="Edytuj">
            <input type="hidden" name="athleteId" value="<?php echo $athlete->getId(); ?>">
          </form>
        </td>
        <td class="align-middle">
          <form action="./ConfirmDeleteAthlete.php" method="post">
            <input type="submit" class="btn btn-danger" name="deleteAthlete" value="Usuń">
            <input type="hidden" name="disciplineId" value="<?php echo $athlete->getDisciplineId(); ?>">
            <input type="hidden" name="athleteId" value="<?php echo $athlete->getId(); ?>">
          </form>
        </td>
      </tr>
      <?php $this->_incrementNumber += 1; ?>
      <?php endforeach; ?>
      </tbody>
    </table>
    <?php endif; ?>
    <?php
  }

}

$athletesView = new AthletesView();

include_once '../templates/footer.php';

<?php

require '../constants.php';
error_reporting(SHOW_ERROR);
ini_set('display_errors', SHOW_ERROR);

include_once '../templates/header.php';

require_once '../services/AthletesService.php';
require_once '../models/Athlete.php';
require_once '../services/DatabaseService.php';
require_once '../services/DisciplinesService.php';

class AthletesInDisciplineView {

  private $_athletesService = null;
  private $_disciplinesService = null;

  private $_athletes = array();
  private $_discipline = null;

  private $_incrementNumber = 1;

  private $_showInfoThatAthletesNotExist = false;

  public function __construct() {
    $this->_athletesService = new AthletesService();
    $this->_disciplinesService = new DisciplinesService();

    $this->setDiscipline();

    $this->_athletes = $this->_athletesService->getAllByDisciplineId($this->_discipline->getId());
    if (count($this->_athletes) == 0) $this->_showInfoThatAthletesNotExist = true;

    $this->render();
  }

  private function setDiscipline(): void {
    if (isset($_GET["showAthletes"])) {
      $disciplineId = (int)$_GET["disciplineId"];
      $this->_discipline = $this->_disciplinesService->getById($disciplineId);
    }
  }

  private function render(): void {
    ?>
    <h1><?php echo ucfirst($this->_discipline->getName()); ?></h1>
    <a type="button" class="btn btn-link" href="./DisciplinesView.php">Wróć</a>
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
          <th>Szczegóły</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($this->_athletes as $athlete): ?>
      <tr>
        <td class="align-middle"><?php echo $this->_incrementNumber;  ?></td>
        <td class="align-middle"><?php echo $athlete->getFirstName();  ?></td>
        <td class="align-middle"><?php echo $athlete->getLastName();  ?></td>
        <td class="align-middle">
          <form action="./AthleteDetailsView.php" method="get">
            <input type="submit" class="btn btn-primary" value="Szczegóły">
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

$athletesInDisciplineView = new AthletesInDisciplineView();

include_once '../templates/footer.php';

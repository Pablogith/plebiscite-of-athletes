<?php

require '../constants.php';
error_reporting(SHOW_ERROR);
ini_set('display_errors', SHOW_ERROR);

include_once '../templates/header.php';

require_once '../services/AthletesService.php';
require_once '../models/Athlete.php';
require_once '../services/DatabaseService.php';
require_once '../services/DisciplinesService.php';

class EditDisciplineView {

  private $_athletesService = null;
  private $_disciplinesService = null;

  private $_athletes = array();
  private $_discipline = null;

  private $_seasonsNames = ["all_ year_round", "winter", "summer"];

  public function __construct() {
    $this->_athletesService = new AthletesService();
    $this->_disciplinesService = new DisciplinesService();

    $this->setDiscipline();
    $this->handleUpdateDiscipline();

    $this->render();
  }

  private function setDiscipline(): void {
    if (isset($_GET["disciplineId"])) {
      $disciplineId = (int)$_GET["disciplineId"];
      $this->_discipline = $this->_disciplinesService->getById($disciplineId);
    }
  }

  private function handleUpdateDiscipline(): void {
    if (isset($_POST["editDiscipline"])) {
      $name = $_POST["Name"];
      $season = $_POST["Season"];
      $disciplineId = (int)$_POST["DisciplineId"];

      $discipline = new Discipline($name, $season);
      $discipline->setId($disciplineId);

      $this->_disciplinesService->update($discipline);

      echo "<script>location.href = \"http://localhost/pawel-relinski-ranking/views/EditDisciplineView.php?disciplineId=$disciplineId\";</script>";
    }
  }

  private function render(): void {
    ?>
    <a class="btn btn-link" href="./disciplinesview.php">Wróć</a>
    <h1>Edytuj dyscyplinę</h1>
    <form action="<?php echo basename($_SERVER['PHP_SELF']) . "?disciplineId=" . $this->_discipline->getId(); ?>" method="post">
      <div class="row">
        <div class="col">
        <label for="Name" class="form-label">Nazwa</label>
          <input type="text" class="form-control" aria-label="Name" id="Name" name="Name" value="<?php echo $this->_discipline->getName(); ?>">
          <input type="hidden" name="DisciplineId" value="<?php echo $this->_discipline->getId(); ?>">
        </div>
        <div class="col">
          <label for="Season" class="form-label">Sezon</label> <br>
          <select class="form-select form-select-lg mb-3 mt-1" aria-label="Season" id="Season" name="Season">
            <?php foreach ($this->_seasonsNames as $season): ?>
              <?php if ($season == $this->_discipline->getSeason()): ?>
                <option value="<?php echo $season ?>" selected><?php echo ucfirst(Discipline::convertNameToPl($season)); ?></option>
              <?php else: ?>
                <option value="<?php echo $season ?>"><?php echo ucfirst(Discipline::convertNameToPl($season)); ?></option>
              <?php endif; ?>
            <?php endforeach; ?>
            ?>
          </select>
        </div>
      </div>
      <button type="submit" class="btn btn-success mb-2 mt-3" value="editDiscipline" name="editDiscipline">
        Zapisz zmiany
      </button>
    </form>
    <?php
  }

}

$editDisciplineView = new EditDisciplineView();

include_once '../templates/footer.php';

<?php

require '../constants.php';
error_reporting(SHOW_ERROR);
ini_set('display_errors', SHOW_ERROR);

include_once '../templates/header.php';

require_once '../services/DatabaseService.php';
require_once '../services/DisciplinesService.php';
require_once '../models/Discipline.php';

class AddDisciplineView {

  private $_disciplinesService = null;

  public function __construct() {
    $this->_disciplinesService = new DisciplinesService();

    $this->handleAddDiscipline();
    $this->render();
  }

  private function handleAddDiscipline(): void {
    if (isset($_POST["addDiscipline"])) {
      $name = $_POST["Name"];
      $season = $_POST["Season"];

      $discipline = new Discipline($name, $season);
      $this->_disciplinesService->create($discipline);
    }
  }

  private function render(): void {
    ?>
    <a class="btn btn-link" href="./disciplinesview.php">Wróć</a>
    <h1>Dodaj dyscypline</h1>
    <form action="<?php echo basename($_SERVER['PHP_SELF']); ?>" method="post">
      <div class="row">
        <div class="col">
        <label for="Name" class="form-label">Nazwa</label>
          <input type="text" class="form-control" aria-label="Name" id="Name" name="Name">
        </div>
        <div class="col">
          <label for="Season" class="form-label">Sezon</label> <br>
          <select class="form-select form-select-lg mb-3 mt-1" aria-label="Season" id="Season" name="Season">
            <option value="all_ year_round">Całoroczny</option>
            <option value="winter">Zimowy</option>
            <option value="summer">Letni</option>
          </select>
        </div>
      </div>
      <button type="submit" class="btn btn-success mb-2 mt-3" value="addDiscipline" name="addDiscipline">
        Dodaj
      </button>
    </form>
    <?php
  }

}

$addDisciplineView = new AddDisciplineView();

include_once '../templates/footer.php';

<?php

require '../constants.php';
error_reporting(SHOW_ERROR);
ini_set('display_errors', SHOW_ERROR);

include_once '../templates/header.php';

require_once '../services/DatabaseService.php';
require_once '../services/DisciplinesService.php';
require_once '../models/Discipline.php';

class DisciplinesView {

  private $_disciplinesService = null;

  private $_disciplines = array();
  private $_incrementNumber = 1;

  private $_showInfoThatDisciplinesNotExist = false;

  public function __construct() {
    $this->_disciplinesService = new DisciplinesService();
    $this->_disciplines = $this->_disciplinesService->getAll();

    if (count($this->_disciplines)  == 0) $this->_showInfoThatDisciplinesNotExist = true;

    $this->deleteDiscipline();
    $this->render();
  }

  private function deleteDiscipline(): void {
    if (isset($_POST["deleteDiscipline"])) {
      $disciplineId = $_POST["disciplineId"];
      $result = $this->_disciplinesService->delete((int)$disciplineId);
      ?>
      <script>
        location.href = 'http://localhost/pawel-relinski-ranking/views/DisciplinesView.php';
      </script>
      <?php
    }
  }

  private function render(): void {
    ?>
    <h1>Dyscypliny</h1>
    <a type="button" class="btn btn-success mb-2 mt-3" href="./AddDisciplineView.php">
      Dodaj dyscypline
    </a>
    <?php if ($this->_showInfoThatDisciplinesNotExist): ?>
    <div class="alert alert-warning" role="alert">
      Brak dyscyplin
    </div>
    <?php else: ?>
    <table class="table table-striped">
    <thead>
        <tr>
          <th>#</th>
          <th>Nazwa</th>
          <th>Sezon</th>
          <th>Ilość zawodników</th>
          <th>Zawodnicy</th>
          <th>Edytuj</th>
          <th>Usuń</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($this->_disciplines as $discipline): ?>
        <tr>
        <td class="align-middle"><?php echo  $this->_incrementNumber; ?></td>
        <td class="align-middle"><?php echo $discipline->getName();  ?></td>
        <td class="align-middle"><?php echo ucfirst($discipline->getSeason('pl'));  ?></td>
        <td class="align-middle"><?php echo $discipline->getNumberOfAthletes();  ?></td>
        <td class="align-middle">
          <form action="./AthletesInDisciplineView.php" method="get">
            <input type="submit" class="btn btn-primary" name="showAthletes" value="Wyświetl">
            <input type="hidden" name="disciplineId" value="<?php echo $discipline->getId(); ?>">
          </form>
        </td>
        <td class="align-middle">
          <form action="./EditDisciplineView.php" method="get">
            <input type="submit" class="btn btn-warning" value="Edytuj">
            <input type="hidden" name="disciplineId" value="<?php echo $discipline->getId(); ?>">
          </form>
        </td>
        <td class="align-middle">
          <form action="./ConfirmDeleteDiscipline.php" method="post">
            <input type="submit" class="btn btn-danger" name="deleteDiscipline" value="Usuń">
            <input type="hidden" name="disciplineId" value="<?php echo $discipline->getId(); ?>">
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

$disciplinesView = new DisciplinesView();

include_once '../templates/footer.php';

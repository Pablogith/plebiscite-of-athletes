<?php 

require '../constants.php';
error_reporting(SHOW_ERROR);
ini_set('display_errors', SHOW_ERROR);

include_once '../templates/header.php';

require_once '../services/DatabaseService.php';
require_once '../services/DisciplinesService.php';

class ConfirmDeleteDiscipline {

  private $_disciplinesService = null;
  private $_disciplineId = null;

  public function __construct() {
    $this->_disciplinesService = new DisciplinesService();

    $this->getDisciplineId();
    $this->deleteDiscipline();
    $this->render();
  }

  private function getDisciplineId(): void {
    if (isset($_POST["deleteDiscipline"])) {
      $this->_disciplineId = $_POST["disciplineId"];
    }
  }

  private function deleteDiscipline(): void {
    if (isset($_POST["ConfirmDeleteDiscipline"])) {
      $this->_disciplineId = $_POST["disciplineId"];
      $this->_disciplinesService->delete((int)$this->_disciplineId);
      ?>
      <script>
        location.href = 'http://localhost/pawel-relinski-ranking/views/DisciplinesView.php';
      </script>
      <?php
    }
  }

  private function render(): void {
    ?>
    <h1 class="mb-3"> Napewno chcesz usunąć dyscypline?</h1>
    <div class="d-flex flex-row">
    <form action="<?php echo basename($_SERVER['PHP_SELF']); ?>" method="post">
      <input type="submit" class="btn btn-danger mr-3" name="ConfirmDeleteDiscipline" value="Tak, chcę usunąć">
      <input type="hidden" name="disciplineId" value="<?php echo $this->_disciplineId; ?>">
    </form>
    <a href="./DisciplinesView.php" type="button" class="btn btn-light">Nie, nie chcę usunąć</a>
    </div>
    <?php
  }

}

$confirmDeleteDiscipline = new ConfirmDeleteDiscipline();

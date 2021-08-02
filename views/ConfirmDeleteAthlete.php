<?php 

require '../constants.php';
error_reporting(SHOW_ERROR);
ini_set('display_errors', SHOW_ERROR);

include_once '../templates/header.php';

require_once '../services/DatabaseService.php';
require_once '../services/AthletesService.php';

class ConfirmDeleteAthlete {

  private $_athletesService = null;
  private $_athleteId = null;
  private $_disciplineId = null;

  public function __construct() {
    $this->_athletesService = new AthletesService();

    $this->deleteAthlete();
    $this->getDataFromPost();
    $this->render();
  }

  private function getDataFromPost(): void {
    if (isset($_POST["deleteAthlete"])) {
      $this->_athleteId = $_POST["athleteId"];
      $this->_disciplineId = $_POST["disciplineId"];
    }
  }

  private function deleteAthlete(): void {
    if (isset($_POST["ConfirmDeleteAthlete"])) {
      $this->_athleteId = (int)$_POST["athleteId"];
      $this->_disciplineId = (int)$_POST["disciplineId"];
      $this->_athletesService->delete($this->_athleteId, $this->_disciplineId);
      ?>
      <script>
        location.href = 'http://localhost/pawel-relinski-ranking/views/AthletesView.php';
      </script>
      <?php
    }
  }

  private function render(): void {
    ?>
    <h1 class="mb-3"> Napewno chcesz usunąć sportowca?</h1>
    <div class="d-flex flex-row">
    <form action="<?php echo basename($_SERVER['PHP_SELF']); ?>" method="post">
      <input type="submit" class="btn btn-danger mr-3" name="ConfirmDeleteAthlete" value="Tak, chcę usunąć">
      <input type="hidden" name="athleteId" value="<?php echo $this->_athleteId; ?>">
      <input type="hidden" name="disciplineId" value="<?php echo $this->_disciplineId; ?>">
    </form>
    <a href="./AthletesView.php" type="button" class="btn btn-light">Nie, nie chcę usunąć</a>
    </div>
    <?php
  }

}

$confirmDeleteAthlete = new ConfirmDeleteAthlete();

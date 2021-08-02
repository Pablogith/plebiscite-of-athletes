<?php

require '../constants.php';

error_reporting(SHOW_ERROR);
ini_set('display_errors', SHOW_ERROR);
ini_set('memory_limit', '1024M');

include_once '../templates/header.php';

require_once '../services/AthletesService.php';
require_once '../models/Athlete.php';
require_once '../services/DatabaseService.php';
require_once '../services/DisciplinesService.php';

class AddAthleteView {

  private $_athletesService = null;
  private $_disciplinesService = null;

  private $_disciplines = array();

  public function __construct() {
    $this->_athletesService = new AthletesService();
    $this->_disciplinesService = new DisciplinesService();

    $this->_disciplines = $this->_disciplinesService->getAll();

    // $this->checkIfAddedAthlete();
    $this->handleAddAthlete();
    $this->render();
  }

  private function handleAddAthlete(): void {
    if (isset($_POST["addAthlete"])) {
      $firstName = $_POST["FirstName"];
      $lastName = $_POST["LastName"];
      $gender = $_POST["Gender"];
      $status = $_POST["Status"];
      $disciplineId = $_POST["DisciplineId"];
      $coach = $_POST["Coach"];

      $fileName = basename($_FILES['file']['name']);
      $fileTmpFile = $_FILES['file']['tmp_name'];

      var_dump($fileTmpFile);

      $athlete = new Athlete($firstName, $lastName, $gender, $status, null, $disciplineId, 0, $coach);
      $newAthlete = $this->_athletesService->create($athlete, $fileName, $fileTmpFile);

      if ($newAthlete == true) {
        $_COOKIE["AddedAthlete"] = true; 
      }
    }
  }

  private function checkIfAddedAthlete(): void {
    if (isset($_COOKIE["AddedAthlete"]) && $_COOKIE["AddedAthlete"] == true) {
      ?>
        <p class="alert alert-warning" role="alert">Dodano sportowca<p>
      <?php
      $_COOKIE["AddedAthlete"] = false;
    }
  }

  private function render(): void {
    ?>
    <a class="btn btn-link" href="./athletesview.php">Wróć</a>
    <h1>Dodaj sportowca</h1>
    <form action="<?php echo basename($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
    <div class="row">
      <div class="col">
      <label for="FirstName" class="form-label">Imię</label>
        <input type="text" class="form-control" aria-label="FirstName" id="FirstName" name="FirstName">
      </div>
      <div class="col">
        <label for="LastName" class="form-label">Nazwisko</label>
        <input type="text" class="form-control" aria-label="LastName" id="LastName" name="LastName">
      </div>
    </div>
    <div class="row mt-4">
      <div class="col">
        <label for="Coach" class="form-label">Trener</label>
        <input type="text" class="form-control" aria-label="Coach" id="Coach" name="Coach">
      </div>
      <div class="col">
        <label for="Status" class="form-label">Status</label> <br>
        <select class="form-select form-select-lg mb-3 mt-1" aria-label=".form-select-sm example" id="Status" name="Status">
          <option value="active">Aktywny</option>
          <option value="passive">Pasywny</option>
        </select>
      </div>
    </div>
    <div class="row mt-4">
      <div class="col">
        <label for="Discipline" class="form-label">Dyscyplina</label> <br>
        <select class="form-select form-select-lg mb-3 mt-1" aria-label=".form-select-sm example" id="Discipline" name="DisciplineId">
          <?php foreach ($this->_disciplines as $discipline): ?>
            <option value="<?php echo $discipline->getId(); ?>">
              <?php echo $discipline->getName(); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col">
        <label for="Gender" class="form-label">Płeć</label> <br>
        <select class="form-select form-select-lg mb-3 mt-1" aria-label=".form-select-lg example" id="Gender" name="Gender">
          <option value="men">Mężczyzna</option>
          <option value="woman">Kobieta</option>
        </select>
      </div>
    </div>
    <div class="row mt-4">
        <div class="mb-3 ml-3">
          <label for="file" class="form-label">Zdjęcie profilowe</label>
          <input class="form-control" type="file" id="file" name="file">
        </div>
    </div>
    <button type="submit" class="btn btn-success mb-2 mt-3" value="addAthlete" name="addAthlete">
      Dodaj
    </button>
    </form>
    <?php
  }

}

$addAthleteView = new AddAthleteView();

include_once '../templates/footer.php';

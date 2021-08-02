<?php

require '../constants.php';
error_reporting(SHOW_ERROR);
ini_set('display_errors', SHOW_ERROR);

include_once '../templates/header.php';

require_once '../services/AthletesService.php';
require_once '../models/Athlete.php';
require_once '../services/DatabaseService.php';
require_once '../services/DisciplinesService.php';

class EditAthleteView {

  private $_athletesService = null;
  private $_disciplinesService = null;

  private $_athlete = null;

  private $_disciplines = array();
  private $_statuses = ["active", "passive"];
  private $_genders = ["men", "woman"];

  public function __construct() {
    $this->_athletesService = new AthletesService();
    $this->_disciplinesService = new DisciplinesService();

    $this->_disciplines = $this->_disciplinesService->getAll();

    $this->setAthlete();
    $this->handleEditAthlete();

    $this->render();
  }

  private function setAthlete(): void {
    if (isset($_GET["athleteId"])) {
      $athleteId = (int)$_GET["athleteId"];
      $this->_athlete = $this->_athletesService->getById($athleteId);
    }
  }

  private function getDisciplineName(int $disciplineId): string {
    $discipline = $this->_disciplinesService->getById($disciplineId);
    return $discipline->getName();
  }

  private function handleEditAthlete(): void {
    if (isset($_POST["editAthlete"])) {
      $athleteId = $_POST["AthleteId"];
      $firstName = $_POST["FirstName"];
      $lastName = $_POST["LastName"];
      $status = $_POST["Status"];
      $gender = $_POST["Gender"];
      $disciplineName = $_POST["DisciplineName"];
      $numberOfTrophies = $_POST["NumberOfTrophies"];
      $coach = $_POST["Coach"];
      $countOfPositiveRates = $_POST["CountOfPositiveRates"];
      $countOfNegativeRates = $_POST["CountOfNegativeRates"];
      $oldDisciplineId = (int)$_POST["OldDisciplineId"];

      $athlete = new Athlete($firstName, $lastName, $gender, $status, $athleteId, $disciplineName, $numberOfTrophies, $coach);
      $athlete->setCountOfPositiveRates((int)$countOfPositiveRates);
      $athlete->setCountOfNegativeRates((int)$countOfNegativeRates);

      $this->_athletesService->update($athlete, $oldDisciplineId);

      echo "<script>location.href = \"http://localhost/pawel-relinski-ranking/views/editathleteview.php?athleteId=$athleteId\";</script>";
    }
  }

  private function render(): void {
    ?>
    <h1>Edytuj</h1>
    <div class="">
      <div class="row gutters">
      <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
      <div class="card h-100">
      	<div class="card-body">
      		<div class="account-settings">
      			<div class="user-profile">
      				<div class="user-avatar">
      					<img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Maxwell Admin">
      				</div>
      				<h5 class="user-firstName">
                <?php echo $this->_athlete->getFirstName(); ?>
              </h5>
      				<h6 class="user-lastName">
                <?php echo $this->_athlete->getLastName(); ?>
              </h6>
      			</div>
      		</div>
      	</div>
      </div>
      </div>
      <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
      <form action="<?php echo basename($_SERVER['PHP_SELF']) . "?athleteId=" . $this->_athlete->getId(); ?>" method="post">
      <div class="card h-100">
      	<div class="card-body">
        <div class="row mb-3">
          <div class="col">
          <label for="FirstName" class="form-label">Imię</label>
            <input type="text" class="form-control" value="<?php echo $this->_athlete->getFirstName(); ?>" aria-label="FirstName" id="FirstName" name="FirstName">
          </div>
          <div class="col">
            <label for="LastName" class="form-label">Nazwisko</label>
            <input type="text" class="form-control" value="<?php echo $this->_athlete->getLastName(); ?>" aria-label="LastName" id="LastName" name="LastName">
          </div>
        </div>
      		<div class="row gutters">
      			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
      				<div class="form-group">
      					<label for="Status">Status</label> <br>
                  <select class="form-select form-select-lg mb-3 mt-1" aria-label="Status" id="Status" name="Status">
                    <?php foreach ($this->_statuses as $status): ?>
                      <?php if ($status == $this->_athlete->getStatus()): ?>
                        <option value="<?php echo $status ?>" selected><?php echo ucfirst(Athlete::convertStatusToPl($status)); ?></option>
                      <?php else: ?>
                        <option value="<?php echo $status ?>"><?php echo ucfirst(Athlete::convertStatusToPl($status)); ?></option>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </select>
      				</div>
      			</div>
      			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
      				<div class="form-group">
      					<label for="Gender">Płeć</label> <br>
                <select class="form-select form-select-lg mb-3 mt-1" aria-label="Gender" id="Gender" name="Gender">
                  <?php foreach ($this->_genders as $gender): ?>
                    <?php if ($gender == $this->_athlete->getGender()): ?>
                      <option value="<?php echo $gender ?>" selected><?php echo ucfirst(Athlete::convertGenderToPl($gender)); ?></option>
                    <?php else: ?>
                      <option value="<?php echo $gender ?>"><?php echo ucfirst(Athlete::convertGenderToPl($gender)); ?></option>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </select>
      				</div>
      			</div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
      				<div class="form-group">
      					<label for="DisciplineName">Dyscyplina</label> <br>
                <select class="form-select form-select-lg mb-3 mt-1" aria-label="DisciplineName" id="DisciplineName" name="DisciplineName">
                  <?php foreach ($this->_disciplines as $discipline): ?>
                    <?php if ($discipline->getId() == $this->_athlete->getDisciplineId()): ?>
                      <option value="<?php echo $discipline->getId(); ?>" selected><?php echo $discipline->getName(); ?></option>
                    <?php else: ?>
                      <option value="<?php echo $discipline->getId(); ?>"><?php echo $discipline->getName(); ?></option>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </select>
      				</div>
      			</div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
      				<div class="form-group">
      					<label for="NumberOfTrophies">Liczba nagród</label>
                <input type="number" class="form-control" id="numberOfTrophies" name="NumberOfTrophies"
                  value="<?php echo $this->_athlete->getNumberOfTrophies(); ?>" min="0">
      				</div>
      			</div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
      				<div class="form-group">
      					<label for="Coach">Trener</label>
                <input type="text" class="form-control" id="coach" name="Coach"
                  value="<?php echo $this->_athlete->getCoach(); ?>">
      				</div>
      			</div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
      			</div>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
              <div class="text-left">
              <input type="hidden" name="AthleteId" value="<?php echo $this->_athlete->getId(); ?>">
              <input type="hidden" name="CountOfPositiveRates" value="<?php echo $this->_athlete->getCountOfPositiveRates(); ?>">
              <input type="hidden" name="CountOfNegativeRates" value="<?php echo $this->_athlete->getCountOfNegativeRates(); ?>">
              <input type="hidden" name="OldDisciplineId" value="<?php echo $this->_athlete->getDisciplineId(); ?>">
              <button type="submit" class="btn btn-warning mb-2 mt-3" value="editAthlete" name="editAthlete">
                Edytuj
              </button>
              </div>
      			</div>
      		</div>
      	</div>
      </div>
      </form>
      </div>
      </div>
      </div>
    <?php
  }

}

$editAthleteView = new EditAthleteView();

include_once '../templates/footer.php';
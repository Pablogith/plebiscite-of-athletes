<?php 

require '../constants.php';
error_reporting(SHOW_ERROR);
ini_set('display_errors', SHOW_ERROR);

include_once '../templates/header.php';

require_once '../services/AthletesService.php';
require_once '../models/Athlete.php';
require_once '../services/DatabaseService.php';
require_once '../services/DisciplinesService.php';

class AthleteDetailsView {

  private $_athletesService = null;
  private $_disciplinesService = null;

  private $_athleteId = null;
  private $_athlete = null;

  public function __construct() {
    $this->_athletesService = new AthletesService();
    $this->_disciplinesService = new DisciplinesService();

    $this->setAthlete();
    $this->handleUpdateRate();

    $this->render();
  }

  private function setAthlete(): void {
    if (isset($_GET['athleteId'])) {
      $this->_athleteId = $_GET['athleteId'];
      $this->_athlete = $this->_athletesService->getById($this->_athleteId);
      if (!$this->_athlete->getImg()) {
        $this->_athlete->setImg("../assets/img/account-avatar.png");
      } else {
        $this->_athlete->setImg("../upload/" . $this->_athlete->getImg());
      }
    }
  }

  private function getDisciplineName(int $disciplineId): string {
    $discipline = $this->_disciplinesService->getById($disciplineId);
    return $discipline->getName();
  }

  private function handleUpdateRate(): void {
    if (isset($_POST["ratingPositive"])) {
      $athleteId = (int)$_POST["athleteId"];
      $this->_athletesService->addPositiveRate($athleteId);
      echo "<script type=\"text/javascript\">location.href = \"http://localhost/pawel-relinski-ranking/views/AthleteDetailsView.php?athleteId=$athleteId\";</script>";
    } else if (isset($_POST["ratingNegative"])) {
      $athleteId = (int)$_POST["athleteId"];
      $this->_athletesService->addNegativeRate($athleteId);
      echo "<script type=\"text/javascript\">location.href = \"http://localhost/pawel-relinski-ranking/views/AthleteDetailsView.php?athleteId=$athleteId\";</script>";
    }
  }

  private function render(): void {
    ?>
      <h1>Szczegóły</h1>
      <a type="button" class="btn btn-link" href="./athletesview.php">Wróć</a>
      <div class="">
      <div class="row gutters">
      <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
      <div class="card h-100">
      	<div class="card-body">
      		<div class="account-settings">
      			<div class="user-profile">
      				<div class="user-avatar">
      					<img src="<?php echo $this->_athlete->getImg(); ?>" alt="Maxwell Admin">
      				</div>
      				<h5 class="user-firstName">
                <?php echo $this->_athlete->getFirstName(); ?>
              </h5>
      				<h6 class="user-lastName">
                <?php echo $this->_athlete->getLastName(); ?>
              </h6>
              <div class="d-flex justify-content-around pt-2">
                <form action="<?php echo basename($_SERVER['PHP_SELF']) . "?athleteId=" . $this->_athlete->getId(); ?>" method="post">
                  <input type="submit" class="btn btn-success" value="+" name="ratingPositive">
                  <input type="hidden" name="athleteId" value="<?php echo $this->_athlete->getId(); ?>">
                </form>
                <form action="<?php echo basename($_SERVER['PHP_SELF']) . "?athleteId=" . $this->_athlete->getId(); ?>" method="post">
                  <input type="submit" class="btn btn-danger" value="-" name="ratingNegative">
                  <input type="hidden" name="athleteId" value="<?php echo $this->_athlete->getId(); ?>">
                </form>
              </div>
      			</div>
      			<div>
              <p>Pozytywne: <?php echo $this->_athlete->getCountOfPositiveRates(); ?></p>
              <p>Negatywne: <?php echo $this->_athlete->getCountOfNegativeRates(); ?></p>
              <p>Średnia: <?php echo $this->_athlete->getAvarageOfRates(); ?></p>
      			</div>
      		</div>
      	</div>
      </div>
      </div>
      <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
      <div class="card h-100">
      	<div class="card-body">
      		<div class="row gutters">
      			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
      				<h6 class="mb-2 text-primary">Dane osobiste:</h6>
      			</div>
      			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
      				<div class="form-group">
      					<label for="status">Status</label>
                <input type="text" class="form-control" id="status" disabled
                  value="<?php echo ucfirst($this->_athlete->getStatus('pl')); ?>">
      				</div>
      			</div>
      			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
      				<div class="form-group">
      					<label for="gender">Płeć</label>
                <input type="text" class="form-control" id="gender" disabled
                  value="<?php echo ucfirst($this->_athlete->getGender('pl')); ?>">
      				</div>
      			</div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
      				<div class="form-group">
      					<label for="disciplineName">Dyscyplina</label>
                <input type="text" class="form-control" id="disciplineName" disabled
                  value="<?php echo $this->getDisciplineName($this->_athlete->getDisciplineId()); ?>">
      				</div>
      			</div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
      				<div class="form-group">
      					<label for="numberOfTrophies">Liczba nagród</label>
                <input type="text" class="form-control" id="numberOfTrophies" disabled
                  value="<?php echo $this->_athlete->getNumberOfTrophies(); ?>">
      				</div>
      			</div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
      				<div class="form-group">
      					<label for="coach">Trener</label>
                <input type="text" class="form-control" id="coach" disabled
                  value="<?php echo $this->_athlete->getCoach(); ?>">
      				</div>
      			</div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
      			</div>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
              <div class="text-left">
                <a href="./editathleteview.php?athleteId=<?php echo $this->_athlete->getId(); ?>"
                   class="btn btn-warning">
                  Edytuj
                </a>
              </div>
      			</div>
      		</div>
      	</div>
      </div>
      </div>
      </div>
      </div>
    <?php
  }

}

$athleteDetailsView = new AthleteDetailsView();

include_once '../templates/footer.php';

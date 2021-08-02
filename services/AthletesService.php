<?php

require '../constants.php';

error_reporting(SHOW_ERROR);
ini_set('display_errors', SHOW_ERROR);

require_once 'DatabaseService.php';
require_once 'DisciplinesService.php';
require_once '../models/Athlete.php';

class AthletesService {

  private $_dbService = null;
  private $_disciplineService = null;

  const ATHLETES_TABLE_NAME = 'Athletes';

  public function __construct() {
    $this->_dbService = new DatabaseService();
    $this->_disciplineService = new DisciplinesService();
  }

  public function getById(int $id): Athlete {
    try {
      if (!is_numeric($id))
        throw new Exception("Niepoprawne id");

      $sql = "SELECT * FROM " . self::ATHLETES_TABLE_NAME . " WHERE Id=$id";
      $result = $this->_dbService->connect()->query($sql);

      if (empty($result))
        throw new Exception("Nie znaleziono sportowca");

      $result = $result->fetch_assoc();
      $athlete = new Athlete($result["FirstName"], 
                        $result["LastName"],
                        $result["Gender"],
                        $result["Status"],
                        $result["Id"],
                        $result["DyscyplineId"],
                        $result["Trophies"],
                        $result["Coach"],
                        $result["CountOfPositiveRates"],
                        $result["CountOfNegativeRates"]);
                       
      return $athlete;
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }

  public function getAll(): array {
    try {
      $sql = "SELECT * FROM " . self::ATHLETES_TABLE_NAME;
      $result = $this->_dbService->connect()->query($sql);

      if (empty($result)) {
        header("refresh:3; url=http://localhost/pawel-relinski-ranking/views/athletesview.php");
        throw new Exception("Nie znaleziono sportowca");
      }

      return $this->convertResultToClassObjectsArray($result);
    } catch (\Exception $e) {
      return $e->getMessage;
    }
  }

  public function getAllByDisciplineId(int $disciplineId) {
    try {
      if (!is_numeric($disciplineId))
        throw new Exception("Błędne id");

      $sql = "SELECT * FROM " . self::ATHLETES_TABLE_NAME . " WHERE `DyscyplineId`=$disciplineId;";
      $result = $this->_dbService->connect()->query($sql);

      if (empty($result))
        throw new Exception("Nie znaleziono sportowca");

      return $this->convertResultToClassObjectsArray($result);
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }

  public function create(Athlete $athlete, string $fileName, string $oldLocation) {
    try {
      $firstName = $athlete->getFirstName();
      $lastName = $athlete->getLastName();
      $gender = $athlete->getGender();
      $status = $athlete->getStatus();
      $disciplineId = $athlete->getDisciplineId();

      $athleteTableName = self::ATHLETES_TABLE_NAME;

      $newLocation = "./../upload/" . $fileName;

      if (move_uploaded_file($oldLocation, $newLocation)) {
        //TODO
      } else {
        //TODO
      }
      
      $sql = "
      INSERT INTO `$athleteTableName`(
        `FirstName`,
        `LastName`,
        `Gender`,
        `Status`,
        `DyscyplineId`,
        `Img`
      )
      VALUES(
        '$firstName',
        '$lastName',
        '$gender',
        '$status',
        $disciplineId,
        '$fileName'
      );
    ";
      $result = $this->_dbService->connect()->query($sql);

      if (!$result)
        throw new Exception($result);

      $res = $this->_disciplineService->addAthlete((int)$disciplineId);

      return $result;
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }

  public function delete(int $athleteId, int $disciplineId) {
    try {
      if (!is_numeric($athleteId))
        throw new Exception("Niepoprawne id");
  
      $sql = "DELETE FROM " . self::ATHLETES_TABLE_NAME . " WHERE Id=$athleteId";
      $result = $this->_dbService->connect()->query($sql);

      if (!$result)
        throw new Exception($result);

      $res = $this->_disciplineService->deleteAthlete((int)$disciplineId);

      return $result;
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }

  public function addPositiveRate(int $athleteId) {
    try {
      if (!is_numeric($athleteId))
        throw new Exception("Niepoprawne id");

      $sql = "UPDATE " . self::ATHLETES_TABLE_NAME . " SET `CountOfPositiveRates`=`CountOfPositiveRates` + 1 WHERE `Athletes`.`Id`=$athleteId";
      $result = $this->_dbService->connect()->query($sql);

      if (!$result) 
        throw new Exception($result);

      return $result;
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }

  public function addNegativeRate(int $athleteId) {
    try {
      if (!is_numeric($athleteId))
        throw new Exception("Niepoprawne id");

      $sql = "UPDATE " . self::ATHLETES_TABLE_NAME . " SET `CountOfNegativeRates`=`CountOfNegativeRates` + 1 WHERE `Athletes`.`Id`=$athleteId";
      $result = $this->_dbService->connect()->query($sql);

      if (!$result) 
        throw new Exception($result);

      return $result;
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }

  public function update(Athlete $athlete, int $oldDisciplineId) {
    try {
      $id = $athlete->getId();
      $firstName = $athlete->getFirstName();
      $lastName = $athlete->getLastName();
      $status = $athlete->getStatus();
      $gender = $athlete->getGender();
      $disciplineId = $athlete->getDisciplineId();
      $numberOfTrophies = $athlete->getNumberOfTrophies();
      $coach = $athlete->getCoach();

      if ($oldDisciplineId != $disciplineId) {
        $this->_disciplineService->addAthlete($disciplineId);
        $this->_disciplineService->deleteAthlete($oldDisciplineId);
      }

      $sql = "UPDATE " . self::ATHLETES_TABLE_NAME . " SET 
        `FirstName`=\"$firstName\",
        `LastName`=\"$lastName\",
        `Gender`=\"$gender\",
        `Status`=\"$status\",
        `Trophies`=\"$numberOfTrophies\",
        `DyscyplineId`=\"$disciplineId\",
        `Coach`=\"$coach\"
        WHERE `Id`={$id};";

      $result = $this->_dbService->connect()->query($sql);

      if (!$result) 
        throw new Exception($result);

      return $result;
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }

  private function convertResultToClassObjectsArray($result): array {
    $pureAthletes = array();
    $athletes = array();

    while($row = $result->fetch_assoc())
      array_push($pureAthletes, $row);

    foreach ($pureAthletes as $athlete) {
      array_push($athletes, new Athlete($athlete["FirstName"],
                                        $athlete["LastName"],
                                        $athlete["Gender"],
                                        $athlete["Status"],
                                        $athlete["Id"],
                                        $athlete["DyscyplineId"],
                                        $athlete["Trophies"],
                                        $athlete["Coach"],
                                        $athlete["CountOfPositiveRates"],
                                        $athlete["CountOfNegativeRates"]));
    }

    return $athletes;
  }
  
}

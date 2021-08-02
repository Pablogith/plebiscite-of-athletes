<?php

require '../constants.php';
error_reporting(SHOW_ERROR);
ini_set('display_errors', SHOW_ERROR);

require_once 'DatabaseService.php';
require_once '../models/Discipline.php';

class DisciplinesService {

  private $_dbService = null;

  const DISCIPLINES_TABLE_NAME = 'Disciplines';

  public function __construct() {
    $this->_dbService = new DatabaseService();
  }

  public function getById(int $id) {
    try {
      if (!is_numeric($id))
        throw new Exception("Niepoprawne id");

      $sql = "SELECT * FROM " . self::DISCIPLINES_TABLE_NAME . " WHERE Id=$id";
      $result = $this->_dbService->connect()->query($sql);

      if (empty($result))
        throw new Exception("Nie znaleziono dyscypliny");

      $result = $result->fetch_assoc();
      return new Discipline(
        $result["Name"],
        $result["Season"],
        $result["NumberOfAthletes"],
        $result["Id"]
      );
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }

  public function getAll(): array {
    try {
      $sql = "SELECT * FROM " . self::DISCIPLINES_TABLE_NAME;
      $result = $this->_dbService->connect()->query($sql);

      if (empty($result))
        throw new Exception("Nie znaleziono dyscpliny");

      return $this->convertResultToClassObjectsArray($result);
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }

  public function create(Discipline $discipline) {
    try {
      $name = $discipline->getName();
      $season = $discipline->getSeason();

      $sql = "INSERT INTO " . self::DISCIPLINES_TABLE_NAME . " (`Name`, `Season`) VALUES ('$name', '$season');";
      $result = $this->_dbService->connect()->query($sql);

      if (!$result) 
        throw new Exception($result);

      return $result;
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }

  public function delete(int $disciplineId) {
    try {
      if (!is_numeric($disciplineId))
        throw new Exception("Niepoprawne id");

      $sql = "DELETE FROM " . self::DISCIPLINES_TABLE_NAME . " WHERE Id=$disciplineId AND NumberOfAthletes = 0;";
      $result = $this->_dbService->connect()->query($sql);

      if ($result) 
        throw new Exception($result);

      return $result;
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }

  public function addAthlete(int $disciplineId) {
    try {
      if (!is_numeric($disciplineId)) 
        throw new Exception("Niepoprawne id");

      $sql = "UPDATE " . self::DISCIPLINES_TABLE_NAME . " SET `NumberOfAthletes`=`NumberOfAthletes` + 1 WHERE `Disciplines`.`Id`=$disciplineId";
      $result = $this->_dbService->connect()->query($sql);

      if (!$result)
        throw new Exception($result);

      return $result;
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }

  public function deleteAthlete(int $disciplineId) {
    try {
      if (!is_numeric($disciplineId)) 
        throw new Exception("Niepoprawne id");

      $sql = "UPDATE " . self::DISCIPLINES_TABLE_NAME . " SET `NumberOfAthletes`=`NumberOfAthletes` - 1 WHERE `Disciplines`.`Id`=$disciplineId";
      $result = $this->_dbService->connect()->query($sql);

      if (!$result)
        throw new Exception($result);

      return $result;
    } catch (\Exception $th) {
      return $e->getMessage();
    }
  }

  public function update(Discipline $discipline) {
    try {
      $name = $discipline->getName();
      $season = $discipline->getSeason();
      $id = $discipline->getId();

      $sql = "UPDATE " . self::DISCIPLINES_TABLE_NAME . " SET `Name`=\"$name\", `Season`=\"$season\" WHERE Id=$id;";
      $result = $this->_dbService->connect()->query($sql);
      
      if (!$result) 
        throw new Exception($result);

      return $result;
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }

  private function convertResultToClassObjectsArray($result): array {
    $pureDisciplines = array();
    $disciplines = array();

    while($row = $result->fetch_assoc())
      array_push($pureDisciplines, $row);

      foreach ($pureDisciplines as $discipline) {
        array_push($disciplines, new Discipline($discipline["Name"],
                                                $discipline["Season"],
                                                $discipline["NumberOfAthletes"],
                                                $discipline["Id"]));
      }

      return $disciplines;
  }

}

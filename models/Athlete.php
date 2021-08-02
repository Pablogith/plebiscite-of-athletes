<?php

final class Athlete {

  private $_id = null;
  private $_firstName = null;
  private $_lastName = null;
  private $_gender = null;
  private $_status = null;
  private $_disciplineId = null;
  private $_numberOfTrophies = null;
  private $_coach = null;
  private $_countOfPositiveRates = null;
  private $_countOfNegativeRates = null;
  private $_img = null;
  
  public function __construct($firstName, $lastName, $gender, $status, $id, $disciplineId, $numberOfTrophies, $coach, $countOfPositiveRates = 0, $countOfNegativeRates = 0) {
    $this->_firstName = $firstName;
    $this->_lastName = $lastName;
    $this->_gender = $gender;
    $this->_status = $status;
    $this->_id = $id;
    $this->_disciplineId = $disciplineId;
    $this->_numberOfTrophies = $numberOfTrophies;
    $this->_coach = $coach;
    $this->_countOfPositiveRates = $countOfPositiveRates;
    $this->_countOfNegativeRates = $countOfNegativeRates;
  }

  public function getFirstName(): string {
    return $this->_firstName;
  }

  public function getLastName(): string {
    return $this->_lastName;
  }

  public function getDisciplineId(): int {
    return $this->_disciplineId;
  }

  public function getGender($lang = 'default'): string {
    switch ($lang) {
      case 'pl':
        $this->translateGenderFromDefaultLangToPolish();
        return $this->_gender;
        break;
      
      default:
        return $this->_gender;
        break;
    }
  }

  public function getStatus($lang = 'default'): string {
    switch ($lang) {
      case 'pl':
        $this->translateStatusFromDefaultLangToPolish();
        return $this->_status;
        break;
      
      default:
        return $this->_status;
        break;
    }
  }

  public function getId(): int {
    return $this->_id;
  }

  public function getImg() {
    return $this->_img;
  }

  public function setImg($value): void {
    $this->_img = $value;
  }

  public function getNumberOfTrophies(): int {
    return $this->_numberOfTrophies;
  }

  public function getCoach(): string {
    if (is_null($this->_coach))
      return 'Brak';
      
    return $this->_coach;
  }

  public function getCountOfPositiveRates(): int {
    return $this->_countOfPositiveRates;
  }

  public function getCountOfNegativeRates(): int {
    return $this->_countOfNegativeRates;
  }

  public function getAvarageOfRates(): float {
    return round(($this->getCountOfPositiveRates() + $this->getCountOfNegativeRates()) / 2, 1);
  }

  private function translateGenderFromDefaultLangToPolish(): void {
    switch ($this->_gender) {
          case 'woman':
            $this->_gender = 'kobieta';
            break;
          case 'men':
            $this->_gender = 'mężczyzna';
            break;
      }
  }

  private function translateStatusFromDefaultLangToPolish(): void {
    switch ($this->_status) {
      case 'active':
        $this->_status = 'aktywny';
        break;
      case 'passive':
        $this->_status = 'pasywny';
        break;
    }
  }

  static public function convertStatusToPl(string $value): string {
    switch ($value) {
      case 'active':
        return 'aktywny';
        break;
      case 'passive':
        return 'pasywny';
        break;
    }
  }

  static public function convertGenderToPl(string $value): string {
    switch ($value) {
      case 'woman':
        return 'kobieta';
        break;
      case 'men':
        return 'mężczyzna';
        break;
  }
  }

}

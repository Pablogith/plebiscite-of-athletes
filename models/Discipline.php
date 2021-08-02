<?php

final class Discipline {

  private $_name = null;
  private $_season = null;
  private $_numberOfAthletes = null;
  private $_id = null;

  public function __construct($name, $season, $numberOfAthletes = null, $id = null) {
    $this->_name = $name;
    $this->_season = $season;
    $this->_numberOfAthletes = $numberOfAthletes;
    $this->_id = $id;
  }

  public function getName(): string {
    return $this->_name;
  }

  public function getSeason($lang = 'deafualt'): string {
    switch ($lang) {
      case 'pl':
        $this->translateSeasonNameFromDefaultLangToPolish();
        return $this->_season;
        break;
      
      default:
        return $this->_season;
        break;
    }
    return $this->_season;
  }

  public function getNumberOfAthletes(): int {
    return $this->_numberOfAthletes;
  }

  public function getId(): int {
    return $this->_id;
  }

  public function setId(int $value): void {
    if (!is_int($value)) {
      throw new Error("Błędne id");
    } else {
      $this->_id = $value;
    }
  }

  private function translateSeasonNameFromDefaultLangToPolish(): void {
    switch ($this->_season) {
      case 'summer':
        $this->_season = 'letni';
        break;

      case 'winter':
        $this->_season = 'zimowy';
        break;

      case 'all_ year_round':
        $this->_season = 'całoroczny';
        break;
    }
  }

  static public function convertNameToPl($name): string {
    switch ($name) {
      case 'summer':
        return 'letni';
        break;

      case 'winter':
        return 'zimowy';
        break;

      case 'all_ year_round':
        return 'całoroczny';
        break;
    }
  }

}

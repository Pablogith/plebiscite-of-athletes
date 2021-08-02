<?php

require '../constants.php';
error_reporting(SHOW_ERROR);
ini_set('display_errors', SHOW_ERROR);

require_once 'DatabaseService.php';
require_once '../models/Message.php';

class AthletesService {

  private $_dbService = null;

  const MESSAGES_TABLE_NAME = 'Messages';

  public function __construct() {
    $this->_dbService = new DatabaseService();
  }

  public function create(Message $message) {
    try {

    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }

}


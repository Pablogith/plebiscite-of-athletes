<?php

require '../constants.php';
error_reporting(SHOW_ERROR);
ini_set('display_errors', SHOW_ERROR);

final class DatabaseService {

  private $_servername = "localhost";
  private $_username = "root";
  private $_password = "";
  private $_name = "ranking-sbd";

  private $_connection = null;

  public function connect(): Object {
    $this->_connection = new mysqli($this->_servername,
                                    $this->_username,
                                    $this->_password);

    $this->_connection->set_charset("utf-8");

    if ($this->_connection->connect_error) {
      die("Connection failed: " . $this->_connection->connect_error);
    }

    $isSelected = $this->_connection->select_db($this->_name);
    if (!$isSelected) {
      $rankingSbdSql = file_get_contents("../ranking-sbd.sql");
      $nameOfDb = $this->_name;
      $sql = "CREATE DATABASE `$nameOfDb`;";

      $this->_connection->query($sql);
      $this->_connection->select_db($this->_name);
      $dbIsCreate = $this->_connection->multi_query($rankingSbdSql);

      if ($dbIsCreate) {
        ?>
        echo "<script>window.location.reload(true);</script>";
        <?php
      } 
    }

    return $this->_connection;
  }

}

<?php

require '../constants.php';
error_reporting(SHOW_ERROR);
ini_set('display_errors', SHOW_ERROR);

include_once '../templates/header.php';

class NotFoundView {

  public function __construct() {
    $this->render();
  }

  private function render(): void {
    ?>
    <h1>404 Nie znaleziono strony</h1>
    <a href="./AthletesView.php">Przejdź do strony głównej</a>
    <?php
  }

}

$notFoundView = new NotFoundView();

include_once '../templates/footer.php';

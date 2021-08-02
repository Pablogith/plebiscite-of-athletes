<?php

require '../constants.php';
error_reporting(SHOW_ERROR);
ini_set('display_errors', SHOW_ERROR);

include_once '../templates/header.php';

class ContactView {

  public function __construct() {
    $this->handleSendMessage();
    $this->render();
  }

  private function handleSendMessage(): void {}

  private function render(): void {
    ?>
    <h1>Kontakt</h1>
    <p>
      Strona została stworzona w ramach projektu szkolnego z przedmiotu Systemy Baz Danych <br> prowadzonych przez Pana Andrzeja Opiele. 
    </p>
    <p>
    Twórcą strony jest Paweł Reliński.
    </p>
    <p>
      W razie jakichkolwiek pytań zachęcam do wypełniania formularza kontaktowego. <br>
      Odpowiedź powinna być dostarczona w ciągu 1/2 dni roboczych.
    </p>
    <form action="<?php echo basename($_SERVER['PHP_SELF']); ?>" method="post">
      <div class="mb-3">
        <label for="email" class="form-label">Adres email</label>
        <input type="email" class="form-control" id="email" placeholder="jankowalski@gmail.com">
      </div>
      <div class="mb-3">
        <label for="textarea" class="form-label">Wiadomość dla mnie</label>
        <textarea class="form-control" id="textarea" rows="3"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Wyślij</button>
    </form>
    <?php
  }

}

$contactView = new ContactView();

include_once '../templates/footer.php';

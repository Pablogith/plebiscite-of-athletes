<?php 

final class Message {

  private $_email = null;
  private $_message = null;

  public function __construct($email, $message) {
    $this->_email = $email;
    $this->_message = $message;
  }

  public function getEmail(): string {
    return $this->_email;
  }

  public function getMessage(): string {
    return $this->_message;
  }

}

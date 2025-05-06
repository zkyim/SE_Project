<?php
require_once '../libraries/Database.php';
class User {
  private $db;

  public function __construct() {
    $this->db = new Database;
  }

  public function findUserByEmail($email) {
    $this->db->query('SELECT * FROM users WHERE email = :email');
    $this->db->bind(':email', $email);

    $row = $this->db->single();

    if ($this->db->rowCount() > 0) {
      return $row;
    }else {
      return false;
    }
  }

  public function register($data) {
    $this->db->query('INSERT INTO users (firstName, lastName, email, password) VALUES (:firstName, :lastName, :email, :password)');

    $this->db->bind(':password', $data['password']);
    $this->db->bind(':email', $data['email']);
    $this->db->bind(':lastName', $data['lastName']);
    $this->db->bind(':firstName', $data['firstName']);
    
    if ($this->db->excute()) {
      return true;
    }else {
      return false;
    }
  }

  public function login($email, $password) {
    $row = $this->findUserByEmail($email);

    if ($row == false) return false;

    if (!password_verify($password, $row->password)) {
      return false;
    }else {
      return $row;
    }
  }

  public function resetpass($email, $password) {
    $this->db->query('UPDATE users SET password = :password WHERE email = :email');
    $this->db->bind(':email', $email);
    $this->db->bind(':password', $password);
    
    if ($this->db->excute()) return true;
    return false;
  }
}
?>
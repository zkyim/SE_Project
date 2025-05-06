<?php 
require_once '../libraries/Database.php';
class checkUser {
  private $db;
  public function __construct() {
    $this->db = new Database;
  }
  public function checkUser() {
    if (isset($_COOKIE['user_id'])) {
      $this->db->query('SELECT * FROM users WHERE id = :id');
      $this->db->bind(':id', $_COOKIE['user_id']);
      $userInfo = $this->db->single();

      $_SESSION['user_id'] = $userInfo->id;
      $_SESSION['user_email'] = $userInfo->email;
      $_SESSION['user_name'] = $userInfo->firstName;
      $_SESSION['user_role'] = $userInfo->role;
      if ($userInfo->role == 'Admin') {
        redirect('../Admin/index.php');
      }else if($userInfo->role == 'Mechanic') {
        redirect('./Mechanic/index.php');
      }else {
        redirect('./User/index.php');
      }
    }
  }
}

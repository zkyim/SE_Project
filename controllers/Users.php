<?php

require_once '../models/User.php';
require_once '../helpers/session_helper.php';

class Users {
  private $userModel;
  public function __construct() {
    $this->userModel = new User();
  }
  public function register() {
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    $data = [
      'firstName' => trim($_POST['firstName']),
      'lastName' => trim($_POST['lastName']),
      'email' => trim($_POST['email']),
      'password' => trim($_POST['password']),
      'confirmPassword' => trim($_POST['confirmPassword']),
    ];

    if (empty($data['firstName']) || empty($data['lastName']) || empty($data['email']) || empty($data['password']) || empty($data['confirmPassword'])) {
      flash('register', 'Please fill in all fields');
      redirect('../view/register.php');
    }

    // if (preg_match('/^[a-zA-Z0-9]*$/', $data['']))

    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
      flash('register', 'Please use a valid email');
      redirect('../view/register.php');
    }

    if (strlen($data['password']) < 6) {
      flash('register', 'Password should be at least 6 characters');
      redirect('../view/register.php');
    }else if ($data['password'] !== $data['confirmPassword']) {
      flash('register', 'Passwords do not match');
      redirect('../view/register.php');
    }

    if ($this->userModel->findUserByEmail($data['email'])) {
      flash('register', 'Email already exists');
      redirect('../view/register.php');
    }

    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

    if ($this->userModel->register($data)) {
      redirect('../view/login.php');
    }else {
      flash('register', 'Something went wrong');
      redirect('../view/register.php');
    }
  }
  public function login() {
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    $data = [
      'email' => trim($_POST['email']),
      'password' => trim($_POST['password']),
      'remember' => trim($_POST['remember']),
    ];

    if (empty($data['email']) || empty($data['password'])) {
      flash('login', 'Please fill in all fields');
      redirect('../view/login.php');
    }

    if ($this->userModel->findUserByEmail($data['email'])) {
      $logedUser = $this->userModel->login($data['email'], $data['password']);
      if ($logedUser) {
        if ($data['remember'] == 'on') {
          setcookie('email', $data['email'], time() + (60 * 60 * 24 * 30), "/");
          setcookie('password', $data['password'], time() + (60 * 60 * 24 * 30), "/");
        }else {
          setcookie('email', '', time() - 3600, "/");
          setcookie('password', '', time() - 3600, "/");
          unset($_COOKIE['email']);
          unset($_COOKIE['password']);
        }
        $this->createUserSession($logedUser);
      }else {
        flash('login', 'Credentials is incorrect');
        redirect('../view/login.php');
      }
    }else {
      flash('login', 'Email does not exist');
      redirect('../view/login.php');
    }
  }

  public function createUserSession($user) {
    $_SESSION['user_id'] = $user->id;
    $_SESSION['user_email'] = $user->email;
    $_SESSION['user_name'] = $user->firstName;
    $_SESSION['user_role'] = $user->role;
    setcookie('user_id', $user->id, time() + (60 * 60 * 24 * 30), "/");
    if ($user->role == 'Admin') {
      redirect('../Admin/index.php');
    }else if($user->role == 'Mechanic') {
      redirect('../Mechanic/index.php');
    }else {
      redirect('../User/index.php');
    }
  }

  public function logout() {
    setcookie('user_id','',time() - 3600, "/");
    unset($_COOKIE['user_id']);
    unset($_SESSION['user_id']);
    unset($_SESSION['user_email']);
    unset($_SESSION['user_name']);
    unset($_SESSION['user_role']);
    session_destroy();
    redirect('../view/login.php');
  }

  public function sendCode() {
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    $data = [
      'email' => trim($_POST['email']),
    ];

    if (empty($data['email'])) {
      flash('sendCode', 'Please fill in all fields');
      redirect('../view/forgot-password.php');
    }

    if (!$this->userModel->findUserByEmail($data['email'])) {
      flash('sendCode', 'Email does not exist');
      redirect('../view/forgot-password.php');
    }

    $code = rand(100000, 999999);
    $email = $data['email'];

    require_once '../mail.php';
    $mail->setFrom('zkim15121@gmail.com', 'FixCar');
    $mail->addAddress($email);
    $mail->Subject = "Code";
    $mail->Body    = "<h1>Code: {$code}</h1>";
    $mail->send();

    if ($mail->send())
    {
      $_SESSION['email'] = $email;
      $_SESSION['code'] = $code;
      flash('confirmCode', 'Code has been sent.');
      redirect('../view/confirm-code.php');
    }
    else
    {
      flash('sendCode', 'The email doesnt work or not use.');
      redirect('../view/forgot-password.php');
    }
  }

  public function confirmCode() {
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    $data = [
      'code' => trim($_POST['code']),
    ];

    if (empty($data['code'])) {
      flash('confirmCode', 'Please fill in all fields');
      redirect('../view/confirm-code.php');
    }
    
    if ($data['code'] == $_SESSION['code']) {
      redirect('../view/resetpass.php');
    }else {
      flash('confirmCode', 'Code is incorrect');
      redirect('../view/confirm-code.php');
    }
  }

  public function resetpass() {
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    $data = [
      'password' => trim($_POST['password']),
      'confirmPassword' => trim($_POST['confirmPassword']),
    ];

    if (empty($data['password']) || empty($data['confirmPassword'])) {
      flash('resetpass', 'Please fill in all fields');
      redirect('../view/resetpass.php');
    }

    if (strlen($data['password']) < 6) {
      flash('resetpass', 'Password should be at least 6 characters');
      redirect('../view/resetpass.php');
    }else if ($data['password'] !== $data['confirmPassword']) {
      flash('resetpass', 'Passwords do not match');
      redirect('../view/resetpass.php');
    }

    $this->userModel->resetpass($_SESSION['email'], password_hash($data['password'], PASSWORD_DEFAULT));
    unset($_SESSION['email']);
    unset($_SESSION['code']);
    flash('login', 'Password has been reset.');
    redirect('../view/login.php');
  }
}

$init = new Users;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  switch($_POST['type']) {
    case 'register':
      $init->register();
      break;
    case 'login':
      $init->login();
      break;
    case 'sendCode':
      $init->sendCode();
      break;
    case 'confirmCode':
      $init->confirmCode();
      break;
    case 'resetpass':
      $init->resetpass();
      break;
  }
} else {
  switch($_GET['query']) {
    case 'logout':
      $init->logout();
      break;
    default:
      redirect('../view/login.php');
  }
}

?>
<?php

class AccountController
{

    private $logFile;
    private $accModel;

    public function __construct()
    {
        $this->logFile = new FileController();
        $this->accModel = new AccountModel();
    }

    public function getUserRole($role_id)
    {
        switch ($role_id) {
            case 1:
                return 'Guest';
            case 2:
                return 'User';
            case 3:
                return 'Company';
            case 4:
                return 'Admin';
            default:
                return false;
        }
    }

    public function createAccount()
    {

        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            $mail = $_POST['mail'];
            $pass = $_POST['pass'];
            $pass_again = $_POST['pass_again'];
            $role = $_POST['role'];
            $errors = [];

            if ($this->mailValidation($mail) && $this->accModel->mIsAccExist($mail)) { //if email is valid and user exist in db
                $errors['mail_exist'] = 'This email is already registered.';
                return $errors;
            }
            // need more validations
            if (!$this->mailValidation($mail)) {
                $errors['mail'] = 'Invalid email adress';
            }

            if (strlen($pass) < 6) {
                $errors['pass'] = 'Password is too short.';
            }

            if ($pass !== $pass_again) {
                $errors['pass_not_match'] = 'Both password not match.';
            }

            if ($role != 2 && $role != 3) {
                $errors['role'] = 'Please choose correct role.';
            }

            if (count($errors) > 0) {
                return $errors;
            }
            // need crypting HASH
            $result = $this->accModel->mCreateAccount($mail, $pass, $role);

            if ($result) {
                return [];
            }

            $errors['SQL_ERR'] = 'The job is not added due to SQL Error.';
            return $errors;
        }
    }

    public function mailValidation($mail)
    {
        if (strlen($mail) < 5) {
            return false;
        }

        return preg_match("/^[a-zA-Z0-9._%+-]+@[a-z0-9A-Z.-]+\.[a-zA-Z]{2,}$/", $mail);

    }

    public function isUserLoggedIn()
    {

        $_SESSION['acc_id'] = (int) $_SESSION['acc_id'];
        if (empty($_SESSION['acc_id'])) {

            return false;
        }
        if (!empty($_SESSION['acc_id'])) {
            return $this->getDataForAcc($_SESSION['acc_id']); // will return null if not exist in db 
        }
    }

    public function getDataForAcc($id)
    {
        if ($id === NULL) {
            return null;
        }

        return $this->accModel->getDataForAcc($id);
    }

    private function validateName($name)
    {
        $pattern = "/^[a-zA-Z]{2,}$/";
        if (preg_match($pattern, $name)) {
            return true;
        }

        return false;
    }

    public function updateUserData()
    {


        if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['settings_clicked'] === "1") {

            $user_id = (int) $_SESSION['acc_id'];
            $first_name = trim($_POST['first_name']);
            $last_name = trim($_POST['last_name']);

            if (!$this->validateName($first_name) || !$this->validateName($last_name)) //Validate the data...
            {
                return 'Wrong data: First name and last name must be 2 characters in a-z alphabet.';
            }

            if ($this->accModel->mUpdateUserData($user_id, $first_name, $last_name)) {
                return 'Sucessfull Update.';
            } else {
                return 'Error.';
            }
        }
    }

    public function setUserSession()
    {

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $mail = trim($_POST['mail']);
            $pass = trim($_POST['pass']);

            //Mail and pass validation here...
            $this->logFile->logLogin($mail);
            $array = $this->accModel->mGetUserByMailAndPass($mail, $pass);

            if ($array) {
                $_SESSION['acc_id'] = $array['account_id'];
                header('Location: index.php');
            } else {
                echo 'error email and pass';
            }
        }
    }
}

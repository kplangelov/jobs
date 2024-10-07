<?php

class AccountModel extends Database
{

    public $logFile;

    public function __construct()
    {
        $this->logFile = new FileController();
    }

    public function mIsAccExist($mail)
    {
        $sql = "SELECT * FROM accounts WHERE mail = :mail";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(":mail", $mail);
        try {
            $stmt->execute();
            $array = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($array) {
                return $array;
            } else {
                false;
            }
        } catch (PDOException $e) {
            $this->logFile->fModelMethodError($sql, $e->getMessage());
            echo 'SQL ERR: ' . $e->getMessage();
            return false;
        }
    }

    public function mCreateAccount($mail, $pass, $role)
    {
        // The acc can must role 2 for user or 3 for company.

        $sql = "INSERT INTO accounts(mail, pass, `role`, register_date)
                        VALUES (:mail, :pass, :rolle, :reg_dt )";

        $stmt = $this->getConnection()->prepare($sql);
        $time = time();

        $stmt->bindParam(":mail", $mail);
        $stmt->bindParam(":pass", $pass);
        $stmt->bindParam(":rolle", $role);
        $stmt->bindParam(":reg_dt", $time);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            $this->logFile->fModelMethodError($sql, $e->getMessage());
            echo 'SQL ERR: ' . $e->getMessage();
            return false;
        }

    }


    public function mUpdateUserData($account_id, $first_name, $last_name)
    {
        $sql = "UPDATE users SET first_name = :first_name, last_name = :last_name WHERE account_id = :id";

        $stmt = $this->getConnection()->prepare($sql);

        $stmt->bindParam(":id", $account_id);
        $stmt->bindParam(":first_name", $first_name);
        $stmt->bindParam(":last_name", $last_name);

        try {
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            $this->logFile->fModelMethodError($sql, $e->getMessage());
            echo 'Error during SQL Query: ' . $e->getMessage();
        }
        return false;
    }

    public function mGetUserByMailAndPass($mail, $pass)
    {
        $sql = "SELECT * FROM accounts WHERE mail = :mail AND pass = :pass ";

        $stmt = $this->getConnection()->prepare($sql);

        $stmt->bindParam(":mail", $mail);
        $stmt->bindParam(":pass", $pass);

        try {
            $stmt->execute();

            $array = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($array) {
                return $array;
            } else {
                return [];
            }
        } catch (PDOException $e) {
            $this->logFile->fModelMethodError($sql, $e->getMessage());
            throw new Exception('Error during SQL Query: ' . $e->getMessage());
        }
    }

    public function getDataForAcc($account_id)
    {
        $sql = "SELECT * FROM accounts WHERE account_id = :account_id";

        $stmt = $this->getConnection()->prepare($sql);

        $stmt->bindParam(":account_id", $account_id);

        try {

            $stmt->execute();

            $array = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($array) {
                return $array;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            $this->logFile->fModelMethodError($sql, $e->getMessage());
            echo 'Error during SQL Query ->' . $e->getMessage();

        }

        return null;
    }
}

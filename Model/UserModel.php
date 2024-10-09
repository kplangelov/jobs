<?php 


class UserModel extends Database {

    public $logFile;

    public function __construct()
    {
        $this->logFile = new FileController();

    }
    public function mCreateUser($account_id)
    {
        // The acc can must role 3 for user or 4 for company.

        $sql = "INSERT INTO users(account_id)
                        VALUES (:acc_id)";

        $stmt = $this->getConnection()->prepare($sql);

        $stmt->bindParam(":acc_id", $account_id);

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            $this->logFile->fModelMethodError($sql, $e->getMessage());
            echo 'SQL ERR: ' . $e->getMessage();
            return false;
        }
    }



}
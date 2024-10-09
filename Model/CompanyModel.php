<?php 


class CompanyModel extends Database {

    public $logFile;
    public function __construct() {
        $this->logFile = new FileController();
    }

    public function saveCompanyLogo($account_id, $company_logo) {    



    }

    public function isSessCompanyExist()
    {
        $account_id = (int) $_SESSION['account_id'];

        $sql = 'SELECT account_id from companies WHERE account_id = :account_id ';
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(':account_id', $account_id);

        try {
            $stmt->execute();
            $acc = $stmt->fetch(PDO::FETCH_ASSOC);

            if(!$acc )
            {
                return false;
            }
            return $acc['account_id'];

        } catch (PDOException $e) {
            $this->logFile->fModelMethodError($sql, $e->getMessage());
            echo 'SQL Err: ' . $e->getMessage();
        }

    }

    public function mCreateAccCompany($account_id)
    {
        // The acc can must role 3 for user or 4 for company.

        $sql = "INSERT INTO companies(account_id)
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
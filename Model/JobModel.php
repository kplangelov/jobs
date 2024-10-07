<?php


class JobModel extends Database
{

    private $logFile;

    public function __construct()
    {
        $this->logFile = new FileController();
    }

    public function mUpdateJobStatus($job_id, $user_id, $status_id)
    {

        try {
            $sql = "UPDATE `job_listings` SET `status` = :status_id WHERE job_id = :job_id AND user_id = :user_id ";
            $stmt = $this->getConnection()->prepare($sql);

            // Bind параметри
            $stmt->bindParam(':job_id', $job_id);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':status_id', $status_id);


            return $stmt->execute();
        } catch (PDOException $e) {
            $this->logFile->fModelMethodError($sql, $e->getMessage());
            echo 'SQL Error by Constructor mGetAllJobs(): ' . $e->getMessage();
        }
    }


    public function mGetJobById($job_id)
    {
        $job_id = (int)$job_id;
        $sql = "SELECT * FROM job_listings WHERE job_id = :job_id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(":job_id", $job_id);


        try {
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC); //will return associative array if true, and NULL if empty
        } catch (PDOException $e) {
            $this->logFile->fModelMethodError($sql, $e->getMessage());
            echo 'SQL Error by Constructor mGetAllJobs(): ' . $e->getMessage();
        }
    }

    public function mGetAllJobs()
    {
        $sql = "SELECT * FROM job_listings WHERE `status` = 1 ORDER BY date_add DESC";

        $stmt = $this->getConnection()->prepare($sql);

        try {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->logFile->fModelMethodError($sql, $e->getMessage());
            echo 'SQL Error by Constructor mGetAllJobs(): ' . $e->getMessage();
        }

        return [];
    }

    public function mGetCountryById($country_id)
    {

        $sql = "SELECT nicename FROM countries where country_id = :country_id ";

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(":country_id", $country_id);

        try {
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->logFile->fModelMethodError($sql, $e->getMessage());
            echo 'SQL Error by Constructor: ' . $e->getMessage();
        }

        return null;
    }

    public function mGetJobCountries()
    {

        $sql = "SELECT country_id, nicename FROM countries";

        $stmt = $this->getConnection()->prepare($sql);

        try {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->logFile->fModelMethodError($sql, $e->getMessage());
            echo 'SQL Error by Constructor: ' . $e->getMessage();
        }

        return [];
    }

    public function getJobsById($account_id, $job_status) // $job_status can be only 0 and 1, because if it -1 it perma deleted.
    {
        $job_status = (int)$job_status;
        if($job_status != 0 && $job_status != 1)
        {
            return 'Job status can be only 0 for deleted and 1 for active job status';
        }

        $sql = "SELECT * FROM job_listings WHERE user_id = :account_id AND `status` = :job_status ORDER BY date_add DESC ";

        $stmt = $this->getConnection()->prepare($sql);

        $stmt->bindParam(":account_id", $account_id);
        $stmt->bindParam(":job_status", $job_status);

        try {

            $stmt->execute();

            $array = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($array) {
                return $array;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            $this->logFile->fModelMethodError($sql, $e->getMessage());
            echo 'Error during SQL Query ->' . $e->getMessage();
        }

        return [];
    }

    public function mCreateJob($user_id, $job_title, $job_desc, $job_country_id, $create_time)
    {
        $sql = "INSERT INTO job_listings (user_id, job_title, job_description, job_country_id, date_add)
                            VALUES(:user_id, :job_title, :job_desc, :job_country_id, :create_time)";

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":job_title", $job_title);
        $stmt->bindParam(":job_desc", $job_desc);
        $stmt->bindParam(":job_country_id", $job_country_id);
        $stmt->bindParam(":create_time", $create_time);

        try {
            //code...
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            $this->logFile->fModelMethodError($sql, $e->getMessage());
            echo 'Error during SQL Query: ' . $e->getMessage();
        }
    }
}

<?php

class JobController
{

    private $jobModel;
    private $accCntrl;

    public function __construct()
    {
        $this->jobModel = new JobModel();
        $this->accCntrl = new AccountController();
    }

    public function updateJobStatus($job_id, $status)
    {
        $user_id = (int) $_SESSION['acc_id'];

        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $get_id = (int) $_GET['job_id'];
            $job_arr = $this->jobModel->mGetJobById($job_id);

            if (empty($job_arr) || $job_id < 1 || $get_id < 1) {
                return 'Обявата не съществува.';
            }

            if ($job_arr['user_id'] !== $user_id) {
                return 'Тази обява не е качена от теб. Записан си като хакер в нашата база.';
            }

            if ($this->jobModel->mUpdateJobStatus($job_id, $user_id, $status)) {
                return 'Job status changed to: ' . $this->getJobStatus($status);
            } else {
                return 'Проблем с изтриването на обявата.';
            }
        }
    }

    public function getJobByIdInJob()
    {
        $job_id = (int) $_GET['id'];
        if ($job_id < 1) {
            return null;
        }
        return $this->jobModel->mGetJobById($job_id);
    }

    public function getJobStatus($status)
    {
        switch ($status) {
            case '1':
                return 'Active';
            case '0':
                return 'Deleted';
            case '-1':
                return 'Permanent deleted';
            default:
                return false;
        }
    }

    public function getAllJobs()
    {
        return $this->jobModel->mGetAllJobs();
    }

    public function getCountryById($id)
    {
        return $this->jobModel->mGetCountryById($id);
    }

    public function getAllCountries()
    {
        return $this->jobModel->mGetJobCountries();
    }


    public function getDeletedJobsById($id)
    {
        return $this->jobModel->getJobsById($id, 0);
    }

    public function getAllJobsById($id)
    {
        return $this->jobModel->getJobsById($id, 1);
    }

    private function jobTitleValidation($job_title)
    {
        if (strlen($job_title) < 5) {
            return false;
        }

        return true;
    }

    private function jobDescValidation($job_desc)
    {
        if (strlen($job_desc) < 20) {
            return false;
        }

        return true;
    }

    public function createJob()
    {

        if ($_SERVER['REQUEST_METHOD'] && $_POST['jobAdd_click'] === "1") {
            $job_user_id = (int) $_SESSION['acc_id'];
            $job_title = trim($_POST['job_title']);
            $job_desc = trim($_POST['job_description']);
            $job_country_id = (int) $_POST['job_country_id'];
            $create_time = time(); //current timestamp
            $errors = [];

            if (!$this->jobTitleValidation($job_title)) {
                $errors['job_title'] = 'Your job title must be minimum 5 symbols.';
            }

            if (!$this->jobDescValidation($job_desc)) {
                $errors['job_desc'] = 'Your job desc must be minimum 20 symbols.';
            }

            if (!empty($errors)) {
                return $errors;
            }

            //after validation ... 

            $result = $this->jobModel->mCreateJob($job_user_id, $job_title, $job_desc, $job_country_id, $create_time);
            if ($result) {
                return [];
            } else {
                return $errors['SQL_ERR'] = 'The job is not added due to SQL Error.';
            }
        }
    }
}


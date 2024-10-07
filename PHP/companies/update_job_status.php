<?php

$jobCon = new JobController();

$jobView = new JobView();

$user_id = (int) $_SESSION['user_id'];

$job_id = (int) $_GET['job_id'];

$job_status = (int) $_GET['set_status_id'];

//Status ID 1 -- Active
//Status ID 0 -- Delete
//Status ID -1 -- Perma delete.

if ($jobCon->UpdateJobStatus($job_id, $job_status)) {
    if ($job_status === 0) // that means user delete the job from my_jobs
    {
        echo '<alert> Изтрита </alert>';
        header('Location: ' . getRoute('my_jobs'));
    } else {
        header('Location: ' . getRoute('deleted_jobs'));

    }

}
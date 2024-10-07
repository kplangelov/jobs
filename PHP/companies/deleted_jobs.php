<?php

$jobCon = new JobController();

$jobView = new JobView();

$user_id = (int)$_SESSION['user_id'];

$jobView->showDeletedJobs($user_id);
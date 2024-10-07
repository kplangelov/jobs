<?php

$jobCon = new JobController();

$jobView = new JobView();

$acc_id = (int)$_SESSION['acc_id'];

$jobView->showJobsById($acc_id);
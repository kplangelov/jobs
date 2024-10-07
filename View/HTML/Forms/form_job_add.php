<?php

$userCntrl = new AccountController();

?>

<div class="container mt-5">
    <h2 class="h3">Add new job</h2>
    <form method="POST" action="">
        <label class="form-label" for="job_title">Job Title</label>
        <input class="form-control bg-dark text-white" type="text" id="job_title" name="job_title" required>


        <label class="form-label" for="job_description">Job Description</label>
        <textarea class="form-control bg-dark placeholder-primary text-white placeholder-glow" id="job_description"
            name="job_description" placeholder="Enter job description"></textarea>

        <label class="form-label" for="job_location">Job Location</label>
        <?php
        $jobViewInForm = new JobView();
        try {
            $jobViewInForm->vShowCountryOptionsInForm();
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
        ?>

        <input class="btn btn-primary mt-3" type="submit" value="Add Job">

        <input type="hidden" name="jobAdd_click" value="1">
    </form>
</div>
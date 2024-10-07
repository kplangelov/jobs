<?php

class JobView
{

    private $jobCntrl;
    private $userCntrl;

    public function __construct()
    {
        $this->jobCntrl = new JobController();
        $this->userCntrl = new AccountController();
    }

    public function vCreateJob()
    {

        $result = $this->jobCntrl->createJob();

        if (is_array($result)) //if array is created;
        {
            if (!count($result)) {
                ?>
                <p class="container p-3 alert alert-success alert-dismissible fade show mt-1" role="alert">
                    Sucessfully added!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </p>
                <?php
            } else {
                foreach ($result as $key => $value) {
                    ?>
                    <p class="container p-3 alert alert-danger alert-dismissible fade show mt-1" role="alert"> <?php echo $value; ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </p>
                    <?php
                }
            }
        }

        includeForm('form_job_add.php');

    }

    public function vShowJobInJob()
    {
        $job = $this->jobCntrl->getJobByIdInJob();
        ?>
        <section class="container mt-3">
            <?php
            if (!empty($job)) {
                ?>
                <div class="row rounded-pill">
                    <div class="col container mb-4 border border-1 p-3">
                        <h3 class="border-start border-5 ps-3"><?php echo htmlspecialchars($job['job_title']) ?></h3>
                        <p class="text-white"><?php echo $job['job_description'] ?></p>
                        <p>
                            <span class="text-secondary">Добавена на: </span>
                            <span><?php echo date("d/m/Y", ($job['date_add'])) ?></span>
                        </p>
                        <?php
                        //get user data
                        //$user_arr = $this->userCntrl->getDataForAcc($job['user_id']);
                        //$username = $user_arr !== NULL ? htmlspecialchars($user_arr['user']) : 'Този потребител не съществува';
                        ?>
                        <a href="" class="btn btn-primary">Бързо кандидатстване</a>
                        <a href="" class="btn btn-primary">Преглед</a>
                    </div>
                    <div class="col container mb-4 border border-1 p-3">
                        test
                    </div>
                </div>
                <?php
            } else {
                echo 'Тази обява не съществува.';
            }
            echo '</section>';
    }

    public function vShowAllJobsInIndex()
    {
        $jobs_arr = $this->jobCntrl->getAllJobs();
        $jobIndex = 1; // Използваме jobIndex вместо i за по-ясно име
        ?>
            <section class="container mt-3">
                <?php
                if (!empty($jobs_arr)) {
                    foreach ($jobs_arr as $job) {
                        ?>
                        <div class="row border border-1">
                            <div class="col container mb-4 border border-1 p-3">
                                <h3 class="border-start border-5 ps-3"><?php echo htmlspecialchars($job['job_title']) ?></h3>
                                <p>
                                    <span class="text-secondary">Добавена на: </span>
                                    <span><?php echo date("d/m/Y", ($job['date_add'])) ?></span>
                                </p>
                                <?php
                                //get user data
                                $user_arr = $this->userCntrl->getDataForAcc($job['user_id']);
                                $username = $user_arr !== NULL ? htmlspecialchars($user_arr['user']) : 'Този потребител не съществува';
                                ?>
                                <a href="" class="btn btn-primary">Бързо кандидатстване</a>
                                <a href="" class="btn btn-primary">Преглед</a>
                            </div>
                            <div class="bg-secondary col mb-4 border border-1 p-3">
                                <div class="row">
                                    <div class="col">
                                        <img width="150" src="https://download.logo.wine/logo/Playtech/Playtech-Logo.wine.png">
                                    </div>
                                    <ul class="col col-md-auto list-group">
                                        <li class="list-group-item bg-dark text-white">ПЛАЙТЕХ БЪЛГАРИЯ ЕООД</li>
                                        <li class="list-group-item bg-dark text-white"><i class="bi bi-people-fill pe-1"></i>Служители:
                                            115</li>
                                        <li class="list-group-item bg-dark text-white"><i class="bi bi-calendar pe-1"></i>Регистрирана:
                                            2023</li>
                                    </ul>
                                    <div class="col">
                                        <i class="bi bi-envelope-fill"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php

                        // echo '<a href="apply.php?job_id=' . htmlspecialchars($job['job_id']) . '" class="apply-button">Кандидатствай</a>'; // Предполагаемо ID на обявата
                        //echo '<a href="' . getRoute('view_job') . '&&id=' . htmlspecialchars($job['job_id']) . '" class="apply-button">Преглед</a>'; // Предполагаемо ID на обявата
                    }
                    ?>
                </section>
                <?php
                } else {
                    echo '<p class="no-jobs-message">Няма нито една добавена обява.</p>';
                }
    }


    public function showDeletedJobs($user_id)
    {
        $jobs_arr = $this->jobCntrl->getDeletedJobsById($user_id);
        $jobIndex = 1; // Използваме jobIndex вместо i за по-ясно име
        echo '<section class="job-list-container">'; // Секция с обявите
        if (!empty($jobs_arr)) {
            foreach ($jobs_arr as $job) {
                echo '<div class="job-card">'; // Карта за обявата
                echo '<h3 class="job-title">' . htmlspecialchars($job['job_title']) . '</h3>';

                echo '<p class="job-id">Обява номер: ' . $jobIndex++ . '</p>';

                echo '<p class="job-description">' . htmlspecialchars($job['description']) . '</p>'; // Предполагаемо описание

                // Бутон за кандидатстване
                echo '<a href="' . getRoute('update_job_status') . '&&job_id=' . htmlspecialchars($job['job_id']) . '&&set_status_id=1" class="apply-button">Възстанови</a>'; // Предполагаемо ID на обявата
                echo '<a href="' . getRoute('update_job_status') . '&&job_id=' . htmlspecialchars($job['job_id']) . '&&set_status_id=-1" class="apply-button">Изтрий завинаги</a>'; // Предполагаемо ID на обявата
                //echo '<a href="job.php?id=' . htmlspecialchars($job['job_id']) . '" class="apply-button">Прегледай</a>'; // Предполагаемо ID на обявата
                echo '</div>'; // Затваряме job-card
            }
            echo '</section>';
        } else {
            echo '<p class="no-jobs-message">Няма нито една изтрита обява от този профил.</p>';
        }
    }

    public function showJobsById($user_id)
    {
        $jobs_arr = $this->jobCntrl->getAllJobsById($user_id);
        $jobIndex = 1; // Използваме jobIndex вместо i за по-ясно име
        ?>
            <section class="container mt-3">
                <?php
                if (!empty($jobs_arr)) {
                    foreach ($jobs_arr as $job) {
                        ?>
                        <div class="row rounded-pill">
                            <div class="col container mb-4 border border-1 p-3">
                                <h3 class="border-start border-5 ps-3"><?php echo htmlspecialchars($job['job_title']) ?></h3>
                                <p class="text-white"><?php echo $job['job_description'] ?></p>
                                <p>
                                    <span class="text-secondary">Добавена на: </span>
                                    <span><?php echo date("d/m/Y", ($job['date_add'])) ?></span>
                                </p>
                                <?php
                                ?>
                                <a href="" class="btn btn-primary">Бързо кандидатстване</a>
                                <a href="" class="btn btn-primary">Преглед</a>
                            </div>
                            <div class="col container mb-4 border border-1 p-3">
                                test
                            </div>
                        </div>
                        <?php
                    }
                    echo '</section>';
                } else {
                    echo '<p class="no-jobs-message">Няма нито една добавена обява от този профил.</p>';
                }
    }


    public function vShowCountryOptionsInForm()
    {
        $array = $this->jobCntrl->getAllCountries();

        if (count($array) > 0) {
            echo '<select class="form-select bg-dark text-white" name="job_country_id">';
            foreach ($array as $country) {
                echo '<option value="';
                echo $country['country_id'];
                echo '">';
                echo $country['nicename'];
                echo '</option>';
            }
            echo '</select>';
        } else {
            throw new Exception("Empty countries");
        }
    }
}


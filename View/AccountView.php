<?php

class AccountView
{

    private $accCntrl;

    public function __construct()
    {
        $this->accCntrl = new AccountController();
    }

    public function vCreateReg()
    {

        $result = $this->accCntrl->createAccount();
        
        ?>
        <div class="container">
            <?php
            if (is_array($result)) {
                if (!count($result)) {
                    ?>
                    <p class="container p-3 alert alert-success alert-dismissible fade show mt-1" role="alert">
                        Sucessfully registration!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </p>
                    <?php
                } else if (count($result)) {
                    
                    foreach ($result as $key => $value) {
                        ?>
                            <p class="container p-3 alert alert-danger alert-dismissible fade show mt-1" role="alert">
                            <?php echo $value; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <?php
                    }
                }
            }

            includeForm("form_registration.php");
            echo '</div>';
    }

    public function vShowUserById($user)
    {
        $result = $this->accCntrl->getDataForAcc($user);

        if (!empty($result)) {
            return htmlspecialchars($result['mail']);
        } else {
            header('Location: error.php?e=user_do_not_exist');
            exit();
        }
    }

    public function showAccountFromId($user)
    {
        $result = $this->accCntrl->getDataForAcc($user);
        ?>
            <section class="container mt-5 border border-1">
                <div class="container pt-5">

                    <?php

                    if (!empty($result)) {
                        ?>
                        <h2 class="h3 border-start border-5 border-secondary ps-3">
                            <i class="bi bi-person-circle"></i> Профил на
                            <?php echo $this->accCntrl->getUserRole($result['role']) ?>
                        </h2>
                        <p><?php echo htmlspecialchars($result['mail']); ?> </p>

                        <p>
                            <?php ?>
                        </p>
                        <?php
                    } else {
                        echo 'Account do not exist.';
                        exit();
                    }
                    ?>
                </div>
            </section>
            <?php
    }
}

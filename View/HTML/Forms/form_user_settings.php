<?php
$accCntrl = new AccountController();
$acc_arr = $accCntrl->isAccLoggedIn();
?>

<div class="container mt-5">
    <h2 class="h3">Profile settings</h2>

    <form method="POST" action="">

        <label for="mail" class="form-label">Mail</label>

        <input class="form-control bg-dark text-white" id="mail" type="text" name="mail"
            value="<?php echo htmlspecialchars($acc_arr['mail']) ?>" placeholder="Mail">


        <label for="pass" class="form-label">New password: </label>

        <input class="form-control bg-dark text-white" id="pass" type="text" name="pass"
            value="<?php echo htmlspecialchars($acc_arr['pass']) ?>" placeholder="Password">

        <input class="btn btn-primary mt-3" type="submit" value="Save">

        <input type="hidden" name="settings_clicked" value="1">
    </form>

</div>
<?php

$userCntrl = new AccountController();

$updateDataResult = $userCntrl->updateUserData();

includeForm('form_user_settings.php');

echo $updateDataResult;

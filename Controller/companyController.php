<?php

class CompanyController
{

    private $accCntrl;

    public function __construct()
    {
        $this->accCntrl = new AccountController();
    }

    public function uploadCompanyLogo()
    {

        if($_SERVER['REQUEST_METHOD'] === 'POST' )
        {
            echo 'It works.';
        }
        

        includeForm('form_company_logo_upload.php');
    }
    
}

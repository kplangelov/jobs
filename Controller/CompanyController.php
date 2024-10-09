<?php

class CompanyController
{

    private $accCntrl;

    public function __construct()
    {
        $this->accCntrl = new AccountController();
    }

    public function validateFile($fileType, $uploadedFile, $maxFileSize, $arrWithTypes, $arrWithExtensions)
    {
        //2MB = 2097152
        //$file = $_FILES['company_logo'];
        $tmp_name = $uploadedFile['tmp_name'];
        $size = $uploadedFile['size'];
        $type = $uploadedFile['type'];

        $errors = [];

        if ($size > $maxFileSize) {
            $errors['size'] = 'max file size issue';
        }
        $type = strtolower($type);

        if (!in_array($type, $arrWithTypes)) {
            $errors['type'] = 'File is not properly type';
        }

        $user_file_ext = pathinfo($uploadedFile['name'], PATHINFO_EXTENSION);

        if (!in_array($user_file_ext, $arrWithExtensions)) {
            $errors['ext'] = 'File extension is not ' . $fileType;
        }

        $phpFileUploadErrors = [
            0 => 'There is no error, the file uploaded with success',
            1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
            2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
            3 => 'The uploaded file was only partially uploaded',
            4 => 'No file was uploaded',
            6 => 'Missing a temporary folder',
            7 => 'Failed to write file to disk.',
            8 => 'A PHP extension stopped the file upload.',
        ];

        if ($uploadedFile['error']) {
            $errors['file_err'] = $phpFileUploadErrors[$uploadedFile['error']];
        }

        if ($errors) {
            return $errors;
        }

        return $tmp_name;

    }

    public function uploadCompanyLogo()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['is_upload_clicked'] === '1') {
            //2MB = 2097152
            //$file = $_FILES['company_logo'];

            $tmp_name = $this->validateFile(
                'image',
                $_FILES['company_logo'],
                2097152,
                ["image/jpg", "image/jpeg", "image/png",],
                ['jpg', 'jpeg', 'png']
            );

            if (is_array($tmp_name)) {
                return $tmp_name;
            }

            $user_file_ext = pathinfo($_FILES['company_logo']['name'], PATHINFO_EXTENSION);

            $uploader = $this->accCntrl->isAccLoggedIn();

            $last_file_name = 'images' . DIRECTORY_SEPARATOR . 'logo_' . $uploader['account_id'] . '_' . time() . '.' . $user_file_ext;
            
            if (!is_writable(dirname($last_file_name))) {
                return ['The target directory is not writable.'];
            }
            
            $result = move_uploaded_file($tmp_name, $last_file_name);

            $result ? [] : ['File can’t be uploaded properly.'];
        }

    }
}

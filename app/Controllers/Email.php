<?php

namespace App\Controllers;

use App\Models\userModel;
use CodeIgniter\Router\Exceptions\RedirectException;

class Email extends BaseController
{
    public function sendEmail()
    {
        $email = \config\Services::email();
        $email->setFrom('Rikofrmndo27@gmail.com', 'Riko Firmando');
        $email->setTo('Rikofrmndo@gmail.com');


        $email->setSubject('test email');
        $email->setMessage('testing');

        if (!$email->send()) {
            return false;
        } else {
            return true;
        }
    }
}

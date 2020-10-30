<?php
namespace App\Libraries;

class IonAuth extends \IonAuth\Libraries\IonAuth
{
    public function __construct()
    {
        // Check compat first
        $this->checkCompatibility();

        $this->config = config('IonAuth');

        $this->email = \Config\Services::email();
        helper('cookie');

        $this->session = session();

        $this->ionAuthModel = new \IonAuth\Models\IonAuthModel();

        $emailConfig = $this->config->emailConfig;

        if ($this->config->useCiEmail && isset($emailConfig) && is_array($emailConfig))
        {
            $this->email->initialize($emailConfig);
        }

        $this->ionAuthModel->triggerEvents('library_constructor');
    }
}

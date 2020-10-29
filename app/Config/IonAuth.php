<?php namespace Config;

class IonAuth extends \IonAuth\Config\IonAuth
{
    // set your specific config
    public $siteTitle                = 'Eventstreammonitor.com';       // Site Title, example.com
    public $adminEmail               = 'admin@eventstreammonitor.com'; // Admin Email, admin@example.com
    // public $emailTemplates           = 'App\\Views\\auth\\email\\';

    public $useCiEmail = true;
    public $emailActivation = true;
    public $manualActivation = true;

}
<?php namespace App\Controllers;

class Auth extends \IonAuth\Controllers\Auth {
    protected $viewsFolder = 'auth';

    public function __construct()
    {
        $this->ionAuth = new \IonAuth\Libraries\IonAuth();
        $this->validation = \Config\Services::validation();
        helper(['form', 'url']);
        $this->configIonAuth = config('IonAuth');
        $this->session = \Config\Services::session();

        if (! empty($this->configIonAuth->templates['errors']['list']))
        {
            $this->validationListTemplate = $this->configIonAuth->templates['errors']['list'];
        }

        $this->data['page_title'] = 'Event Stream Monitor';
    }

    public function login()
    {
        if ($this->request->getPost())
        {
            // check to see if the user is logging in
            // check for "remember me"
            $remember = (bool)$this->request->getVar('remember');

            if ($this->ionAuth->login($this->request->getVar('identity'), $this->request->getVar('password'), $remember))
            {
                //if the login is successful
                //redirect them back to the home page
                $this->session->setFlashdata('message', $this->ionAuth->messages());
                return redirect()->to('/home');
            }
            else
            {
                // if the login was un-successful
                // redirect them back to the login page
                $this->session->setFlashdata('message', $this->ionAuth->errors($this->validationListTemplate));
                // use redirects instead of loading views for compatibility with MY_Controller libraries
                return redirect()->back()->withInput();
            }
        }
        else
        {
            if($this->ionAuth->loggedIn()) {
                return redirect()->to('/home');
            }

            // the user is not logging in so display the login page
            // set the flash data error message if there is one
            $this->data['message'] = $this->validation->getErrors() ? $this->validation->listErrors($this->validationListTemplate) : $this->session->getFlashdata('message');

            return $this->renderPage($this->viewsFolder . DIRECTORY_SEPARATOR . 'login', $this->data);
        }
    }
}
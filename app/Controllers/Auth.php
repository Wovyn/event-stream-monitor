<?php
namespace App\Controllers;

class Auth extends \IonAuth\Controllers\Auth {
    protected $viewsFolder = 'auth';

    public function __construct()
    {
        $this->ionAuth = new \App\Libraries\IonAuth();
        $this->validation = \Config\Services::validation();
        helper(['form', 'url']);
        $this->configIonAuth = config('IonAuth');
        $this->session = \Config\Services::session();

        if (! empty($this->configIonAuth->templates['errors']['list']))
        {
            $this->validationListTemplate = $this->configIonAuth->templates['errors']['list'];
        }

        $this->data['meta'] = [
            'title' => 'Event Stream Monitor'
        ];
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
                return redirect()->to('/dashboard');
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
                return redirect()->to('/dashboard');
            }

            // the user is not logging in so display the login page
            // set the flash data error message if there is one
            $this->data['message'] = $this->validation->getErrors() ? $this->validation->listErrors($this->validationListTemplate) : $this->session->getFlashdata('message');

            return $this->renderPage($this->viewsFolder . DIRECTORY_SEPARATOR . 'login', $this->data);
        }
    }

    public function register() {
        $tables                        = $this->configIonAuth->tables;
        $identityColumn                = $this->configIonAuth->identity;
        $this->data['identity_column'] = $identityColumn;

        if ($this->request->getPost())
        {
            $email    = strtolower($this->request->getPost('email'));
            $identity = ($identityColumn === 'email') ? $email : $this->request->getPost('identity');
            $password = $this->request->getPost('password');

            $additionalData = [
                'first_name' => $this->request->getPost('first_name'),
                'last_name'  => $this->request->getPost('last_name'),
                'company'    => $this->request->getPost('company'),
                'phone'      => $this->request->getPost('phone'),
            ];

            $user_id = $this->ionAuth->register($identity, $password, $email, $additionalData);
            if ($user_id)
            {
                return json_encode([
                        'error' => false,
                        'message' => $this->ionAuth->messages()
                    ]);
            } else {
                return json_encode([
                        'error' => true,
                        'message' => $this->ionAuth->errors()
                    ]);
            }
        }
    }

    public function forgot_password() {
        if ($this->request->getPost())
        {
            $identityColumn = $this->configIonAuth->identity;
            $identity = $this->ionAuth->where($identityColumn, $this->request->getPost('email'))->users()->row();

            if (empty($identity))
            {
                if ($this->configIonAuth->identity !== 'email')
                {
                    $this->ionAuth->setError('Auth.forgot_password_identity_not_found');
                }
                else
                {
                    $this->ionAuth->setError('Auth.forgot_password_email_not_found');
                }

                $this->session->setFlashdata('message', $this->ionAuth->errors($this->validationListTemplate));
                return redirect()->to('/auth/forgot_password');
            }

            // run the forgotten password method to email an activation code to the user
            $forgotten = $this->ionAuth->forgottenPassword($identity->{$this->configIonAuth->identity});

            if ($forgotten)
            {
                // if there were no errors
                return json_encode([
                    'error' => false,
                    'message' => $this->ionAuth->messages()
                ]);
            }
            else
            {
                return json_encode([
                    'error' => true,
                    'message' => $this->ionAuth->errors()
                ]);
            }
        }
    }

    public function activate(int $id, string $code = ''): \CodeIgniter\HTTP\RedirectResponse
    {
        $activation = false;

        if ($code)
        {
            $activation = $this->ionAuth->activate($id, $code);
        }
        else if ($this->ionAuth->isAdmin())
        {
            $activation = $this->ionAuth->activate($id);
        }

        if ($activation)
        {
            $this->session->setFlashdata('message', $this->ionAuth->messages());
        }
        else
        {
            $this->session->setFlashdata('message', $this->ionAuth->errors());
        }

        return redirect()->to('/auth/login');
    }

    public function lockscreen() {
        $this->data['user'] = $this->ionAuth->user()->row();

        if($_POST) {
            // validate password
            $isValid = $this->ionAuth->verifyPassword($_POST['password'], $this->data['user']->password, $this->data['user']->email);

            if($isValid) {
                $this->session->remove('lockscreen');
                return redirect()->to('/dashboard');
            } else {
                $this->data['has_error'] = true;
            }
        }

        $this->session->set('lockscreen', true);

        $this->data['page_title'] = 'Lockscreen | ' . $this->data['page_title'];
        return view('auth/lockscreen', $this->data);
    }

    public function emailTest() {
        $email = \Config\Services::email();

        $email->setFrom('admin@eventstreammonitor.com', 'Admin');
        $email->setTo('rj@humanxtensions.com');

        $email->setSubject('Email Test');
        $email->setMessage('Testing the email class.');

        if(!$email->send()) {
            echo 'error';
        }
    }

    // private function setAwsRegions() {
    //     $authKeysModel = new \App\Models\AuthKeysModel();
    //     if(!$authKeysModel->where('user_id', $this->ionAuth->user()->row()->id)->countAllResults()) {
    //         return;
    //     }

    //     if(!$this->session->has('regions')) {
    //         $aws = new \Config\Aws();
    //         $authKeysModel = new \App\Models\AuthKeysModel();
    //         $keys = $authKeysModel->where('user_id', $this->ionAuth->user()->row()->id)->first();

    //         if($keys) {
    //             $this->ec2 = new \App\Libraries\Ec2([
    //                 'access' => $keys->aws_access,
    //                 'secret' => $keys->aws_secret
    //             ]);

    //             $result = $this->ec2->DescribeRegions();

    //             $regions = [];
    //             if(!$result['error']) {
    //                 foreach ($result['describeRegions']['Regions'] as $region) {
    //                     $regions[$region['RegionName']] = $aws->regions[$region['RegionName']];
    //                 }

    //             }
    //         } else {
    //             // set to default
    //             $regions = $aws->regions;
    //         }

    //         asort($regions, SORT_STRING);
    //         $this->session->set('regions', $regions);
    //     }
    // }

    // public function getSession() {
    //     $session = $this->session->get();

    //     unset(
    //         $session['_ci_previous_url'],
    //         $session['__ci_last_regenerate'],
    //         $session['old_last_login'],
    //         $session['last_check']
    //     );

    //     return $this->response->setJSON(json_encode($session));
    // }
}
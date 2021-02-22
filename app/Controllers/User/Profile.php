<?php
namespace App\Controllers\User;

class Profile extends \App\Controllers\BaseController
{
    protected $usersModel, $authKeysModel, $ionAuthModel;

    public function __construct() {
        parent::__construct();

        $this->usersModel = new \App\Models\UsersModel();
        $this->authKeysModel = new \App\Models\AuthKeysModel();
        $this->ionAuthModel = new \IonAuth\Models\IonAuthModel();
    }

    public function index()
    {
        $this->data['meta']['title'] = 'User Profile | ' . $this->data['meta']['title'];
        $this->data['meta']['header'] = 'User Profile';
        $this->data['meta']['subheader'] = 'User Info, Twilio and AWS API Keys';

        array_push($this->data['css'],
           "/bower_components/bootstrap-fileinput/css/fileinput.min.css",
           "/bower_components/bootstrap-social/bootstrap-social.css"
        );

        array_push($this->data['scripts'],
            "/bower_components/jquery.pulsate/jquery.pulsate.min.js",
            "/bower_components/bootstrap-fileinput/js/plugins/canvas-to-blob.min.js",
            "/bower_components/bootstrap-fileinput/js/fileinput.min.js",
            "/bower_components/jquery-validation/dist/jquery.validate.min.js",
            "/assets/js/pages-user-profile.js",
            "/assets/js/pages/user/profile.js"
        );

        $this->data['auth_keys'] = $this->authKeysModel->where('user_id', $this->data['user']->id)->first();

        return view('user/profile', $this->data);
    }

    public function update() {
        if($this->request->getPost()) {
            $data = [
                'first_name' => $this->request->getPost('first_name'),
                'last_name' => $this->request->getPost('last_name'),
                'email' => $this->request->getPost('email'),
                'phone' => $this->request->getPost('phone'),
                'company' => $this->request->getPost('company')
            ];

            if($this->request->getPost('password') != '') {
                $data['password'] = $this->ionAuthModel->hashPassword($this->request->getPost('password'), $this->request->getPost('email'));
            }

            $result = $this->usersModel->update($this->data['user']->id, $data);

            return json_encode([
                'error' => !$result,
                'message' => ($result ? 'Successfully updated user profile!' : 'Something went wrong.')
            ]);
        }
    }

    public function update_keys() {
        if($this->request->getPost()) {
            $data = [
                'twilio_sid' => $this->request->getPost('twilio_sid'),
                'twilio_secret' => $this->request->getPost('twilio_secret'),
                'aws_access' => $this->request->getPost('aws_access'),
                'aws_secret' => $this->request->getPost('aws_secret'),
                'event_stream_role_arn' => $this->request->getPost('event_stream_role_arn'),
                'external_id' => $this->request->getPost('external_id'),
                'aws_account' => null
            ];

            // validate aws keys and get
            $sts = new \App\Libraries\Sts([
                'access' => $data['aws_access'],
                'secret' => $data['aws_secret']
            ]);

            $identity = $sts->GetCallerIdentity();
            if(!$identity['error']) {
                $data['aws_account'] = $identity['getCallerIdentity']['Account'];
            }

            // echo '<pre>' , var_dump($data) , '</pre>';

            if($this->authKeysModel->where('user_id', $this->data['user']->id)->countAllResults()) {
                // update
                $result = $this->authKeysModel->where('user_id', $this->data['user']->id)->update(null, $data);
            } else {
                // save
                $data['user_id'] = $this->data['user']->id;
                $result = $this->authKeysModel->save($data);
            }

            return json_encode([
                'error' => !$result,
                'message' => ($result ? 'Successfully updated auth keys!' : 'Something went wrong.')
            ]);
        }
    }

    public function auth_keys() {
        // $result = [
        //     'has_keys' => true
        // ];

        // if($this->authKeysModel->where('user_id', $this->data['user']->id)->countAllResults()) {
        //     $keys = $this->authKeysModel->where('user_id', $this->data['user']->id)->first();

        //     $result['keys'] = [
        //         'twilio_sid' => $keys['twilio_sid'],
        //         'twilio_secret' => $keys['twilio_secret'],
        //         'aws_access' => $keys['aws_access'],
        //         'aws_secret' => $keys['aws_secret']
        //     ];
        // } else {
        //     $result['has_keys'] = false;
        //     $result['message'] = 'Before using the portal, you must enter your API Keys for Twilio and AWS.';
        // }

        // return json_encode($result);

        $result = [
            'keys' => true
        ];

        if(!$this->authKeysModel->where('user_id', $this->data['user']->id)->countAllResults()) {
            $result['keys'] = false;
            $result['message'] = 'Before using the portal, you must enter your API Keys for Twilio and AWS.';
        }

        return json_encode($result);
    }

}
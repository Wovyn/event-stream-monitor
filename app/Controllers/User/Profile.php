<?php
namespace App\Controllers\User;
use App\Controllers\BaseController;

class Profile extends BaseController
{
    protected $usersModel, $authKeysModel, $ionAuthModel;

    public function __construct() {
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
            "/assets/js/pages/user-profile.js"
        );

        $this->data['auth_keys'] = $this->authKeysModel->where('user_id', $this->data['user']->id)->asObject()->first();

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
                'aws_secret' => $this->request->getPost('aws_secret')
            ];

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
}
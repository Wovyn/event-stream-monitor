<?php
namespace App\Controllers\User;
use App\Controllers\BaseController;

class Profile extends BaseController
{
    protected $usersModel;
    protected $ionAuthModel;

    public function __construct() {
        $this->usersModel = new \App\Models\UsersModel();
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
}
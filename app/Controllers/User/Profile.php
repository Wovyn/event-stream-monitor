<?php
namespace App\Controllers\User;
use App\Controllers\BaseController;

class Profile extends BaseController
{
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


}
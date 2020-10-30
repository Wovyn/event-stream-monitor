<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class IonAuthFilter implements FilterInterface
{

    protected $ionAuth;

    public function __construct() {
        $this->ionAuth = new \IonAuth\Libraries\IonAuth();

    }

    public function before(RequestInterface $request)
    {
        if(!$this->ionAuth->loggedIn()) {
            return redirect()->to('/auth/login');
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response)
    {
        // Do something here
    }
}
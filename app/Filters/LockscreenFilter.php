<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class LockscreenFilter implements FilterInterface
{

    protected $session;

    public function __construct() {
        $this->session = \Config\Services::session();
    }

    public function before(RequestInterface $request)
    {
        if($this->session->has('lockscreen')) {
            return redirect()->to('/auth/lockscreen');
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response)
    {
        // Do something here
    }
}
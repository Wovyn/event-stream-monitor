<?php
namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;

class BaseController extends Controller
{

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = ['form', 'url', 'aws', 'hx'];

	/**
	 * IonAuth library
	 *
	 * @var \IonAuth\Libraries\IonAuth
	 */
	protected $ionAuth;
	protected $data;

	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.:
		// $this->session = \Config\Services::session();

		$this->data['css'] = [];
        $this->data['scripts'] = [];

        $app_config = new \Config\App();

        $this->data['meta'] = [
        	'title' => 'Event Stream Monitor',
        	'header' => null,
        	'subheader' => null,
        	'sessionExpiration' => $app_config->sessionExpiration,
        	'sessionTimeToUpdate' => $app_config->sessionTimeToUpdate
        ];
	}

	// triggers first before initController
	public function __construct() {
		$this->session = \Config\Services::session();

		$this->ionAuth = new \IonAuth\Libraries\IonAuth();
		$this->data['user'] = $this->ionAuth->user()->row();
	}

}

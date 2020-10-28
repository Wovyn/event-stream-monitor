<?php
namespace App\Controllers;

class Migrate extends \CodeIgniter\Controller {

    protected $migrate;
    protected $seeder;

    public function __construct()  {
        $this->migrate = \Config\Services::migrations();
        $this->seeder = \Config\Database::seeder();
    }

    public function index() {
        try {
          $this->migrate->setNamespace('App')->latest();
        } catch (\Exception $e) {
            echo $e;
        }
    }

    public function rollback($batch) {
        try {
          $this->migrate->setNamespace('App')->regress($batch);
        } catch (\Exception $e) {
            echo $e;
        }
    }

    public function IonAuth() {
        try {
          $this->migrate->setNamespace('IonAuth')->latest();
          $this->seeder->call('IonAuth\Database\Seeds\IonAuthSeeder');

        } catch (\Exception $e) {
            echo $e;
        }
    }
}

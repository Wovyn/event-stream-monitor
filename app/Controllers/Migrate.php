<?php
namespace App\Controllers;

class Migrate extends \CodeIgniter\Controller {

    protected $migrate,
        $seeder,
        $db;

    public function __construct()  {
        $this->migrate = \Config\Services::migrations();
        $this->seeder = \Config\Database::seeder();
        $this->db = \Config\Database::connect();
    }

    public function index() {
        try {
            $this->migrate->setNamespace('App')->latest();
            echo 'Successfully migrated latest migration from App.';
        } catch (\Exception $e) {
            echo $e;
        }
    }

    public function rollback($batch) {
        try {
            $this->migrate->setNamespace('App')->regress($batch);
            echo 'Successfully rolled back to migration batch: ' . $batch . '.';
        } catch (\Exception $e) {
            echo $e;
        }
    }

    public function IonAuth() {
        try {
            $this->migrate->setNamespace('IonAuth')->latest();
            $this->seeder->call('IonAuth\Database\Seeds\IonAuthSeeder');
            echo 'Successfully migrated IonAuth migrations.';
        } catch (\Exception $e) {
            echo $e;
        }
    }

    public function check() {
        $this->migrate->setNamespace(null);

        $result = [];
        foreach ($this->migrate->findMigrations() as $migration) {
            if($this->db->tableExists('migrations')) {
                $check_migration = $this->db->table('migrations')->getWhere(['version' => $migration->version, 'class' => $migration->class]);
                if(!count($check_migration->getResult())) {
                    $result[] = [
                        'version' => $migration->version,
                        'name' => $migration->name,
                        'result' => $this->do_migrate($migration->path, $migration->namespace),
                    ];
                }
            } else {
                $result[] = [
                    'version' => $migration->version,
                    'name' => $migration->name,
                    'result' => $this->do_migrate($migration->path, $migration->namespace)
                ];

                if($migration->name == 'install_ion_auth') {
                    $this->seeder->call('IonAuth\Database\Seeds\IonAuthSeeder');
                }
            }
        }

        return $this->response->setJSON(json_encode($result));
    }

    public function do_migrate($path, $namespace) {
        $result = [];

        try {
            $result['success'] = $this->migrate->force($path, $namespace);
        } catch (\Exception $e) {
            $result['success'] = false;
            $result['error_message'] = $e->getMessage();
        }

        return $result;
    }
}

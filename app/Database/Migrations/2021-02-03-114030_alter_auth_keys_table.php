<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterAuthKeysTable01 extends Migration
{
    public function up()
    {
        $fields = [
            'created_at' => [
                'type' => 'TIMESTAMP',
                'after' => 'aws_secret'
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'after' => 'created_at'
            ]
        ];

        $this->forge->addColumn('auth_keys', $fields);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropColumn('auth_keys', ['created_at', 'updated_at']);
    }
}

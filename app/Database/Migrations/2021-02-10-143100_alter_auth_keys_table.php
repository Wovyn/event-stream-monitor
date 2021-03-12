<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterAuthKeysTable03 extends Migration
{
    public function up()
    {
        $fields = [
            'aws_account' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'after' => 'external_id'
            ]
        ];

        $this->forge->addColumn('auth_keys', $fields);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropColumn('auth_keys', ['aws_account']);
    }
}

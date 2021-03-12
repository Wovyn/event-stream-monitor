<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterAuthKeysTable02 extends Migration
{
    public function up()
    {
        $fields = [
            'event_stream_role_arn' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'after' => 'aws_secret'
            ],
            'external_id' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'after' => 'event_stream_role_arn'
            ]
        ];

        $this->forge->addColumn('auth_keys', $fields);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropColumn('auth_keys', ['event_stream_role_arn', 'external_id']);
    }
}

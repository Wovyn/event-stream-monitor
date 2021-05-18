<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterAuthKeysTable04 extends Migration
{
    public function up()
    {
        $fields = [
            's3_firehose_role_arn' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'after' => 'event_stream_role_arn'
            ]
        ];

        $this->forge->addColumn('auth_keys', $fields);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropColumn('auth_keys', ['s3_firehose_role_arn']);
    }
}

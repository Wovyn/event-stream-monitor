<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EventstreamSinksTable extends Migration
{
    public function up()
    {
        $fields = [
            'id' => [
                'type' => 'MEDIUMINT',
                'constraint' => '11',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'user_id' => [
                'type' => 'MEDIUMINT',
                'constraint' => '8',
                'unsigned' => true,
            ],
            'description' => [
                'type' => 'TEXT'
            ],
            'status' => [
                'type' => 'TEXT' // "ENUM('initialized', 'validating', 'active', 'failed')"
            ],
            'sink_type' => [
                'type' => 'TEXT' // "ENUM('kinesis', 'webhook')"
            ],
            'sid' => [
                'type' => 'VARCHAR',
                'constraint' => '50'
            ],
            'created_at' => [
                'type' => 'TIMESTAMP'
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP'
            ]
        ];

        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('user_id','users','id','NO ACTION','CASCADE');
        $this->forge->createTable('eventstream_sinks');
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropTable('eventstream_sinks', TRUE);
    }
}

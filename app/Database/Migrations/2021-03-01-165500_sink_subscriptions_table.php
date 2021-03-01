<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SinkSubscriptionsTable extends Migration
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
            'sink_id' => [
                'type' => 'MEDIUMINT',
                'constraint' => '11',
                'unsigned' => true,
            ],
            'subscription_sid' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => FALSE
            ],
            'subscriptions' => [
                'type' => 'TEXT'
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
        $this->forge->addForeignKey('sink_id','eventstream_sinks','id','NO ACTION','CASCADE');
        $this->forge->createTable('sink_subscriptions');
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropTable('sink_subscriptions', TRUE);
    }
}

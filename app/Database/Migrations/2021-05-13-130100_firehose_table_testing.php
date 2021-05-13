<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FirehoseTable extends Migration
{
    public function up()
    {
        if($this->db->tableExists('firehose')) {
            $this->forge->dropTable('firehose', TRUE);
        }

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
            'region' => [
                'type' => 'VARCHAR',
                'constraint'  => '20'
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => TRUE,
            ],
            'kinesis_id' => [
                'type' => 'MEDIUMINT',
                'constraint' => '11',
                'unsigned' => true,
            ],
            'elasticsearch_id' => [
                'type' => 'MEDIUMINT',
                'constraint' => '11',
                'unsigned' => true,
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
        $this->forge->addForeignKey('kinesis_id','kinesis_data_streams','id','NO ACTION','CASCADE');
        $this->forge->addForeignKey('elasticsearch_id','elasticsearch','id','NO ACTION','CASCADE');
        $this->forge->createTable('firehose');
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropTable('firehose', TRUE);
    }
}

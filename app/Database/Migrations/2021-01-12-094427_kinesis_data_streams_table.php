<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KinesisDataStreamsTable extends Migration
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
            'region' => [
                'type' => 'VARCHAR',
                'constraint'  => '20'
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => TRUE,
            ],
            'shards' => [
                'type' => 'SMALLINT',
                'constraint' => '8',
                'null' => TRUE,
            ],
            'create_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'last_update TIMESTAMP NULL' // 'ON UPDATE CURRENT_TIMESTAMP' causes problem when creating the table on sqlite3
        ];

        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('user_id','users','id','NO ACTION','CASCADE');
        $this->forge->createTable('kinesis_data_streams');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('kinesis_data_streams', TRUE);
	}
}

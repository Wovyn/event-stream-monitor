<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterKinesisTable extends Migration
{
	public function up()
	{
        $this->forge->dropColumn('kinesis_data_streams', ['create_date', 'last_update']);

		$fields = [
            'created_at' => [
                'type' => 'TIMESTAMP',
                'after' => 'shards'
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'after' => 'created_at'
            ]
        ];

        $this->forge->addColumn('kinesis_data_streams', $fields);
	}

	//--------------------------------------------------------------------

	public function down()
	{
        $this->forge->dropColumn('kinesis_data_streams', ['created_at', 'updated_at']);

		$fields = [
            'create_date' => [
                'type' => 'TIMESTAMP',
                'null' => false,
                'default' => 'CURRENT_TIMESTAMP',
                'default_string' => false,
                'after' => 'shards'
            ],
            'last_update' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                'after' => 'create_date'
            ]
        ];

        $this->forge->addColumn('kinesis_data_streams', $fields);
	}
}

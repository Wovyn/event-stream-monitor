<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AuthKeysTable extends Migration
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
            'twilio_sid' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => FALSE
            ],
            'twilio_secret' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => FALSE
            ],
            'aws_access' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => FALSE
            ],
            'aws_secret' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => FALSE
            ]
            // 'create_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
            // 'last_update TIMESTAMP NULL on update CURRENT_TIMESTAMP'
        ];

        $this->forge->addField($fields);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('user_id','users','id','NO ACTION','CASCADE');
        $this->forge->createTable('auth_keys');
    }

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('auth_keys', TRUE);
	}
}

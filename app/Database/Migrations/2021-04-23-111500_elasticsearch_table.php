<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ElasticsearchTable extends Migration
{
    public function up()
    {
        if($this->db->tableExists('elasticsearch')) {
            $this->forge->dropTable('elasticsearch', TRUE);
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
            'domain_name' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
            ],
            'status' => [
                'type' => 'TEXT'
            ],
            'settings' => [
                'type' => 'TEXT',
                'null' => TRUE
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
        $this->forge->createTable('elasticsearch');
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropTable('elasticsearch', TRUE);
    }
}

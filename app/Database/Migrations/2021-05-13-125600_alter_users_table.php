<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterUsersTable01 extends Migration
{
    public function up()
    {
        $fields = [
            'last_news_update' => [
                'type' => 'TEXT'
            ]
        ];

        $this->forge->addColumn('users', $fields);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropColumn('users', ['last_news_update']);
    }
}

<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterEventstreamSinksTable01 extends Migration
{
    public function up()
    {
        $fields = [
            'config' => [
                'type' => 'TEXT'
            ]
        ];

        $this->forge->addColumn('eventstream_sinks', $fields);

        // update sinks with new config fields
        $eventstreamSinksModel = new \App\Models\EventstreamSinksModel();
        $authKeysModel = new \App\Models\AuthKeysModel();

        // get all sinks
        $sinks = $eventstreamSinksModel->findAll();
        foreach ($sinks as $sink) {
            // get user keys
            $keys = $authKeysModel->where('user_id', $sink->user_id)->first();

            $twilio = new \App\Libraries\Twilio(
                $keys->twilio_sid,
                $keys->twilio_secret
            );

            // fetch sink
            $fetchSink = $twilio->FetchSink($sink->sid);

            // generate config data
            $config = [
                'sink_configuration' => $fetchSink['response']->sinkConfiguration,
                'extra' => [
                    'webhook_data_view_url' => null
                ]
            ];

            // update sink config field
            $eventstreamSinksModel
                ->update($sink->id, [
                    'config' => json_encode($config)
                ]);
        }
    }

    //--------------------------------------------------------------------

    public function down()
    {
        $this->forge->dropColumn('eventstream_sinks', ['config']);
    }
}

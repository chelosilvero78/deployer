<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateNotificationChannels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('channels', 'slack');

        Schema::create('channels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('type');
            $table->text('config');
            $table->unsignedInteger('project_id');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('project_id')->references('id')->on('projects');
        });

        DB::table('notify_emails')->orderBy('id')->chunk(100, function ($rows) {
            $channels = [];
            foreach ($rows as $row) {
                $channels[] = $this->channelData($row, ['email' => $row->email], 'mail');
            }

            DB::table('channels')->insert($channels);
        });

        // FIXME: failure_only

        DB::table('slack')->orderBy('id')->chunk(100, function ($rows) {
            $channels = [];
            foreach ($rows as $row) {
                $channels[] = $this->channelData($row, [
                    'webhook' => $row->webhook,
                    'channel' => $row->channel,
                    'icon'    => empty($row->icon) ? null : $row->icon
                ], 'slack');
            }

            DB::table('channels')->insert($channels);
        });

        Schema::drop('slack');
        Schema::drop('notify_emails');
    }

    private function channelData(stdClass $row, array $config, $type)
    {
        return [
            'project_id' => $row->project_id,
            'type'       => $type,
            'name'       => $row->name,
            'config'     => json_encode($config),
            'created_at' => $row->created_at,
            'deleted_at' => $row->deleted_at,
            'updated_at' => $row->updated_at,
        ];
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

<?php

use Illuminate\Database\Seeder;
use REBELinBLUE\Deployer\Channel;

class NotificationTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('channels')->delete();

        Channel::create([
            'project_id' => 1,
            'type'       => 'slack',
            'name'       => 'Deployer',
            'config'     => json_encode([
                'channel' => '#testing',
                'icon'    => ':ghost:',
                'webhook' => 'https://hooks.slack.com/services/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',
            ])
        ]);
    }
}

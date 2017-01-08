<?php

use Illuminate\Database\Seeder;
use REBELinBLUE\Deployer\Channel;

class ChannelTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('channels')->delete();

        Channel::create([
            'project_id' => 1,
            'type'       => 'slack',
            'name'       => 'Deployer',
            'config'     => [
                'channel' => '#testing',
                'icon'    => ':ghost:',
                'webhook' => 'https://hooks.slack.com/services/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',
            ]
        ]);

        Channel::create([
            'project_id' => 1,
            'type'       => 'mail',
            'name'       => 'Deployer',
            'config'     => [
                'email' => 'admin@example.com',
            ]
        ]);

        Channel::create([
            'project_id' => 1,
            'type'       => 'webhook',
            'name'       => 'Deployer',
            'config'     => [
                'url' => 'http://requestb.in/19kiuuc1',
            ]
        ]);
    }
}

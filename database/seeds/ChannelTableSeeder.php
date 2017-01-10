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
            'name'       => 'All staff',
            'config'     => [
                'channel' => '#testing',
                'icon'    => ':ghost:',
                'webhook' => 'https://hooks.slack.com/services/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',
            ],
            'on_deployment_success'  => true,
            'on_deployment_failure'  => true,
            'on_link_down'           => true,
            'on_link_recovered'      => true,
            'on_heartbeat_missing'   => true,
            'on_heartbeat_recovered' => true,
        ]);

        Channel::create([
            'project_id' => 1,
            'type'       => 'mail',
            'name'       => 'Operations',
            'config'     => [
                'email' => 'admin@example.com',
            ],
            'on_deployment_success' => true,
            'on_deployment_failure' => true,
        ]);

        Channel::create([
            'project_id' => 1,
            'type'       => 'webhook',
            'name'       => 'Webhook',
            'config'     => [
                'url' => 'http://requestb.in/19kiuuc1',
            ],
            'on_deployment_success' => true,
        ]);

        Channel::create([
            'project_id' => 1,
            'type'       => 'hipchat',
            'name'       => 'Support',
            'config'     => [
                'url' => '#',
            ],
            'on_link_down'           => true,
            'on_link_recovered'      => true,
        ]);

        Channel::create([
            'project_id' => 1,
            'type'       => 'twilio',
            'name'       => 'SMS alerts',
            'config'     => [
                'url' => '#',
            ],
            'on_deployment_failure'  => true,
            'on_link_down'           => true,
            'on_heartbeat_missing'   => true,
        ]);
    }
}
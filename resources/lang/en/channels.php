<?php

return [

    'label'                  => 'Notifications',
    'create'                 => 'Add a new notification',
    'edit'                   => 'Edit the notification',
    'none'                   => 'The project does not currently have any notifications setup',
    'name'                   => 'Name',
    'type'                   => 'Type',
    'warning'                => 'The notification could not be saved, please check the form below.',
    'triggers'               => 'Triggers',
    'on_deployment_success'  => 'Deployment Succeeded',
    'on_deployment_failure'  => 'Deployment Failed',
    'on_link_down'           => 'URL Failed',
    'on_link_recovered'      => 'URL Recovered',
    'on_heartbeat_missing'   => 'Heartbeat Missing',
    'on_heartbeat_recovered' => 'Heartbeat Recovered',

    // Types
    'custom'                 => 'Custom',
    'slack'                  => 'Slack',
    'hipchat'                => 'Hipchat',
    'twilio'                 => 'SMS',
    'mail'                   => 'E-mail',

    'which'                  => 'Which type of notification do you wish to add?',

    // Slack
    'icon'                  => 'Icon',
    'bot'                   => 'Bot',
    'icon_info'             => 'Either an emoji, for example :ghost: or the URL to an image',
    'webhook'               => 'Webhook URL',
    'channel'               => 'Channel',

];

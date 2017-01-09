<?php

return [

    // Slack
    'test_message'        => 'This is a test to ensure the notification is setup correctly, if you ' .
                             'can see this it means it is! :+1:',
    'success_message'     => 'Deployment %s successful! :smile:',
    'failed_message'      => 'Deployment %s failed! :cry:',

    // Deployment success email
    'deployment_done'    => 'Deployment Finished',
    'deployment_header'  => 'The deployment has finished.',
    'project_name'       => 'Project name',
    'deployed_branch'    => 'Deployed branch',
    'deployment_details' => 'View the Deployment',
    'started_at'         => 'Started at',
    'finished_at'        => 'Finished at',
    'last_committer'     => 'Last committer',
    'last_commit'        => 'Last commit',
    'reason'             => 'Deployment reason - :reason',

    // TODO cleanup - Used by slack success currently
    'branch'              => 'Branch',
    'project'             => 'Project',
    'commit'              => 'Commit',
    'committer'           => 'Committer',
];

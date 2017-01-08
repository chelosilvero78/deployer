<?php

namespace REBELinBLUE\Deployer\Jobs;

use REBELinBLUE\Deployer\Deployment;
use REBELinBLUE\Deployer\Notifications\DeploymentSucceeded;
use REBELinBLUE\Deployer\NotifyEmail;
use REBELinBLUE\Deployer\Project;

/**
 * Send email notifications for deployment.
 * @deprecated
 */
class MailDeployNotification extends Job
{
    /**
     * @var Project
     */
    private $project;

    /**
     * @var Deployment
     */
    private $deployment;

    /**
     * MailDeployNotification constructor.
     *
     * @param Project    $project
     * @param Deployment $deployment
     */
    public function __construct(Project $project, Deployment $deployment)
    {
        $this->project    = $project;
        $this->deployment = $deployment;
    }

    /**
     * Execute the command.
     */
    public function handle()
    {
        $this->project->notifyEmails->each(function (NotifyEmail $email) {
            $email->notify(new DeploymentSucceeded($this->project, $this->deployment));
        });
    }
}

<?php

namespace REBELinBLUE\Deployer\Listeners\Events;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Queue\InteractsWithQueue;
use REBELinBLUE\Deployer\Events\DeploymentFinished;
use REBELinBLUE\Deployer\Notifications\DeploymentFailed;
use REBELinBLUE\Deployer\Notifications\DeploymentSucceeded;

/**
 * When a deploy finished, notify the followed user.
 */
class SendDeploymentNotifications extends Event implements ShouldQueue
{
    use InteractsWithQueue, DispatchesJobs;

    /**
     * Handle the event.
     *
     * @param DeploymentFinished $event
     */
    public function handle(DeploymentFinished $event)
    {
        $project    = $event->deployment->project;
        $deployment = $event->deployment;

        if ($deployment->isAborted()) {
            return;
        }

        $notification = $deployment->isSuccessful() ? DeploymentSucceeded::class : DeploymentFailed::class;

        foreach ($project->channels as $channel) {
            $channel->notify(new $notification($project, $deployment));
        }
    }
}

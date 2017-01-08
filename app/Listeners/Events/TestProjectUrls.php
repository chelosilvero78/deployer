<?php

namespace REBELinBLUE\Deployer\Listeners\Events;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Queue\InteractsWithQueue;
use REBELinBLUE\Deployer\Events\DeploymentFinished;
use REBELinBLUE\Deployer\Jobs\RequestProjectCheckUrl;

/**
 * When a deploy finished, notify the followed user.
 */
class TestProjectUrls extends Event implements ShouldQueue
{
    use InteractsWithQueue, DispatchesJobs;

    /**
     * Handle the event.
     *
     * @param DeploymentFinished $event
     * @dispatches RequestProjectCheckUrl
     */
    public function handle(DeploymentFinished $event)
    {
        $project    = $event->deployment->project;
        $deployment = $event->deployment;

        if ($deployment->isAborted()) {
            return;
        }

        // Trigger to check the project urls
        $this->dispatch(new RequestProjectCheckUrl($project->checkUrls));
    }
}

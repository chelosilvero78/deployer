<?php

namespace REBELinBLUE\Deployer\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use REBELinBLUE\Deployer\Events\DeploymentFinished;
use REBELinBLUE\Deployer\Events\EmailChangeRequested;
use REBELinBLUE\Deployer\Events\HeartbeatMissed;
use REBELinBLUE\Deployer\Events\HeartbeatRecovered;
use REBELinBLUE\Deployer\Events\JsonWebTokenExpired;
use REBELinBLUE\Deployer\Events\UserWasCreated;
use REBELinBLUE\Deployer\Listeners\Events\ClearJwt;
use REBELinBLUE\Deployer\Listeners\Events\CreateJwt;
use REBELinBLUE\Deployer\Listeners\Events\EmailChangeConfirmation;
use REBELinBLUE\Deployer\Listeners\Events\SendDeploymentNotifications;
use REBELinBLUE\Deployer\Listeners\Events\NotifyHeartbeat;
use REBELinBLUE\Deployer\Listeners\Events\SendSignupEmail;
use REBELinBLUE\Deployer\Listeners\Events\TestProjectUrls;

/**
 * The event service provider.
 */
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        UserWasCreated::class       => [SendSignupEmail::class],
        DeploymentFinished::class   => [SendDeploymentNotifications::class, TestProjectUrls::class],
        // HeartbeatMissed::class      => [NotifyHeartbeat::class], // FIXME
        // HeartbeatRecovered::class   => [NotifyHeartbeat::class],
        EmailChangeRequested::class => [EmailChangeConfirmation::class],
        JsonWebTokenExpired::class  => [CreateJwt::class],
        Login::class                => [CreateJwt::class],
        Logout::class               => [ClearJwt::class],
    ];

    /**
     * Register any other events for your application.
     */
    public function boot()
    {
        parent::boot();
    }
}

<?php

namespace REBELinBLUE\Deployer\Listeners\Events;

use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Session;

/**
 * Event listener class to remove the JWT on logout.
 */
class ClearJwt extends Event
{
    /**
     * Handle the event.
     *
     * @param Logout $event
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function handle(Logout $event)
    {
        Session::forget('jwt');
    }
}

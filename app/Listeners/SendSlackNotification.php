<?php

namespace App\Listeners;

use App\Services\Fetcher;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendSlackNotification
{
    /**
     * @var Fetcher
     */
    private $fetcher;

    /**
     * Create the event listener.
     *
     * @param Fetcher $fetcher
     */
    public function __construct(Fetcher $fetcher)
    {
        $this->fetcher = $fetcher;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        try {
            $this->fetcher->phid($event->phid)->sendSlackNotification();
        } catch (\Exception $e) {}
    }
}

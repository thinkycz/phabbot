<?php

namespace App\Abstracts;

use App\Notifications\PhabricatorFeedUpdated;
use App\Services\Fetcher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable as IsNotifiable;
use Illuminate\Support\Facades\Notification;

abstract class Notifiable extends Model
{
    use IsNotifiable;

    protected $appends = ['lastStory'];

    public function getLastStoryAttribute()
    {
        return app(Fetcher::class)->story($this->phid);
    }

    public function sendSlackNotification()
    {
        Notification::route('slack', config('services.slack.webhook'))->notify(new PhabricatorFeedUpdated($this));
    }
}
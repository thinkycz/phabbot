<?php

namespace App\Notifications;

use App\Abstracts\Notifiable;
use Illuminate\Notifications\Messages\SlackAttachment;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class PhabricatorFeedUpdated extends Notification
{
    /**
     * @var Notifiable
     */
    private $notifiable;

    /**
     * Create a new notification instance.
     *
     * @param Notifiable $notifiable
     */
    public function __construct(Notifiable $notifiable)
    {
        $this->notifiable = $notifiable;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via()
    {
        return ['slack'];
    }

    /**
     * Get the Slack representation of the notification.
     *
     * @return SlackMessage
     */
    public function toSlack()
    {
        return (new SlackMessage)
            ->success()
            ->content($this->notifiable->lastStory->text)
            ->attachment(function (SlackAttachment $attachment) {
                $attachment
                    ->timestamp($this->notifiable->lastStory->epoch)
                    ->action('Open on Phabricator', $this->notifiable->uri)
                    ->fields([
                        'Type' => $this->notifiable->typeName,
                        'ID'   => $this->notifiable->phid,
                    ]);
            });
    }
}

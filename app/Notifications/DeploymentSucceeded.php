<?php

namespace REBELinBLUE\Deployer\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;
use NotificationChannels\Webhook\WebhookChannel;
use NotificationChannels\Webhook\WebhookMessage;
use REBELinBLUE\Deployer\Channel;
use REBELinBLUE\Deployer\Deployment;
use REBELinBLUE\Deployer\Project;

/**
 * Notification which is sent when a deployment succeeds.
 */
class DeploymentSucceeded extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var Project
     */
    private $project;

    /**
     * @var Deployment
     */
    private $deployment;

    /**
     * Create a new notification instance.
     */
    public function __construct(Project $project, Deployment $deployment)
    {
        $this->project    = $project;
        $this->deployment = $deployment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  Channel $notification
     * @return array
     */
    public function via(Channel $notification)
    {
        if ($notification->type === Channel::WEBHOOK) {
            return [WebhookChannel::class];
        }

        return [$notification->type];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  Channel     $notification
     * @return MailMessage
     */
    public function toMail(Channel $notification)
    {
        $table = [
            Lang::get('emails.project_name')    => $this->project->name,
            Lang::get('emails.deployed_branch') => $this->deployment->branch,
            Lang::get('emails.started_at')      => $this->deployment->started_at,
            Lang::get('emails.finished_at')     => $this->deployment->finished_at,
            Lang::get('emails.last_committer')  => $this->deployment->committer,
            Lang::get('emails.last_commit')     => $this->deployment->short_commit,
        ];

        $email = (new MailMessage)
            ->view(['notifications.email', 'notifications.email-plain'], [
                'name'  => $notification->name,
                'table' => $table,
            ])
            ->to($notification->config->email)
            ->subject(Lang::get('emails.deployment_done'))
            ->line(Lang::get('emails.deployment_header'))
            ->action(Lang::get('emails.deployment_details'), route('deployments', ['id' => $this->deployment->id]));

        if (!empty($this->deployment->reason)) {
            $email->line(Lang::get('emails.reason', ['reason' => $this->deployment->reason]));
        }

        return $email;
    }

    /**
     * Get the slack version of the notification.
     *
     * @param  Channel      $notification
     * @return SlackMessage
     */
    public function toSlack(Channel $notification)
    {
        return (new SlackMessage)
                ->success()
                ->to($notification->config->channel)
                ->content(Lang::get('notifications.success_message'));
    }

    /**
     * Get the webhook version of the notification.
     *
     * @param  Channel        $notification
     * @return WebhookMessage
     */
    public function toWebhook(Channel $notification)
    {
        return (new WebhookMessage)
            ->data([
                'payload' => [
                    'webhook' => 'data',
                ],
            ])
            ->userAgent('Custom-User-Agent')
            ->header('X-Custom', 'Custom-Header');
    }
}
//
//[channel] => #testing
//   [icon] => :ghost:
//   [webhook] => https://hooks.slack.com/services/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

//->attachment(function ($attachment) use ($url) {
//    $attachment->title('Invoice 1322', $url)
//        ->fields([
//            'Title' => 'Server Expenses',
//            'Amount' => '$1,234',
//            'Via' => 'American Express',
//            'Was Overdue' => ':-1:',
//        ]);
//});

/*
     * Generates a slack payload for the deployment.
     *
     * @return array
     * @deprecated
public function notificationPayload()
{
    $colour  = 'good';
    $message = Lang::get('notifications.success_message');

    if ($this->status === self::FAILED) {
        $colour  = 'danger';
        $message = Lang::get('notifications.failed_message');
    }

    $payload = [
        'attachments' => [
            [
                'fallback' => sprintf($message, '#' . $this->id),
                'text'     => sprintf($message, sprintf(
                    '<%s|#%u>',
                    route('deployments', ['id' => $this->id]),
                    $this->id
                )),
                'color'    => $colour,
                'fields'   => [
                    [
                        'title' => Lang::get('notifications.project'),
                        'value' => sprintf(
                            '<%s|%s>',
                            route('projects', ['id' => $this->project_id]),
                            $this->project->name
                        ),
                        'short' => true,
                    ], [
                        'title' => Lang::get('notifications.commit'),
                        'value' => $this->commit_url ? sprintf(
                            '<%s|%s>',
                            $this->commit_url,
                            $this->short_commit
                        ) : $this->short_commit,
                        'short' => true,
                    ], [
                        'title' => Lang::get('notifications.committer'),
                        'value' => $this->committer,
                        'short' => true,
                    ], [
                        'title' => Lang::get('notifications.branch'),
                        'value' => $this->project->branch,
                        'short' => true,
                    ],
                ],
                'footer' => Lang::get('app.name'),
                'ts'     => time(),
            ],
        ],
    ];

    return $payload;
}


 *         $payload = [
            'channel' => $this->notification->channel,
        ];

        if (!empty($this->notification->icon)) {
            $icon_field = 'icon_url';
            if (preg_match('/:(.*):/', $this->notification->icon)) {
                $icon_field = 'icon_emoji';
            }

            $payload[$icon_field] = $this->notification->icon;
        }

        $payload = array_merge($payload, $this->payload);

        if (isset($payload['attachments'])) {
            $expire_at = Carbon::createFromTimestamp($payload['attachments'][0]['ts'])->addMinutes($this->timeout);

            if (Carbon::now()->gt($expire_at)) {
                return;
            }
        }

        // FIXME: Rebuild to use guzzle
        Request::post($this->notification->webhook)
               ->sendsJson()
               ->body($payload)
               ->send();
 */

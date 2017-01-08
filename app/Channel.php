<?php

namespace REBELinBLUE\Deployer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use REBELinBLUE\Deployer\Traits\BroadcastChanges;

/**
 * Notification channel.
 */
class Channel extends Model
{
    use SoftDeletes, BroadcastChanges, Notifiable;

    const EMAIL = 'mail';
    const SLACK = 'slack';
    const HIPCHAT = 'hipchat';
    const WEBHOOK = 'webhook';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'project_id', 'type', 'config'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'         => 'integer',
        'project_id' => 'integer',
        'config'     => 'object',
    ];

    /**
     * Belongs to relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Returns the email address to send the notification to.
     *
     * @return string|null
     */
    public function routeNotificationForMail()
    {
        if ($this->type === self::EMAIL) {
            return $this->config->email;
        }

        return null;
    }

    /**
     * Returns the URL for the slack webhook.
     *
     * @return string|null
     */
    public function routeNotificationForSlack()
    {
        if ($this->type === self::SLACK) {
            return $this->config->webhook;
        }

        return null;
    }

    /**
     * Returns the URL for the custom webhook.
     *
     * @return string|null
     */
    public function routeNotificationForWebhook()
    {
        if ($this->type === self::WEBHOOK) {
            return $this->config->url;
        }

        return null;
    }
}

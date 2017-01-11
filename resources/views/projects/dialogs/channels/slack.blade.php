<div class="channel-config" id="channel-config-slack">
    <div class="form-group">
        <label for="notification_slack_icon">{{ Lang::get('channels.icon') }}</label>
        <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="right" title="{{ Lang::get('channels.icon_info') }}"></i>
        <input type="text" class="form-control" id="notification_config_icon" name="icon" placeholder=":ghost:" />
    </div>
    <div class="form-group">
        <label for="notification_slack_channel">{{ Lang::get('channels.channel') }}</label>
        <input type="text" class="form-control" id="notification_config_channel" name="channel" placeholder="#slack" />
    </div>
    <div class="form-group">
        <label for="notification_slack_webhook">{{ Lang::get('channels.webhook') }}</label>
        <input type="text" class="form-control" id="notification_config_webhook" name="webhook" placeholder="https://hooks.slack.com/services/" />
    </div>
</div>

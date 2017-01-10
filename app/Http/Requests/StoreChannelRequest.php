<?php

namespace REBELinBLUE\Deployer\Http\Requests;

/**
 * Request for validating channels.
 */
class StoreChannelRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];

        // Check if there are specific validation rules for the selected type
        $type = $this->get('type') . 'Rules';
        if (method_exists($this, $type)) {
            $rules = $this->{$type}();
        }

        return array_merge([
            'name'                   => 'required|max:255',
            'project_id'             => 'required|integer|exists:projects,id',
            'type'                   => 'required|in:slack,hipchat,twilio,mail,custom',
            'on_deployment_success'  => 'boolean',
            'on_deployment_failure'  => 'boolean',
            'on_link_down'           => 'boolean',
            'on_link_recovered'      => 'boolean',
            'on_heartbeat_missing'   => 'boolean',
            'on_heartbeat_recovered' => 'boolean',
        ], $rules);
    }

    /**
     * Validation rules specific to slack.
     *
     * @return array
     */
    private function slackRules()
    {
        // FIXME: May be able to convert these to just properties?
        return [
            'channel' => 'required|max:255|channel',
            'webhook' => 'required|regex:/^https:\/\/hooks.slack.com\/services\/[a-z0-9]+\/[a-z0-9]+\/[a-z0-9]+$/i',
        ]; // FIXME: Add icon
    }

    /**
     * Validation rules specific to email.
     *
     * @return array
     */
    private function emailRules()
    {
        return [
            'email' => 'required|email',
        ];
    }

    /**
     * Validation rules specific to hipchat.
     *
     * @return array
     */
    private function hipchatRules()
    {
        return [

        ];
    }

    /**
     * Validation rules specific to twilio.
     *
     * @return array
     */
    private function twilioRules()
    {
        return [
            'number' => 'required', // FIXME: REGULAR EXPRESSION
        ];
    }

    /**
     * Validation rules specific to custom channels.
     *
     * @return array
     */
    private function customRules()
    {
        return [
            'webhook' => 'required|active_url',
        ];
    }
}

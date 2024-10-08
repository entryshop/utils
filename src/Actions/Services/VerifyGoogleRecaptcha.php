<?php

namespace Entryshop\Utils\Actions\Services;

use Entryshop\Utils\Actions\AsAction;
use Http;

class VerifyGoogleRecaptcha
{
    use AsAction;

    protected $url;
    protected $keys;
    protected $api_key;
    protected $project_id;

    public function __construct()
    {
        $this->url        = config('services.google.recaptcha.verify_url');
        $this->api_key    = config('services.google.recaptcha.api_key');
        $this->project_id = config('services.google.recaptcha.project_id');
        $this->keys       = [
            'ios'     => config('services.google.recaptcha.ios'),
            'android' => config('services.google.recaptcha.android'),
            'site'    => config('services.google.recaptcha.site'),
        ];
    }

    /**
     * Verify recaptcha
     *
     * @param  string  $token
     * @param  string  $action  user action, like send_otp
     * @param  string  $platform  can be ios, android or web
     * @return boolean
     */
    public function handle($token, $action = '', $platform = 'site'): bool
    {
        $url = $this->url . $this->project_id . "/assessments?key=" . $this->api_key;

        $payload = [
            "event" => [
                "token"          => $token,
                "siteKey"        => $this->keys[$platform],
                "expectedAction" => $action,
            ],
        ];

        $response = Http::asJson()->post($url, $payload)->json();

        if (empty($response['riskAnalysis'])) {
            return false;
        }

        if ($response['riskAnalysis']['score'] >= config('services.google.recaptcha.score_threshold') && $response['tokenProperties']['valid'] && $response['tokenProperties']['action'] === $action) {
            return true;
        }

        return false;
    }

}

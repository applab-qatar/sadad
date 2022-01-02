<?php


namespace Applab\Sadad\Api;

use Applab\Sadad\Utilities\PayConfig;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;
class Authentication extends PayConfig
{
    //authenticate the app api user for all requests
    public function login()
    {
        try {
            $body = [
                'sadadId' => $this->merchant_id,
                'secretKey' => $this->secret_key,
                'domain' => $this->domain
            ];
            $response = $this->client->request('POST', 'userbusinesses/login', [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode($body)
            ]);
            if ($response->getStatusCode() == 200) {
                $response = json_decode($response->getBody());
                if ($response->accessToken) {
                    Cache::put('sadad-access-token', $response->accessToken, 900);
                    return true;
                }
            }
            throw new \Exception("SADAD Access Token generation failed");
        } catch (GuzzleException $e) {
            \Log::critical("SADAD Authentication Failure " . $e->getMessage());
            throw $e;
        }
    }
}

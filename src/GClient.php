<?php


namespace Applab\Sadad;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class GClient extends Client
{
    protected $client;
    public function __construct()
    {
        $this->client=new Client([
            'base_uri'=>config('sadad-config.api-url');
        ]);
        return $this->client;
    }
}

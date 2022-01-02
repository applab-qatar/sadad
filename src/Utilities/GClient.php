<?php


namespace Applab\Sadad\Utilities;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class GClient extends Client
{
    public $client;
    public function __construct()
    {
        $this->client=new Client([
            'base_uri'=>$this->api_url
        ]);
        return $this->client;
    }
}

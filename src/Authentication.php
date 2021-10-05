<?php


namespace Applab\Sadad;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;

class Authentication extends GClient
{
    //authenticate the app api user for all requests
    public function login()
    {
        try{
            if(config('applab-sadad.client-id')!='' && config('applab-sadad.client-secret')!='') {
                $body = [
                        'sadadId' => config('applab-sadad.client-id'),
                        'secretKey' => config('applab-sadad.client-secret'),
                        'domain' => config('applab-sadad.reg-domain')];
                $response = $this->client->request('POST', 'userbusinesses/login',[
                    'headers' => [
                        'Content-Type'=>'application/json',
                    ],
                    'body' => json_encode($body)
                ]);
                if($response->getStatusCode()==200){
                    $response=json_decode($response->getBody());
                    if($response->accessToken){
                        Cache::put('sadad-access-token',$response->accessToken,900);
                        return true;
                    }
                }
                throw new \Exception("SADAD Access Token generation failed");
            }else{
                throw new \Exception('SADAD Invalid input!, Ensure configuration values are correct');
            }
        }catch(GuzzleException $e){
            \Log::critical("SADAD Authentication Failure ".$e->getMessage());
            throw $e;
        }
    }
}

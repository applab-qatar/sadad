<?php


namespace Applab\Sadad\Api;

use Applab\Sadad\ApiAuthentication;
use Applab\Sadad\Utilities\PayConfig;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Exception;
class Transaction extends PayConfig
{
    /*
     */
    public function __construct()
    {
        if(!Cache::has('sadad-access-token') || empty(Cache::get('sadad-access-token'))){
            $this->authClass=new Authentication();
            $this->authClass->login();
        }
        parent::__construct();
    }
    public function single($transNo)
    {
        try {
            $response = $this->client->request('GET', 'transactions/getTransaction', [
                'headers' => [
                    'Authorization' =>  Cache::get('sadad-access-token'),
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],'form_params' => ['transactionno'=>$transNo]
            ]);
            if ($response->getStatusCode()==200) {
                return $response->getBody();
            }
            throw new \Exception("Transaction details failed");
        } catch (GuzzleException $e) {
            throw $e;
        }
    }
    public function list($filter=[])
    {
        try {
            $query='';
            if(!empty($filter)){
                $validated=Validator::make($filter, [
                    'skip'    => 'number',
                    'limit'    => 'number',
                    'cellnumber'    => 'number',
//                'start_date'    => 'required|before:end|date_format:Y-m-d H:i:s',
//                'end_date'    => 'required|after:start|date_format:Y-m-d H:i:s',
                ]);
                if($validated->fails()){
                    \Log::error("Sadad ListTransaction::Validation ".$validated->getMessageBag());
                    throw new Exception("Invalid input!, Ensure input(s) are correct");
                }
                if(in_array('skip',$filter)){
                    $query='?filter[skip]='.$filter['skip'];
                }else{
                    $query='?filter[skip]=0';
                }
                if(in_array('limit',$filter)){
                    $query.='&filter[limit]='.$filter['limit'];
                }else{
                    $query.='&filter[limit]=10';
                }
                if(in_array('website_ref_no',$filter)){
                    $query='&filter[website_ref_no]='.$filter['website_ref_no'];
                }
                if(in_array('cellnumber',$filter)){
                    $query.='&filter[cellnumber]='.$filter['cellnumber'];
                }elseif(in_array('date_range',$filter)){
                    if(in_array('start_date',$filter['date_range'])) {
                        $query .= '&filter[date_range][startDate]=' . $filter['date_range']['start_date'];
                        if(in_array('end_date',$filter['date_range'])) {
                            $query .= '&filter[date_range][endDate]=' . $filter['date_range']['end_date'];
                        }else{
                            $query .= '&filter[date_range][endDate]=' . $filter['date_range']['start_date'];
                        }
                    }
                }
            }else{
                $query='?filter[skip]=0&filter[limit]=20';
            }
            $response = $this->client->request('GET', 'transactions/listTransactions'.$query, [
                'headers' => [
                    'Authorization' =>  Cache::get('sadad-access-token'),
//                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ]
            ]);
            if ($response->getStatusCode()==200) {
                return $response->getBody();
            }
            throw new Exception("Sadad Listing failed");
        } catch (GuzzleException $e) {
            throw $e;
        }
    }


    public function refund($transNo)
    {
        try {
            $body=json_encode(['transactionno'=>$transNo]);
            $response = $this->client->request('POST', 'transactions/refundTransaction', [
                'headers' => [
                    'Authorizations' =>  Cache::get('sadad-access-token'),
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],'json' => $body
            ]);
            if ($response->getStatusCode()==200) {
                return $response->getBody();
            }
            throw new \Exception("Transaction refund failed");
        } catch (GuzzleException $e) {
            throw $e;
        }
    }
}

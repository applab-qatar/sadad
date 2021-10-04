<?php

namespace Applab\Sadad;

use Exception;
use Illuminate\Support\Facades\Cache;

class Sadad
{
    /*
     *
     */
    public function __construct()
    {
        if(!Cache::has('sadad-access-token') && empty(Cache::get('sadad-access-token'))){
            $this->authClass=new Authentication();
            $this->authClass->login();
        }
        $this->transaction=new Transaction();
    }
    /*
     * Single
     */
    public function getSingle($transactionNo)
    {
        try{
            $response= $this->transaction->single($transactionNo);
            return json_decode($response);
        }catch(Exception $e){
            \Log::error("SadadTransactionSingle::Exception ".$e->getMessage());
            throw $e;
        }
    }

    /*
       * All
   */
    public function getAll($filter)
    {
        try{
            $response= $this->transaction->list($filter);
            return json_decode($response);
        }catch(Exception $e){
            \Log::error("SadadTransactionAll::Exception ".$e->getMessage());
            throw $e;
        }
    }
}

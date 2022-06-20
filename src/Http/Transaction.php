<?php


namespace Applab\Sadad\Http;

use \Applab\Sadad\Api\Transaction as ApiTransaction;
use Applab\Sadad\Utilities\PayConfig;

class Transaction extends PayConfig
{
    /*
     * Single
     */
    public function getSingle($transactionNo)
    {
        try{
            $transaction=new ApiTransaction();
            $response= $transaction->single($transactionNo);
            return json_decode($response);
        }catch(Exception $e){
            \Log::error("SADAD TransactionSingle::Exception ".$e->getMessage());
            throw $e;
        }
    }

    /*
       * All
   */
    public function getAll($filter)
    {
        try{
            $transaction=new ApiTransaction();
            $response= $transaction->list($filter);
            return json_decode($response);
        }catch(Exception $e){
            \Log::error("SADAD TransactionAll::Exception ".$e->getMessage());
            throw $e;
        }
    }

    /**
     * Refund transactions
     */
    public function refundTransaction($transactionNo)
    {
        try{
            $transaction=new ApiTransaction();
            $response= $transaction->refund($transactionNo);
            return json_decode($response);
        }catch(Exception $e){
            \Log::error("SADAD refundTransaction::Exception ".$e->getMessage());
            throw $e;
        }
    }
}
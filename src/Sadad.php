<?php

namespace Applab\Sadad;

use Applab\Sadad\Http\Transaction;
use Applab\Sadad\Http\Payment;
use Applab\Sadad\Models\SadadLog;
use Exception;

class Sadad extends Payment
{
    /*
     * Single
     */
    public function getTransaction($transactionNo)
    {
        $transaction=new Transaction();
        return $transaction->getSingle($transactionNo);
    }

    /*
       * All
   */
    public function getTransactions($filter)
    {
        $transaction=new Transaction();
        return $transaction->getAll($filter);
    }
    public static function __callStatic($name, $arguments)
    {
        call_user_func($name, $arguments);
    }
    private function logEntry($model,$response)
    {
        $logCreated=new SadadLog();
        $logCreated->transable_type=$model->getMorphClass();
        $logCreated->transable_id=$model->id;
        $logCreated->response=$response;
        $logCreated->save();
        return $logCreated;
    }
}

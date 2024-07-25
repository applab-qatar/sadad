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

    /**
     * Refun transaction 
     *
     * @param string $transactionNo
     * @return Response
     */
    public function refundTransaction($transactionNo)
    {
        $transaction=new Transaction();
        return $transaction->refundTransaction($transactionNo);
    }

    /**
     * List invoices
     *
     * @param array $filter
     * @return Response
     */
    public function listInvoices($filter)
    {
        $transaction = new Transaction();
        return $transaction->listInvoices($filter);
    }

    /**
     * Create invoice
     *
     * @param array $payload
     * @return Response
     */
    public function createInvoice($payload)
    {
        $transaction = new Transaction();
        return $transaction->createInvoice($payload);
    }

    /**
     * Share invoice
     *
     * @param array $payload
     * @return Response
     */
    public function shareInvoice($payload)
    {
        $transaction = new Transaction();
        return $transaction->shareInvoice($payload);
    }

    public static function __callStatic($name, $arguments)
    {
        call_user_func($name, $arguments);
    }
    public function logEntry($model,$response,$entryType='callback')//$entryType=api/callback
    {
        $logCreated=new SadadLog();
        $logCreated->transable_type=$model->getMorphClass();
        $logCreated->transable_id=$model->id;
        $logCreated->response=json_encode($response);
        if($entryType =='callback') {
            if ($response['RESPCODE'] == 1)
                $logCreated->sadad_id = @$response['transaction_number'];
            $logCreated->status = @$response['STATUS'];
        }else{//api
            $logCreated->sadad_id =  @$response['invoicenumber'];
            $logCreated->status = @$response['transactionstatus']['name'];
        }
        $logCreated->save();
        return $logCreated;
    }
}

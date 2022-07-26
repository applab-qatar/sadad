<?php

namespace Applab\Sadad\Requests;

class InvoiceRequest
{
    public $countryCode;
    public $cellnumber;
    public $clientname;
    public $status;
    public $remarks;
    public $amount;
    public $invoicedetails = [];

    public $payload = [];

    public function setInvoiceDetails($invoice_details)
    {
        $invoiceDetails = [];
        foreach($invoice_details as $detail) {
            $invoiceItems['description'] = $detail['description'];
            $invoiceItems['quantity'] = $detail['quantity'] ?? 1;
            $invoiceItems['amount'] = $detail['amount'] ?? 1;
            $invoiceDetails[] = $invoiceItems;
        }
        $this->invoicedetails = $invoiceDetails;

        return $this;
    }

    public function preparePayload()
    {
        $this->payload = [
            'countryCode' => $this->countryCode,
            'cellnumber' => $this->cellnumber,
            'clientname' => $this->clientname,
            'status' => $this->status,
            'remarks' => $this->remarks,
            'amount' => $this->amount,
            'invoicedetails' => $this->invoicedetails,
        ];

        return $this;
    }

    public function getPayload()
    {
        return $this->payload;
    }
}
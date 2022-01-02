<?php

namespace Applab\Sadad\Utilities;


class PayConfig extends GClient
{
    public $requestUrl;
    public $api_url;
    protected $merchant_id;
    protected $secret_key;
    protected $domain;
    protected $version;
    protected $language;
    public function __construct()
    {
        $this->requestUrl = config('applab-sadad.purchase-url');
        $this->api_url = config('applab-sadad.api-url');

        $this->merchant_id = config('applab-sadad.client-id'); // sadad merchant id
        $this->secret_key = config('applab-sadad.client-secret');
        $this->domain = config('applab-sadad.reg-domain');

        $this->version = '2.1';
        $this->language = (app()->getLocale() == 'ar') ? 'ARB':'ENG';

        if(empty($this->merchant_id))
            $message='merchant_id';
        elseif(empty($this->secret_key))
            $message='secret_key';
        elseif(empty($this->domain))
            $message='domain';
        if(isset($message))
            throw new \Exception('SADAD Invalid input['.$message.']!, Please Ensure configuration values are correct');

        parent::__construct();
    }
}
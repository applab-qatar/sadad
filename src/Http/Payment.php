<?php


namespace Applab\Sadad\Http;


use Applab\Sadad\Requests\WCORequest;
use Applab\Sadad\Traits\CheckSum;
use Applab\Sadad\Utilities\PayConfig;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
class Payment extends PayConfig
{
    use CheckSum;
    public function __construct()
    {
        parent::__construct();
    }


    public function reqData($wco_request)
    {
        $checksum_array = array();

        $checksum_array['merchant_id'] = $this->merchant_id;
        $checksum_array['WEBSITE'] = $this->domain;
        $checksum_array['SADAD_WEBCHECKOUT_PAGE_LANGUAGE'] = $this->language;

        $checksum_array['ORDER_ID'] = $wco_request->order_id??$wco_request->getOrderId();
        $checksum_array['TXN_AMOUNT'] = $wco_request->total_amount;
        if($wco_request->customer_id) {
            $checksum_array['CUST_ID'] = $wco_request->customer_id;
        }
        if($wco_request->customer_email) {
            $checksum_array['EMAIL'] = $wco_request->customer_email;
        }
        $checksum_array['MOBILE_NO'] =$wco_request->customer_mobile;

        $checksum_array['CALLBACK_URL'] = $wco_request->callback_url;

        $checksum_array['productdetail'] = $wco_request->products;
        $checksum_array['txnDate'] =  date('Y-m-d H:i:s');
        return $checksum_array;
    }
    public function webCheckoutOne(WCORequest $request,$returnType='view')
    {
        try{
            $input =   [
                'total_amount' => $request->total_amount,
                'customer_mobile' => $request->customer_mobile,
                'callback_url' => $request->callback_url,
                'products' => $request->products,
            ];

            $validator=Validator::make($input, [
                'total_amount' => 'required',
                'customer_mobile' => 'required',
                'callback_url' => 'required',
                'products' => 'required',
            ]);
            if ($validator->fails()) {
                if($returnType==='view')
                    return view('sadad::web-checkout-error')->withErrors($validator);
                else
                    return ['status'=>false,'response'=>$validator];
            }
            try{
                $checksum_array=self::reqData($request);
                $_checksum_data = array();
                $_checksum_data['postData'] =$checksum_array;
                $_checksum_data['secretKey'] = $this->secret_key;

                $checksum_array1=self::processData($checksum_array);
                $sAry1 = array();
                $_checksum_data['postData'] = $checksum_array1;
                $_checksum_data['secretKey'] = $this->secret_key;

                $checksum = self::getFromString(json_encode($_checksum_data), $this->secret_key . $this->merchant_id);
                $sAry1[] = "";
                $form= self::makeForm($_checksum_data,$checksum);
                if($returnType==='view')
                    return view('sadad::web-checkout-one', compact('form'));
                else
                    return ['status'=>true,'response'=>$form];
            }catch(\Exception $e){
                \Log::critical("SADAD webCheckoutOne Failure ".$e->getMessage());
                throw $e;
            }
        }catch(ValidationException $e){
            \Log::critical("SADAD webCheckoutOne Validation ".$e->getMessage());
            throw $e;
        }
    }

    private function makeForm($_checksum_data,$checksum)
    {
        $form = '<form method="post" id="sadad_payment_form" name="gosadad" action="' . $this->requestUrl . '" data-link="' . $this->requestUrl . '">';
        foreach ($_checksum_data['postData'] as $k => $v) {
            if ($k != 'productdetail') {
                $form .= '<input type="hidden" name="' . $k . '" value="' . $v . '"><br />';
            } else {
                $form .= '<input type="hidden" name="productdetail[0][order_id]" value="' . $v[0]['order_id'] . '">';
                $form .= '<input type="hidden" name="productdetail[0][itemname]" value="' . $v[0]['itemname'] . '">';
                $form .= '<input type="hidden" name="productdetail[0][amount]" value="' . $v[0]['amount'] . '">';
                $form .= '<input type="hidden" name="productdetail[0][quantity]" value="' . $v[0]['quantity'] . '">';
                $form .= '<input type="hidden" name="productdetail[0][type]" value="' . $v[0]['type'] . '"><br />';
            }
        }
        $form .= '<input type="hidden" name="checksumhash" value="' . $checksum . '">';
        return $form .= '<input type="submit" id="sadad_payment_form_submit"></form>';
    }
}
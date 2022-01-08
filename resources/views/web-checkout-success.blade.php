@extends('sadad::index')
@section('content')
    <div class="row">
        <div class="col-md-12">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div id="invoice" style="text-align:center">
                <div class="invoice-wrapper successful">
                    <div class="content-wrapper"
                         style="padding:20px 20px 10px;border-radius: 30px;margin:20px 0;background-color: #f8f8ff">
                        <div class="confirm text-center">
                            <h3 style="color:#53ff53">@lang('global.payment_success')!</h3>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div style="text-align: center">
        <a class="btn btn-success"
           href="{{ url('')}}">@lang('global.finish')</a>
    </div>
    <div class="clearfix"></div>
@endsection 
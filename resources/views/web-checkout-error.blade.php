@extends('sadad::index')
@section('content')
    <div class="row">
        <div class="col-md-12">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div id="invoice" style="text-align:center">
                <div class="invoice-wrapper not-successful">
                    <div class="content-wrapper"
                         style="padding:20px 20px 10px;border-radius: 30px;margin:20px 0;background-color: #f8f8ff">
                        <div class="confirm fail text-center">
                            <h3 style="color:#FF6262">{{trans('Payment Failed')}}!</h3>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
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
           href="{{ url('')}}">{{trans('finish')}}</a>
    </div>
    <div class="clearfix"></div>
@endsection 
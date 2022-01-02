@extends('sadad::index')
@section('content')
    <div class="row">
        <div class="col-md-8 text-center">
            {!! $form !!}
        </div>
    </div>
    @push('scripts')
        <script type="text/javascript">
            document.getElementById("sadad_payment_form_submit").click();
        </script>
    @endpush
@endsection
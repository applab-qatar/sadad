@extends('sadad::index')
@section('content')
    <div class="w-full bg-white rounded-lg shadow-lg flex flex-col p-4 justify-center items-center">
        {!! $form !!}
    </div>
    @push('scripts')
        <script type="text/javascript">
            document.getElementById("sadad_payment_form_submit").click();
        </script>
    @endpush
@endsection

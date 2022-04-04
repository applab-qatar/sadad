@extends('sadad::index')
@section('content')
    <div class="w-full bg-white rounded-lg shadow-lg flex flex-col justify-center items-center">
        <div class="min-h-screen min-w-full bg-gray-50 flex flex-col justify-center relative overflow-hidden rounded-xl">
            <div class="flex items-center justify-center">
            <button type="button" class="inline-flex items-center px-4 py-2 font-semibold leading-6 text-sm shadow rounded-md text-white bg-gray-800 hover:bg-gray-600 transition ease-in-out duration-150 cursor-not-allowed" disabled="">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg> 
            {{ App::getLocale() == 'ar' ? 'جاري المعالجة' : 'Processing payment...' }}
            </button>
            </div>
        </div>
        {!! $form !!}
    </div>
    @push('scripts')
        <script type="text/javascript">
            document.getElementById("sadad_payment_form_submit").click();
        </script>
    @endpush
@endsection

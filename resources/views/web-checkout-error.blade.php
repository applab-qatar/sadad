@extends('sadad::index')
@section('content')
    <div class="w-full bg-white rounded-lg shadow-lg flex flex-col px-4 pt-8 pb-4 justify-center items-center space-y-4">
        <div class="p-3 mr-4 text-red-500 bg-red-100 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                    clip-rule="evenodd" />
            </svg>
        </div>

        <div @if (app()->getLocale() == 'ar') dir="rtl" @endif class="flex flex-col w-full p-4 bg-red-100 rounded-lg border border-red-400">
            <span class="font-sedmibold text-red-600 text-center text-lg">
                {{ trans('Payment Failed!') }}
            </span>

            @if ($errors->any())
                <div class="flex flex-col items-center w-full mt-2 space-y-1">
                    @foreach ($errors->all() as $error)
                        <span class="font-semibold text-gray-600 text-xs">
                            {{ $error }}
                        </span>
                    @endforeach
                </div>
            @endif
        </div>

        <a href="{{ url('payment/failed') }}"
            class="bg-red-500 hover:bg-red-600 focus:outline-red-200 px-6 py-2 rounded-lg text-white text-xs">{{ trans('Finish') }}</a>
    </div>
@endsection

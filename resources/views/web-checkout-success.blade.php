@extends('sadad::index')
@section('content')
    <div class="w-full bg-white rounded-lg shadow-lg flex flex-col px-4 pt-8 pb-4 justify-center items-center space-y-4">
        <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd" />
            </svg>
        </div>

        <div @if(app()->getLocale()=='ar') dir="rtl" @endif class="flex flex-col w-full p-4 bg-green-100 rounded-lg border border-green-400">
            <span class="font-sedmibold text-green-600 text-center text-lg">
                {{ trans('Congratulations!') }}
            </span>
            <span class="font-sedmibold text-green-600 text-center text-xs">
                {{ trans('You have successfully subscribed.') }}
            </span>

            <div class="flex justify-between items-center w-full mt-2">
                <span class="font-semibold text-gray-600 text-xs">
                    {{ trans('Transaction No.') }}
                </span>
                <span class="text-gray-600 text-xs">
                    {{ $payment->id }}
                </span>
            </div>

            <div class="flex justify-between items-center w-full">
                <span class="font-semibold text-gray-600 text-xs">
                    {{ trans('Date') }}
                </span>
                <span dir="ltr" class="text-gray-600 text-xs">
                    {{ $payment->created_at->format('d/m/Y H:i A') }}
                </span>
            </div>

            <div class="flex justify-between items-center w-full mt-4">
                <span class="font-semibold text-gray-700 text-sm">
                    {{ trans('Amount') }}
                </span>
                <span class="text-gray-700 text-sm">
                    {{ $payment->amount }} {{ trans('QAR') }}
                </span>
            </div>
        </div>

        <a href="{{ url('payment/success') }}"
            class="bg-green-500 hover:bg-green-600 focus:outline-green-200 px-6 py-2 rounded-lg text-white text-xs">{{ trans('Finish') }}</a>
    </div>
@endsection

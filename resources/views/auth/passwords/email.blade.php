@extends('layouts.app')

@section('content')


    <form method="POST" action="{{ route('password.email') }}"
          class="lg:w-1/2 lg:mx-auto bg-card py-12 px-16 rounded shadow"
    >
        @csrf

        @if (session('status'))
            <div class="bg-teal-100 border-t-4 border-green-dark rounded-b text-green-dark px-4 py-3 mb-4 shadow-md" role="alert">
                <div class="flex items-center">
                    <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                    <div>
                        <p class="font-bold">{{ session('status') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <h1 class="text-2xl font-normal mb-10 text-center">{{ __('Reset Password') }}</h1>

        <div class="field mb-6">
            <label class="label text-sm mb-2 block" for="email">{{ __('E-Mail Address') }}</label>

            <div class="control">
                <input id="email"
                       type="email"
                       class="input bg-transparent border rounded p-2 text-xs w-full {{ $errors->has('email') ? 'border-error' : 'border-muted-light' }}"
                       name="email"
                       value="{{ old('email') }}"
                       required>
                @if ($errors->has('email'))
                    <span class="text-center text-xs font-normal text-error">
                        {{ $errors->has('email') ? $errors->first('email') : ''}}
                    </span>
                @endif
            </div>
        </div>

        <div class="field mb-6">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="button mr-2">
                    {{ __('Send Password Reset Link') }}
                </button>

            </div>
        </div>
    </form>

@endsection

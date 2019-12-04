@extends('layouts.app')

{{dump($errors)}}

@section('content')
<form method="POST" action="{{ route('password.update') }}"
          class="lg:w-1/2 lg:mx-auto bg-card py-12 px-16 rounded shadow"
    >
        @csrf

        <h1 class="text-2xl font-normal mb-10 text-center">{{ __('Reset Password') }}</h1>

         <input type="hidden" name="token" value="{{ $token }}">
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
                        {{ $errors->first('email') }}
                    </span>
                @endif
            </div>
        </div>

        <div class="field mb-6">
            <label class="label text-sm mb-2 block" for="password">{{ __('Password') }}</label>

            <div class="control">
                <input id="password"
                       type="password"
                       class="input bg-transparent border rounded p-2 text-xs w-full {{ $errors->has('password') ? 'border-error' : 'border-muted-light' }}"
                       name="password"
                       required>

                @if ($errors->has('password'))
                    <span class="text-center text-xs font-normal text-error">
                        {{$errors->first('password') }}
                    </span>
                @endif

            </div>
        </div>

        <div class="field mb-6">
            <label class="label text-sm mb-2 block" for="password-confirmation">{{ __('Confirm Password') }}</label>

            <div class="control">
                <input id="password-confirmation"
                       type="password"
                       class="input bg-transparent border rounded p-2 text-xs w-full {{ $errors->has('password') ? 'border-error' : 'border-muted-light' }}"
                       name="password_confirmation"
                       required>
                @if ($errors->has('password'))
                    <span class="text-center text-xs font-normal text-error">
                        {{$errors->first('password') }}
                    </span>
                @endif
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button type="submit" class="button is-link mr-2">
                    {{ __('Reset Password') }}
                </button>
            </div>
        </div>
    </form>
@endsection

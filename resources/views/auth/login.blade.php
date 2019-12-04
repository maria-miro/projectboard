@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('login') }}"
          class="lg:w-1/2 lg:mx-auto bg-card py-12 px-16 rounded shadow"
    >
        @csrf

        <h1 class="text-2xl font-normal mb-10 text-center">{{ __('Login') }}</h1>

        <div class="field mb-6">
            <label class="label text-sm mb-2 block" for="email">{{ __('E-Mail Address') }}</label>

            <div class="control">
                <input id="email"
                       type="email"
                       class="input bg-transparent border rounded p-2 text-xs w-full {{ $errors->has('email') ? 'border-error' : 'border-muted-light' }}"
                       name="email"
                       value="{{ old('email') }}"
                       required>
                <span class="text-center text-xs font-normal text-error">
                    {{ $errors->has('email') ? $errors->first('email') : ''}}
                </span>
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
                <span class="text-center text-xs font-normal text-error">
                    {{ $errors->has('password') ? $errors->first('password') : ''}}
                </span>
            </div>
        </div>

        <div class="field mb-6">
            <div class="control">
                <input class="form-check-input"
                       type="checkbox"
                       name="remember"
                       id="remember"
                        {{ old('remember') ? 'checked' : '' }}>

                <label class="text-sm" for="remember">
                    {{ __('Remember Me') }}
                </label>
            </div>
        </div>

        <div class="field mb-6">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="button mr-2">
                    {{ __('Login') }}
                </button>

                @if (Route::has('password.request'))
                    <a class="text-default text-sm" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif
            </div>
        </div>
    </form>
@endsection
